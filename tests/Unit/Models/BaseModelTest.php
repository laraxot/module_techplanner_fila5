<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Models\BaseModel;

beforeEach(function () {
    /** @var \Modules\TechPlanner\Tests\TestCase $this */
        $this->baseModel = new class() extends BaseModel
    {
        protected $table = 'test_techplanner_table';
    };
});

test('base model extends eloquent model', function () {
    /** @var \Modules\TechPlanner\Tests\TestCase $this */
        expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function () {
    /** @var \Modules\TechPlanner\Tests\TestCase $this */
        expect($this->baseModel->getTable())->toBe('test_techplanner_table');
});

test('base model can be instantiated', function () {
    /** @var \Modules\TechPlanner\Tests\TestCase $this */
        expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
});

test('base model has proper inheritance chain', function () {
    /** @var \Modules\TechPlanner\Tests\TestCase $this */
        expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has timestamps enabled', function () {
    /** @var \Modules\TechPlanner\Tests\TestCase $this */
        expect($this->baseModel->usesTimestamps())->toBeTrue();
});
