<?php

declare(strict_types=1);

use Filament\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers\PhoneCallsRelationManager;
use Modules\TechPlanner\Filament\Resources\ClientResource\Tables\ClientsTable;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\MedicalDirector;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

/*
 * Difetti trovati rifacendo i percorsi del manuale d'uso nel pannello (2026-11-05).
 * Lo schema viene dalle migrazioni vere del modulo, su SQLite in memoria.
 */

function tpMigrate(string ...$files): void
{
    foreach ($files as $file) {
        $migration = require dirname(__DIR__, 2).'/database/migrations/'.$file;
        if (! $migration instanceof Migration || ! method_exists($migration, 'up')) {
            throw new RuntimeException("Migrazione non valida: {$file}");
        }
        $migration->up();
    }
}

beforeEach(function (): void {
    $this->useIsolatedTechPlannerConnection(foreignKeys: true);
    tpMigrate(
        '2024_12_26_000008_create_client_table.php',
        '2019_12_12_000005_create_appointments_table.php',
        '2019_12_12_000012_create_machines_table.php',
        '2026_11_05_220000_create_device_table.php',
        '2026_11_05_220020_create_medical_directors_table.php',
    );
});

it('registers a device without an appointment', function (): void {
    $client = Client::query()->create(['company_name' => 'Studio di prova']);

    $device = Device::query()->create(['client_id' => $client->getKey(), 'type' => 'Endorale', 'brand' => 'Planmeca']);

    expect($device->exists)->toBeTrue()
        ->and($device->getAttribute('appointment_id'))->toBeNull();
});

it('can rerun the device migration without duplicating the client foreign key', function (): void {
    tpMigrate('2026_11_05_220000_create_device_table.php');

    $fks = array_filter(
        Schema::connection('tech_planner')->getForeignKeys((new Device())->getTable()),
        static fn (array $fk): bool => $fk['columns'] === ['client_id'],
    );

    expect($fks)->toHaveCount(1);
});

it('saves a medical director with the fields of the panel form', function (): void {
    $client = Client::query()->create(['company_name' => 'Studio di prova']);

    $director = MedicalDirector::query()->create([
        'client_id' => $client->getKey(),
        'name' => 'Dott.ssa Elena Neri',
        'email' => 'direzione@example.com',
        'license_number' => 'OMCeO VE 1234',
        'specialization' => 'Odontoiatria',
        'license_expiry' => '2030-12-31',
    ]);

    expect($director->fresh()?->getAttribute('license_number'))->toBe('OMCeO VE 1234');
});

it('imports a medical director from the Access columns without a name', function (): void {
    $client = Client::query()->create(['company_name' => 'Studio di prova']);

    $director = MedicalDirector::query()->create([
        'client_id' => $client->getKey(),
        'last_name' => 'Neri',
        'first_name' => 'Elena',
        'start_date' => '2020-01-01',
    ]);

    expect($director->exists)->toBeTrue();
});

it('shows filters, sort by distance and bulk actions on the client list', function (): void {
    $table = new ClientsTable();

    expect($table->getTableFilters()['business_closed'] ?? null)->toBeInstanceOf(TernaryFilter::class)
        ->and($table->getTableFilters()['activity'] ?? null)->toBeInstanceOf(SelectFilter::class)
        ->and($table->getTableActions()['sortByDistance'] ?? null)->toBeInstanceOf(Action::class)
        ->and(array_keys($table->getTableBulkActions()))->toContain('updateCoordinates', 'sendRecordsNotification');
});

it('gives the client phone calls tab real columns', function (): void {
    $manager = new PhoneCallsRelationManager();
    $columns = (new ReflectionMethod($manager, 'getTableColumns'))->invoke($manager);

    expect($columns)->toBeArray()->not->toBeEmpty()
        ->and(array_keys($columns))->toContain('date', 'call_type');
});

it('resolves contact icons instead of failing the client list', function (): void {
    app()->setLocale('it');

    expect(AddressItemEnum::PHONE->getIcon())->toBe('heroicon-o-phone')
        ->and(ContactTypeEnum::PHONE->getIcon())->toStartWith('heroicon-');
});
