# Setup Relation Managers per TechPlanner

## Problema Risolto

L'errore `BadMethodCallException: Call to undefined method legalRepresentatives()` è stato risolto aggiungendo la relazione mancante nel modello `Client`.

## Relazioni Implementate

### Client Model
```php
/**
 * Get the legal representatives for the client.
 */
public function legalRepresentatives(): HasMany
{
    return $this->hasMany(\Modules\TechPlanner\Models\LegalRepresentative::class);
}
```

### LegalRepresentative Model
```php
/**
 * Get the client that owns the legal representative.
 */
public function client(): BelongsTo
{
    return $this->belongsTo(\Modules\TechPlanner\Models\Client::class);
}
```

## Abilitazione RelationManager

Per abilitare i RelationManager nel ClientResource, decommentare il metodo `getRelations()`:

```php
public static function getRelations(): array
{
    return [
        LegalRepresentativesRelationManager::class,
    ];
}
```

## Test della Soluzione

```bash
# Test tramite tinker
php artisan tinker
$client = \Modules\TechPlanner\Models\Client::first();
$client->legalRepresentatives; // Dovrebbe funzionare senza errori
```

## Documentazione Correlata

- [Legal Representatives Relationship Fix](legal-representatives-relationship-fix.md)
- [Filament RelationManager Documentation](https://filamentphp.com/docs/3.x/panels/resources/relation-managers)

