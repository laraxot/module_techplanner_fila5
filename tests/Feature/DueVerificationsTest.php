<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Tables\DevicesTable;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\DeviceVerification;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

/*
 * FUN-01: «quando tornare» viene dall'ultima verifica di ogni apparecchio. Schema dalle migrazioni vere.
 */

function tpDueMigrate(string ...$files): void
{
    foreach ($files as $file) {
        $migration = require dirname(__DIR__, 2).'/database/migrations/'.$file;
        if (! $migration instanceof Migration || ! method_exists($migration, 'up')) {
            throw new RuntimeException("Migrazione non valida: {$file}");
        }
        $migration->up();
    }
}

function tpDevice(string $type, ?string ...$nextDates): Device
{
    $client = Client::query()->firstOrCreate(['company_name' => 'Studio Verdi']);
    $device = Device::query()->create(['client_id' => $client->getKey(), 'type' => $type]);
    foreach ($nextDates as $i => $next) {
        DeviceVerification::query()->create([
            'device_id' => $device->getKey(),
            'verification_date' => today()->subYears(3 - $i)->toDateString(),
            'next_verification_date' => $next,
            'verification_type' => 'Periodica',
            'result' => 'Conforme',
        ]);
    }

    return $device;
}

beforeEach(function (): void {
    $this->useIsolatedTechPlannerConnection(foreignKeys: true);
    tpDueMigrate(
        '2024_12_26_000008_create_client_table.php',
        '2019_12_12_000005_create_appointments_table.php',
        '2019_12_12_000012_create_machines_table.php',
        '2026_11_05_220000_create_device_table.php',
        '2026_11_05_220010_create_device_verifications_table.php',
    );
    Carbon::setTestNow('2026-11-10 09:00:00');

    // L'ultima verifica decide: la prima data (vecchia, scaduta) non conta più.
    $this->overdue = tpDevice('Scaduto', '2024-01-01', '2026-10-01');
    $this->soon = tpDevice('Entro 30 giorni', '2020-01-01', '2026-11-25');
    $this->later = tpDevice('Fra un anno', '2025-01-01', '2027-11-10');
    $this->never = tpDevice('Mai verificato');
});

afterEach(fn () => Carbon::setTestNow());

it('reads the next verification date from the latest verification', function (): void {
    $dates = Device::query()->withNextVerificationDate()->get()
        ->mapWithKeys(fn (Device $d): array => [$d->getAttribute('type') => $d->getAttribute('next_verification_date')?->toDateString()]);

    expect($dates->all())->toBe([
        'Scaduto' => '2026-10-01',
        'Entro 30 giorni' => '2026-11-25',
        'Fra un anno' => '2027-11-10',
        'Mai verificato' => null,
    ]);
});

it('finds overdue, due-soon and never-verified devices', function (): void {
    expect(Device::query()->verificationDueBy(today()->subDay())->pluck('type')->all())->toBe(['Scaduto'])
        ->and(Device::query()->verificationDueBy(today()->addDays(30))->pluck('type')->all())->toBe(['Scaduto', 'Entro 30 giorni'])
        ->and(Device::query()->neverVerified()->pluck('type')->all())->toBe(['Mai verificato']);
});

it('ignores verifications in the trash', function (): void {
    $this->overdue->verifications()->orderByDesc('verification_date')->first()?->delete();

    expect(Device::query()->withNextVerificationDate()->find($this->overdue->getKey())?->getAttribute('next_verification_date')?->toDateString())
        ->toBe('2024-01-01');
});

it('colours the due date red, yellow or green', function (): void {
    expect(DevicesTable::dueColor(Carbon::parse('2026-11-09')))->toBe('danger')
        ->and(DevicesTable::dueColor(Carbon::parse('2026-12-01')))->toBe('warning')
        ->and(DevicesTable::dueColor(Carbon::parse('2027-06-01')))->toBe('success')
        ->and(DevicesTable::dueColor(null))->toBe('gray');
});

it('offers the due filter on the device list', function (): void {
    expect((new DevicesTable())->getTableFilters())->toHaveKeys(['due', 'trashed']);
});
