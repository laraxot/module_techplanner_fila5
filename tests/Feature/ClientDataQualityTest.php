<?php

declare(strict_types=1);

use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Geo\Filament\Forms\Components\AddressSection;
use Modules\TechPlanner\Filament\Imports\ClientImporter;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Rules\ItalianFiscalCodeRule;
use Modules\TechPlanner\Rules\ItalianVatNumberRule;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

/*
 * FUN-05 (P.IVA e codice fiscale controllati), TPL-08 (recapiti non più doppi nel modulo cliente),
 * FUN-04 (reimportare un file aggiorna invece di duplicare).
 */

dataset('valid-vat', ['06363391001', 'IT06363391001', '0636 3391 001']);
dataset('invalid-vat', ['06363391002', '0636339100', 'ABCDEFGHIJK', '']);

it('accepts valid Italian VAT numbers', function (string $vat): void {
    expect(ItalianVatNumberRule::isValid($vat))->toBeTrue();
})->with('valid-vat');

it('rejects mistyped VAT numbers', function (string $vat): void {
    expect(ItalianVatNumberRule::isValid($vat))->toBeFalse();
})->with('invalid-vat');

it('accepts personal and company fiscal codes, omocodia included', function (string $code): void {
    expect(ItalianFiscalCodeRule::isValid($code))->toBeTrue();
})->with(['RSSMRA85T10A562S', 'rssmra85t10a562s', '06363391001']);

it('rejects wrong fiscal codes', function (string $code): void {
    expect(ItalianFiscalCodeRule::isValid($code))->toBeFalse();
})->with(['RSSMRA85T10A562T', 'RSSMRA85T10A562', '06363391002']);

it('reports an Italian message and lets empty values through', function (): void {
    app()->setLocale('it');

    $validator = Validator::make(
        ['vat_number' => '12345678901', 'tax_code' => null],
        ['vat_number' => [new ItalianVatNumberRule()], 'tax_code' => ['nullable', new ItalianFiscalCodeRule()]],
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->keys())->toBe(['vat_number'])
        ->and($validator->errors()->first('vat_number'))->toContain('partita IVA');
});

it('shows each contact field once in the client form', function (): void {
    $fields = array_keys((new AddressSection('address'))->getFormSchema());

    expect($fields)->toContain('route', 'street_number', 'postal_code', 'locality')
        ->not->toContain('phone', 'email', 'fax', 'mobile', 'pec', 'whatsapp', 'notes');
});

describe('client import', function (): void {
    beforeEach(function (): void {
        $this->useIsolatedTechPlannerConnection();
        // Anche le tabelle dei figli: il ripristino di un cliente riporta indietro apparecchi, chiamate, referenti.
        foreach ([
            '2024_12_26_000008_create_client_table.php',
            '2019_12_12_000005_create_appointments_table.php',
            '2019_12_12_000012_create_machines_table.php',
            '2026_11_05_220000_create_device_table.php',
            '2024_12_26_000000_create_phone_call_table.php',
            '2026_11_05_220020_create_medical_directors_table.php',
            '2024_12_26_230220_create_legal_representatives_table.php',
            '2024_12_26_230221_create_legal_offices_table.php',
            '2026_11_06_000000_create_controls_table.php',
        ] as $file) {
            $migration = require dirname(__DIR__, 2).'/database/migrations/'.$file;
            expect($migration)->toBeInstanceOf(Migration::class);
            $migration->up();
        }
    });

    function tpImporter(array $row): ClientImporter
    {
        $importer = new ClientImporter(new Import(), [], []);
        (fn () => $this->data = $row)->call($importer);

        return $importer;
    }

    it('updates the client with the same Access id instead of adding a copy', function (): void {
        Client::query()->forceCreate(['id' => 7, 'company_name' => 'Vecchio nome']);

        expect(tpImporter(['id' => '7', 'company_name' => 'Nuovo nome'])->resolveRecord()?->getKey())->toBe(7);
    });

    it('finds the client by VAT number when the id is missing', function (): void {
        $client = Client::query()->create(['company_name' => 'Studio', 'vat_number' => '06363391001']);

        expect(tpImporter(['vat_number' => '06363391001'])->resolveRecord()?->getKey())->toBe($client->getKey());
    });

    it('brings a trashed client back when the file contains it', function (): void {
        Client::query()->forceCreate(['id' => 9, 'company_name' => 'Chiuso per errore']);
        // Cestino diretto: qui non servono le tabelle dei figli.
        DB::connection('tech_planner')->table('clients')->where('id', 9)->update(['deleted_at' => now()]);

        $resolved = tpImporter(['id' => '9'])->resolveRecord();

        expect($resolved?->getKey())->toBe(9)
            ->and($resolved?->trashed())->toBeFalse();
    });

    it('creates a new client when nothing matches', function (): void {
        expect(tpImporter(['company_name' => 'Nuovo'])->resolveRecord()?->exists)->toBeFalse();
    });

    it('writes the end-of-import notification in Italian', function (): void {
        app()->setLocale('it');
        $import = new Import();
        $import->successful_rows = 3;
        $import->total_rows = 3;

        expect(ClientImporter::getCompletedNotificationBody($import))->toBe('Importazione finita: 3 righe importate.');
    });
});
