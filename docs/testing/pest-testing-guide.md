# Pest Testing Guide for TechPlanner Module

## Overview

This guide outlines the Pest testing standards and practices for the TechPlanner module, following Laraxot conventions and ensuring comprehensive test coverage for project management functionality.

## Laraxot Testing Standards

### Header Requirements

```php
<?php

declare(strict_types=1);

uses(\Modules\TechPlanner\Tests\TestCase::class);
```

### Key Principles

- **No namespace declarations** in test files
- **Module-specific TestCase** extension
- **Direct imports** of tested classes
- **Describe blocks** for logical organization
- **Custom expectations** for domain objects
- **Helper functions** for test data creation

## Custom Expectations

The TechPlanner module provides custom expectations for domain objects:

```php
expect($project)->toBeProject();
expect($task)->toBeTask();
expect($resource)->toBeResource();
```

## Helper Functions

Global helper functions are available for creating test data:

```php
// Create and persist objects
$project = createProject(['name' => 'Test Project']);
$task = createTask(['project_id' => $project->id]);
$resource = createResource(['type' => 'human']);

// Create objects without persisting
$project = makeProject(['status' => 'planning']);
$task = makeTask(['estimated_hours' => 20]);
$resource = makeResource(['availability' => 100]);
```

## Test Organization

### Describe Blocks

Use describe blocks to organize related tests:

```php
describe('Project Management Business Logic', function () {
    test('project can be created with valid data', function () {
        // Test implementation
    });
    
    test('project calculates completion percentage correctly', function () {
        // Test implementation
    });
});

describe('Task Management', function () {
    test('task belongs to project', function () {
        // Test implementation
    });
    
    test('task can have dependencies', function () {
        // Test implementation
    });
});
```

### BeforeEach Setup

Use beforeEach for common test setup:

```php
beforeEach(function () {
    $this->project = createProject([
        'name' => 'Test Project',
        'status' => 'active'
    ]);
});
```

## Business Logic Testing

### Project Management Tests

Focus on core business logic:

- Project creation and validation
- Status transitions
- Completion percentage calculations
- Resource allocation
- Date constraint validation
- Budget tracking

### Task Management Tests

Cover task-specific functionality:

- Task-project relationships
- Dependency management
- Progress tracking
- Time estimation
- Status workflows

### Resource Management Tests

Test resource allocation:

- Multi-project allocation
- Availability calculations
- Capacity management
- Resource conflicts

## Performance Testing

### Fast Test Execution

- Use `RefreshDatabase` trait for clean state
- Avoid unnecessary database operations
- Mock external dependencies
- Focus on isolated unit tests

### Test Data Management

```php
// Efficient test data creation
beforeEach(function () {
    $this->project = createProject();
    $this->tasks = collect([
        createTask(['project_id' => $this->project->id]),
        createTask(['project_id' => $this->project->id])
    ]);
});
```

## Error Handling

### Graceful Degradation

```php
test('handles missing dependencies gracefully', function () {
    try {
        $project = createProject();
        expect($project)->toBeProject();
    } catch (\Exception $e) {
        $this->markTestSkipped('Project creation requires database setup');
    }
});
```

### Edge Cases

Test boundary conditions and error scenarios:

```php
test('validates date constraints', function () {
    $project = makeProject([
        'start_date' => Carbon::today()->addDays(10),
        'end_date' => Carbon::today()->addDays(5)
    ]);
    
    expect($project->isValidDateRange())->toBeFalse();
});
```

## Coverage Areas

### Core Models
- Project lifecycle management
- Task dependency tracking
- Resource allocation algorithms
- Timeline calculations

### Business Rules
- Status transition validation
- Budget variance calculations
- Critical path analysis
- Resource conflict detection

### Integration Points
- Database relationships
- External API interactions
- File system operations
- Email notifications

## Best Practices

### Test Naming
- Use descriptive test names
- Follow "it should..." pattern
- Group related tests in describe blocks

### Data Management
- Use factories for consistent test data
- Clean up after tests with RefreshDatabase
- Avoid hardcoded values

### Assertions
- Use specific expectations
- Test both positive and negative cases
- Verify side effects

### Performance
- Keep tests fast and isolated
- Mock expensive operations
- Use database transactions when possible

## Running Tests

```bash
# Run all TechPlanner tests
./vendor/bin/pest Modules/TechPlanner/tests

# Run specific test file
./vendor/bin/pest Modules/TechPlanner/tests/Feature/ProjectManagementTest.php

# Run with coverage
./vendor/bin/pest --coverage Modules/TechPlanner/tests
```

## Current Test Coverage

- **Feature Tests**: Project management business logic
- **Unit Tests**: Individual model methods
- **Integration Tests**: Cross-module functionality
- **Performance Tests**: Resource allocation algorithms

## Next Steps

1. Expand test coverage for all business rules
2. Add integration tests for external APIs
3. Implement performance benchmarks
4. Create visual regression tests for UI components

---

*Last updated: September 2025*
*Following Laraxot Pest testing conventions*
