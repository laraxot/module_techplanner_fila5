# Model Fillable con Enum - Best Practices

## Problema Attuale

Nel modello `Client.php`, la gestione dei campi `fillable` presenta diverse problematiche:

1. **Approccio ibrido non coerente**: Alcuni campi sono definiti staticamente nell'array `$fillable`, altri vengono aggiunti dinamicamente tramite `getFillable()`
2. **Mancanza di ContactTypeEnum**: Nonostante il modello usi campi di contatto, non integra `ContactTypeEnum`
3. **Duplicazione della logica**: La logica per estrarre i campi dagli enum è duplicata e non centralizzata
4. **Mantenibilità complessa**: Aggiungere nuovi campi richiede modifiche in più punti

## Architettura Consigliata

### 1. Pattern Centralizzato con Enum

```php
<?php

class Client extends BaseModel
{
    // Definizione statica dei campi base (non-enum)
    protected $fillable = [
        'name',
        'assigned_worker_id',
        'notes',
        'administrative_reference',
    ];

    /**
     * Override del metodo getFillable per includere dinamicamente
     * tutti i campi definiti negli enum
     */
    public function getFillable(): array
    {
        // Unisci i campi base con quelli degli enum
        return array_merge(
            $this->fillable,
            AddressItemEnum::getColumnNames(),
            ContactTypeEnum::getColumnNames(),
            CompanyItemEnum::getColumnNames()
        );
    }
}
```

### 2. Trait Centralizzato per Logica Enum

```php
<?php

namespace Modules\TechPlanner\Models\Traits;

use Modules\Geo\Enums\AddressItemEnum;
use Modules\Notify\Enums\ContactTypeEnum;
use Modules\TechPlanner\Enums\CompanyItemEnum;

trait HasEnumFillable
{
    /**
     * Ottieni tutti i campi fillable dagli enum configurati
     */
    protected function getEnumFillable(): array
    {
        $enumFields = [];
        
        // Aggiungi campi indirizzo se il modello usa HasAddress
        if (method_exists($this, 'hasAddress') && $this->hasAddress()) {
            $enumFields = array_merge($enumFields, AddressItemEnum::getColumnNames());
        }
        
        // Aggiungi campi contatto se il modello ha contatti
        if (method_exists($this, 'hasContacts') && $this->hasContacts()) {
            $enumFields = array_merge($enumFields, ContactTypeEnum::getColumnNames());
        }
        
        // Aggiungi campi aziendali se il modello è aziendale
        if (method_exists($this, 'isBusiness') && $this->isBusiness()) {
            $enumFields = array_merge($enumFields, CompanyItemEnum::getColumnNames());
        }
        
        return $enumFields;
    }

    /**
     * Override del metodo getFillable
     */
    public function getFillable(): array
    {
        return array_merge(
            $this->fillable,
            $this->getEnumFillable()
        );
    }
}
```

### 3. Configurazione Declarative del Modello

```php
<?php

class Client extends BaseModel
{
    use HasAddress, HasEnumFillable;

    protected $fillable = [
        'name',
        'assigned_worker_id',
        'notes',
        'administrative_reference',
    ];

    /**
     * Definizione dichiarativa degli enum utilizzati
     */
    protected array $enumFillables = [
        'address' => AddressItemEnum::class,
        'contacts' => ContactTypeEnum::class,
        'business' => CompanyItemEnum::class,
    ];

    /**
     * Verifica se il modello ha contatti
     */
    public function hasContacts(): bool
    {
        return true;
    }

    /**
     * Verifica se il modello è di tipo business
     */
    public function isBusiness(): bool
    {
        return true;
    }
}
```

## Vantaggi dell'Approccio Consigliato

### 1. **Single Source of Truth**
- Gli enum definiscono la struttura dati in un unico punto
- Nessuna duplicazione dei nomi dei campi
- Coerenza garantita tra database, form e modello

### 2. **Type Safety**
- PHP 8.1+ enum提供了强类型支持
- IDE autocompletion e refactoring sicuri
- Errori di battitura ridotti

### 3. **Manutenzione Semplificata**
- Aggiungere un nuovo campo: solo nell'enum
- Rimuovere un campo: solo nell'enum
- Modificare un campo: solo nell'enum

### 4. **Documentazione Integrata**
- Ogni campo ha label, icona, colore e descrizione
- Traduzioni centralizzate
- Contesto aziendale italiano preservato

### 5. **Performance Ottimizzata**
- Cache dei nomi dei campi a livello di enum
- Lazy loading solo quando necessario
- Niente query N+1 per i campi

## Implementazione Graduale

### Fase 1: Refactoring Fillable
1. Creare il trait `HasEnumFillable`
2. Spostare la logica da `getFillable()` al trait
3. Aggiungere i metodi `hasContacts()` e `isBusiness()`

### Fase 2: Integrazione Enum
1. Aggiungere `ContactTypeEnum` ai fillable
2. Verificare compatibilità con database esistente
3. Aggiornare le migrazioni se necessario

### Fase 3: Validazione e Testing
1. Testare tutti i form Filament
2. Verificare le API endpoints
3. Validare le esportazioni (CSV, PDF)

## Politica Laraxot

Secondo la filosofia Laraxot:

1. **Logic**: La logica dei fillable deve essere matematicamente precisa e prevedibile
2. **Philosophy**: Single Source of Truth attraverso gli enum
3. **Politics**: Governance centralizzata della struttura dati
4. **Religion**: Strong typing attraverso enum PHP 8.1+
5. **Zen**: Forma senza forma - i campi esistono nell'enum ma si manifestano nel modello

## Pattern da Evitare

### ❌ Dynamic Fillable Complessi
```php
public function getFillable(): array
{
    $fields = Arr::map(AddressItemEnum::cases(), fn ($item) => $item->value);
    $fields = array_merge(parent::getFillable(), $fields);
    // Logica duplicata e non manutenibile
    return $fields;
}
```

### ❌ Hardcoding dei Nomi
```php
protected $fillable = [
    'phone',
    'mobile',
    'email',
    // Duplicazione dei valori dell'enum
];
```

### ❌ Mancanza di Contesto
```php
// Non chiaro perché questi campi sono fillable
protected $fillable = ['name', 'phone', 'email'];
```

## Conclusione

L'approccio consigliato centralizza la definizione dei campi negli enum, mantenendo il modello pulito e manutenibile. Questo pattern segue i principi DRY e KISS mentre preserva il contesto business italiano e la coerenza architetturale Laraxot.