# Analisi Errori PHPStan - TechPlanner Project 2025

**Data Analisi**: 2025-01-18  
**Totale Errori**: 48  
**Livello PHPStan**: 9  
**Obiettivo**: Correzione sistematica per raggiungere PHPStan Level 10

## 📊 Categorizzazione per Priorità

### 🔴 PRIORITÀ 1 - CRITICI (Fix Immediato)
**Totale**: 8 errori

#### 1.1 View String Type Errors (2 errori)
- **File**: `Employee/app/Filament/Widgets/TeamPresenceWidget.php`
- **Linee**: 52, 60
- **Errore**: `Parameter #1 $view of function view expects view-string|null, string given`
- **Causa**: Passaggio di stringhe dinamiche alla funzione `view()` invece di view-string tipizzate
- **Impatto**: Potenziali errori runtime se le view non esistono

#### 1.2 Offset Access Errors (3 errori)
- **File**: `Geo/app/Models/Address.php`
- **Linee**: 187 (2 errori)
- **Errore**: `Offset 'codice'/'nome' does not exist on string`
- **Causa**: Tentativo di accesso ad array su variabile stringa
- **Impatto**: Errori runtime fatali

#### 1.3 Mixed Type Access (3 errori)
- **File**: `UI/app/Filament/Forms/Components/LocationSelector.php`
- **Linee**: 311, 312 (3 errori)
- **Errore**: `Cannot access offset string on mixed`
- **Causa**: Accesso ad offset su tipo mixed senza controllo
- **Impatto**: Errori runtime imprevedibili

### 🟡 PRIORITÀ 2 - TYPE SAFETY (Fix Sistematico)
**Totale**: 25 errori

#### 2.1 PHPDoc Parameter Errors (15 errori)
- **Moduli**: Geo, Lang, Media, Notify, Tenant, Xot
- **Errore**: `PHPDoc tag @param references unknown parameter`
- **Causa**: Parametri PHPDoc non corrispondenti ai parametri reali dei metodi
- **Impatto**: Documentazione inconsistente, difficoltà debugging

#### 2.2 Missing Type Parameters (4 errori)
- **File**: `Notify/app/Notifications/GenericNotification.php`, `TelegramNotification.php`, `User/app/Notifications/Auth/Otp.php`
- **Errore**: `Method has parameter with no type specified`
- **Causa**: Parametri senza type hint esplicito
- **Impatto**: Perdita type safety, difficoltà refactoring

#### 2.3 Return Type Mismatch (1 errore)
- **File**: `Xot/app/Datas/MetatagData.php`
- **Linea**: 645
- **Errore**: `Method should return string but returns string|null`
- **Causa**: Tipo di ritorno dichiarato non corrisponde all'implementazione
- **Impatto**: Inconsistenza type safety

#### 2.4 Collection Map Type Errors (1 errore)
- **File**: `Tenant/app/Actions/GetTenantNameAction.php`
- **Linea**: 36
- **Errore**: `Collection::map() expects callable(string, int): string, Closure(string, string=, string|null=, array<string, string>=): string given`
- **Causa**: Signature della closure non corrisponde al tipo atteso
- **Impatto**: Errori runtime su operazioni collection

#### 2.5 Null Safety Issues (4 errori)
- **File**: `UI/app/Actions/Datetime/GetDaysMappingAction.php`
- **Linee**: 30, 37
- **Errore**: `Cannot call method startOfWeek() on Carbon\Carbon|null`
- **Causa**: Chiamata metodo su tipo nullable senza controllo
- **Impatto**: Potenziali errori runtime

### 🟢 PRIORITÀ 3 - QUALITÀ CODICE (Fix Incrementale)
**Totale**: 15 errori

#### 3.1 Strict Comparison Always False/True (5 errori)
- **File**: `Employee/app/Filament/Widgets/TimeOffBalanceWidget.php`, `User/app/Console/Commands/ChangePasswordCommand.php`, `Xot/app/Actions/Cast/SafeObjectCastAction.php`
- **Errore**: `Strict comparison using ===/!== will always evaluate to false/true`
- **Causa**: Confronti tra tipi incompatibili
- **Impatto**: Logica condizionale errata

#### 3.2 Magic Constant Out of Class (3 errori)
- **File**: `Xot/Helpers/Helper.php`
- **Linee**: 167, 454, 466
- **Errore**: `Magic constant __CLASS__ is always empty outside a class`
- **Causa**: Uso di `__CLASS__` in contesto non-classe
- **Impatto**: Comportamento imprevedibile

#### 3.3 Callable Non-Native Method (3 errori)
- **File**: `User/app/Filament/Pages/MyProfilePage.php`, `User/app/Models/BaseUser.php`
- **Errore**: `Creating callable from a non-native static/method`
- **Causa**: Creazione callable da metodi non nativi
- **Impatto**: Potenziali problemi di performance

#### 3.4 Array Duplicate Keys (1 errore)
- **File**: `User/lang/it/device.php`
- **Linea**: 7
- **Errore**: `Array has 2 duplicate keys with value 'navigation'`
- **Causa**: Chiavi duplicate in array di traduzione
- **Impatto**: Comportamento imprevedibile nelle traduzioni

#### 3.5 Undefined Variable (1 errore)
- **File**: `Tenant/app/Services/TenantService.php`
- **Linea**: 148
- **Errore**: `Variable $default might not be defined`
- **Causa**: Variabile utilizzata senza inizializzazione
- **Impatto**: Potenziali errori runtime

#### 3.6 Unknown Parameters (2 errori)
- **File**: `Xot/app/Actions/Pdf/ContentPdfAction.php`
- **Linee**: 88, 107
- **Errore**: `Unknown parameter $filename in call to method`
- **Causa**: Chiamata metodo con parametri non definiti
- **Impatto**: Errori runtime

## 🎯 Piano di Correzione Sistematica

### Fase 1: Correzione Errori Critici (Priorità 1)
1. **View String Type Errors**: Implementare view-string tipizzate o controlli runtime
2. **Offset Access Errors**: Aggiungere controlli di tipo prima dell'accesso
3. **Mixed Type Access**: Implementare type guards e controlli di sicurezza

### Fase 2: Implementazione Type Safety (Priorità 2)
1. **PHPDoc Consistency**: Allineare documentazione con implementazione reale
2. **Missing Types**: Aggiungere type hints espliciti a tutti i parametri
3. **Return Types**: Correggere inconsistenze tra dichiarazione e implementazione
4. **Collection Types**: Implementare signature corrette per closure
5. **Null Safety**: Aggiungere controlli null safety per Carbon e altri tipi nullable

### Fase 3: Miglioramenti Qualità (Priorità 3)
1. **Strict Comparisons**: Correggere logica di confronto
2. **Magic Constants**: Sostituire con alternative appropriate
3. **Callable Methods**: Ottimizzare creazione callable
4. **Array Issues**: Correggere chiavi duplicate e variabili non definite
5. **Parameter Validation**: Verificare signature dei metodi

## 📋 Pattern di Correzione Comuni

### Pattern 1: View String Type Safety
```php
// ❌ ERRATO
$viewName = 'dynamic.view.' . $type;
return view($viewName);

// ✅ CORRETTO
$viewName = 'dynamic.view.' . $type;
if (!view()->exists($viewName)) {
    throw new ViewNotFoundException("View {$viewName} not found");
}
return view($viewName);
```

### Pattern 2: Offset Access Safety
```php
// ❌ ERRATO
$data = $this->getData();
return $data['codice'];

// ✅ CORRETTO
$data = $this->getData();
if (!is_array($data) || !isset($data['codice'])) {
    return null;
}
return $data['codice'];
```

### Pattern 3: PHPDoc Consistency
```php
// ❌ ERRATO
/**
 * @param string $attribute
 */
public function validate($value, $rule, $parameters, $validator) {}

// ✅ CORRETTO
/**
 * @param mixed $value
 * @param string $rule
 * @param array<int, string> $parameters
 * @param \Illuminate\Contracts\Validation\Validator $validator
 */
public function validate($value, string $rule, array $parameters, $validator): bool {}
```

### Pattern 4: Null Safety
```php
// ❌ ERRATO
$carbon = $this->getCarbon();
return $carbon->startOfWeek();

// ✅ CORRETTO
$carbon = $this->getCarbon();
if ($carbon === null) {
    throw new InvalidArgumentException('Carbon instance is null');
}
return $carbon->startOfWeek();
```

## 🔗 Collegamenti Correlati

- [PHPStan Systematic Approach](../Xot/docs/phpstan-systematic-approach.md)
- [Type Safety Guidelines](../Xot/docs/filament-component-type-safety.md)
- [Best Practices](../Xot/docs/best-practices.md)

## 📝 Note Implementative

1. **Approccio Incrementale**: Correggere per priorità, testando ogni modifica
2. **Backward Compatibility**: Mantenere compatibilità con codice esistente
3. **Documentazione**: Aggiornare PHPDoc per ogni modifica
4. **Testing**: Verificare che le correzioni non introducano regressioni
5. **Performance**: Considerare impatto performance per ogni correzione

---

*Documento di analisi sistematica errori PHPStan - Framework Laraxot TechPlanner*
