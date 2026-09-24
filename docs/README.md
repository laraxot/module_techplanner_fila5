# TechPlanner Module Documentation

**Ultima modifica**: 2025-01-23
**Status**: ✅ Documentazione completa e aggiornata
## 🎯 Business Overview
The TechPlanner module is a comprehensive business management system designed for technical service companies, particularly those dealing with device inspection, maintenance, and compliance in regulated environments such as healthcare. It provides a complete solution for:
- **Client Management**: Complete client lifecycle from registration to ongoing service
- **Appointment Scheduling**: Technical appointments and device inspections
- **Device Tracking**: Medical devices, machinery, and equipment management
- **Compliance Management**: Legal representatives, medical directors, and regulatory compliance
- **Communication Hub**: Integrated contact management with multiple communication channels
## 🏢 Business Domain
This module serves technical planning companies that provide:
- Medical device inspections and certifications
- Compliance auditing for healthcare facilities
- Preventive maintenance scheduling
- Legal and regulatory consulting
- Multi-location client management
## 📊 Core Business Entities
### 1. Client Management
- **Primary Model**: `Client`
- **Business Logic**: Complete client lifecycle management
- **Key Features**:
  - Multi-contact management (phone, mobile, email, PEC, WhatsApp)
  - Geographic location tracking with full address parsing
  - Business status tracking (active/closed)
  - Administrative and legal contact references
  - Integration with Google Maps for location services
  - **Bulk Actions**: 
    - Update coordinates from addresses (via `UpdateCoordinatesBulkAction` from Geo module)
    - Send multi-channel notifications (via `SendNotificationBulkAction` from Notify module)
### 2. Appointment System
- **Primary Model**: `Appointment`
- **Business Logic**: Technical appointment scheduling and management
  - Client-appointment relationship tracking
  - Date/time scheduling with notes
  - Machine association for specific inspections
  - Status tracking throughout appointment lifecycle
### 3. Device & Equipment Management
- **Primary Models**: `Device`, `Machine`
- **Business Logic**: Track and manage client equipment
  - Device verification and certification tracking
  - Machine-specific appointment associations
  - Equipment lifecycle management
  - Compliance status monitoring
### 4. Legal & Compliance Structure
- **Primary Models**: `LegalRepresentative`, `MedicalDirector`, `LegalOffice`
- **Business Logic**: Regulatory compliance management
  - Legal representative assignment per client
  - Medical director oversight for healthcare facilities
  - Legal office coordination for complex clients
  - Compliance documentation tracking
### 5. Workforce Management
- **Primary Models**: `Worker`, `Participant`
- **Business Logic**: Technical staff assignment and coordination
  - Worker assignment to client accounts
  - Participant tracking for appointments
  - Workload distribution and scheduling
## 🏗️ Architecture & Dependencies
### Module Dependencies
```
TechPlanner Module
├── Xot Module (Foundation)
│   ├── XotBaseResource (Filament base classes)
│   ├── XotBaseModel (Model foundation)
│   └── Core architectural patterns
├── Notify Module (Multi-channel Communication)
│   ├── SendNotificationBulkAction (Bulk notifications)
│   ├── MailTemplate (Template management)
│   └── RecordNotification (Notification system)
├── Geo Module (Geographic Services)
│   ├── UpdateCoordinatesBulkAction (Coordinate updates)
│   ├── AddressColumn (Address display)
│   └── Geographic scopes and traits
├── User Module (Authentication & Authorization)
│   ├── BaseProfile (User profiles)
│   ├── Role & Permission system
│   └── Device user relationships
├── Geo Module (Geographic Services)
│   ├── GeographicalScopes
│   ├── Address management
│   └── Location services
└── Media Module (File Management)
    ├── Media collections
    └── File attachments
### Filament v4 Integration
- **Resources**: Complete CRUD interfaces for all business entities
- **Components**: Custom contact display with HTML formatting
- **Relations**: Properly configured relationship managers
- **Forms**: Type-safe form schemas with validation
- **Tables**: Optimized listing with search and filtering
## 🔧 Business Workflows
### 1. Client Onboarding Workflow
1. Client Registration
   ├── Basic information capture
   ├── Address and location setup
   ├── Contact information (multiple channels)
   ├── Legal representative assignment
   └── Medical director assignment (if applicable)
2. Service Setup
   ├── Device/equipment registration
   ├── Compliance requirements assessment
   ├── Inspection schedule planning
   └── Worker assignment
3. Ongoing Management
   ├── Regular appointment scheduling
   ├── Device verification tracking
   ├── Compliance monitoring
   └── Communication management
### 2. Appointment Lifecycle
1. Scheduling
   ├── Client selection
   ├── Date/time coordination
   ├── Equipment/device specification
   ├── Worker assignment
   └── Notes and requirements
2. Execution
   ├── On-site inspection
   ├── Device verification
   ├── Compliance documentation
   └── Status updates
3. Follow-up
   ├── Report generation
   ├── Next appointment scheduling
   ├── Compliance tracking
   └── Client communication
## 📋 Key Models & Relationships
### Client Model
```php
// Core client information with comprehensive contact management
class Client extends BaseModel
{
    // Key Relationships
    - hasMany(Appointment::class)
    - hasMany(Device::class)
    - hasMany(LegalRepresentative::class)
    - hasMany(MedicalDirector::class)
    - hasMany(LegalOffice::class)
    - hasMany(PhoneCall::class)
    // Key Features
    - Geographic location tracking
    - Multi-channel contact management
    - HTML contact display with action links
    - Business status management
}
### Appointment Model
// Technical appointment scheduling
class Appointment extends Model
    - belongsTo(Client::class)
    - hasMany(Machine::class)
    - Date/time scheduling
    - Notes and requirements
    - Client association
    - Equipment tracking
## 🎨 Filament Resources & UI Patterns
### Contact Management UI
The module provides sophisticated contact management with:
- **Visual Contact Cards**: HTML-formatted contact information
- **Action Links**: Direct calling, emailing, WhatsApp integration
- **Responsive Design**: Mobile-optimized contact displays
- **Icon Integration**: Heroicon SVG icons for contact types
### Resource Patterns
All Filament resources follow the XotBaseResource pattern:
- **Type Safety**: Full PHPStan Level 9/10 compliance
- **Consistent UI**: Standardized forms and tables
- **Relationship Management**: Proper foreign key handling
- **Permission Integration**: Role-based access control
## 🔗 API & Integration Points
### Geographic Integration
- **Geo Module**: Address parsing and location services
- **Google Maps**: Coordinate tracking and mapping
- **Address Standardization**: Consistent address formatting
- **UpdateCoordinatesBulkAction**: Riutilizzabile BulkAction per aggiornamento coordinate multiple
  - Utilizzato in `ClientResource/Pages/ListClients` per aggiornare coordinate client
  - Separazione business logic (Spatie Action) da UI (Filament BulkAction)
### Communication Integration
- **Phone System**: Tel: links for direct calling
- **Email System**: Mailto: links with proper formatting
- **WhatsApp**: Direct messaging integration
- **PEC**: Certified email for legal compliance
## 🧪 Testing Strategy
### Model Testing
- **Factory Pattern**: Comprehensive model factories
- **Relationship Testing**: All model relationships verified
- **Business Logic Testing**: Custom methods and calculations
- **Type Safety**: PHPStan compliance verification
### Integration Testing
- **Filament Resources**: Complete CRUD operations
- **Form Validation**: Business rule enforcement
- **Permission Testing**: Role-based access verification
- **API Endpoints**: External integration points
## 📖 Additional Documentation
### Technical Documentation
- [Model Relationships](./models-and-relationships.md) - Detailed model structure
- [Filament Resources](./filament-resources.md) - UI component documentation
- [Business Logic](./business-logic.md) - Core business processes
- [API Documentation](./api-documentation.md) - Integration endpoints
- [Config Icon Key Analysis](./config-icon-key-analysis.md) - Configurazione chiave `icon` nel config.php
### Quality Assurance
- [PHPStan Complete Fixes 2025](./phpstan-complete-fixes-2025.md) - ✅ **COMPLETE SUCCESS**: All PHPStan errors resolved (0 errors)
- [Testing Documentation](./testing/) - Test coverage and strategies
- [Type Safety Guidelines](../Xot/docs/filament-component-type-safety.md) - Filament v4 compliance
## 🚀 Quick Start Guide
### Prerequisites
1. Xot Module (foundation) - must be installed first
2. User Module (authentication) - required for profiles and permissions
3. Geo Module (geography) - required for location services
4. Media Module (files) - required for attachments
### Installation Steps
1. Ensure all dependency modules are active
2. Run migrations: `php artisan migrate --path=Modules/TechPlanner/database/migrations`
3. Seed data: `php artisan db:seed --class=TechPlannerSeeder`
4. Configure permissions in User module
5. Access via Filament admin panel
### Configuration
1. **Geographic Services**: Configure Google Maps API keys
2. **Communication**: Set up email and messaging services
3. **Permissions**: Assign roles for different user types
4. **Customization**: Adapt forms and tables for specific business needs
## 🔗 External Dependencies
- [Laravel Framework](https://laravel.com/docs) - Core framework
- [Filament v4](https://filamentphp.com/docs) - Admin panel and UI
- [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary) - File management
- [Spatie Permissions](https://spatie.be/docs/laravel-permission) - Role management
- [Spatie Schemaless Attributes](https://github.com/spatie/laravel-schemaless-attributes) - Flexible data storage
---
## 🚀 Filament 4.x Compatibility
**Date**: 2025-01-27
**Status**: ✅ SUCCESSFULLY COMPLETED
The TechPlanner module has been successfully upgraded to Filament 4.x with full compatibility and enhanced features.
### Migration Achievements
- **Full Type Safety**: PHPStan Level 9/10 compliance maintained
- **Enhanced UI**: Improved contact management with HTML formatting
- **Resource Optimization**: All Filament resources updated and optimized
- **Relationship Management**: Proper handling of complex business relationships
- **Performance**: Optimized queries and reduced memory usage
*Last updated: 2025-01-23 - ✅ COMPLETE SUCCESS: Comprehensive business documentation with Filament 4.x compatibility*
## 🚀 Aggiornamento Filament 4.x
**Data**: 2025-12-16
**Status**: ✅ COMPLETATO CON SUCCESSO
Il modulo TechPlanner è stato aggiornato con successo a Filament 4.x. Il codice rispetta rigorosamente gli standard "Super Cow" (Level 10 PHPStan, no `label()` calls, use `XotBase` classes).

### Highlights Aggiornamento
- **Traduzioni**: Rimossi tutti i `->label('...')` hardcoded. Ora si usano esclusivamente i file di traduzione in `lang/it`.
- **Pulizia Risorse**: `ClientResource` ottimizzato, rimosso codice di migrazione improprio in `getFormSchema`.
- **Strict Typing**: Conformità totale a PHPStan Level 10.
- **XotBase**: Estensione corretta di `XotBaseResource`, `XotBasePage`, `XotBaseViewRecord`.

### Componenti Temporaneamente Disabilitati
- Widget Google Maps (in attesa di compatibilità pacchetti)
- Plugin traduzioni multilingua (in attesa di LaraZeus\SpatieTranslatable)
- Widget FullCalendar (in attesa di Saade\FilamentFullCalendar)

*Ultima modifica: 2025-12-16 - ✅ SUCCESSO COMPLETO: Filament 4.x aggiornato, refactoring Super Cow completato*
# TechPlanner Module Documentation\n\nMain module for Sottana Service project.\n\n## Contents\n- [Brand Update 2026](../../../docs/brand-update-2026.md)\n- [Project Roadmap](../../../migration_plan.md)