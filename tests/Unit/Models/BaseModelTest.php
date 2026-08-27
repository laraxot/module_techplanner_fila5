<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Models\BaseModel;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

function createTechPlannerTestBaseModel(): BaseModel
{
    return new class() extends BaseModel
    {
        protected $table = 'test_techplanner_table';
    };
}

test('base model extends eloquent model', function () {
    $this->assertInstanceOf(Model::class, createTechPlannerTestBaseModel());
});

test('base model has correct table name', function () {
    $this->assertSame('test_techplanner_table', createTechPlannerTestBaseModel()->getTable());
});

test('base model can be instantiated', function () {
    $this->assertInstanceOf(BaseModel::class, createTechPlannerTestBaseModel());
});

test('base model has proper inheritance chain', function () {
    $baseModel = createTechPlannerTestBaseModel();
    $this->assertInstanceOf(BaseModel::class, $baseModel);
    $this->assertInstanceOf(Model::class, $baseModel);
});

test('base model has timestamps enabled', function () {
    $this->assertTrue(createTechPlannerTestBaseModel()->usesTimestamps());
});
