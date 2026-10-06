# CompanyEnum Integration Guide

## Overview

`CompanyItemEnum` centralizza tutti i campi aziendali del dominio TechPlanner, seguendo la filosofia Laraxot di Single Source of Truth per i dati business italiani.

## Struttura dell'Enum

### 1. Campi Aziendali Definiti

```php
enum CompanyItemEnum: string implements HasLabel, HasIcon, HasColor
{
    case BUSINESS_CLOSED = 'business_closed';    // Stato attività
    case ACTIVITY = 'activity';                  // Settore merceologico
    case COMPANY_NAME = 'company_name';          // Ragione sociale
    case TAX_CODE = 'tax_code';                  // Codice fiscale azienda
    case VAT_NUMBER = 'vat_number';              // Partita IVA
    case FISCAL_CODE = 'fiscal_code';            // Codice fiscale rappresentante
}
```

### 2. Metodi Strategici

#### `getFormSchema()`
Genera automaticamente i campi form con tipi corretti:
```php
return [
    'business_closed' => Toggle::make('business_closed')->label('Attività Cessata'),
    'activity' => TextInput::make('activity')->label('Attività')->prefixIcon('heroicon-o-briefcase'),
    'company_name' => TextInput::make('company_name')->label('Ragione Sociale')->required(),
    // ...
];
```

#### `columns()` per Database
Gestisce creazione e aggiornamento colonne:
```php
// CREATE: aggiunge tutte le colonne aziendali
CompanyItemEnum::columns($table);

// UPDATE: verifica esistenza prima di aggiungere
CompanyItemEnum::columns($table, $this);
```

## Contesto Business Italiano

### 1. **Distinzione Codici Fiscali**
- `TAX_CODE`: Codice fiscale dell'azienda (persona giuridica)
- `FISCAL_CODE`: Codice fiscale del rappresentante legale (persona fisica)

### 2. **Campo Business Closed**
- Indica se l'attività è cessata
- Importante per compliance italiana
- Utilizzato in report e filtri

### 3. **Activity Field**
- Settore merceologico/ATECO
- Necessario per documentazione fiscale
- Usato in analisi di business

## Integrazione Model Pattern

### 1. **Trait HasBusinessFields**

```php
<?php

namespace Modules\TechPlanner\Models\Traits;

use Modules\TechPlanner\Enums\CompanyItemEnum;

trait HasBusinessFields
{
    /**
     * Verifica se il modello ha campi aziendali
     */
    public function isBusiness(): bool
    {
        return true; // Override nei modelli specifici
    }

    /**
     * Ottieni i campi aziendali fillable
     */
    protected function getBusinessFillable(): array
    {
        return $this->isBusiness() 
            ? CompanyItemEnum::getColumnNames() 
            : [];
    }
}
```

### 2. **Modello Client Integrato**

```php
<?php

class Client extends BaseModel
{
    use HasEnumFillable, HasBusinessFields, HasAddress;

    protected $fillable = [
        'name',
        'assigned_worker_id',
        'notes',
        'administrative_reference',
    ];

    /**
     * Client è sempre un'entità business
     */
    public function isBusiness(): bool
    {
        return true;
    }

    /**
     * Client ha sempre contatti
     */
    public function hasContacts(): bool
    {
        return true;
    }

    /**
     * Client ha sempre indirizzo
     */
    public function hasAddress(): bool
    {
        return true;
    }
}
```

### 3. **Trait HasEnumFillable Aggiornato**

```php
trait HasEnumFillable
{
    public function getFillable(): array
    {
        return array_merge(
            $this->fillable,
            $this->getEnumFillable()
        );
    }

    protected function getEnumFillable(): array
    {
        $fields = [];
        
        // Campi indirizzo
        if (method_exists($this, 'hasAddress') && $this->hasAddress()) {
            $fields = array_merge($fields, AddressItemEnum::getColumnNames());
        }
        
        // Campi contatto
        if (method_exists($this, 'hasContacts') && $this->hasContacts()) {
            $fields = array_merge($fields, ContactTypeEnum::getColumnNames());
        }
        
        // Campi aziendali
        if (method_exists($this, 'isBusiness') && $this->isBusiness()) {
            $fields = array_merge($fields, CompanyItemEnum::getColumnNames());
        }
        
        return $fields;
    }
}
```

## Vantaggi dell'Approccio

### 1. **Compliance Italiana**
- Campi specifici per normativa fiscale italiana
- Distinzione clara tra codici fiscali
- Supporto completo per documentazione ATECO

### 2. **Type Safety**
- Enum PHP 8.1+ previene errori
- Autocompletion IDE completo
- Refactoring sicuro

### 3. **Manutenzione Centralizzata**
- Nuovo campo aziendale? Solo nell'enum
- Modifica label? Solo nei file di traduzione
- Validazioni? Centralizzate nell'enum

### 4. **Coerenza UI**
- Stesse icone e colori ovunque
- Traduzioni automatiche
- Form consistenti

## Best Practices

### 1. **Traduzioni Italiane Complete**

```php
// lang/it/company_item_enum.php
return [
    'business_closed' => [
        'label' => 'Attività Cessata',
        'description' => 'Indica se l\'attività aziendale è cessata',
        'icon' => 'heroicon-o-x-circle',
        'color' => 'danger',
    ],
    'tax_code' => [
        'label' => 'Codice Fiscale Azienda',
        'description' => 'Codice fiscale dell\'azienda (persona giuridica)',
        'icon' => 'heroicon-o-document-text',
        'color' => 'info',
    ],
    'fiscal_code' => [
        'label' => 'Codice Fiscale',
        'description' => 'Codice fiscale del rappresentante (persona fisica)',
        'icon' => 'heroicon-o-identification',
        'color' => 'warning',
    ],
    // ...
];
```

### 2. **Validazioni Business**

```php
// Nell'enum o in trait dedicati
trait ValidatesBusinessFields
{
    public function validateTaxCode(string $code): bool
    {
        // Logica validazione codice fiscale italiano
        return $this->isValidItalianTaxCode($code);
    }
    
    public function validateVatNumber(string $vat): bool
    {
        // Logica validazione Partita IVA italiana
        return $this->isValidItalianVAT($vat);
    }
}
```

### 3. **Migrazioni Corrette**

```php
// CREATE
$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    CompanyItemEnum::columns($table);
    ContactTypeEnum::columns($table);
    AddressItemEnum::columns($table);
});

// UPDATE
$this->tableUpdate(function (Blueprint $table): void {
    CompanyItemEnum::updateColumns($table, $this);
    ContactTypeEnum::updateColumns($table, $this);
    AddressItemEnum::updateColumns($table, $this);
});
```

## Politica Laraxot

1. **Logic**: Struttura matematicamente precisa per business italiano
2. **Philosophy**: Single Source of Truth per dati aziendali
3. **Politics**: Governance centralizzata compliance fiscale
4. **Religion**: Strong typing per campi legali
5. **Zen**: Forma senza forma - dati esistono nell'enum ma si manifestano nel modello

## Pattern da Evitare

### ❌ Campi Aziendali Hardcoded
```php
protected $fillable = [
    'company_name',
    'vat_number',
    'tax_code',
    'fiscal_code',
    'business_closed',
    'activity',
];
```

### ❌ Logica Duplicata
```php
// In ogni modello business
protected $fillable = [
    'name',
    'company_name',
    'vat_number',
    // Duplicazione e inconsistenza
];
```

### ❌ Mancanza Contesto Italiano
```php
// Non chiaro la distinzione tax_code vs fiscal_code
'tax_code' => 'Tax Code',
'fiscal_code' => 'Fiscal Code',
```

## Esempi Utilizzo

### 1. **Modello Business Puro**
```php
class Company extends BaseModel
{
    use HasEnumFillable, HasBusinessFields;
    
    public function isBusiness(): bool { return true; }
    public function hasContacts(): bool { return true; }
    public function hasAddress(): bool { return true; }
}
```

### 2. **Modello Ibrido**
```php
class Person extends BaseModel
{
    use HasEnumFillable;
    
    public function isBusiness(): bool { return false; }
    public function hasContacts(): bool { return true; }
    public function hasAddress(): bool { return true; }
}
```

### 3. **Modello Condizionale**
```php
class Lead extends BaseModel
{
    use HasEnumFillable;
    
    public function isBusiness(): bool 
    {
        return $this->type === 'business'; // Solo lead business hanno campi aziendali
    }
}
```

## Testing

### 1. **Enum Tests**
```php
test('CompanyItemEnum provides correct business fields', function () {
    $expected = [
        'business_closed',
        'activity', 
        'company_name',
        'tax_code',
        'vat_number',
        'fiscal_code'
    ];
    
    expect(CompanyItemEnum::getColumnNames())->toBe($expected);
});
```

### 2. **Model Tests**
```php
test('Client includes business fields in fillable', function () {
    $client = new Client();
    $fillable = $client->getFillable();
    
    expect($fillable)
        ->toContain('company_name')
        ->toContain('vat_number')
        ->toContain('tax_code');
});
```

## Conclusione

`CompanyItemEnum` rappresenta l'approccio Laraxot ottimale per gestire dati aziendali nel contesto italiano: centralizzato, compliant, type-safe e manutenibile. L'integrazione attraverso trait garantisce consistenza mentre preserva la flessibilità per diversi tipi di modelli.