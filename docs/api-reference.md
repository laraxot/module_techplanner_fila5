# TechPlanner API Reference

## Overview
This document provides a comprehensive reference for all APIs, services, and actions available in the TechPlanner module.

## Core Models

### Client Model
**Namespace**: `Modules\TechPlanner\Models\Client`

#### Properties
- `id` (string): Primary identifier
- `business_name` (string): Client business name
- `vat_number` (string): VAT number
- `fiscal_code` (string): Fiscal code
- `address` (string): Full address
- `city` (string): City
- `province` (string): Province code
- `postal_code` (string): Postal code
- `country` (string): Country code
- `phone` (string): Phone number
- `mobile` (string): Mobile number
- `email` (string): Email address
- `pec` (string): PEC address
- `whatsapp` (string): WhatsApp number
- `is_active` (boolean): Business status
- `legal_representative_id` (string): Legal representative reference
- `medical_director_id` (string): Medical director reference

#### Relationships
- `legalRepresentative` (BelongsTo): Legal representative
- `medicalDirector` (BelongsTo): Medical director
- `appointments` (HasMany): Scheduled appointments
- `devices` (HasMany): Registered devices
- `contacts` (HasMany): Additional contacts

#### Methods
```php
// Get full address with formatting
public function getFullAddressAttribute(): string

// Check if client has active devices
public function hasActiveDevices(): bool

// Get upcoming appointments
public function getUpcomingAppointments(): Collection

// Get compliance status
public function getComplianceStatus(): string
```

### Appointment Model
**Namespace**: `Modules\TechPlanner\Models\Appointment`

#### Properties
- `id` (string): Primary identifier
- `client_id` (string): Client reference
- `technician_id` (string): Technician reference
- `device_id` (string): Device reference
- `appointment_type` (string): Type of appointment
- `scheduled_date` (datetime): Scheduled date and time
- `duration` (integer): Duration in minutes
- `status` (string): Appointment status
- `notes` (text): Appointment notes
- `location` (string): Location address

#### Relationships
- `client` (BelongsTo): Client information
- `technician` (BelongsTo): Assigned technician
- `device` (BelongsTo): Device being serviced
- `reports` (HasMany): Inspection reports

### Device Model
**Namespace**: `Modules\TechPlanner\Models\Device`

#### Properties
- `id` (string): Primary identifier
- `client_id` (string): Owner client
- `device_type` (string): Type/category of device
- `brand` (string): Device brand
- `model` (string): Device model
- `serial_number` (string): Serial number
- `purchase_date` (date): Purchase date
- `warranty_expiry` (date): Warranty expiry
- `last_inspection` (date): Last inspection date
- `next_inspection` (date): Next required inspection
- `status` (string): Current status

#### Relationships
- `client` (BelongsTo): Owner client
- `appointments` (HasMany): Service appointments
- `reports` (HasMany): Inspection reports

## Services

### ClientService
**Namespace**: `Modules\TechPlanner\Services\ClientService`

#### Methods
```php
// Create new client with validation
public function createClient(array $data): Client

// Update client information
public function updateClient(string $clientId, array $data): Client

// Deactivate client
public function deactivateClient(string $clientId): bool

// Get clients by compliance status
public function getClientsByCompliance(string $status): Collection

// Search clients by criteria
public function searchClients(array $criteria): Collection
```

### AppointmentService
**Namespace**: `Modules\TechPlanner\Services\AppointmentService`

#### Methods
```php
// Schedule new appointment
public function scheduleAppointment(array $data): Appointment

// Reschedule appointment
public function rescheduleAppointment(string $appointmentId, DateTime $newDate): Appointment

// Cancel appointment
public function cancelAppointment(string $appointmentId, string $reason): bool

// Get technician availability
public function getTechnicianAvailability(string $technicianId, DateTime $date): array

// Generate appointment reports
public function generateReport(string $appointmentId): array
```

### DeviceService
**Namespace**: `Modules\TechPlanner\Services\DeviceService`

#### Methods
```php
// Register new device
public function registerDevice(array $data): Device

// Update device information
public function updateDevice(string $deviceId, array $data): Device

// Schedule next inspection
public function scheduleInspection(string $deviceId, DateTime $date): bool

// Get devices requiring inspection
public function getDevicesRequiringInspection(): Collection

// Generate compliance certificate
public function generateComplianceCertificate(string $deviceId): array
```

## Actions

### CreateClientAction
**Namespace**: `Modules\TechPlanner\Actions\CreateClientAction`

#### Usage
```php
$action = new CreateClientAction();
$client = $action->execute([
    'business_name' => 'Company Name',
    'vat_number' => 'IT123456789',
    // ... other fields
]);
```

### ScheduleAppointmentAction
**Namespace**: `Modules\TechPlanner\Actions\ScheduleAppointmentAction`

#### Usage
```php
$action = new ScheduleAppointmentAction();
$appointment = $action->execute([
    'client_id' => 'client-uuid',
    'technician_id' => 'tech-uuid',
    'scheduled_date' => now()->addDays(7),
    // ... other fields
]);
```

### RegisterDeviceAction
**Namespace**: `Modules\TechPlanner\Actions\RegisterDeviceAction`

#### Usage
```php
$action = new RegisterDeviceAction();
$device = $action->execute([
    'client_id' => 'client-uuid',
    'device_type' => 'medical-imaging',
    'brand' => 'Siemens',
    'model' => 'MRI-2000',
    // ... other fields
]);
```

## Events

### AppointmentScheduled
**Namespace**: `Modules\TechPlanner\Events\AppointmentScheduled`

#### Properties
- `appointment` (Appointment): The scheduled appointment

### DeviceRegistered
**Namespace**: `Modules\TechPlanner\Events\DeviceRegistered`

#### Properties
- `device` (Device): The registered device

### ClientCreated
**Namespace**: `Modules\TechPlanner\Events\ClientCreated`

#### Properties
- `client` (Client): The created client

## Listeners

### SendAppointmentNotification
**Namespace**: `Modules\TechPlanner\Listeners\SendAppointmentNotification`

Handles sending notifications when appointments are scheduled.

### UpdateComplianceStatus
**Namespace**: `Modules\TechPlanner\Listeners\UpdateComplianceStatus`

Updates compliance status when devices are inspected.

## Notifications

### AppointmentReminder
**Namespace**: `Modules\TechPlanner\Notifications\AppointmentReminder`

Sent to clients before scheduled appointments.

### InspectionDue
**Namespace**: `Modules\TechPlanner\Notifications\InspectionDue`

Sent when device inspections are due.

## Rules

### ValidVatNumber
**Namespace**: `Modules\TechPlanner\Rules\ValidVatNumber`

Validates Italian VAT number format.

### ValidFiscalCode
**Namespace**: `Modules\TechPlanner\Rules\ValidFiscalCode`

Validates Italian fiscal code format.

## Jobs

### GenerateComplianceReport
**Namespace**: `Modules\TechPlanner\Jobs\GenerateComplianceReport`

Generates monthly compliance reports for all clients.

### SendInspectionReminders
**Namespace**: `Modules\TechPlanner\Jobs\SendInspectionReminders`

Sends reminders for upcoming inspections.

## Middleware

### CheckTechnicianAvailability
**Namespace**: `Modules\TechPlanner\Http\Middleware\CheckTechnicianAvailability`

Ensures technician is available before scheduling appointments.

## Configuration

### config/techplanner.php
```php
return [
    'appointment' => [
        'default_duration' => 60, // minutes
        'reminder_hours' => [24, 48], // hours before appointment
        'buffer_time' => 15, // minutes between appointments
    ],
    'compliance' => [
        'inspection_interval_days' => 365,
        'grace_period_days' => 30,
        'certificate_valid_days' => 365,
    ],
    'notifications' => [
        'email' => true,
        'sms' => true,
        'whatsapp' => false,
    ],
];
```

## API Endpoints (if using API routes)

### Clients
- `GET /api/techplanner/clients` - List all clients
- `POST /api/techplanner/clients` - Create new client
- `GET /api/techplanner/clients/{id}` - Get client details
- `PUT /api/techplanner/clients/{id}` - Update client
- `DELETE /api/techplanner/clients/{id}` - Delete client

### Appointments
- `GET /api/techplanner/appointments` - List appointments
- `POST /api/techplanner/appointments` - Schedule appointment
- `GET /api/techplanner/appointments/{id}` - Get appointment details
- `PUT /api/techplanner/appointments/{id}` - Update appointment
- `DELETE /api/techplanner/appointments/{id}` - Cancel appointment

### Devices
- `GET /api/techplanner/devices` - List devices
- `POST /api/techplanner/devices` - Register device
- `GET /api/techplanner/devices/{id}` - Get device details
- `PUT /api/techplanner/devices/{id}` - Update device
- `DELETE /api/techplanner/devices/{id}` - Remove device

## Testing

### Test Classes
- `ClientTest` - Test client model and service
- `AppointmentTest` - Test appointment scheduling
- `DeviceTest` - Test device management
- `TechPlannerTestCase` - Base test class for module

## Common Patterns

### Creating a New Entity
1. Create Model with proper relationships
2. Create Migration for database structure
3. Create Factory for testing
4. Create Service for business logic
5. Create Action for complex operations
6. Create Filament Resource for admin interface
7. Write Tests
8. Update Documentation

### Validation Rules
All input validation should use:
- Form Requests for complex validation
- Custom Rules for business-specific validation
- Model events for data integrity

### Notifications
Use Laravel's notification system with:
- Email templates for formal communications
- SMS for urgent notifications
- Database notifications for in-app alerts