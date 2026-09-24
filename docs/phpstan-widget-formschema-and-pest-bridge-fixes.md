# PHPStan fixes — Widget getFormSchema + Pest bridge

Sessione di fix dei 10 errori PHPStan (level max) riportati per il modulo TechPlanner.
Config usata: `laravel/phpstan.neon` (immutabile, unica sorgente).

## Errori risolti

### 1. `method.childReturnType` nei widget (3 errori)

File:
- `app/Filament/Widgets/ClientMapWidget.php`
- `app/Filament/Widgets/CoordinatesWidget.php`
- `app/Filament/Widgets/MapWidget.php`

**Causa**: il PHPDoc dichiarava `@return array<string, Component>` per
`getFormSchema()`, incompatibile con il tipo del genitore
`Modules\Xot\Filament\Widgets\XotBaseWidget::getFormSchema()` che dichiara
`@return array<int, mixed>`. Una chiave `string` non è sottotipo di una chiave `int`,
quindi l'override viola la covarianza del tipo di ritorno.

**Fix**: allineato il PHPDoc a `@return array<int, Component>`, compatibile con il
genitore (`Component` è sottotipo di `mixed`, chiavi `int` invariate). I tre metodi
ritornano array vuoti (widget di sola visualizzazione), quindi il tipo è corretto.
Convenzione coerente con i widget fratelli (`User\...\LoginWidget` usa
`array<int, Component>`).

### 2. `method.internalClass` in `tests/Unit/Models/BaseModelTest.php` (6 errori)

**Causa**: le chiamate `expect(...)->toBe()/toBeInstanceOf()/toBeTrue()` venivano
risolte da PHPStan sulla classe `@internal` `Pest\Mixins\Expectation`, perché il file
di test è namespaced (`Modules\TechPlanner\Tests\Unit\Models`) e il bridge di analisi
statica `Modules/Xot/tests/Support/PestFunctionBridge.php` — che ridefinisce
`expect()` come ritorno di `Modules\Xot\Tests\Support\PestExpectation` (non interno)
per ogni namespace di test — **non conteneva i namespace di TechPlanner**.
Il bridge era stato generato il 2026-07-14, prima dell'aggiunta dei test TechPlanner
correnti.

**Fix**:
- Rigenerato il bridge con `php bashscripts/tools/generate-pest-phpstan-bridge.php`,
  che ora include i namespace `Modules\TechPlanner\Tests\*` (214 namespace totali).
- Aggiunto `uses(\Modules\TechPlanner\Tests\TestCase::class)` in `BaseModelTest.php`
  come richiesto dalla convenzione del modulo (vedi `tests/Pest.php`).

Il test era già in sintassi Pest: nessuna conversione da PHPUnit necessaria.

## Nota sul residuo "Found 1 error"

Analizzando *solo* `Modules/TechPlanner`, PHPStan segnala che il pattern ignorato
globale `#PHPDoc tag @mixin contains unknown class #` non è stato usato
(`reportUnmatchedIgnoredErrors`). Non è un errore di codice TechPlanner: quel pattern
matcha quando si analizza l'intero albero `Modules/`. Non va toccata la config globale.

## Gate di qualità

- PHPStan: 9/9 errori reali risolti (resta solo il meta-avviso sopra).
- Pest: `BaseModelTest` 5 passed (6 assertions).
- Pint: applicato, nessuna anomalia.
- phpmd: solo finding pre-esistenti idiomatici Laravel/Laraxot (StaticAccess a facade,
  `Factory::new()`, proprietà `$module_dir`/`$module_ns` dei base provider, complessità
  migration) — non correlati agli errori PHPStan, non regressioni.
- phpinsights: non completa (fallisce al 96% cercando `composer.lock` nella dir del
  modulo — limite dell'ambiente, non del codice).

## Lezione generalizzabile

Quando un file di test Pest namespaced produce `method.internalClass` su `expect()`,
la causa quasi sempre è che il namespace non è coperto da `PestFunctionBridge.php`:
rigenerare il bridge, non aggiungere ignore.
