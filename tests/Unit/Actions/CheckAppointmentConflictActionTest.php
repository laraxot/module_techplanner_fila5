<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\TechPlanner\Actions\CheckAppointmentConflictAction;
use Modules\TechPlanner\Enums\AppointmentStatusEnum;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    if (! Schema::hasTable('appointments')) {
        Schema::create('appointments', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedInteger('worker_id')->nullable();
            $table->dateTime('date');
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    DB::table('appointments')->delete();
});

function seedAppointment(int $workerId, string $date, int $duration, string $status = 'scheduled'): int
{
    return (int) DB::table('appointments')->insertGetId([
        'worker_id' => $workerId,
        'client_id' => 1,
        'date' => $date,
        'duration_minutes' => $duration,
        'status' => $status,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

it('returns null when the worker has no appointments', function (): void {
    $conflict = app(CheckAppointmentConflictAction::class)->execute(
        7,
        Carbon::parse('2026-03-10 10:00'),
        60,
    );

    expect($conflict)->toBeNull();
});

it('detects an overlapping appointment for the same worker', function (): void {
    seedAppointment(7, '2026-03-10 10:00:00', 60);

    $conflict = app(CheckAppointmentConflictAction::class)->execute(
        7,
        Carbon::parse('2026-03-10 10:30:00'),
        60,
    );

    expect($conflict)->toBeInstanceOf(Appointment::class);
    Assert::assertNotNull($conflict);
    expect($conflict->worker_id)->toBe(7);
});

it('ignores adjacent appointments that only touch the boundary', function (): void {
    seedAppointment(7, '2026-03-10 09:00:00', 60);

    $conflict = app(CheckAppointmentConflictAction::class)->execute(
        7,
        Carbon::parse('2026-03-10 10:00:00'),
        60,
    );

    expect($conflict)->toBeNull();
});

it('ignores appointments of other workers', function (): void {
    seedAppointment(7, '2026-03-10 10:00:00', 60);

    $conflict = app(CheckAppointmentConflictAction::class)->execute(
        8,
        Carbon::parse('2026-03-10 10:30:00'),
        60,
    );

    expect($conflict)->toBeNull();
});

it('ignores terminal statuses that no longer occupy the agenda', function (): void {
    seedAppointment(7, '2026-03-10 10:00:00', 60, AppointmentStatusEnum::COMPLETED->value);
    seedAppointment(7, '2026-03-10 11:00:00', 60, AppointmentStatusEnum::CANCELLED->value);
    seedAppointment(7, '2026-03-10 12:00:00', 60, AppointmentStatusEnum::NO_SHOW->value);

    $conflict = app(CheckAppointmentConflictAction::class)->execute(
        7,
        Carbon::parse('2026-03-10 10:30:00'),
        240,
    );

    expect($conflict)->toBeNull();
});

it('excludes the appointment being edited', function (): void {
    $id = seedAppointment(7, '2026-03-10 10:00:00', 60);

    $conflict = app(CheckAppointmentConflictAction::class)->execute(
        7,
        Carbon::parse('2026-03-10 10:30:00'),
        60,
        $id,
    );

    expect($conflict)->toBeNull();
});
