# TechPlanner Filament Resources Documentation

**Last Updated**: 2025-01-23
**Status**: ✅ Complete Filament v4 Implementation

## 🎨 Overview

The TechPlanner module provides a complete set of Filament v4 resources for managing technical service operations. All resources follow the XotBaseResource pattern for consistency, type safety, and enhanced functionality.

## 🏗️ Resource Architecture

### Base Resource Pattern
All TechPlanner resources extend `XotBaseResource` which provides:
- **Type Safety**: Full PHPStan Level 9/10 compliance
- **Standardized UI**: Consistent form and table layouts
- **Permission Integration**: Role-based access control
- **Audit Trails**: Automatic creator/updater tracking
- **Relationship Management**: Proper foreign key handling

```php
abstract class XotBaseResource extends Resource
{
    // Provides foundation for all TechPlanner resources
    // Includes common patterns, permissions, and UI standards
}
```

## 📋 Core Resources

### 1. ClientResource
**File**: `app/Filament/Resources/ClientResource.php`
**Purpose**: Complete client lifecycle management

#### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        // Business Identity Section
        Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('company_name')
            ->maxLength(255),

        Forms\Components\TextInput::make('vat_number')
            ->unique(ignoreRecord: true)
            ->maxLength(255),

        Forms\Components\TextInput::make('fiscal_code')
            ->unique(ignoreRecord: true)
            ->maxLength(255),

        // Contact Information Section
        Forms\Components\Section::make('Contact Information')
            ->schema([
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),

                Forms\Components\TextInput::make('mobile')
                    ->tel()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),

                Forms\Components\TextInput::make('pec')
                    ->email()
                    ->label('PEC Email')
                    ->maxLength(255),

                Forms\Components\TextInput::make('whatsapp')
                    ->tel()
                    ->maxLength(255),
            ])
            ->columns(2),

        // Geographic Information Section
        Forms\Components\Section::make('Address Information')
            ->schema([
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),

                Forms\Components\TextInput::make('city')
                    ->maxLength(255),

                Forms\Components\TextInput::make('postal_code')
                    ->maxLength(10),

                Forms\Components\TextInput::make('province')
                    ->maxLength(255),

                Forms\Components\TextInput::make('country')
                    ->default('Italy')
                    ->maxLength(255),

                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->step(0.000001),

                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->step(0.000001),
            ])
            ->columns(2),

        // Business Management Section
        Forms\Components\Section::make('Business Information')
            ->schema([
                Forms\Components\Toggle::make('business_closed')
                    ->label('Business Closed'),

                Forms\Components\TextInput::make('competent_health_unit')
                    ->maxLength(255),

                Forms\Components\TextInput::make('administrative_reference')
                    ->maxLength(255),

                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ])
            ->columns(2),
    ];
}
```

#### Table Schema
```php
public static function getTableSchema(): array
{
    return [
        Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),

        Tables\Columns\TextColumn::make('company_name')
            ->searchable()
            ->toggleable(),

        Tables\Columns\TextColumn::make('city')
            ->searchable()
            ->sortable(),

        Tables\Columns\IconColumn::make('business_closed')
            ->boolean()
            ->label('Status'),

        // Custom HTML column for contacts
        Tables\Columns\TextColumn::make('contacts_html')
            ->label('Contacts')
            ->html()
            ->searchable(false)
            ->sortable(false),

        Tables\Columns\TextColumn::make('appointments_count')
            ->counts('appointments')
            ->label('Appointments'),

        Tables\Columns\TextColumn::make('devices_count')
            ->counts('devices')
            ->label('Devices'),
    ];
}
```

#### Business Features
- **Contact Display**: HTML-formatted contact information with action links
- **Geographic Integration**: Address parsing and coordinate management
- **Status Tracking**: Business operational status
- **Relationship Counts**: Quick overview of related entities

### 2. AppointmentResource
**File**: `app/Filament/Resources/AppointmentResource.php`
**Purpose**: Technical appointment scheduling and management

#### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Select::make('client_id')
            ->relationship('client', 'name')
            ->required()
            ->searchable()
            ->preload(),

        Forms\Components\DateTimePicker::make('date')
            ->required()
            ->native(false)
            ->displayFormat('d/m/Y H:i')
            ->minDate(now()),

        Forms\Components\Textarea::make('notes')
            ->maxLength(65535)
            ->columnSpanFull()
            ->placeholder('Appointment details, requirements, or special instructions...'),
    ];
}
```

#### Table Schema
```php
public static function getTableSchema(): array
{
    return [
        Tables\Columns\TextColumn::make('client.name')
            ->searchable()
            ->sortable()
            ->url(fn ($record) => ClientResource::getUrl('edit', ['record' => $record->client])),

        Tables\Columns\TextColumn::make('date')
            ->dateTime('d/m/Y H:i')
            ->sortable()
            ->color(fn ($record) => $record->date->isPast() ? 'danger' : 'success'),

        Tables\Columns\TextColumn::make('notes')
            ->limit(50)
            ->tooltip(fn ($record) => $record->notes),

        Tables\Columns\TextColumn::make('machines_count')
            ->counts('machines')
            ->label('Equipment'),
    ];
}
```

#### Business Features
- **Client Integration**: Direct relationship with client management
- **Date Validation**: Future date enforcement for new appointments
- **Equipment Tracking**: Machine association for inspections
- **Notes Management**: Detailed appointment requirements

### 3. DeviceResource
**File**: `app/Filament/Resources/DeviceResource.php`
**Purpose**: Device and equipment management

#### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Select::make('client_id')
            ->relationship('client', 'name')
            ->required()
            ->searchable(),

        Forms\Components\TextInput::make('device_type')
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('model')
            ->maxLength(255),

        Forms\Components\TextInput::make('serial_number')
            ->unique(ignoreRecord: true)
            ->maxLength(255),

        Forms\Components\DatePicker::make('installation_date')
            ->native(false),

        Forms\Components\DatePicker::make('last_inspection_date')
            ->native(false),

        Forms\Components\DatePicker::make('next_inspection_date')
            ->native(false)
            ->after('last_inspection_date'),

        Forms\Components\Select::make('status')
            ->options([
                'active' => 'Active',
                'maintenance' => 'Under Maintenance',
                'retired' => 'Retired',
                'pending' => 'Pending Installation',
            ])
            ->default('active'),
    ];
}
```

#### Business Features
- **Lifecycle Management**: Installation to retirement tracking
- **Inspection Scheduling**: Compliance inspection management
- **Status Tracking**: Operational status monitoring
- **Serial Number Management**: Unique identification

### 4. LegalRepresentativeResource
**File**: `app/Filament/Resources/LegalRepresentativeResource.php`
**Purpose**: Legal compliance contact management

**Business Logic**: Rappresentante legale dell'azienda cliente. Obbligatorio per alcune tipologie di clienti (strutture sanitarie, aziende con obblighi normativi). Gestisce dati identificativi e contatti del rappresentante legale.

#### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\Select::make('client_id')
            ->relationship('client', 'name')
            ->required()
            ->searchable(),

        Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('surname')
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('email')
            ->email()
            ->required()
            ->maxLength(255),

        Forms\Components\TextInput::make('phone')
            ->tel()
            ->maxLength(255),

        Forms\Components\TextInput::make('tax_code')
            ->maxLength(16),

        Forms\Components\TextInput::make('role')
            ->maxLength(255),
    ];
}
```

#### Table Columns (List Page)
```php
public function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name')->sortable()->searchable(),
        'email' => TextColumn::make('email')->searchable()->sortable(),
        'phone' => TextColumn::make('phone')->searchable(),
        'fiscal_code' => TextColumn::make('fiscal_code')->searchable(),
        'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
    ];
}
```

### 5. LegalOfficeResource
**File**: `app/Filament/Resources/LegalOfficeResource.php`
**Purpose**: Legal office reference management

**Business Logic**: Ufficio legale di riferimento per clienti con esigenze legali complesse. Gestisce informazioni complete dello studio legale (nome, indirizzo, contatti) associato al cliente. Utilizzato per compliance e gestione documentale.

#### Form Schema
```php
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required()->maxLength(255),
        'address' => TextInput::make('address')->required()->maxLength(255),
        'city' => TextInput::make('city')->required()->maxLength(255),
        'postal_code' => TextInput::make('postal_code')->required()->maxLength(10),
        'province' => TextInput::make('province')->required()->maxLength(2),
        'country' => TextInput::make('country')
            ->required()
            ->default('IT')
            ->maxLength(2),
        'phone' => TextInput::make('phone')->tel()->maxLength(255),
        'email' => TextInput::make('email')->email()->maxLength(255),
    ];
}
```

#### Table Columns (List Page)
```php
public function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name')->sortable()->searchable(),
        'city' => TextColumn::make('city')->sortable()->searchable(),
        'province' => TextColumn::make('province')->sortable()->searchable(),
        'phone' => TextColumn::make('phone')->searchable(),
        'email' => TextColumn::make('email')->searchable()->sortable(),
        'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
    ];
}
```

**Critical Pattern**: Le pagine List **DEVONO** implementare `getTableColumns()` quando la Resource viene usata come RelationManager. `XotBaseRelationManager` chiama questo metodo per ottenere le colonne della tabella dalla pagina List principale.

## 🎨 UI Patterns & Best Practices

### 1. Form Sections
Logical grouping of related fields:
```php
Forms\Components\Section::make('Contact Information')
    ->description('Primary contact methods for this client')
    ->schema([
        // Contact fields
    ])
    ->columns(2)
    ->collapsible();
```

### 2. Conditional Fields
Dynamic form behavior based on other field values:
```php
Forms\Components\TextInput::make('medical_director_required')
    ->visible(fn (Get $get) => $get('client_type') === 'healthcare');
```

### 3. Relationship Management
Proper handling of model relationships:
```php
Forms\Components\Select::make('client_id')
    ->relationship('client', 'name')
    ->required()
    ->searchable()
    ->preload()
    ->createOptionForm([
        // Inline client creation form
    ]);
```

### 4. Custom Columns
Business-specific display logic:
```php
Tables\Columns\TextColumn::make('contacts_html')
    ->label('Contacts')
    ->html()
    ->formatStateUsing(fn ($record) => $record->contacts_html);
```

## 🔧 Resource Configuration

### Navigation & Grouping
```php
protected static ?string $navigationGroup = 'Client Management';
protected static ?int $navigationSort = 10;
protected static ?string $navigationIcon = 'heroicon-o-users';
```

### Permissions Integration
```php
public static function canViewAny(): bool
{
    return auth()->user()->can('view_clients');
}

public static function canCreate(): bool
{
    return auth()->user()->can('create_clients');
}
```

### Global Search
```php
public static function getGloballySearchableAttributes(): array
{
    return ['name', 'company_name', 'email', 'vat_number'];
}
```

## 📱 Responsive Design

### Mobile Optimization
- **Collapsible Sections**: Organized content for small screens
- **Priority Columns**: Most important data visible first
- **Action Buttons**: Touch-friendly interface elements
- **Contact Links**: Direct calling/emailing from mobile devices

### Accessibility Features
- **Proper Labels**: Screen reader compatible
- **Keyboard Navigation**: Full keyboard accessibility
- **Color Contrast**: WCAG compliant color schemes
- **Focus Management**: Clear focus indicators

## 🔗 Relationship Managers

### Pattern getTableColumns() nelle List Pages

**Filosofia**: Quando una Resource viene usata come RelationManager (es. `LegalOfficesRelationManager`), `XotBaseRelationManager` cerca di ottenere le colonne della tabella dalla pagina List principale chiamando `getTableColumns()`. Questo pattern garantisce coerenza tra la vista principale e la vista RelationManager.

**Regola Critica**: Tutte le pagine List che estendono `XotBaseListRecords` **DEVONO** implementare `getTableColumns()` se la Resource può essere usata come RelationManager.

**Pattern Corretto**:
```php
class ListLegalOffices extends XotBaseListRecords
{
    protected static string $resource = LegalOfficeResource::class;

    /**
     * Get table columns for LegalOffice list.
     * REQUIRED when Resource is used as RelationManager.
     *
     * @return array<string, TextColumn>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->sortable()
                ->searchable(),
            'city' => TextColumn::make('city')
                ->sortable()
                ->searchable(),
            // ... altre colonne
        ];
    }
}
```

**Perché è Necessario**:
- `XotBaseRelationManager::getTableColumns()` chiama `getTableColumns()` sulla pagina List
- Se il metodo non esiste, si verifica `BadMethodCallException`
- Garantisce coerenza tra vista principale e RelationManager
- Permette riuso del codice delle colonne

**Esempi Implementati**:
- ✅ `ListLegalOffices` - Implementato
- ✅ `ListLegalRepresentatives` - Implementato
- ✅ `ListMedicalDirectors` - Implementato
- ✅ `ListDevices` - Implementato
- ✅ `ListPhoneCalls` - Implementato
- ✅ `ListAppointments` - Implementato

### Client Appointments Manager
```php
class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
```

## 🧪 Testing Resources

### Resource Testing Strategy
```php
// Form validation testing
test('client_form_validates_required_fields')
test('appointment_form_prevents_past_dates')
test('device_form_validates_serial_uniqueness')

// Permission testing
test('user_cannot_access_without_permission')
test('user_can_view_own_clients_only')

// UI testing
test('contact_html_renders_correctly')
test('relationship_managers_load_properly')
```

## 🚀 Performance Optimization

### Query Optimization
- **Eager Loading**: Load relationships efficiently
- **Select Optimization**: Only load required columns
- **Pagination**: Proper pagination for large datasets
- **Indexing**: Database indexes for searchable fields

### Caching Strategy
- **Static Data**: Cache dropdown options
- **Computed Values**: Cache complex calculations
- **Relationship Counts**: Cache frequently accessed counts

## 📊 Advanced Features

### Bulk Actions
```php
Tables\Actions\BulkAction::make('assign_worker')
    ->label('Assign Worker')
    ->form([
        Forms\Components\Select::make('worker_id')
            ->relationship('workers', 'name'),
    ])
    ->action(function (Collection $records, array $data) {
        $records->each(function ($record) use ($data) {
            $record->update(['assigned_worker_id' => $data['worker_id']]);
        });
    });
```

### Custom Actions
```php
Tables\Actions\Action::make('schedule_appointment')
    ->label('Schedule')
    ->icon('heroicon-o-calendar')
    ->url(fn ($record) => AppointmentResource::getUrl('create', [
        'client_id' => $record->id
    ]));
```

### Export Functionality
```php
Tables\Actions\ExportAction::make()
    ->exporter(ClientExporter::class)
    ->formats([
        ExportFormat::Xlsx,
        ExportFormat::Csv,
    ]);
```

---

*This documentation provides comprehensive coverage of TechPlanner's Filament v4 implementation with business-focused UI patterns and best practices.*