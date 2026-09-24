# Fix: Legal Representatives Relationship Error

## Problema
Errore `BadMethodCallException: Call to undefined method Modules\TechPlanner\Models\Client::legalRepresentatives()` quando si accede alla pagina di modifica di un cliente in Filament.

## Causa
Il `LegalRepresentativesRelationManager` di Filament tentava di chiamare il metodo `legalRepresentatives()` sul modello `Client`, ma questo metodo non era definito.

## Soluzione Implementata

### 1. Aggiunta relazione nel modello Client
Aggiunto il metodo `legalRepresentatives()` nel file `laravel/Modules/TechPlanner/app/Models/Client.php`:

```php
/**
 * Get the legal representatives for the client.
 */
public function legalRepresentatives(): HasMany
{
    return $this->hasMany(\Modules\TechPlanner\Models\LegalRepresentative::class);
}
```

### 2. Aggiornamento documentazione PHPDoc
Aggiunto alla documentazione del modello Client:

```php
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modules\TechPlanner\Models\LegalRepresentative[] $legalRepresentatives
 * @property-read int|null $legal_representatives_count
```

### 3. Aggiunta relazione inversa nel modello LegalRepresentative
Aggiunto il metodo `client()` nel file `laravel/Modules/TechPlanner/app/Models/LegalRepresentative.php`:

```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Get the client that owns the legal representative.
 */
public function client(): BelongsTo
{
    return $this->belongsTo(\Modules\TechPlanner\Models\Client::class);
}
```

### 4. Aggiornamento documentazione PHPDoc LegalRepresentative
Aggiunto alla documentazione:

```php
 * @property-read \Modules\TechPlanner\Models\Client $client
```

## File Modificati
- `laravel/Modules/TechPlanner/app/Models/Client.php`
- `laravel/Modules/TechPlanner/app/Models/LegalRepresentative.php`

## Test
La relazione è ora funzionante e il RelationManager di Filament può accedere correttamente ai rappresentanti legali di un cliente.

## Note
- La relazione è di tipo `HasMany` (un cliente può avere più rappresentanti legali)
- La relazione inversa è di tipo `BelongsTo` (un rappresentante legale appartiene a un cliente)
- Entrambi i modelli estendono `BaseModel` del modulo TechPlanner

