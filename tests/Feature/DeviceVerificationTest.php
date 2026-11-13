<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Modules\TechPlanner\Filament\Resources\DeviceResource\RelationManagers\DeviceVerificationsRelationManager;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\DeviceVerification;
use Modules\TechPlanner\Models\PhoneCall;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

/*
 * Verifiche periodiche degli apparecchi (story: Modules/TechPlanner/docs/stories/device-verifications-fix.story.md).
 * Database `tech_planner` su SQLite in memoria, schema creato dalle migrazioni vere del modulo:
 * si prova la migrazione, non una sua copia.
 */

function tpVerificationsMigration(): string
{
    return dirname(__DIR__, 2).'/database/migrations/2026_11_05_220010_create_device_verifications_table.php';
}

function tpUseMemoryDatabase(TestCase $test): void
{
    $test->useIsolatedTechPlannerConnection(foreignKeys: true);
    // Device usa la tabella `machines` (condivisa con Machine, che estende Device).
    Schema::connection('tech_planner')->create((new Device())->getTable(), static function (Blueprint $table): void {
        $table->id();
        $table->unsignedBigInteger('appointment_id')->nullable();
        $table->unsignedBigInteger('client_id')->nullable();
        $table->string('type')->nullable();
        $table->date('first_verification_date')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}

/** Data `Y-m-d` di un attributo con cast `date`; fallisce se il cast non c'è. */
function tpDate(mixed $value): string
{
    if (! $value instanceof Carbon) {
        throw new RuntimeException('Atteso un Carbon dal cast date, ricevuto '.get_debug_type($value));
    }

    return $value->toDateString();
}

function tpRunVerificationsMigration(): void
{
    $migration = require tpVerificationsMigration();
    if (! $migration instanceof Migration || ! method_exists($migration, 'up')) {
        throw new RuntimeException('La migrazione delle verifiche non restituisce una Migration');
    }
    $migration->up();
}

/** @return list<array{name: string, columns: list<string>, foreign_table: string}> */
function tpDeviceForeignKeys(): array
{
    /** @var list<array{name: string, columns: list<string>, foreign_table: string}> $fks */
    $fks = Schema::connection('tech_planner')->getForeignKeys('device_verifications');

    return array_values(array_filter($fks, static fn (array $fk): bool => $fk['columns'] === ['device_id']));
}

beforeEach(function (): void {
    tpUseMemoryDatabase($this);
});

it('links verifications to the device table on a fresh install', function (): void {
    tpRunVerificationsMigration();

    $fks = tpDeviceForeignKeys();

    expect($fks)->toHaveCount(1)
        ->and($fks[0]['foreign_table'])->toBe((new Device())->getTable());
});

it('makes exposure parameters optional on an existing install', function (): void {
    // Schema creato dalla versione precedente della migrazione: exposure_parameters NOT NULL.
    Schema::connection('tech_planner')->create('device_verifications', static function (Blueprint $table): void {
        $table->bigIncrements('id');
        $table->foreignId('device_id')->constrained((new Device())->getTable())->cascadeOnDelete();
        $table->date('verification_date');
        $table->date('next_verification_date');
        $table->string('result');
        $table->string('exposure_parameters');
        $table->string('verification_type');
        $table->text('notes')->nullable();
    });

    tpRunVerificationsMigration();

    $device = Device::query()->create(['type' => 'Endorale']);
    $verification = DeviceVerification::query()->create([
        'device_id' => $device->getKey(),
        'verification_date' => '2026-01-10',
        'next_verification_date' => '2027-01-10',
        'result' => 'Conforme',
        'verification_type' => 'Periodica',
    ]);

    expect($verification->exists)->toBeTrue()
        ->and($verification->getAttribute('exposure_parameters'))->toBeNull()
        ->and(tpDeviceForeignKeys()[0]['foreign_table'])->toBe((new Device())->getTable());
});

it('saves every field the verification form collects', function (): void {
    tpRunVerificationsMigration();
    $device = Device::query()->create(['type' => 'Panoramico']);

    $verification = $device->verifications()->create([
        'verification_date' => '2026-03-01',
        'next_verification_date' => '2027-03-01',
        'verification_type' => 'Periodica',
        'result' => 'Conforme',
        'exposure_parameters' => '70 kV, 7 mA',
        'notes' => 'Nessuna anomalia',
    ])->fresh();

    expect($verification)->toBeInstanceOf(DeviceVerification::class)
        ->and($verification?->getAttribute('result'))->toBe('Conforme')
        ->and($verification?->getAttribute('verification_type'))->toBe('Periodica')
        ->and($verification?->getAttribute('exposure_parameters'))->toBe('70 kV, 7 mA')
        ->and(tpDate($verification?->getAttribute('next_verification_date')))->toBe('2027-03-01')
        ->and($verification?->device()->first()?->is($device))->toBeTrue();
});

it('flags a device as due when it has no verifications', function (): void {
    tpRunVerificationsMigration();
    $device = Device::query()->create(['type' => 'Endorale']);

    expect($device->needs_verification)->toBeTrue()
        ->and($device->latest_verification)->toBeNull();
});

it('uses the most recent verification date, not the insertion order', function (): void {
    tpRunVerificationsMigration();
    $device = Device::query()->create(['type' => 'Endorale']);

    $base = ['verification_type' => 'Periodica', 'result' => 'Conforme'];
    $device->verifications()->create($base + [
        'verification_date' => now()->subMonth()->toDateString(),
        'next_verification_date' => now()->addYear()->toDateString(),
    ]);
    // Inserita dopo ma più vecchia: non deve diventare «l'ultima verifica».
    $device->verifications()->create($base + [
        'verification_date' => now()->subYears(3)->toDateString(),
        'next_verification_date' => now()->subYears(2)->toDateString(),
    ]);

    expect(tpDate($device->latest_verification?->getAttribute('verification_date')))
        ->toBe(now()->subMonth()->toDateString())
        ->and($device->needs_verification)->toBeFalse();
});

it('flags a device as due when the next verification date has passed', function (): void {
    tpRunVerificationsMigration();
    $device = Device::query()->create(['type' => 'Endorale']);
    $device->verifications()->create([
        'verification_date' => now()->subYears(2)->toDateString(),
        'next_verification_date' => now()->subDay()->toDateString(),
        'verification_type' => 'Periodica',
        'result' => 'Conforme',
    ]);

    expect($device->needs_verification)->toBeTrue();
});

it('binds the verifications relation manager to a relation that exists', function (): void {
    $relationship = DeviceVerificationsRelationManager::getRelationshipName();

    expect(method_exists(Device::class, $relationship))->toBeTrue();

    $relation = (new Device())->{$relationship}();
    if (! $relation instanceof HasMany) {
        throw new RuntimeException("Device::{$relationship}() non restituisce una HasMany");
    }

    expect($relation->getRelated())->toBeInstanceOf(DeviceVerification::class);
});

it('lets appointments and phone calls belong to a client', function (string $model): void {
    /** @var Appointment|PhoneCall $instance */
    $instance = new $model();

    expect($instance->client()->getForeignKeyName())->toBe('client_id');
})->with([Appointment::class, PhoneCall::class]);
