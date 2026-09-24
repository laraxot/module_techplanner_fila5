# TechPlanner Models and Relationships

**Last Updated**: 2025-01-23
**Status**: ✅ Complete Model Documentation

## 📊 Entity Relationship Overview

The TechPlanner module follows a sophisticated business model designed for technical service companies managing client relationships, device inspections, and regulatory compliance.

```
                            ┌─────────────────┐
                            │      Client     │
                            │  (Core Entity)  │
                            └─────────┬───────┘
                                      │
                  ┌───────────────────┼───────────────────┐
                  │                   │                   │
            ┌─────▼─────┐    ┌───────▼────────┐    ┌─────▼─────┐
            │Appointment│    │     Device     │    │LegalOffice│
            │           │    │    Machine     │    │           │
            └─────┬─────┘    └────────────────┘    └───────────┘
                  │
            ┌─────▼─────┐
            │Participant│
            │  Worker   │
            └───────────┘
```

## 🏢 Core Business Models

### 1. Client Model
**File**: `app/Models/Client.php`
**Purpose**: Central client management with comprehensive business information

#### Key Attributes
```php
// Business Identity
- name: string              // Client business name
- company_name: string      // Legal company name
- vat_number: string        // VAT identification
- fiscal_code: string       // Tax identification
- tax_code: string          // Additional tax reference

// Geographic Information
- address: string           // Primary address
- city: string              // City
- postal_code: string       // ZIP/Postal code
- province: string          // Province/State
- country: string           // Country
- route: string             // Street name (parsed)
- street_number: string     // Street number (parsed)
- latitude: float           // GPS coordinate
- longitude: float          // GPS coordinate

// Contact Information
- phone: string             // Primary phone
- mobile: string            // Mobile phone
- email: string             // Primary email
- pec: string               // Certified email (legal)
- fax: string               // Fax number
- whatsapp: string          // WhatsApp number

// Business Management
- business_closed: boolean  // Operational status
- assigned_worker_id: int   // Primary worker assignment
- notes: text               // General notes
- administrative_reference: string // Admin contact
- competent_health_unit: string   // Regulatory authority
```

#### Relationships
```php
// One-to-Many Relationships
hasMany(Appointment::class)         // Client appointments
hasMany(Device::class)              // Client devices
hasMany(LegalRepresentative::class) // Legal contacts
hasMany(MedicalDirector::class)     // Medical oversight
hasMany(LegalOffice::class)         // Legal offices
hasMany(PhoneCall::class)           // Communication log

// Geographic Relationships (via Geo Module)
- GeographicalScopes trait for location queries
- Address parsing and standardization
```

#### Business Methods
```php
// Contact Management
getContactsHtmlAttribute(): string  // HTML contact display
formatContactLink(): string         // Individual contact formatting
getContactHref(): string           // Contact action URLs
formatPhoneNumber(): string        // Phone number formatting

// Geographic Methods
getFullAddressAttribute(): string   // Complete address formatting
withDistance(): Builder            // Geographic distance queries
```

### 2. Appointment Model
**File**: `app/Models/Appointment.php`
**Purpose**: Technical appointment scheduling and management

#### Key Attributes
```php
- client_id: int            // Foreign key to Client
- date: datetime            // Appointment date/time
- notes: text               // Appointment notes
- created_by: string        // User who created
- updated_by: string        // User who updated
```

#### Relationships
```php
belongsTo(Client::class)    // Parent client
hasMany(Machine::class)     // Associated equipment
```

#### Business Logic
- Appointment scheduling with client association
- Equipment/machine tracking for specific inspections
- Notes and requirements management
- Audit trail with creator/updater tracking

### 3. Device & Machine Models
**File**: `app/Models/Device.php`, `app/Models/Machine.php`
**Purpose**: Equipment and device management

#### Device Model
```php
// Equipment tracking for clients
belongsTo(Client::class)    // Owner client
hasMany(DeviceVerification::class) // Verification records
```

#### Machine Model
```php
// Specific machinery associated with appointments
belongsTo(Appointment::class) // Related appointment
```

#### Business Logic
- Equipment lifecycle tracking
- Verification and certification management
- Appointment-specific machinery inspection
- Compliance status monitoring

### 4. Legal & Compliance Models

#### LegalRepresentative Model
**File**: `app/Models/LegalRepresentative.php`
**Purpose**: Legal contact management for clients

```php
belongsTo(Client::class)    // Associated client
// Stores legal representative information for compliance
```

#### MedicalDirector Model
**File**: `app/Models/MedicalDirector.php`
**Purpose**: Medical oversight for healthcare facilities

```php
belongsTo(Client::class)    // Associated client
// Medical director assignment for healthcare compliance
```

#### LegalOffice Model
**File**: `app/Models/LegalOffice.php`
**Purpose**: Legal office coordination

```php
belongsTo(Client::class)    // Associated client
// Legal office coordination for complex legal requirements
```

### 5. Workforce Models

#### Worker Model
**File**: `app/Models/Worker.php`
**Purpose**: Technical staff management

```php
// Worker assignment and coordination
// Integration with User module for authentication
```

#### Participant Model
**File**: `app/Models/Participant.php`
**Purpose**: Appointment participation tracking

```php
// Track participants in appointments
// Support for multiple participants per appointment
```

### 6. Communication Models

#### PhoneCall Model
**File**: `app/Models/PhoneCall.php`
**Purpose**: Communication logging

```php
belongsTo(Client::class)    // Associated client
// Log phone communications and call history
```

## 🏗️ Architectural Patterns

### 1. Base Model Inheritance
All models extend from foundation classes:
```php
Client extends BaseModel           // Xot foundation
Appointment extends Model          // Laravel standard
Profile extends BaseProfile        // User module base
```

### 2. Trait Usage
Strategic trait implementation for cross-cutting concerns:
```php
// Geographic functionality
GeographicalScopes trait          // Location-based queries
HasAddress trait                  // Address management

// Media management
HasMedia trait                    // File attachments

// Permission system
HasRoles trait                    // Role-based access
```

### 3. Factory Pattern
Comprehensive factories for testing:
```php
ProfileFactory                    // Profile generation
// Additional factories for all major models
```

## 🔗 Module Dependencies

### Required Dependencies
```php
// Xot Module (Foundation)
- XotBaseModel                    // Model foundation
- XotBaseResource                 // Filament integration

// User Module (Authentication)
- BaseProfile                     // Profile foundation
- Role/Permission system          // Access control
- DeviceUser relationships        // Device assignments

// Geo Module (Geographic Services)
- GeographicalScopes              // Location queries
- Address management              // Address parsing

// Media Module (File Management)
- Media collections               // File attachments
- MediaLibrary integration        // File handling
```

### Optional Integrations
```php
// Notify Module
- Notification system             // Client communications

// Activity Module
- Activity logging                // Audit trails

// Lang Module
- Translation support             // Multilingual
```

## 📊 Database Schema Patterns

### Key Conventions
1. **Primary Keys**: Auto-incrementing integers
2. **Foreign Keys**: Standard Laravel naming (`client_id`, `user_id`)
3. **Timestamps**: Laravel standard (`created_at`, `updated_at`)
4. **Soft Deletes**: Audit-friendly deletion tracking
5. **User Tracking**: Creator/updater fields for audit trails

### Indexes and Performance
```sql
-- Geographic indexing for location queries
INDEX (latitude, longitude)

-- Client lookup optimization
INDEX (vat_number)
INDEX (fiscal_code)
INDEX (email)

-- Appointment scheduling optimization
INDEX (client_id, date)
INDEX (date, status)
```

## 🧪 Testing Relationships

### Model Testing Strategy
```php
// Relationship testing
testClientHasAppointments()       // One-to-many verification
testAppointmentBelongsToClient()  // Inverse relationship
testClientHasDevices()            // Equipment association

// Business logic testing
testContactsHtmlGeneration()      // HTML contact display
testAddressFormatting()           // Geographic formatting
testPhoneNumberFormatting()       // Contact formatting
```

### Factory Integration
```php
// Related model creation
Client::factory()
    ->hasAppointments(3)          // Create with appointments
    ->hasDevices(5)               // Create with devices
    ->hasLegalRepresentatives(1)  // Create with legal contacts
    ->create();
```

## 🔧 Business Rules & Constraints

### Data Integrity Rules
1. **Client Uniqueness**: VAT number and fiscal code uniqueness
2. **Appointment Scheduling**: Future date validation
3. **Contact Validation**: Email and phone format validation
4. **Geographic Data**: Coordinate validation and address parsing
5. **Legal Compliance**: Required legal representative for certain client types

### Relationship Constraints
1. **Client-Appointment**: Appointments cannot exist without clients
2. **Appointment-Machine**: Machines are optional but must relate to valid appointments
3. **Client-Legal**: Legal representatives are required for business clients
4. **Worker Assignment**: Workers must exist in User module

## 📝 Best Practices

### Model Design
1. **Single Responsibility**: Each model has a clear business purpose
2. **Relationship Clarity**: Explicit relationship definitions
3. **Type Safety**: Full PHPStan compliance with proper type hints
4. **Business Logic**: Keep business rules in models, not controllers

### Performance Optimization
1. **Eager Loading**: Load relationships efficiently
2. **Query Scopes**: Reusable query patterns
3. **Indexing**: Strategic database indexing
4. **Caching**: Cache frequently accessed data

### Maintenance
1. **Documentation**: Comprehensive PHPDoc blocks
2. **Testing**: Complete test coverage for relationships
3. **Migrations**: Version-controlled schema changes
4. **Factories**: Realistic test data generation

---

*This documentation provides a complete overview of the TechPlanner module's data architecture and business relationships.*