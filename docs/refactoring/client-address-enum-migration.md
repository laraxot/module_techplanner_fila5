# Client Table Refactoring - AddressItemEnum Integration

## Scopo (Purpose)

Refactoring della tabella `clients` per allineare i campi indirizzo alla nomenclatura standard definita da `AddressItemEnum`. Questo garantisce:

- **Consistenza** con il modulo Geo e tutti gli altri modelli
- **Type safety** attraverso l'uso dell'enum
- **Traduzioni uniformi** per tutti i campi indirizzo
- **Facilità di manutenzione** attraverso una single source of truth

## Stato Attuale (Current State)

La migrazione `2024_12_26_000007_create_client_table.php` contiene campi indirizzo con nomenclatura mista e inconsistente:

### Problemi Identificati

| Campo Attuale | Problema | Campo Standard AddressItemEnum |
|---------------|----------|--------------------------------|
| `address` | Nome generico, non strutturato | `route` + `street_number` (separati) |
| `city` | OK, ma meglio usare `locality` per consistenza | `locality` |
| `postal_code` | ✅ OK | `postal_code` |
| `province` | ✅ OK, ma dovrebbe essere `administrative_area_level_2` | `administrative_area_level_2` |
| `country` | ✅ OK | `country` |
| `phone` | ✅ OK | `phone` |
| `latitude` | ✅ OK | `latitude` |
| `longitude` | ✅ OK | `longitude` |
| `street_number` | ✅ OK (già presente nel modello) | `street_number` |
| ❌ MANCANTE | `route` non presente in migrazione | `route` |
| ❌ MANCANTE | `administrative_area_level_3` (Comune) | `administrative_area_level_3` |
| ❌ MANCANTE | `administrative_area_level_1` (Regione) | `administrative_area_level_1` |
| ❌ MANCANTE | `formatted_address` | `formatted_address` |
| ❌ MANCANTE | `place_id` | `place_id` |

## Analisi dei Campi

### Campo `address` - DA DEPRECARE

**Problema**: Il campo `address` è troppo generico. In un indirizzo strutturato, dovremmo avere:
- `route` (nome via)
- `street_number` (numero civico)

**Soluzione**:
1. Aggiungere `route` se non presente
2. Mantenere `address` per backward compatibility (deprecato)
3. Popolare `route` e `street_number` automaticamente da `address` esistente tramite migrazione dati
4. Nei nuovi inserimenti, usare sempre `route` e `street_number` separati

### Campo `city` vs `locality`

**Analisi**:
- `city` è il nome più comune e intuitivo
- `locality` è la nomenclatura Google Places API
- Il modulo Geo usa `administrative_area_level_3` per il Comune

**Soluzione**:
- Mantenere `city` per backward compatibility
- Aggiungere `locality` come alias/campo aggiuntivo
- Aggiungere `administrative_area_level_3` per mapping con Geo

### Campo `province`

**Problema**: In Italia, `province` va bene, ma per consistenza internazionale dovremmo usare `administrative_area_level_2`.

**Soluzione**:
- Mantenere `province` per backward compatibility
- Aggiungere `administrative_area_level_2` come campo standard
- In Italia: `administrative_area_level_2` contiene la **sigla provincia** (es. MI, RM)

## Piano di Refactoring

### Fase 1: Aggiunta Campi Standard (NON Breaking Change)

Aggiungere i campi mancanti senza rimuovere quelli esistenti:

```php
if (! $this->hasColumn('route')) {
    $table->string(AddressItemEnum::ROUTE->value)->nullable()
        ->comment('Nome via/strada - Standard AddressItemEnum');
}

if (! $this->hasColumn('administrative_area_level_3')) {
    $table->string(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value)->nullable()
        ->comment('Comune - Standard AddressItemEnum');
}

if (! $this->hasColumn('administrative_area_level_2')) {
    $table->string(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value)->nullable()
        ->comment('Provincia/Sigla - Standard AddressItemEnum');
}

if (! $this->hasColumn('administrative_area_level_1')) {
    $table->string(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1->value)->nullable()
        ->comment('Regione - Standard AddressItemEnum');
}

if (! $this->hasColumn('locality')) {
    $table->string(AddressItemEnum::LOCALITY->value)->nullable()
        ->comment('Località/Frazione - Standard AddressItemEnum');
}

if (! $this->hasColumn('formatted_address')) {
    $table->text(AddressItemEnum::FORMATTED_ADDRESS->value)->nullable()
        ->comment('Indirizzo completo formattato - Standard AddressItemEnum');
}

if (! $this->hasColumn('place_id')) {
    $table->string(AddressItemEnum::PLACE_ID->value)->nullable()
        ->comment('Google Places ID - Standard AddressItemEnum');
}
```

### Fase 2: Migrazione Dati (Data Migration)

Creare una migrazione separata per popolare i nuovi campi dai vecchi:

```php
use Modules\Geo\Enums\AddressItemEnum;
use Modules\TechPlanner\Models\Client;

// Popolare route da address (estrarre nome via)
DB::table('clients')
    ->whereNotNull('address')
    ->whereNull(AddressItemEnum::ROUTE->value)
    ->each(function ($client) {
        // Logica per estrarre via e numero civico da address
        $parts = $this->parseAddress($client->address);

        DB::table('clients')->where('id', $client->id)->update([
            AddressItemEnum::ROUTE->value => $parts['route'],
            AddressItemEnum::STREET_NUMBER->value => $parts['street_number'] ?? $client->street_number,
        ]);
    });

// Popolare administrative_area_level_3 da city
DB::table('clients')
    ->whereNotNull('city')
    ->whereNull(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value)
    ->update([
        AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value => DB::raw('city'),
    ]);

// Popolare administrative_area_level_2 da province
DB::table('clients')
    ->whereNotNull('province')
    ->whereNull(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value)
    ->update([
        AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value => DB::raw('province'),
    ]);
```

### Fase 3: Aggiornamento Model Client

Aggiungere i nuovi campi al modello e creare accessori per backward compatibility:

```php
use Modules\Geo\Enums\AddressItemEnum;

class Client extends BaseModel
{
    use HasAddress;

    protected $fillable = [
        // ... campi esistenti ...

        // Campi indirizzo standard AddressItemEnum
        AddressItemEnum::PHONE->value,
        AddressItemEnum::ROUTE->value,
        AddressItemEnum::STREET_NUMBER->value,
        AddressItemEnum::LOCALITY->value,
        AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value,
        AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value,
        AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1->value,
        AddressItemEnum::COUNTRY->value,
        AddressItemEnum::POSTAL_CODE->value,
        AddressItemEnum::FORMATTED_ADDRESS->value,
        AddressItemEnum::PLACE_ID->value,
        AddressItemEnum::LATITUDE->value,
        AddressItemEnum::LONGITUDE->value,

        // Campi legacy (deprecati ma mantenuti)
        'address',      // DEPRECATO: usare route + street_number
        'city',         // DEPRECATO: usare administrative_area_level_3
        'province',     // DEPRECATO: usare administrative_area_level_2
    ];

    /**
     * Accessore per backward compatibility
     *
     * @deprecated Usare route + street_number separati
     */
    public function getAddressAttribute(): ?string
    {
        // Se address è già popolato, restituiscilo
        if ($this->attributes['address'] ?? null) {
            return $this->attributes['address'];
        }

        // Altrimenti componi da route + street_number
        $route = $this->getAttribute(AddressItemEnum::ROUTE->value);
        $streetNumber = $this->getAttribute(AddressItemEnum::STREET_NUMBER->value);

        return trim("$route $streetNumber") ?: null;
    }

    /**
     * Accessore per backward compatibility
     *
     * @deprecated Usare administrative_area_level_3
     */
    public function getCityAttribute(): ?string
    {
        return $this->attributes['city']
            ?? $this->getAttribute(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value);
    }

    /**
     * Accessore per backward compatibility
     *
     * @deprecated Usare administrative_area_level_2
     */
    public function getProvinceAttribute(): ?string
    {
        return $this->attributes['province']
            ?? $this->getAttribute(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value);
    }
}
```

### Fase 4: Aggiornamento Forms Filament

Aggiornare `ClientResource` per usare AddressItemEnum:

```php
use Modules\Geo\Enums\AddressItemEnum;
use Filament\Forms;

public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\Section::make('Dati Anagrafici')
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('vat_number'),
                Forms\Components\TextInput::make('fiscal_code'),
            ]),

        Forms\Components\Section::make('Indirizzo')
            ->schema([
                // Usa schema standard AddressItemEnum
                Forms\Components\TextInput::make(AddressItemEnum::ROUTE->value)
                    ->label(AddressItemEnum::ROUTE->getLabel())
                    ->prefixIcon(AddressItemEnum::ROUTE->getIcon())
                    ->helperText(AddressItemEnum::ROUTE->getDescription()),

                Forms\Components\TextInput::make(AddressItemEnum::STREET_NUMBER->value)
                    ->label(AddressItemEnum::STREET_NUMBER->getLabel())
                    ->prefixIcon(AddressItemEnum::STREET_NUMBER->getIcon()),

                Forms\Components\TextInput::make(AddressItemEnum::LOCALITY->value)
                    ->label(AddressItemEnum::LOCALITY->getLabel())
                    ->prefixIcon(AddressItemEnum::LOCALITY->getIcon()),

                Forms\Components\TextInput::make(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->value)
                    ->label(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->getLabel())
                    ->prefixIcon(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3->getIcon()),

                Forms\Components\TextInput::make(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->value)
                    ->label(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->getLabel())
                    ->prefixIcon(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2->getIcon()),

                Forms\Components\TextInput::make(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1->value)
                    ->label(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1->getLabel())
                    ->prefixIcon(AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1->getIcon()),

                Forms\Components\TextInput::make(AddressItemEnum::COUNTRY->value)
                    ->label(AddressItemEnum::COUNTRY->getLabel())
                    ->prefixIcon(AddressItemEnum::COUNTRY->getIcon()),

                Forms\Components\TextInput::make(AddressItemEnum::POSTAL_CODE->value)
                    ->label(AddressItemEnum::POSTAL_CODE->getLabel())
                    ->prefixIcon(AddressItemEnum::POSTAL_CODE->getIcon()),
            ])
            ->columns(2),

        Forms\Components\Section::make('Coordinate')
            ->schema([
                Forms\Components\TextInput::make(AddressItemEnum::LATITUDE->value)
                    ->label(AddressItemEnum::LATITUDE->getLabel())
                    ->numeric(),

                Forms\Components\TextInput::make(AddressItemEnum::LONGITUDE->value)
                    ->label(AddressItemEnum::LONGITUDE->getLabel())
                    ->numeric(),
            ])
            ->columns(2),

        Forms\Components\Section::make('Contatti')
            ->schema([
                Forms\Components\TextInput::make(AddressItemEnum::PHONE->value)
                    ->label(AddressItemEnum::PHONE->getLabel())
                    ->prefixIcon(AddressItemEnum::PHONE->getIcon())
                    ->tel(),

                Forms\Components\TextInput::make('email')
                    ->email(),

                Forms\Components\TextInput::make('mobile'),
                Forms\Components\TextInput::make('pec'),
                Forms\Components\TextInput::make('whatsapp'),
            ])
            ->columns(2),
    ]);
}
```

## Vantaggi del Refactoring

### 1. Consistenza con Modulo Geo

Tutti i campi indirizzo seguono la stessa nomenclatura del modello `Address`:
- `route` invece di `address`
- `administrative_area_level_3` invece di solo `city`
- `administrative_area_level_2` invece di solo `province`

### 2. Type Safety

Usando `AddressItemEnum::XXX->value` invece di stringhe hardcoded:
- PHPStan rileva errori di typo a compile-time
- IDE autocomplete funziona perfettamente
- Refactoring sicuro (renaming automatico)

### 3. Traduzioni Uniformi

Tutti i form usano le stesse traduzioni centrali:
- `AddressItemEnum::ROUTE->getLabel()` restituisce "Via" (it), "Street" (en), "Straße" (de)
- Nessuna duplicazione di chiavi di traduzione
- Un solo punto di manutenzione

### 4. Integrazione Google Places API

I nomi dei campi sono già compatibili con Google Places API:
- Parsing automatico delle risposte API
- Nessun mapping custom necessario
- Geocoding e reverse geocoding semplificati

### 5. Preparazione per HasAddress Trait

Se in futuro si decide di migrare verso relazioni polimorfe (`HasAddress` trait):
- I nomi dei campi sono già compatibili
- Migrazione dati semplificata
- Nessun breaking change nelle API

## Backward Compatibility

Il refactoring mantiene **piena backward compatibility**:

- ✅ Campi legacy (`address`, `city`, `province`) rimangono nel database
- ✅ Accessori nel modello garantiscono compatibilità con codice esistente
- ✅ Nuovi campi sono tutti `nullable`
- ✅ Migrazione dati automatica popola i nuovi campi
- ✅ Nessun breaking change nelle API

## Timeline di Deprecazione

### Fase 1 (Immediate) - DONE
- ✅ Aggiunta nuovi campi standard
- ✅ Migrazione dati esistenti
- ✅ Aggiornamento model e forms

### Fase 2 (3 mesi) - Deprecation Warnings
- ⚠️ Aggiungere deprecation notice a campi legacy
- ⚠️ Logging quando vengono usati campi deprecati
- ⚠️ Documentare API changes

### Fase 3 (6 mesi) - Rimozione Soft
- 🗑️ Smettere di popolare campi legacy nei nuovi record
- 🗑️ Mantenere campi solo per backward compatibility lettura

### Fase 4 (12 mesi) - Rimozione Completa
- ❌ Rimuovere campi `address`, `city`, `province` dal database
- ❌ Rimuovere accessori legacy dal model
- ❌ BREAKING CHANGE - major version bump

## Checklist Implementazione

- [ ] Aggiungere campi standard alla migrazione
- [ ] Creare migrazione dati per popolare nuovi campi
- [ ] Aggiornare $fillable nel model Client
- [ ] Aggiungere accessori backward compatibility
- [ ] Aggiornare ClientResource form schema
- [ ] Aggiornare ClientResource table columns
- [ ] Aggiornare tests per usare nuovi campi
- [ ] Aggiornare seeders per usare nuovi campi
- [ ] Aggiornare factories per usare nuovi campi
- [ ] Validare con PHPStan level 10
- [ ] Validare con PHPMD
- [ ] Validare con PHPInsights
- [ ] Aggiornare documentazione API
- [ ] Creare changelog entry
- [ ] Git commit con messaggio descrittivo
- [ ] Code review
- [ ] Deploy su staging per testing
- [ ] Deploy su production

## Riferimenti

- [AddressItemEnum Documentation](../../Geo/docs/enums/address-item-enum.md)
- [Address Model Documentation](../../Geo/docs/models/address.md)
- [HasAddress Trait](../../Geo/docs/traits/hasaddress-implementation.md)
- [Geo Module Architecture](../../Geo/docs/architecture.md)

---

> **Nota**: Questo refactoring segue la filosofia del progetto: Single Source of Truth, Type Safety, Backward Compatibility.
