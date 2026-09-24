# Utilizzo dei Componenti Geo

**Data**: 2025-12-12  
**Modulo**: TechPlanner  
**Status**: 📚 **DOCUMENTAZIONE**

## Filosofia d'Uso

Il modulo TechPlanner utilizza componenti dal modulo Geo seguendo il principio di **dipendenza esplicita** e **riutilizzo intelligente**.

## Componenti Geo Utilizzati

### 1. AddressColumn
**Fonte**: `Modules\Geo\Filament\Tables\Columns\AddressColumn`

```php
use Modules\Geo\Filament\Tables\Columns\AddressColumn;

// Nelle tabelle Filament (es. ListClients)
AddressColumn::make('full_address')
    ->label('Indirizzo');
```

### 2. AddressSection (Form ClientResource)
**Fonte**: `Modules\Geo\Filament\Forms\Components\AddressSection`

```php
use Modules\Geo\Filament\Forms\Components\AddressSection;

// Nel form di ClientResource (TechPlanner)
return [
    // ...
    'address' => AddressSection::make('address'),
    'contacts' => ContactSection::make('contacts'),
    // ...
];
```

### 2. AddressItemEnum
**Fonte**: `Modules\Geo\Enums\AddressItemEnum`

```php
use Modules\Geo\Enums\AddressItemEnum;

// Nelle migrazioni
AddressItemEnum::columns($table, $this);

// Nei form
AddressItemEnum::getFormSchema();
```

### 3. AddressColumn Trait
**Fonte**: `Modules\TechPlanner\Traits\AddressColumn` (wrapper)

```php
use Modules\TechPlanner\Traits\AddressColumn;

// Migrazioni semplificate
AddressColumn::add($table, $this);
```

## Pattern di Utilizzo

### 1. Import Esplicito
```php
// Dichiarazione chiara della dipendenza
use Modules\Geo\Filament\Tables\Columns\AddressColumn;
use Modules\Geo\Enums\AddressItemEnum;
```

### 2. Utilizzo Diretto
```php
// Nessuna astrazione non necessaria
$addressItems = AddressItemEnum::cases();
```

### 3. Wrapper per Comodità
```php
// Quando serve una semplificazione per TechPlanner
use Modules\TechPlanner\Traits\AddressColumn;

AddressColumn::add($table, $migration);
```

## Vantaggi per TechPlanner

1. **Niente Duplicazione** - Non riscriviamo logica indirizzi
2. **Sempre Aggiornato** - Beneficiamo degli update di Geo
3. **Testato** - Usiamo codice già testato dal modulo Geo
4. **Consistente** - Stesso comportamento in tutto l'applicazione

## Dipendenze Chiare

### composer.json (se necessario)
```json
{
    "require": {
        "laravel/framework": "^10.0",
        "modules/geo": "*"
    }
}
```

### Module Manifest
```php
// In Modules/TechPlanner/module.json
{
    "dependencies": [
        "geo"
    ]
}
```

## Esempi Pratici

### Tabella Clienti
```php
use Modules\Geo\Filament\Tables\Columns\AddressColumn;

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('business_name'),
            AddressColumn::make('address'), // Componente Geo
            TextColumn::make('email'),
        ]);
}
```

### Migrazione Clienti
```php
use Modules\Geo\Enums\AddressItemEnum;

$this->tableCreate(function (Blueprint $table): void {
    $table->id();
    $table->string('business_name');
    
    // Campi indirizzo centralizzati
    AddressItemEnum::columns($table, null, true);
    
    $table->timestamps();
});
```

### Form Cliente
```php
use Modules\Geo\Enums\AddressItemEnum;

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('business_name'),
            
            // Campi indirizzo da Geo
            ...AddressItemEnum::getFormSchema(),
            
            TextInput::make('email'),
        ]);
}
```

## Best Practices

1. **Importa sempre esplicitamente** - Nessun uso dinamico
2. **Non modificare componenti Geo** - Estendi se necessario
3. **Documenta l'uso** - Spiega perché usi componenti Geo
4. **Mantieni compatibilità** - Verifica update di Geo

## Quando Estendere vs Usare Direttamente

### Usa Direttamente Quando:
- Il componente Geo fa esattamente ciò che ti serve
- Non hai necessità specifiche del dominio TechPlanner
- Vuoi beneficiare degli update automatici

### Estendi Quando:
- Hai logica specifica del business
- Hai bisogno di campi aggiuntivi
- Il comportamento deve essere diverso per TechPlanner

## Esempio di Estensione
```php
use Modules\Geo\Filament\Tables\Columns\AddressColumn as GeoAddressColumn;

class ClientAddressColumn extends GeoAddressColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Logica specifica per TechPlanner
        $this->formatStateUsing(function ($state) {
            return $state . ' (Cliente)';
        });
    }
}
```

## Conclusione

Utilizzando i componenti Geo, TechPlanner si concentra sulla **logica di business** lasciando la **gestione degli indirizzi** agli esperti del modulo Geo. Questo crea un'architettura pulita, manutenibile e rispettosa dei principi DRY e KISS.