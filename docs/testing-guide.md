# TechPlanner Testing Guide

## Overview
This guide provides comprehensive testing strategies and examples for the TechPlanner module.

## Testing Setup

### Environment Configuration
Ensure your testing environment is properly configured:

1. **Database Setup**
```bash
# Use SQLite for testing
php artisan config:cache --env=testing
php artisan migrate:fresh --env=testing
```

2. **Test Database Configuration**
```php
// config/database.php (testing environment)
'connections' => [
    'testing' => [
        'driver' => 'sqlite',
        'database' => ':memory:',
        'prefix' => '',
    ],
],
```

## Test Structure

### Base Test Class
Create a base test class for common functionality:

```php
<?php

namespace Modules\TechPlanner\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\TechPlanner\Database\Seeders\TechPlannerDatabaseSeeder;

abstract class TechPlannerTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->seed(TechPlannerDatabaseSeeder::class);
        $this->actingAs($this->createUser());
    }

    protected function createUser()
    {
        return \Modules\User\Models\User::factory()->create();
    }

    protected function createClient(array $attributes = [])
    {
        return \Modules\TechPlanner\Models\Client::factory()->create($attributes);
    }

    protected function createAppointment(array $attributes = [])
    {
        return \Modules\TechPlanner\Models\Appointment::factory()->create($attributes);
    }

    protected function createDevice(array $attributes = [])
    {
        return \Modules\TechPlanner\Models\Device::factory()->create($attributes);
    }
}
```

## Model Tests

### Client Model Test
```php
<?php

namespace Modules\TechPlanner\Tests\Unit\Models;

use Modules\TechPlanner\Tests\TechPlannerTestCase;
use Modules\TechPlanner\Models\Client;

class ClientTest extends TechPlannerTestCase
{
    /** @test */
    public function it_can_create_a_client()
    {
        $client = Client::factory()->create([
            'business_name' => 'Test Company',
            'vat_number' => 'IT12345678901',
        ]);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('Test Company', $client->business_name);
        $this->assertEquals('IT12345678901', $client->vat_number);
    }

    /** @test */
    public function it_has_many_appointments()
    {
        $client = $this->createClient();
        $appointment = $this->createAppointment(['client_id' => $client->id]);

        $this->assertCount(1, $client->appointments);
        $this->assertEquals($appointment->id, $client->appointments->first()->id);
    }

    /** @test */
    public function it_has_many_devices()
    {
        $client = $this->createClient();
        $device = $this->createDevice(['client_id' => $client->id]);

        $this->assertCount(1, $client->devices);
        $this->assertEquals($device->id, $client->devices->first()->id);
    }

    /** @test */
    public function it_returns_full_address()
    {
        $client = $this->createClient([
            'address' => 'Via Roma 1',
            'city' => 'Milano',
            'postal_code' => '20100',
            'province' => 'MI',
        ]);

        $expected = 'Via Roma 1, 20100 Milano (MI)';
        $this->assertEquals($expected, $client->full_address);
    }

    /** @test */
    public function it_checks_active_devices()
    {
        $client = $this->createClient();
        $this->createDevice(['client_id' => $client->id, 'status' => 'active']);
        $this->createDevice(['client_id' => $client->id, 'status' => 'inactive']);

        $this->assertTrue($client->hasActiveDevices());
    }

    /** @test */
    public function it_gets_upcoming_appointments()
    {
        $client = $this->createClient();
        $pastAppointment = $this->createAppointment([
            'client_id' => $client->id,
            'scheduled_date' => now()->subDays(1),
        ]);
        $upcomingAppointment = $this->createAppointment([
            'client_id' => $client->id,
            'scheduled_date' => now()->addDays(1),
        ]);

        $upcoming = $client->getUpcomingAppointments();
        $this->assertCount(1, $upcoming);
        $this->assertEquals($upcomingAppointment->id, $upcoming->first()->id);
    }
}
```

### Appointment Model Test
```php
<?php

namespace Modules\TechPlanner\Tests\Unit\Models;

use Modules\TechPlanner\Tests\TechPlannerTestCase;
use Modules\TechPlanner\Models\Appointment;
use Carbon\Carbon;

class AppointmentTest extends TechPlannerTestCase
{
    /** @test */
    public function it_can_create_an_appointment()
    {
        $appointment = Appointment::factory()->create([
            'appointment_type' => 'inspection',
            'status' => 'scheduled',
        ]);

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals('inspection', $appointment->appointment_type);
        $this->assertEquals('scheduled', $appointment->status);
    }

    /** @test */
    public function it_belongs_to_client()
    {
        $client = $this->createClient();
        $appointment = $this->createAppointment(['client_id' => $client->id]);

        $this->assertInstanceOf(\Modules\TechPlanner\Models\Client::class, $appointment->client);
        $this->assertEquals($client->id, $appointment->client->id);
    }

    /** @test */
    public function it_can_be_rescheduled()
    {
        $appointment = $this->createAppointment();
        $newDate = now()->addDays(2);

        $appointment->reschedule($newDate);

        $this->assertEquals($newDate, $appointment->scheduled_date);
        $this->assertEquals('rescheduled', $appointment->status);
    }

    /** @test */
    public function it_can_be_cancelled()
    {
        $appointment = $this->createAppointment();

        $appointment->cancel('Client request');

        $this->assertEquals('cancelled', $appointment->status);
        $this->assertEquals('Client request', $appointment->cancellation_reason);
    }
}
```

## Service Tests

### ClientService Test
```php
<?php

namespace Modules\TechPlanner\Tests\Unit\Services;

use Modules\TechPlanner\Tests\TechPlannerTestCase;
use Modules\TechPlanner\Services\ClientService;
use Modules\TechPlanner\Models\Client;

class ClientServiceTest extends TechPlannerTestCase
{
    private ClientService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ClientService::class);
    }

    /** @test */
    public function it_can_create_a_client()
    {
        $data = [
            'business_name' => 'New Company',
            'vat_number' => 'IT98765432109',
            'email' => 'info@newcompany.com',
        ];

        $client = $this->service->createClient($data);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', $data);
    }

    /** @test */
    public function it_validates_vat_number()
    {
        $data = [
            'business_name' => 'Invalid Company',
            'vat_number' => 'INVALID',
            'email' => 'info@invalid.com',
        ];

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->service->createClient($data);
    }

    /** @test */
    public function it_can_update_client()
    {
        $client = $this->createClient();
        $updateData = [
            'business_name' => 'Updated Company',
        ];

        $updated = $this->service->updateClient($client->id, $updateData);

        $this->assertEquals('Updated Company', $updated->business_name);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'business_name' => 'Updated Company',
        ]);
    }

    /** @test */
    public function it_can_deactivate_client()
    {
        $client = $this->createClient(['is_active' => true]);

        $result = $this->service->deactivateClient($client->id);

        $this->assertTrue($result);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'is_active' => false,
        ]);
    }

    /** @test */
    public function it_can_search_clients()
    {
        $client1 = $this->createClient(['business_name' => 'Alpha Company']);
        $client2 = $this->createClient(['business_name' => 'Beta Company']);
        $client3 = $this->createClient(['business_name' => 'Gamma Company']);

        $results = $this->service->searchClients(['business_name' => 'Company']);

        $this->assertCount(3, $results);

        $results = $this->service->searchClients(['business_name' => 'Alpha']);

        $this->assertCount(1, $results);
        $this->assertEquals($client1->id, $results->first()->id);
    }
}
```

## Action Tests

### CreateClientAction Test
```php
<?php

namespace Modules\TechPlanner\Tests\Unit\Actions;

use Modules\TechPlanner\Tests\TechPlannerTestCase;
use Modules\TechPlanner\Actions\CreateClientAction;
use Modules\TechPlanner\Models\Client;
use Illuminate\Support\Facades\Event;

class CreateClientActionTest extends TechPlannerTestCase
{
    /** @test */
    public function it_creates_client_and_fires_event()
    {
        Event::fake();

        $action = new CreateClientAction();
        $data = [
            'business_name' => 'Test Company',
            'vat_number' => 'IT12345678901',
            'email' => 'test@example.com',
        ];

        $client = $action->execute($data);

        $this->assertInstanceOf(Client::class, $client);
        $this->assertDatabaseHas('clients', $data);

        Event::assertDispatched(\Modules\TechPlanner\Events\ClientCreated::class, function ($event) use ($client) {
            return $event->client->id === $client->id;
        });
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $action = new CreateClientAction();
        $data = []; // Empty data

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $action->execute($data);
    }
}
```

## Feature Tests

### Client Management Feature Test
```php
<?php

namespace Modules\TechPlanner\Tests\Feature;

use Modules\TechPlanner\Tests\TechPlannerTestCase;
use Modules\TechPlanner\Models\Client;

class ClientManagementTest extends TechPlannerTestCase
{
    /** @test */
    public function it_can_list_clients()
    {
        $clients = Client::factory()->count(3)->create();

        $response = $this->get('/admin/techplanner/clients');

        $response->assertStatus(200);
        $response->assertSee($clients[0]->business_name);
        $response->assertSee($clients[1]->business_name);
        $response->assertSee($clients[2]->business_name);
    }

    /** @test */
    public function it_can_create_client()
    {
        $data = [
            'business_name' => 'New Test Company',
            'vat_number' => 'IT12345678901',
            'email' => 'test@company.com',
        ];

        $response = $this->post('/admin/techplanner/clients', $data);

        $response->assertRedirect('/admin/techplanner/clients');
        $this->assertDatabaseHas('clients', $data);
    }

    /** @test */
    public function it_can_edit_client()
    {
        $client = $this->createClient();

        $response = $this->get("/admin/techplanner/clients/{$client->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($client->business_name);
    }

    /** @test */
    public function it_can_update_client()
    {
        $client = $this->createClient();
        $updateData = [
            'business_name' => 'Updated Company',
            'vat_number' => $client->vat_number,
            'email' => $client->email,
        ];

        $response = $this->put("/admin/techplanner/clients/{$client->id}", $updateData);

        $response->assertRedirect('/admin/techplanner/clients');
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'business_name' => 'Updated Company',
        ]);
    }

    /** @test */
    public function it_can_delete_client()
    {
        $client = $this->createClient();

        $response = $this->delete("/admin/techplanner/clients/{$client->id}");

        $response->assertRedirect('/admin/techplanner/clients');
        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }
}
```

## API Tests (if applicable)

### Client API Test
```php
<?php

namespace Modules\TechPlanner\Tests\Feature\Api;

use Modules\TechPlanner\Tests\TechPlannerTestCase;
use Modules\TechPlanner\Models\Client;

class ClientApiTest extends TechPlannerTestCase
{
    /** @test */
    public function it_can_list_clients_via_api()
    {
        Client::factory()->count(3)->create();

        $response = $this->getJson('/api/techplanner/clients');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_create_client_via_api()
    {
        $data = [
            'business_name' => 'API Test Company',
            'vat_number' => 'IT12345678901',
            'email' => 'api@test.com',
        ];

        $response = $this->postJson('/api/techplanner/clients', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
        $this->assertDatabaseHas('clients', $data);
    }

    /** @test */
    public function it_validates_api_requests()
    {
        $data = [
            'business_name' => '', // Invalid
        ];

        $response = $this->postJson('/api/techplanner/clients', $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['business_name']);
    }
}
```

## Browser Tests (Dusk)

### Appointment Creation Browser Test
```php
<?php

namespace Modules\TechPlanner\Tests\Browser;

use Laravel\Dusk\Browser;
use Modules\TechPlanner\Tests\DuskTestCase;
use Modules\TechPlanner\Models\Client;

class AppointmentCreationTest extends DuskTestCase
{
    /** @test */
    public function it_can_create_appointment_via_browser()
    {
        $client = Client::factory()->create();

        $this->browse(function (Browser $browser) use ($client) {
            $browser->visit('/admin/techplanner/appointments/create')
                    ->select('client_id', $client->id)
                    ->type('scheduled_date', now()->addDays(1)->format('Y-m-d\TH:i'))
                    ->select('appointment_type', 'inspection')
                    ->press('Create Appointment')
                    ->waitForText('Appointment created successfully')
                    ->assertPathIs('/admin/techplanner/appointments');
        });

        $this->assertDatabaseHas('appointments', [
            'client_id' => $client->id,
            'appointment_type' => 'inspection',
        ]);
    }
}
```

## Test Utilities

### Custom Assertions
```php
<?php

namespace Modules\TechPlanner\Tests\Assertions;

trait TechPlannerAssertions
{
    public function assertClientHasActiveDevices($clientId)
    {
        $client = \Modules\TechPlanner\Models\Client::find($clientId);
        $this->assertTrue($client->hasActiveDevices(), 'Client should have active devices');
    }

    public function assertAppointmentIsScheduled($appointmentId)
    {
        $appointment = \Modules\TechPlanner\Models\Appointment::find($appointmentId);
        $this->assertEquals('scheduled', $appointment->status);
    }

    public function assertDeviceRequiresInspection($deviceId)
    {
        $device = \Modules\TechPlanner\Models\Device::find($deviceId);
        $this->assertLessThanOrEqual(
            now()->addDays(30),
            $device->next_inspection,
            'Device should require inspection within 30 days'
        );
    }
}
```

### Test Helpers
```php
<?php

namespace Modules\TechPlanner\Tests\Helpers;

use Carbon\Carbon;

trait AppointmentHelpers
{
    protected function createAppointmentSlot($technicianId, $date, $duration = 60)
    {
        return [
            'technician_id' => $technicianId,
            'scheduled_date' => $date,
            'duration' => $duration,
            'status' => 'available',
        ];
    }

    protected function getOverlappingAppointments($technicianId, $startTime, $endTime)
    {
        return \Modules\TechPlanner\Models\Appointment::where('technician_id', $technicianId)
            ->where('scheduled_date', '<', $endTime)
            ->where('scheduled_date', '>', $startTime)
            ->get();
    }
}
```

## Running Tests

### Command Line
```bash
# Run all TechPlanner tests
php artisan test modules/TechPlanner/tests

# Run specific test file
php artisan test modules/TechPlanner/tests/Unit/Models/ClientTest.php

# Run with coverage
php artisan test --coverage modules/TechPlanner/tests

# Run in parallel
php artisan test --parallel modules/TechPlanner/tests
```

### GitHub Actions CI
```yaml
name: TechPlanner Tests

on:
  push:
    paths:
      - 'modules/TechPlanner/**'
  pull_request:
    paths:
      - 'modules/TechPlanner/**'

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: password
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=3
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: bcmath, pdo, sqlite, pdo_sqlite
        
    - name: Copy Environment File
      run: cp .env.example .env
      
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
      
    - name: Generate Application Key
      run: php artisan key:generate
      
    - name: Run Migrations
      run: php artisan migrate --force
      
    - name: Run Tests
      run: php artisan test modules/TechPlanner/tests
```

## Best Practices

1. **Test Naming**: Use descriptive test names that explain what is being tested
2. **Arrange-Act-Assert**: Structure tests clearly
3. **Test One Thing**: Each test should verify one specific behavior
4. **Use Factories**: Create test data using model factories
5. **Mock External Services**: Don't make real API calls in tests
6. **Test Edge Cases**: Test validation, errors, and boundary conditions
7. **Keep Tests Fast**: Use in-memory database for unit tests
8. **Clean Up**: Ensure tests clean up after themselves
9. **Document Tests**: Add comments for complex test scenarios
10. **Regular Review**: Review and update tests with code changes