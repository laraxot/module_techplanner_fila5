<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Feature;

use Carbon\Carbon;

beforeEach(function () {
    $this->project = createProject([
        'name' => 'Test Project',
        'status' => 'active',
        'start_date' => Carbon::today(),
        'end_date' => Carbon::today()->addDays(30),
    ]);
});

describe('Project Management Business Logic', function () {
    test('project can be created with valid data', function () {
        $project = createProject([
            'name' => 'New Project',
            'description' => 'Project description',
            'status' => 'planning',
        ]);

        expect($project)
            ->toBeProject()
            ->and($project->name)
            ->toBe('New Project')
            ->and($project->status)
            ->toBe('planning');
    });

    test('project can have multiple tasks', function () {
        $task1 = createTask([
            'project_id' => $this->project->id,
            'name' => 'Task 1',
            'status' => 'pending',
        ]);

        $task2 = createTask([
            'project_id' => $this->project->id,
            'name' => 'Task 2',
            'status' => 'in_progress',
        ]);

        expect($this->project->tasks)
            ->toHaveCount(2)
            ->and($this->project->tasks->first()->name)
            ->toBe('Task 1')
            ->and($this->project->tasks->last()->name)
            ->toBe('Task 2');
    });

    test('project calculates completion percentage correctly', function () {
        createTask([
            'project_id' => $this->project->id,
            'name' => 'Completed Task',
            'status' => 'completed',
        ]);

        createTask([
            'project_id' => $this->project->id,
            'name' => 'Pending Task',
            'status' => 'pending',
        ]);

        $completionPercentage = $this->project->getCompletionPercentage();
        expect($completionPercentage)->toBe(50.0);
    });

    test('project can be assigned resources', function () {
        $resource = createResource([
            'name' => 'Developer',
            'type' => 'human',
            'availability' => 100,
        ]);

        $this->project->resources()->attach($resource->id, [
            'allocation_percentage' => 80,
            'start_date' => Carbon::today(),
            'end_date' => Carbon::today()->addDays(15),
        ]);

        expect($this->project->resources)
            ->toHaveCount(1)
            ->and($this->project->resources->first()->name)
            ->toBe('Developer')
            ->and($this->project->resources->first()->pivot->allocation_percentage)
            ->toBe(80);
    });

    test('project validates date constraints', function () {
        $project = makeProject([
            'start_date' => Carbon::today()->addDays(10),
            'end_date' => Carbon::today()->addDays(5), // Invalid: end before start
        ]);

        expect($project->isValidDateRange())->toBeFalse();
    });

    test('project can calculate total estimated hours', function () {
        createTask([
            'project_id' => $this->project->id,
            'estimated_hours' => 20,
        ]);

        createTask([
            'project_id' => $this->project->id,
            'estimated_hours' => 30,
        ]);

        $totalHours = $this->project->getTotalEstimatedHours();
        expect($totalHours)->toBe(50);
    });

    test('project status transitions are valid', function () {
        expect($this->project->canTransitionTo('in_progress'))->toBeTrue();
        expect($this->project->canTransitionTo('completed'))->toBeFalse(); // Can't skip to completed

        $this->project->update(['status' => 'in_progress']);
        expect($this->project->canTransitionTo('completed'))->toBeTrue();
        expect($this->project->canTransitionTo('planning'))->toBeFalse(); // Can't go backwards
    });
});

describe('Task Management', function () {
    test('task belongs to project', function () {
        $task = createTask([
            'project_id' => $this->project->id,
            'name' => 'Test Task',
        ]);

        expect($task->project_id)->toBe($this->project->id)->and($task->project->name)->toBe($this->project->name);
    });

    test('task can have dependencies', function () {
        $task1 = createTask([
            'project_id' => $this->project->id,
            'name' => 'First Task',
        ]);

        $task2 = createTask([
            'project_id' => $this->project->id,
            'name' => 'Second Task',
        ]);

        $task2->dependencies()->attach($task1->id);

        expect($task2->dependencies)->toHaveCount(1)->and($task2->dependencies->first()->name)->toBe('First Task');
    });

    test('task calculates progress correctly', function () {
        $task = createTask([
            'project_id' => $this->project->id,
            'estimated_hours' => 10,
            'actual_hours' => 6,
        ]);

        $progress = $task->getProgressPercentage();
        expect($progress)->toBe(60.0);
    });
});

describe('Resource Management', function () {
    test('resource can be allocated to multiple projects', function () {
        $resource = createResource([
            'name' => 'Senior Developer',
            'type' => 'human',
            'availability' => 100,
        ]);

        $project2 = createProject(['name' => 'Second Project']);

        $resource
            ->projects()
            ->attach([
                $this->project->id => ['allocation_percentage' => 50],
                $project2->id => ['allocation_percentage' => 30],
            ]);

        expect($resource->projects)->toHaveCount(2)->and($resource->getTotalAllocation())->toBe(80);
    });

    test('resource availability is calculated correctly', function () {
        $resource = createResource([
            'name' => 'Designer',
            'availability' => 100,
        ]);

        $resource->projects()->attach($this->project->id, [
            'allocation_percentage' => 60,
        ]);

        expect($resource->getAvailableCapacity())->toBe(40);
    });
});

describe('Project Analytics', function () {
    test('project tracks time accurately', function () {
        $task = createTask([
            'project_id' => $this->project->id,
            'estimated_hours' => 20,
            'actual_hours' => 25,
        ]);

        expect($this->project->isOverBudget())->toBeTrue()->and($this->project->getBudgetVariance())->toBe(5);
    });

    test('project calculates critical path', function () {
        $task1 = createTask([
            'project_id' => $this->project->id,
            'name' => 'Critical Task 1',
            'estimated_hours' => 10,
        ]);

        $task2 = createTask([
            'project_id' => $this->project->id,
            'name' => 'Critical Task 2',
            'estimated_hours' => 15,
        ]);

        $task2->dependencies()->attach($task1->id);

        $criticalPath = $this->project->getCriticalPath();
        expect($criticalPath)->toHaveCount(2)->and($criticalPath->sum('estimated_hours'))->toBe(25);
    });
});
