# PHPStan Level 10 Compliance Status

**Last Updated**: 2026-07-06

**Status**: ✅ FULLY COMPLIANT (0 errors, level max)

Baseline sessione 2026-07-06: 254 → 0, in una passata condivisa con Employee/Notify/User/Xot. TechPlanner era, insieme a Employee, l'unico modulo la cui `tests/TestCase.php` estendeva direttamente `Illuminate\Foundation\Testing\TestCase` invece di `Modules\Xot\Tests\XotBaseTestCase`; il resto del batch di errori è stato risolto in parallelo (vedi `Modules/Employee/docs/phpstan-compliance-status.md` per l'analisi completa della causa radice condivisa).

## Summary
The TechPlanner module is fully compliant with PHPStan Level 10 analysis. All static analysis errors have been resolved, ensuring type safety and code quality.

## Fixed Issues

### 1. Property Access on Eloquent Models
**Problem**: Using `property_exists()` on Eloquent models  
**Solution**: Replaced with `getAttribute()` method  
**File**: `app/Filament/Resources/ClientResource/Pages/ListClients.php`  
**Details**: Eloquent model attributes are magic properties and cannot be checked with `property_exists()`

### 2. Type Safety in Client Resource
**Problem**: Potential null access on client attributes  
**Solution**: Added proper type checking and safe attribute access  
**File**: `app/Filament/Resources/ClientResource/Pages/ListClients.php`

## Compliance Verification
```bash
./vendor/bin/phpstan analyse Modules/TechPlanner --level=10 --memory-limit=-1
# Result: [OK] No errors
```

## Best Practices Implemented

1. **Type Safety**: All method parameters and return types are properly declared
2. **Eloquent Best Practices**: Using appropriate methods for accessing model attributes
3. **Null Safety**: Proper handling of potentially null values
4. **PHPDoc Compliance**: Accurate type annotations for complex return types

## Ongoing Maintenance

To maintain PHPStan compliance:
1. Run PHPStan analysis before committing changes
2. Ensure all new methods have proper type hints
3. Use `getAttribute()` instead of `property_exists()` for Eloquent models
4. Add PHPDoc annotations for complex generic types

## Related Documentation
- [PHPStan Configuration](../../../../phpstan.neon)
- [Laraxot Development Standards](../../../../docs/development/standards.md)
- [Eloquent Best Practices](eloquent-best-practices.md)

## Correzione root cause (2026-07-06, sessione pomeridiana)

La causa radice descritta sopra (`TestCase` che estende direttamente `Illuminate\Foundation\Testing\TestCase`) non è quella che ha effettivamente generato la maggior parte dei 254 errori. Cause reali trovate e corrette:

1. **`tests/Feature/ProjectManagementTest.php`** (133 errori) + helper `createProject/createTask/createResource` e expectation `toBeProject/toBeTask/toBeResource` in `tests/Pest.php` (45 errori): testavano/referenziavano `Modules\TechPlanner\Models\Project|Task|Resource`, modelli **mai esistiti** in questo modulo (il dominio reale è Client/Worker/Appointment/Machine/Device — nessuna traccia di "project management" in produzione). Scaffold generico scollegato dal dominio reale: **rimosso**, non corretto (per la regola: non creare i model mancanti per far passare un test scollegato dalla realtà).
2. **`app/Models/Client.php`**: `use Modules\Xot\Models\Traits\HasDynamicFillable;` puntava a un trait mai creato (introdotto in un refactor passato mai completato). A differenza del caso 1, qui l'intento era chiaro e univoco (property `$dynamicFillableEnums` + metodo `getDynamicFillableEnums()` già presenti, enum `AddressItemEnum` con i valori attesi): **creato** `Modules/Xot/app/Models/Traits/HasDynamicFillable.php`.
3. **`tests/Pest.php`**: dichiarava un `namespace Modules\TechPlanner\Tests;` che rompeva la risoluzione delle funzioni globali Pest (`uses()`), più un `uses()->in('Feature','Unit')` a livello globale, pattern vietato dalla convenzione già scritta in `Modules/Employee/tests/Pest.php` (causa `method.internalClass`). Rimossi entrambi.
4. **`tests/TestCase.php`**: chiamava `$this->loadLaravelMigrations()`, metodo del trait `RefreshDatabase` mai incluso nella classe — rimosso (il bootstrap condiviso via `Modules\Xot\Tests\CreatesApplication` gestisce già le migrazioni).
5. **`tests/Unit/Models/BaseModelTest.php`**: usava `$this->baseModel` (proprietà dinamica non tipizzabile) — riscritto con una funzione helper locale.

Ri-verificato con `phpstan analyse Modules/TechPlanner --memory-limit=-1`: **0 errori**, confermato con cache pulita. Test: 5/5 passano (`php artisan test Modules/TechPlanner`). Dettagli completi: `docs/chat/phpstan-modules-progress-2026-07-06-pm.md` (root del repo).