<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Models\BaseModel;

function createTechPlannerTestBaseModel(): BaseModel
{
    return new class() extends BaseModel
    {
        protected $table = 'test_techplanner_table';
    };
}

test('base model extends eloquent model', function () {
    expect(createTechPlannerTestBaseModel())->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function () {
    expect(createTechPlannerTestBaseModel()->getTable())->toBe('test_techplanner_table');
});

test('base model can be instantiated', function () {
    expect(createTechPlannerTestBaseModel())->toBeInstanceOf(BaseModel::class);
});

test('base model has proper inheritance chain', function () {
    $baseModel = createTechPlannerTestBaseModel();
    expect($baseModel)->toBeInstanceOf(BaseModel::class);
    expect($baseModel)->toBeInstanceOf(Model::class);
});

test('base model has timestamps enabled', function () {
    expect(createTechPlannerTestBaseModel()->usesTimestamps())->toBeTrue();
});
