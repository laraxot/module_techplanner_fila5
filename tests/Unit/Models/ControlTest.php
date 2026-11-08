<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Illuminate\Support\Facades\Schema;
use Modules\TechPlanner\Enums\ControlTypeEnum;
use Modules\TechPlanner\Models\Control;
use Modules\TechPlanner\Models\ElectromedicalControl;
use Modules\TechPlanner\Models\HealthAuthorizationControl;
use Modules\TechPlanner\Models\IntraoralControl;
use Modules\TechPlanner\Models\OtherControl;
use Modules\TechPlanner\Models\RxControl;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

it('maps every control type enum case to a child model', function (): void {
    $control = new Control;

    foreach (ControlTypeEnum::cases() as $case) {
        $childClass = $control->classFromAlias($case->value);

        expect($childClass)->not->toBe($case->value)
            ->and(is_subclass_of($childClass, Control::class))->toBeTrue();
    }
});

it('hydrates the correct child model from the discriminator column', function (): void {
    $cases = [
        ControlTypeEnum::RX->value => RxControl::class,
        ControlTypeEnum::INTRAORAL->value => IntraoralControl::class,
        ControlTypeEnum::HEALTH_AUTHORIZATION->value => HealthAuthorizationControl::class,
        ControlTypeEnum::ELECTROMEDICAL->value => ElectromedicalControl::class,
        ControlTypeEnum::OTHER->value => OtherControl::class,
    ];

    foreach ($cases as $alias => $expectedClass) {
        $model = (new Control)->newFromBuilder(['id' => 1, 'control_type' => $alias]);

        expect($model::class)->toBe($expectedClass);
    }
});

it('uses the controls table for parent and children', function (): void {
    expect((new Control)->getTable())->toBe('controls')
        ->and((new RxControl)->getTable())->toBe('controls')
        ->and((new IntraoralControl)->getTable())->toBe('controls')
        ->and((new HealthAuthorizationControl)->getTable())->toBe('controls')
        ->and((new ElectromedicalControl)->getTable())->toBe('controls')
        ->and((new OtherControl)->getTable())->toBe('controls');
});

it('exposes client, device and worker relationships', function (): void {
    $control = new Control;

    expect($control->client()->getForeignKeyName())->toBe('client_id')
        ->and($control->device()->getForeignKeyName())->toBe('device_id')
        ->and($control->worker()->getForeignKeyName())->toBe('worker_id')
        ->and($control->appointment()->getForeignKeyName())->toBe('appointment_id');
});

it('creates the controls table with the parental discriminator', function (): void {
    if (! Schema::hasTable('controls')) {
        $this->markTestSkipped('controls table not migrated in this test database.');
    }

    expect(Schema::hasColumn('controls', 'control_type'))->toBeTrue()
        ->and(Schema::hasColumn('controls', 'client_id'))->toBeTrue()
        ->and(Schema::hasColumn('controls', 'device_id'))->toBeTrue()
        ->and(Schema::hasColumn('controls', 'worker_id'))->toBeTrue();
});
