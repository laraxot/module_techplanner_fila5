<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\TechPlanner\Models\Project;
use Modules\TechPlanner\Models\Resource;
use Modules\TechPlanner\Models\Task;

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | Il TestCase di default per tutti i test del modulo TechPlanner.
 * | Estende il TestCase specifico del modulo che fornisce il setup necessario.
 * |
 */

uses(TestCase::class)->uses(DatabaseTransactions::class)->in('Feature', 'Unit');

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | Aspettative globali per il modulo TechPlanner.
 * | Quando definisci expectation globali, saranno disponibili
 * | in tutti i test del modulo.
 * |
 */

expect()->extend('toBeProject', fn () => $this->toBeInstanceOf(Project::class));

expect()->extend('toBeTask', fn () => $this->toBeInstanceOf(Task::class));

expect()->extend('toBeResource', fn () => $this->toBeInstanceOf(Resource::class));

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 * |
 * | Funzioni helper globali per i test del modulo TechPlanner.
 * | Queste funzioni saranno disponibili in tutti i test.
 * |
 */

function createProject(array $attributes = []): Project
{
    return Project::factory()->create($attributes);
}

function makeProject(array $attributes = []): Project
{
    return Project::factory()->make($attributes);
}

function createTask(array $attributes = []): Task
{
    return Task::factory()->create($attributes);
}

function makeTask(array $attributes = []): Task
{
    return Task::factory()->make($attributes);
}

function createResource(array $attributes = []): Resource
{
    return Resource::factory()->create($attributes);
}

function makeResource(array $attributes = []): Resource
{
    return Resource::factory()->make($attributes);
}
