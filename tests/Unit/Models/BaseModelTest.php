<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Models\BaseModel;

use function Safe\class_parents;

beforeEach(function () {
    // Il boot del modello anonimo fa scattare `eloquent.booting`, intercettato
    // dal wildcard subscriber di event-sourcing la cui istanza singleton può
    // non essere risolvibile in test: i metadata non richiedono eventi.
    $this->baseModel = Model::withoutEvents(static fn () => new class() extends BaseModel
    {
        protected $table = 'test_techplanner_table';
    });
});

test('base model has correct table name', function () {
    expect($this->baseModel->getTable())->toBe('test_techplanner_table');
});

test('base model has proper inheritance chain', function () {
    $parents = class_parents($this->baseModel);

    expect($parents)->toContain(BaseModel::class);
    expect($parents)->toContain(Model::class);
});

test('base model has timestamps enabled', function () {
    expect($this->baseModel->usesTimestamps())->toBeTrue();
});
