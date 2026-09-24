# TechPlanner Module - DRY + KISS Improvements

## Current State Analysis

### ✅ Successfully Implemented
- **AddressItemEnum**: Centralized address columns
- **ContactTypeEnum**: Centralized contact columns
- **Enum Integration**: Proper use of enum patterns
- **Type Safety**: PHPStan level 10 compliant

### ❌ Issues Identified
- Complex migrations with 30+ hasColumn() checks
- Repetitive field patterns across migrations
- Mixed use of enum patterns and manual definitions
- Opportunities for better abstraction

## Specific Improvements Needed

### 1. Repetitive Pattern in Client Migration

**Current Code** (2024_12_26_000008_create_client_table.php):
```php
// 35+ repetitive checks
if (! $this->hasColumn('business_closed')) {
    $table->boolean('business_closed')->default(false);
}
if (! $this->hasColumn('competent_health_unit')) {
    $table->string('competent_health_unit')->nullable();
}
if (! $this->hasColumn('vat_number')) {
    $table->string('vat_number')->nullable()->comment('Partita IVA');
}
// ... 30 more similar checks
```

### 2. Mixed Pattern Usage

**Inconsistent Usage**:
```php
// Some places use enums correctly
AddressItemEnum::updateColumns($table, $this, true);
ContactTypeEnum::updateColumns($table, $this);

// Other places still use manual checks
if (! $this->hasColumn('fax')) {
    $table->string('fax')->nullable();
}
```

## Proposed Improvements

### 1. Create TechPlannerMigrationHelpers Trait

```php
<?php

namespace Modules\TechPlanner\Database\Migrations\Traits;

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

trait TechPlannerMigrationHelpers
{
    /**
     * Safely add column with existence check
     */
    protected function safeAddColumn(Blueprint $table, string $column, callable $definition): void
    {
        if (!$this->hasColumn($column)) {
            $definition($table);
        }
    }
    
    /**
     * Add address and contact columns using enums
     */
    protected function addLocationColumns(Blueprint $table, bool $withLegacy = false): void
    {
        AddressItemEnum::updateColumns($table, $this, $withLegacy);
        ContactTypeEnum::updateColumns($table, $this);
    }
    
    /**
     * Add business-related fields
     */
    protected function addBusinessColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'business_closed', fn($t) => 
            $t->boolean()->default(false)->comment('Business closed status'));
        
        $this->safeAddColumn($table, 'competent_health_unit', fn($t) => 
            $t->string()->nullable()->comment('Competent health unit'));
        
        $this->safeAddColumn($table, 'vat_number', fn($t) => 
            $t->string()->nullable()->comment('Partita IVA'));
        
        $this->safeAddColumn($table, 'tax_code', fn($t) => 
            $t->string()->nullable()->comment('Codice fiscale'));
        
        $this->safeAddColumn($table, 'company_name', fn($t) => 
            $t->string()->nullable()->comment('Ragione sociale'));
    }
    
    /**
     * Add contact preference fields
     */
    protected function addContactPreferences(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'preferred_contact', fn($t) => 
            $t->string()->default('email')->comment('Preferred contact method'));
        
        $this->safeAddColumn($table, 'contact_frequency', fn($t) => 
            $t->string()->default('weekly')->comment('Contact frequency preference'));
        
        $this->safeAddColumn($table, 'marketing_consent', fn($t) => 
            $t->boolean()->default(false)->comment('Marketing consent'));
    }
    
    /**
     * Add device-related fields
     */
    protected function addDeviceColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'device_type', fn($t) => 
            $t->string()->nullable()->comment('Device type'));
        
        $this->safeAddColumn($table, 'device_brand', fn($t) => 
            $t->string()->nullable()->comment('Device brand'));
        
        $this->safeAddColumn($table, 'device_model', fn($t) => 
            $t->string()->nullable()->comment('Device model'));
        
        $this->safeAddColumn($table, 'serial_number', fn($t) => 
            $t->string()->nullable()->comment('Serial number'));
    }
    
    /**
     * Add compliance fields
     */
    protected function addComplianceColumns(Blueprint $table): void
    {
        $this->safeAddColumn($table, 'gdpr_consent', fn($t) => 
            $t->boolean()->default(false)->comment('GDPR consent'));
        
        $this->safeAddColumn($table, 'privacy_policy_accepted', fn($t) => 
            $t->boolean()->default(false)->comment('Privacy policy acceptance'));
        
        $this->safeAddColumn($table, 'terms_accepted', fn($t) => 
            $t->boolean()->default(false)->comment('Terms acceptance'));
        
        $this->safeAddColumn($table, 'compliance_notes', fn($t) => 
            $t->text()->nullable()->comment('Compliance notes'));
    }
}
```

### 2. Create TechPlannerBaseMigration Class

```php
<?php

namespace Modules\TechPlanner\Database\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Modules\TechPlanner\Database\Migrations\Traits\TechPlannerMigrationHelpers;
use Modules\Xot\Database\Migrations\XotBaseMigration;

abstract class TechPlannerBaseMigration extends XotBaseMigration
{
    use TechPlannerMigrationHelpers;
    
    /**
     * Standard business entity structure
     */
    protected function createBusinessEntityTable(Blueprint $table, array $additionalColumns = []): void
    {
        $table->id();
        $table->string('name');
        
        // Add business-related columns
        $this->addBusinessColumns($table);
        
        // Add location and contact
        $this->addLocationColumns($table, true); // with legacy
        
        // Add contact preferences
        $this->addContactPreferences($table);
        
        // Add additional columns
        foreach ($additionalColumns as $column => $definition) {
            $this->safeAddColumn($table, $column, $definition);
        }
        
        $this->addTimestampsWithUsers($table, true); // with soft deletes
    }
    
    /**
     * Device management table structure
     */
    protected function createDeviceTable(Blueprint $table, array $additionalColumns = []): void
    {
        $table->id();
        $table->string('name');
        
        // Device-specific fields
        $this->addDeviceColumns($table);
        
        // Location for device
        $this->addLocationColumns($table);
        
        // Additional columns
        foreach ($additionalColumns as $column => $definition) {
            $this->safeAddColumn($table, $column, $definition);
        }
        
        $this->addTimestampsWithUsers($table);
    }
}
```

### 3. Refactored Client Migration

**Before**:
```php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable();
            $table->string('vat_number')->nullable();
            // ... 20+ more fields
            
            AddressItemEnum::columns($table, true);
            ContactTypeEnum::columns($table);
        });
        
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('business_closed')) {
                $table->boolean('business_closed')->default(false);
            }
            // ... 30+ more repetitive checks
        });
    }
};
```

**After**:
```php
return new class extends TechPlannerBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $this->createBusinessEntityTable($table, [
                'vat_number' => fn($t) => $t->string()->nullable(),
                'fiscal_code' => fn($t) => $t->string()->nullable(),
            ]);
        });
        
        $this->tableUpdate(function (Blueprint $table): void {
            // Additional updates if needed
            $this->addComplianceColumns($table);
            $this->updateTimestamps($table, true);
        });
    }
};
```

### 4. Device Migration Example

```php
return new class extends TechPlannerBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $this->createDeviceTable($table, [
                'type' => fn($t) => $t->string()->comment('Device type'),
                'status' => fn($t) => $t->string()->default('active')->comment('Device status'),
            ]);
        });
        
        $this->tableUpdate(function (Blueprint $table): void {
            // Device-specific updates
            if (!$this->hasColumn('last_maintenance')) {
                $table->timestamp('last_maintenance')->nullable()->comment('Last maintenance date');
            }
            
            $this->updateTimestamps($table);
        });
    }
};
```

## Implementation Strategy

### Phase 1: Helper Creation (Week 1)
1. Create TechPlannerMigrationHelpers trait
2. Create TechPlannerBaseMigration class
3. Identify common patterns across migrations

### Phase 2: Refactoring (Week 2-3)
1. Refactor client migration as example
2. Refactor device migration
3. Refactor worker migration
4. Refactor appointment migration

### Phase 3: Validation (Week 4)
1. Test all refactored migrations
2. Ensure enum patterns work correctly
3. Update documentation

## Success Metrics

### Before Improvements
- 35+ hasColumn() checks in client migration
- Mixed manual and enum patterns
- Repetitive field definitions
- Complex migration logic

### After Improvements
- <5 hasColumn() checks per migration
- Consistent enum-based patterns
- Centralized field definitions
- Simple, readable migrations

## Benefits

1. **DRY Compliance**: 90% reduction in repetitive code
2. **KISS Principle**: Much simpler migration logic
3. **Maintainability**: Changes in helpers affect all migrations
4. **Consistency**: Standardized patterns across module
5. **Type Safety**: Better IDE support and refactoring
6. **Enum Integration**: Full leverage of AddressItemEnum and ContactTypeEnum

## Migration Patterns

### Business Entity Pattern
```php
$this->createBusinessEntityTable($table, [
    'custom_field' => fn($t) => $t->string()->nullable(),
]);
```

### Device Management Pattern
```php
$this->createDeviceTable($table, [
    'custom_property' => fn($t) => $t->string()->nullable(),
]);
```

### Service Provider Pattern
```php
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');
    
    $this->addLocationColumns($table);
    $this->addContactColumns($table);
    $this->addComplianceColumns($table);
    
    $this->addTimestampsWithUsers($table);
});
```

## Conclusion

The TechPlanner module has excellent enum-based patterns but suffers from extensive repetition in migration code. By implementing the proposed helper traits and base class, we can achieve dramatic DRY + KISS improvements while fully leveraging the existing AddressItemEnum and ContactTypeEnum patterns. The modular approach allows for easy extension and maintenance of all TechPlanner-related migrations.

## ListClients table columns: AddressColumn + ContactColumn

Nella pagina `ClientResource\Pages\ListClients` la tabella utilizza ora due colonne composte riusabili:

- **AddressColumn** (`Modules\Geo\Filament\Tables\Columns\AddressColumn`)
  - Estende `ViewColumn` e usa la view condivisa `geo::filament.tables.columns.address` del modulo Geo.
  - Mostra `full_address` quando presente, oppure compone l indirizzo da `address`, `city`, `province`, `postal_code`, `country`.
  - È dichiarata in `getTableColumns()` come `AddressColumn::make('full_address')` e posta prima di `ContactColumn`.
  - La definizione risiede in Geo per rispettare la filosofia di avere un solo punto di verità per gli indirizzi, mentre TechPlanner è solo consumer.

- **ContactColumn** (`Modules\Notify\Filament\Tables\Columns\ContactColumn`)
  - Gestisce i contatti usando `ContactTypeEnum` e una Blade view dedicata.

### TODO / Miglioramenti DRY + KISS

- Valutare lo spostamento di `AddressColumn` in un modulo condiviso (Geo o Xot) per riuso cross–modulo.
- Allineare label e traduzioni delle colonne address/contacts tramite file di lingua del modulo, evitando label inline.
- Documentare un pattern comune "composite column" insieme a `ContactColumn` (Notify) nelle docs root/UI/Xot, per guidare la creazione di future colonne aggregate.

## ClientResource form: uso di AddressSection (Geo)

Nel form di `ClientResource` non vengono più definiti manualmente i singoli `TextInput` per `address`, `city`, `postal_code`, `province`, `country`, ecc. Al loro posto viene riutilizzata la sezione indirizzo condivisa del modulo Geo:

- **AddressSection** (`Modules\Geo\Filament\Forms\Components\AddressSection`)
  - Wrapper di `AddressResource::getFormSchema()` che espone lo schema indirizzo come sezione riusabile.
  - Inserita nello schema di `ClientResource::getFormSchema()` come:

    ```php
    'address' => AddressSection::make('address'),
    ```

  - In questo modo tutta la logica di struttura e validazione dell indirizzo rimane centralizzata in Geo, mentre TechPlanner si limita a consumarla.

### Motivazione

- **DRY**: nessuna duplicazione di campi indirizzo tra Geo e TechPlanner.
- **KISS**: `ClientResource` dichiara solo la presenza di una sezione indirizzo, non i dettagli dei singoli componenti.
- **Filosofia Laraxot**: un solo modulo sorgente (Geo) per le primitive di indirizzo; i moduli business (TechPlanner) sono solo consumer.

## CompanySection: sezione aziendale riusabile in ClientResource

Per i campi aziendali di `ClientResource` (`business_closed`, `activity`, `company_name`, `tax_code`, `vat_number`, `fiscal_code`) è stata introdotta una sezione dedicata:

- **CompanySection** (`Modules\TechPlanner\Filament\Forms\Components\CompanySection`)
  - Estende `Modules\Xot\Filament\Schemas\Components\XotBaseSection`, wrapper Laraxot per `Filament\Schemas\Components\Section`, come faranno `AddressSection` e `ContactSection` nelle prossime iterazioni.
  - Espone i campi aziendali tramite `getFormSchema()` utilizzando componenti `Forms\Components` (Toggle + TextInput).
  - Viene inclusa nello schema del form di `ClientResource` come:

    ```php
    'company' => CompanySection::make('company'),
    ```

### Motivazione

- **DRY**: tutti i campi aziendali sono centralizzati in un unico componente, riusabile in eventuali altre risorse (es. altri moduli che trattano aziende/clienti).
- **KISS**: `ClientResource` non definisce più a mano ogni singolo `TextInput`/`Toggle` aziendale, ma dichiara solo una sezione `company`.
- **Coerenza UI**: stessa architettura di `AddressSection` (Geo) e `ContactSection` (Notify), facilitando manutenzione e onboarding.

## Client::$fillable e enum (AddressItemEnum, ContactTypeEnum, CompanyItemEnum)

### Stato attuale

Nel modello `Client` attuale:

```php
protected $fillable = [
    'name',
    'vat_number',
    'fiscal_code',
    // Additional fields from business context
    'business_closed',
    'company_name',
    'competent_health_unit',
    'tax_code',
    'fax',
    'mobile',
    'pec',
    'whatsapp',
    'assigned_worker_id',
    'notes',
    'administrative_reference',
];

public function getFillable(): array
{
    $fields = Arr::map(AddressItemEnum::cases(), fn ($item) => $item->value);

    $fields = array_merge(parent::getFillable(), $fields);

    return $fields;
}
```

Criticità di questo approccio:

- Mescola **logica enum** (Geo) con la definizione di mass-assignment del modello business (TechPlanner).
- Considera solo `AddressItemEnum` (indirizzo), ma non ancora `ContactTypeEnum` (contatti) né un eventuale `CompanyItemEnum` (campi aziendali).
- Aggiunge dinamicamente TUTTI i casi dell'enum ai `fillable`, anche se il modello non usa tutti quei campi.
- L'override di `getFillable()` su singolo modello è poco visibile e può sorprendere chi si aspetta il comportamento base di `BaseModel`.

### Obiettivi di design

Per Laraxot / TechPlanner vogliamo:

1. **Chiarezza di dominio**: dal modello `Client` deve essere chiaro quali campi sono davvero utilizzati e mass-assegnabili.
2. **DRY + KISS**: sfruttare gli enum (`AddressItemEnum`, `ContactTypeEnum`, `CompanyItemEnum`) senza trasformare `getFillable()` in un calderone dinamico.
3. **Sicurezza mass-assignment**: evitare di aprire per errore al mass assignment campi che il modello non dovrebbe esporre.
4. **Separazione dei ruoli**: gli enum definiscono lo *schema potenziale* (tutti i possibili campi), il modello sceglie un *sottoinsieme esplicito*.

### Pattern professionale raccomandato

> **Principio chiave**: gli enum Geo/Notify/TechPlanner sono la *fonte di verità* per l'elenco dei possibili campi, ma ogni modello business deve dichiarare **esplicitamente** quali di quei campi usa e rende mass-assegnabili.

#### 1. Niente logica complessa in `getFillable()` del singolo modello

- Evitare override locali di `getFillable()` come quello attuale, che fanno merge dinamico con `AddressItemEnum::cases()`.
- Delegare la logica comune a **trait/base model** documentati e riutilizzabili, non a metodi riscritti ogni volta.

#### 2. Enum come sorgente di nomi, non come scorciatoia per aprire tutto

Per ogni enum:

- `AddressItemEnum` espone `getColumnNames()` con TUTTI i campi indirizzo.
- `ContactTypeEnum` espone `getColumnNames()` con TUTTI i campi contatto.
- `CompanyItemEnum` (quando introdotto) farà lo stesso per i campi aziendali.

Pattern raccomandato per i modelli business (es. `Client`):

- Definire in modo **esplicito** quali sottoinsiemi usare, ad es.:
  - "per questo modello uso tutti i campi di `AddressItemEnum` meno X";
  - "per i contatti uso solo `phone`, `email`, `pec`, `whatsapp`";
  - "per l'azienda uso solo `business_closed`, `company_name`, `vat_number`, `tax_code`".
- Questa selezione può essere documentata (e in futuro implementata) con proprietà di configurazione, es.:

  ```php
  // Solo documentazione / design: NON implementato
  protected static array $addressFields = [
      // enum-based
      // AddressItemEnum::ROUTE->value,
      // AddressItemEnum::STREET_NUMBER->value,
      // ...
  ];

  protected static array $contactFields = [
      // ContactTypeEnum::PHONE->value,
      // ContactTypeEnum::EMAIL->value,
      // ...
  ];

  protected static array $companyFields = [
      'business_closed',
      'company_name',
      'vat_number',
      'tax_code',
  ];
  ```

> Nota: questi snippet sono **solo concettuali** e non vanno implementati così come sono; servono a fissare il design.

#### 3. Trait/base model per comporre i `fillable` (design, non implementazione)

Invece di sovrascrivere `getFillable()` su `Client`, il pattern Laraxot consigliato è:

- Definire un trait (es. `HasEnumDrivenFillable`) o una logica nel `BaseModel` del modulo che:
  - legge le configurazioni statiche del modello (`$addressFields`, `$contactFields`, `$companyFields`, ...);
  - usa gli enum solo per validare/normalizzare i nomi (es. verificare che ogni campo configurato esista tra i valori dell'enum);
  - costruisce l'array finale dei `fillable` come:

    ```text
    fillable_finale = campi_business_espliciti
                    + addressFields selezionati
                    + contactFields selezionati
                    + companyFields selezionati
    ```

Vantaggi di questo design (anche prima dell'implementazione):

- **Trasparenza**: chi legge il modello vede chiaramente quali campi enum vengono usati.
- **Controllo**: aggiungere un nuovo valore a `AddressItemEnum` non lo rende automaticamente mass-assegnabile ovunque.
- **Riutilizzo**: lo stesso trait può essere usato in altri modelli business (es. altri attori con indirizzo+contatti).

#### 4. Allineamento con Form/Resource Filament

- I form di Filament (via `AddressSection`, `ContactSection`, `CompanySection`) usano già gli enum per generare i componenti.
- La documentazione deve chiarire che:
  - **form schema** e **fillable** sono correlati ma non identici:
    - il form può avere campi read-only o computed che non sono fillable;
    - alcuni campi fillable possono essere popolati via azioni/servizi e non via form pubblico.
- Perciò:
  - `AddressItemEnum::getFormSchema()` guida il **form**;
  - `AddressItemEnum::getColumnNames()` (o simili) supporta la definizione consapevole dei **fillable**, non la sostituisce.

### TODO documentale

- [ ] Creare un documento dedicato (es. `client-fillable-enums.md`) che codifichi il contratto tra:
  - `Client` (modello business),
  - `AddressItemEnum` (Geo),
  - `ContactTypeEnum` (Notify),
  - `CompanySection` / futuro `CompanyItemEnum` (TechPlanner).
- [ ] Aggiornare gli esempi di migrazione e form in questo file per mostrare esplicitamente quali campi enum sono usati da `Client`.
- [ ] Quando verrà implementata una soluzione trait/base model per i fillable enum-driven, documentarla qui con esempi concreti e note PHPStan.