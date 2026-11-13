<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\TechPlanner\Filament\Resources\ClientResource\Tables\ClientsTable;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\DeviceVerification;
use Modules\TechPlanner\Models\PhoneCall;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

/*
 * TPL-03: «Elimina» su un cliente cancellava per sempre, a cascata, apparecchi, verifiche e chiamate.
 * Ora il cliente va nel cestino con i suoi figli e torna con loro. Schema dalle migrazioni vere.
 */

function tpSoftMigrate(string ...$files): void
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
    tpSoftMigrate(
        '2024_12_26_000008_create_client_table.php',
        '2019_12_12_000005_create_appointments_table.php',
        '2019_12_12_000012_create_machines_table.php',
        '2026_11_05_220000_create_device_table.php',
        '2026_11_05_220010_create_device_verifications_table.php',
        '2024_12_26_000000_create_phone_call_table.php',
        '2026_11_05_220020_create_medical_directors_table.php',
        '2024_12_26_230220_create_legal_representatives_table.php',
        '2024_12_26_230221_create_legal_offices_table.php',
        '2026_11_06_000000_create_controls_table.php',
    );

    $this->client = Client::query()->create(['company_name' => 'Studio Rossi']);
    $this->device = Device::query()->create(['client_id' => $this->client->getKey(), 'type' => 'Endorale']);
    $this->verification = DeviceVerification::query()->create([
        'device_id' => $this->device->getKey(),
        'verification_date' => '2026-01-10',
        'next_verification_date' => '2028-01-10',
        'verification_type' => 'Periodica',
        'result' => 'Conforme',
    ]);
    $this->call = PhoneCall::query()->create(['client_id' => $this->client->getKey(), 'date' => now(), 'call_type' => 'outgoing']);
});

it('moves the client and everything it owns to the trash instead of erasing it', function (): void {
    $this->client->delete();

    expect(Client::query()->count())->toBe(0)
        ->and(Device::query()->count())->toBe(0)
        ->and(DeviceVerification::query()->count())->toBe(0)
        ->and(PhoneCall::query()->count())->toBe(0)
        ->and(Client::withTrashed()->count())->toBe(1)
        ->and(Device::withTrashed()->count())->toBe(1)
        ->and(DeviceVerification::withTrashed()->count())->toBe(1)
        ->and(PhoneCall::withTrashed()->count())->toBe(1);
});

it('brings back the children that were trashed with the client', function (): void {
    $this->client->delete();
    Client::withTrashed()->findOrFail($this->client->getKey())->restore();

    expect(Device::query()->count())->toBe(1)
        ->and(DeviceVerification::query()->count())->toBe(1)
        ->and(PhoneCall::query()->count())->toBe(1);
});

it('leaves trashed what had been deleted before the client', function (): void {
    $this->travel(-1)->days();
    $this->call->delete();
    $this->travelBack();

    $this->client->delete();
    Client::withTrashed()->findOrFail($this->client->getKey())->restore();

    expect(PhoneCall::query()->count())->toBe(0)
        ->and(Device::query()->count())->toBe(1);
});

it('offers the trash filter and restore actions on the client list', function (): void {
    $table = new ClientsTable();

    expect($table->getTableFilters())->toHaveKey('trashed')
        ->and($table->getTableActions())->toHaveKeys(['restore', 'forceDelete'])
        ->and($table->getTableBulkActions())->toHaveKeys(['restore', 'forceDelete']);
});

it('adds missing trash columns on an older database without touching existing ones', function (): void {
    Schema::connection('tech_planner')->create('workers', static function ($table): void {
        $table->id();
    });

    $migration = require dirname(__DIR__, 2).'/database/migrations/2026_11_10_000000_ensure_soft_delete_columns_on_techplanner_tables.php';
    $migration->up();
    $migration->up();

    expect(Schema::connection('tech_planner')->hasColumns('workers', ['deleted_at', 'deleted_by']))->toBeTrue()
        ->and(Schema::connection('tech_planner')->hasColumn('clients', 'deleted_at'))->toBeTrue();
});
