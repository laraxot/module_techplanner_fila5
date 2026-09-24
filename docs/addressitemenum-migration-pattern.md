# AddressItemEnum Migration Pattern

## Overview

`AddressItemEnum` fornisce un pattern centralizzato per la gestione dei campi contatto nelle migrazioni, seguendo la filosofia DRY + KISS e il pattern XotBaseMigration.

## Filosofia

### Logica
Definizione matematicamente precisa di tutti i campi indirizzo e contatto gestiti da AddressItemEnum:
- `phone` - Numero di telefono associato all'indirizzo
- `name` - Nome identificativo per l'indirizzo (e.g., "Casa", "Ufficio")
- `description` - Descrizione aggiuntiva o note sull'indirizzo
- `route` - Nome della via o strada (e.g., "Via Roma", "Piazza Duomo")
- `street_number` - Numero civico (e.g., "123", "1/A")
- `locality` - Città o località (e.g., "Milano")
- `administrative_area_level_3` - Comune
- `administrative_area_level_2` - Provincia
- `administrative_area_level_1` - Regione
- `country` - Codice o nome del Paese
- `postal_code` - CAP (Codice di Avviamento Postale)
- `formatted_address` - Indirizzo completo formattato automaticamente
- `place_id` - ID del luogo (e.g., Google Places ID)
- `latitude` - Coordinata geografica di latitudine
- `longitude` - Coordinata geografica di longitudine
- `fax` - Numero di fax
- `mobile` - Numero di cellulare
- `pec` - Indirizzo di Posta Elettronica Certificata (PEC)
- `whatsapp` - Numero di telefono WhatsApp
- `email` - Indirizzo email
- `notes` - Note generali o aggiuntive

### Filosofia
Single Source of Truth per tutti i campi contatto. Non ripetere mai la definizione dei campi.

### Politica
Governance centralizzata della struttura contatti attraverso l'enum.

### Religione
Strong typing attraverso i valori enum per garantire consistenza.

### Zen
Form without form - la struttura emerge dall'enum in modo naturale.

## Pattern di Utilizzo

### 1. In una nuova migrazione (CREATE block)

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum; // Changed to AddressItemEnum
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name')->nullable();
            
            // Campi indirizzo e contatto standard
            AddressItemEnum::columns($table); // Changed to AddressItemEnum
            
            $this->addCommonFields($table);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiungi campi indirizzo e contatto se mancanti
            AddressItemEnum::updateColumns($table, $this); // Changed to AddressItemEnum
            
            $this->updateTimestamps($table, true);
        });
    }
};
```

### 2. In una migrazione di update

```php
<?php

$this->tableUpdate(function (Blueprint $table): void {
    // Aggiungi tutti i campi indirizzo e contatto in modo sicuro
    AddressItemEnum::updateColumns($table, $this);
    
    // Altri aggiornamenti...
});
```

### 3. Combinato con AddressItemEnum

```php
<?php

use Modules\Geo\Enums\AddressItemEnum;
use Modules\Notify\Enums\AddressItemEnum;

$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('name');
    
    // Campi indirizzo
    AddressItemEnum::columns($table);
    
    // Campi contatto
    AddressItemEnum::columns($table);
    
    $this->addCommonFields($table);
});

$this->tableUpdate(function (Blueprint $table): void {
    // Aggiornamenti sicuri
    AddressItemEnum::updateColumns($table, $this, true);
    AddressItemEnum::updateColumns($table, $this);
    
    $this->updateTimestamps($table, true);
});
```

## Metodi Disponibili

### `AddressItemEnum::columns($table)`
- **Uso**: Solo nel CREATE block
- **Comportamento**: Aggiunge tutti i campi contatto senza controlli
- **Vantaggi**: Più veloce, ideato per tabelle nuove

### `AddressItemEnum::updateColumns($table, $migration)`
- **Uso**: Solo nel UPDATE block
- **Comportamento**: Controlla l'esistenza prima di aggiungere
- **Vantaggi**: Sicuro per tabelle esistenti, idempotente

### `AddressItemEnum::getColumnNames()`
- **Uso**: Ottenere l'elenco dei nomi delle colonne
- **Ritorna**: Array con tutti i nomi dei campi

## Best Practices

### 1. Sempre usare il metodo corretto per il blocco

```php
// ✅ CORRETTO
$this->tableCreate(function (Blueprint $table): void {
    AddressItemEnum::columns($table); // CREATE block
});

$this->tableUpdate(function (Blueprint $table): void {
    AddressItemEnum::updateColumns($table, $this); // UPDATE block
});

// ❌ SBAGLIATO
$this->tableUpdate(function (Blueprint $table): void {
    AddressItemEnum::columns($table); // Errore: non controlla l'esistenza
});
```

### 2. Non mischiare approcci

```php
// ✅ CORRETTO - Usa solo AddressItemEnum
AddressItemEnum::updateColumns($table, $this);

// ❌ SBAGLIATO - Non mischiare con definizioni manuali
if (!$this->hasColumn('email')) {
    $table->string('email')->nullable();
}
AddressItemEnum::updateColumns($table, $this);
```

### 3. Ordine dei campi

Nei CREATE block, l'ordine consigliato è:
1. ID e campi primari
2. Campi specifici del modello
3. AddressItemEnum::columns() (se necessario)
4. AddressItemEnum::columns()
5. Altri campi comuni

## Esempio Completo: Cliente

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Notify\Enums\AddressItemEnum;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Campi anagrafici
            $table->string('name')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('fiscal_code')->nullable();
            
            // Indirizzo completo
            AddressItemEnum::columns($table, true); // true = include legacy
            
            // Contatti completi
            AddressItemEnum::columns($table);
            
            $this->addCommonFields($table);
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiorna indirizzo in modo sicuro
            AddressItemEnum::updateColumns($table, $this, true);
            
            // Aggiorna contatti in modo sicuro
            AddressItemEnum::updateColumns($table, $this);
            
            // Altri campi business
            if (! $this->hasColumn('business_closed')) {
                $table->boolean('business_closed')->default(false);
            }
            
            $this->updateTimestamps($table, true);
        });
    }
};
```

## Integrazione con Filament

AddressItemEnum si integra perfettamente con i componenti Filament:

```php
use Modules\Notify\Enums\AddressItemEnum;

// Nel form
AddressItemEnum::getFormSchema();

// Nella vista
$enum = AddressItemEnum::from($contactType);
$icon = $enum->getIcon();
$color = $enum->getColor();
$label = $enum->getLabel();
```

## Vantaggi del Pattern

1. **DRY**: Definizione unica dei campi contatto
2. **KISS**: Metodi semplici e chiari
3. **Sicurezza**: Controlli automatici in UPDATE
4. **Consistenza**: Stessa struttura ovunque
5. **Manutenibilità**: Cambi in un solo punto
6. **Type Safety**: Enum garantisce valori validi

## Note Tecniche

- I campi sono tutti nullable per massima flessibilità
- Ogni campo ha un commento descrittivo
- Il metodo `updateColumns` segue il pattern XotBaseMigration
- Compatible con PHPStan livello 10

## Riepilogo

| Contesto | Metodo da usare | Controlli esistenza |
|----------|-----------------|---------------------|
| CREATE block | `AddressItemEnum::columns()` | No |
| UPDATE block | `AddressItemEnum::updateColumns()` | Sì |

Questo pattern garantisce migrazioni sicure e manutenibili, seguendo la filosofia del progetto TechPlanner.