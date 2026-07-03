# AppointmentResource - TechPlanner

## 📋 Overview

**Resource**: `Modules\TechPlanner\Filament\Resources\AppointmentResource`
**Model**: `Modules\TechPlanner\Models\Appointment`

## 🎯 Purpose

Manages appointments within the TechPlanner module, providing CRUD operations for scheduling and tracking client appointments.

## 🔧 Current Implementation

### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Select::make('client_id')
            ->relationship('client', 'name')
            ->required(),
        Forms\Components\DatePicker::make('date')
            ->required(),
        Forms\Components\TimePicker::make('time')
            ->required(),
        Forms\Components\Select::make('status')
            ->options([
                'scheduled' => 'Scheduled',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])
            ->required(),
        Forms\Components\Textarea::make('notes')
            ->maxLength(65535)
            ->columnSpanFull(),
    ];
}
```

### Pages Configuration
```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListAppointments::route('/'),
        'create' => Pages\CreateAppointment::route('/create'),
        'edit' => Pages\EditAppointment::route('/{record}/edit'),
    ];
}
```

## 📊 Fields Mapping

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| client_id | Select | ✅ | Relationship to Client model |
| date | DatePicker | ✅ | Appointment date |
| time | TimePicker | ✅ | Appointment time |
| status | Select | ✅ | Appointment status |
| notes | Textarea | ❌ | Additional notes |

## 🎨 Status Options

- **Scheduled**: Appointment is booked but not confirmed
- **Confirmed**: Client has confirmed attendance
- **Completed**: Appointment has been completed
- **Cancelled**: Appointment was cancelled

## 🔗 Relationships

### Client Relationship
```php
->relationship('client', 'name')
```
- Links to `Modules\TechPlanner\Models\Client`
- Displays client name in dropdown
- Required field for appointment creation

## 📋 Validation Rules

### Required Fields
- `client_id`: Must be a valid client ID
- `date`: Must be a valid date
- `time`: Must be a valid time
- `status`: Must be one of: scheduled, confirmed, completed, cancelled

### Optional Fields
- `notes`: Maximum length 65535 characters

## 🚀 Usage Examples

### Creating an Appointment
```php
// Through Filament interface
$appointment = Appointment::create([
    'client_id' => 1,
    'date' => '2025-01-15',
    'time' => '14:30:00',
    'status' => 'scheduled',
    'notes' => 'Initial consultation',
]);
```

### Querying Appointments
```php
// Get all scheduled appointments
$scheduled = Appointment::where('status', 'scheduled')->get();

// Get appointments for specific client
$clientAppointments = Appointment::where('client_id', $clientId)->get();
```

## 🛠️ Technical Implementation

### Inheritance
```php
class AppointmentResource extends XotBaseResource
```
- Inherits from `Modules\Xot\Filament\Resources\XotBaseResource`
- Provides base functionality for Filament resources

### Model Binding
```php
protected static ?string $model = Appointment::class;
```
- Binds to `Modules\TechPlanner\Models\Appointment`

## 📈 Performance Considerations

### Index Page Optimization
- Ensure proper indexing on `client_id`, `date`, and `status` fields
- Consider pagination for large datasets
- Implement search functionality for client names

### Form Performance
- Client dropdown uses relationship loading
- Date and time pickers are client-side components
- Status options are static for fast rendering

## 🔧 Customization Points

### Adding Custom Fields
```php
// In getFormSchema() method
Forms\Components\TextInput::make('custom_field')
    ->maxLength(255),
```

### Modifying Status Options
```php
// Update the status options array
'status' => Forms\Components\Select::make('status')
    ->options([
        'scheduled' => 'Programmato',
        'confirmed' => 'Confermato',
        // ... other options
    ])
```

### Adding Validation Rules
```php
// Add custom validation rules
'custom_field' => Forms\Components\TextInput::make('custom_field')
    ->maxLength(255)
    ->rules(['required', 'string', 'max:255']),
```

## 🧪 Testing

### Test Coverage
- **Unit Tests**: `Modules/TechPlanner/tests/Unit/Models/AppointmentTest.php`
- **Feature Tests**: `Modules/TechPlanner/tests/Feature/Filament/Resources/AppointmentResourceTest.php`

### Key Test Scenarios
- Appointment creation with valid data
- Validation of required fields
- Status transition validation
- Client relationship integrity
- Form rendering and submission

## 📚 Related Documentation

- [ClientResource Documentation](./client-resource.md)
- [XotBaseResource Documentation](../../Xot/docs/filament/xot-base-resource.md)
- [Filament Forms Documentation](https://filamentphp.com/docs/forms)
- [Laravel Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)

## 🔄 Version History

### v1.0.0 (Current)
- Initial implementation
- Basic CRUD operations
- Client relationship management
- Status-based workflow

### Planned Enhancements
- Recurring appointments support
- Calendar integration
- Email notifications
- Conflict detection
- Timezone support

---

*Last updated: September 2025*
*TechPlanner Module - Appointment Management*