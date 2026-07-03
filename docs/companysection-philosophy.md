# CompanySection - Filosofia del Componente Aziendale

**Data**: 2025-12-12  
**Modulo**: TechPlanner  
**Status**: 📚 **DOCUMENTAZIONE**

## Concetto Fondamentale

CompanySection è il componente specializzato per la gestione dei dati aziendali nel dominio TechPlanner, seguendo il principio di **centralizzazione del business logic** e **riutilizzo controllato**.

## Filosofia dell'Architettura

### 1. Dominio-Specific Component
A differenza di AddressSection e ContactSection che sono componenti generici riutilizzabili, CompanySection è **dominio-specifico**:

```php
// Componenti generici (modulo Geo/Notify)
AddressSection::make('address')    // Riutilizzabile ovunque
ContactSection::make('contacts')   // Riutilizzabile ovunque

// Componente dominio-specific (modulo TechPlanner)
CompanySection::make('company')    // Solo per dominio aziendale
```

### 2. Business Logic Centralization
CompanySection centralizza la logica aziendale:
- **Dati anagrafici**: company_name, vat_number, tax_code
- **Stato aziendale**: business_closed, activity
- **Informazioni fiscali**: fiscal_code, competenti sanitarie

### 3. Pattern Evolution
Attualmente CompanySection usa campi hardcoded, ma evolverà verso:

```php
// Attuale (hardcoded)
$this->schema([
    TextInput::make('company_name')->required(),
    TextInput::make('vat_number')->nullable(),
    // ...
]);

// Futuro (enum-driven)
CompanyItemEnum::getFormSchema()
```

## Religione dell'Implementazione

### DRY Principle nel Contesto Aziendale
> "Non ripetere la logica aziendale, ma mantieni la specificità del dominio"

CompanySection bilancia:
- **DRY interna**: Non duplicare definizioni campi
- **Specificità**: Mantenere logica specifica del business

### KISS Principle per Business Logic
> "Semplice è meglio, ma il business ha le sue regole"

La semplicità di CompanySection rispetta:
- Regole fiscali italiane
- Logica di business specifica
- Validazioni settore-specifiche

## Zen del Componente Aziendale

> "Il componente aziendale non è generico, ma riflette l'anima del business"

CompanySection incapsula l'essenza del dominio aziendale italiano:
- Partita IVA
- Codice fiscale
- Regole fiscali
- Logica di chiusura aziendale

## Politica di Utilizzo

### Quando Usare CompanySection
1. **Entità con dati aziendali** (Client, LegalOffice, etc.)
2. **Form che richiedono logica fiscale italiana**
3. **Quando servono validazioni business-specifiche**

### Quando NON Usare CompanySection
1. **Entità senza dati aziendali**
2. **Form generici di contatto**
3. **Logica internazionale non italiana**

## Architettura Corrente vs Futura

### Implementazione Attuale
```php
class CompanySection extends Section
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->schema(fn (): array => $this->getFormSchema());
        $this->columns(2);
    }

    protected function getFormSchema(): array
    {
        return [
            'business_closed' => Toggle::make('business_closed'),
            'activity' => TextInput::make('activity'),
            'company_name' => TextInput::make('company_name')->required(),
            // ...
        ];
    }
}
```

### Implementazione Futura (Target)
```php
enum CompanyItemEnum: string implements HasLabel, HasIcon, HasColor
{
    case BUSINESS_CLOSED = 'business_closed';
    case ACTIVITY = 'activity';
    case COMPANY_NAME = 'company_name';
    // ...

    public static function getFormSchema(): array
    {
        // Schema centralizzato
    }

    public static function columns(Blueprint $table, ?XotBaseMigration $migration = null): void
    {
        // Migrazioni centralizzate
    }
}
```

## Dipendenze e Relazioni

### Modello Target
```php
// Client model (primary user)
class Client extends Model
{
    use HasCompany; // Trait per logica aziendale
}

// Legal office (secondary user)
class LegalOffice extends Model
{
    use HasCompany; // Riutilizza stessa logica
}
```

### Trait HasCompany
```php
trait HasCompany
{
    public function getCompanyDataAttribute()
    {
        return [
            'company_name' => $this->company_name,
            'vat_number' => $this->vat_number,
            // ...
        ];
    }
}
```

## Vantaggi Filosofici

1. **Business Logic Encapsulation**
   - Logica fiscale centralizzata
   - Validazioni specifiche italiane
   - Regole di business coerenti

2. **Domain Consistency**
   - Stesso comportamento in tutto il dominio
   - Validazioni uniformi
   - Logica di business condivisa

3. **Maintainability**
   - Cambi logici in un punto
   - Evoluzione controllata
   - Test centralizzati

4. **Italian Business Compliance**
   - Partita IVA rules
   - Codice fiscale validation
   - Business closure logic

## Pattern da Seguire

### 1. Enum-Driven Evolution
```php
// Step 1: Create CompanyItemEnum
enum CompanyItemEnum: string implements HasLabel, HasIcon, HasColor
{
    // Definizione campi centralizzata
}

// Step 2: Refactor CompanySection
class CompanySection extends Section
{
    protected function getFormSchema(): array
    {
        return CompanyItemEnum::getFormSchema();
    }
}

// Step 3: Add Migration Helper
CompanyItemEnum::columns($table, $this);
```

### 2. Trait-Based Model Integration
```php
// Step 4: Create HasCompany trait
trait HasCompany
{
    // Logica aziendale condivisa
}

// Step 5: Apply to models
class Client extends Model
{
    use HasCompany;
}
```

## Best Practices

1. **Mantenere Specificità del Dominio**
   - Non rendere CompanySection troppo generico
   - Preservare logica business-specifica

2. **Evoluzione Controllata**
   - Migrazione graduale a enum-driven
   - Mantenere backward compatibility

3. **Documentazione Business Logic**
   - Spiegare regole fiscali
   - Documentare validazioni specifiche

4. **Testing del Dominio**
   - Test per logica di business
   - Validazioni fiscali
   - Scenari di chiusura aziendale

## Conclusione

CompanySection rappresenta l'equilibrio perfetto tra **riutilizzo interno** e **specificità del dominio**. Mentre AddressSection e ContactSection sono componenti generici, CompanySection incapsula la logica unica del business italiano, mantenendo allo stesso tempo i principi DRY e KISS all'interno del suo dominio di applicazione.