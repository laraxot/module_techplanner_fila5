<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Control;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

it('exposes the latest appointment as a has-one relation on appointments', function () {
    $client = new Client();

    $relation = $client->latestAppointment();

    expect($relation->getQualifiedForeignKeyName())->toBe('appointments.client_id')
        ->and($relation->getParent()->getKeyName())->toBe('id')
        ->and($relation->getRelated()::class)->toBe(Appointment::class);
});

it('exposes appointment controls as a has-many relation', function () {
    $appointment = new Appointment();

    $relation = $appointment->controls();

    expect($relation->getQualifiedForeignKeyName())->toBe('controls.appointment_id')
        ->and($relation->getRelated()::class)->toBe(Control::class);
});
