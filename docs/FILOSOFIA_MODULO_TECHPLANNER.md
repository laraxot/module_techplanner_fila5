# Analisi Approfondita del Modulo TechPlanner

> **Ultimo aggiornamento**: 2026-01-07  
> **Scopo**: Documentare la filosofia, logica, business logic e architettura del modulo TechPlanner  
> **Status**: ✅ Documentazione completa e aggiornata

**Indice**:
1. [LOGICA - Come funziona il sistema](#1-logica---come-funziona-il-sistema)
2. [FILOSOFIA - Principi di Domain-Driven Design](#2-filosofia---principi-di-domain-driven-design)
3. [BUSINESS LOGIC - Entità Principali](#3-business-logic---entità-principali)
4. [POLITICA - Regole Business e Validazioni](#4-politica---regole-business-e-validazioni)
5. [RELIGIONE - Dogmi del Dominio Tecnico](#5-religione---dogmi-del-dominio-tecnico)
6. [SCOPO - Obiettivo Business del Modulo](#6-scopo---obiettivo-business-del-modulo)
7. [ZEN - L'Essenza del Business Domain](#7-zen---lessenza-del-business-domain)

---

## 1. LOGICA - Come funziona il sistema

### Workflow Core
Il modulo TechPlanner gestisce un sistema completo di **assistenza tecnica e manutenzione dispositivi medici/industriali** per aziende che forniscono servizi di verifica, certificazione e compliance.

**Flusso operativo principale:**
```
1. ONBOARDING CLIENTE
   ├─ Registrazione dati aziendali (Client)
   ├─ Geolocalizzazione automatica (Geo module)
   ├─ Assegnazione rappresentante legale
   ├─ Assegnazione direttore sanitario (se healthcare)
   └─ Registrazione dispositivi da verificare

2. PIANIFICAZIONE INTERVENTI
   ├─ Creazione appuntamento (Appointment)
   ├─ Associazione dispositivi da verificare
   ├─ Assegnazione tecnici (Worker)
   └─ Coordinamento logistico geografico

3. ESECUZIONE
   ├─ Intervento on-site
   ├─ Verifica dispositivi (DeviceVerification)
   ├─ Registrazione risultati
   └─ Tracking comunicazioni (PhoneCall)

4. COMPLIANCE & FOLLOW-UP
   ├─ Certificazioni e verifiche periodiche
   ├─ Scheduling prossime verifiche
   ├─ Gestione scadenze
   └─ Comunicazioni multi-canale
```

---

## 2. FILOSOFIA - Principi di Domain-Driven Design

### Principi Architetturali Chiave

**1. Enum-Driven Configuration**
```php
CompanyItemEnum::class  // Centralizza campi aziendali
PhoneCallEnum::class    // Stati chiamate
```
- Single source of truth per definizioni business
- Traduzioni automatiche multi-lingua
- Form schema generati da enum

**2. Modular Composition**
```
TechPlanner dipende da:
├─ Xot (foundation) → XotBaseResource, XotBasePage
├─ Geo (geografia) → AddressSection, coordinate, scopes
├─ Notify (comunicazioni) → ContactSection, multi-channel
├─ User (autenticazione) → Profile, roles
└─ Media (files) → Allegati documentazione
```

**3. XotBase Extension Rule (CRITICO)**
```php
// ❌ MAI fare questo
class MyResource extends Resource {}

// ✅ SEMPRE così
class ClientResource extends XotBaseResource {}
class ListClients extends XotBaseListRecords {}
```

---

## 3. BUSINESS LOGIC - Entità Principali

### Entità Core del Dominio

#### **Client** (Entità centrale)
```
Responsabilità:
├─ Anagrafica completa azienda
├─ Dati fiscali (P.IVA, C.F., CUAA)
├─ Geolocalizzazione con coordinate GPS
├─ Multi-contact (phone, mobile, email, PEC, WhatsApp)
├─ Status operativo (business_closed)
└─ HTML contact rendering con action links

Relazioni:
├─ hasMany(Appointment)        → Appuntamenti programmati
├─ hasMany(Device)             → Dispositivi da verificare
├─ hasMany(PhoneCall)          → Log comunicazioni
├─ hasMany(LegalRepresentative)→ Rappresentanti legali
├─ hasMany(MedicalDirector)    → Direttori sanitari
└─ hasMany(LegalOffice)        → Uffici legali
```

**Caratteristiche Uniche:**
- `getContactsHtmlAttribute()`: Genera HTML con icone Heroicon e link cliccabili
- Integrazione WhatsApp business
- PEC (Posta Elettronica Certificata) per compliance italiana
- Formattazione intelligente numeri telefono italiani

#### **Device/Machine**
```
Responsabilità:
├─ Tracking dispositivi medici/industriali
├─ Identificazione (serial, model, brand)
├─ Parametri tecnici (kV, mA per apparecchi RX)
├─ Gestione verifiche periodiche
└─ Calcolo scadenze certificazioni

Business Logic:
- needs_verification: bool → Scadenza verifiche
- latest_verification → Ultima verifica eseguita
- verifications: HasMany → Storico completo
```

#### **Appointment**
```
Minimalista ma potente:
├─ client_id + date
├─ notes per dettagli
└─ hasMany(Machine) → Dispositivi da verificare

Pattern: "Keep it simple"
```

#### **DeviceVerification**
```
Compliance tracking:
├─ verification_date
├─ next_verification_date
├─ result (esito verifica)
├─ verification_type (tipo controllo)
├─ exposure_parameters (parametri rilevati)
└─ notes
```

#### **PhoneCall**
```
Communication tracking:
├─ client_id
├─ date + duration
├─ call_type (inbound/outbound)
├─ notes
└─ Enum per categorizzazione
```

#### **Legal Entities** (Compliance Healthcare)
```
LegalRepresentative:
├─ Rappresentante legale azienda cliente
├─ Dati identificativi + contatti (name, email, phone, fiscal_code)
├─ Obbligatorio per alcune tipologie cliente (healthcare, strutture regolamentate)
├─ Relazione: belongsTo(Client)
└─ Business Logic: Compliance normativa, responsabilità legale azienda

MedicalDirector:
├─ Direttore sanitario (healthcare)
├─ Dati anagrafici + qualifiche
├─ Date inizio/fine incarico
├─ Required per strutture sanitarie (obbligo normativo)
└─ Relazione: belongsTo(Client)

LegalOffice:
├─ Ufficio legale di riferimento
├─ Dati completi: name, address, city, province, postal_code, country
├─ Contatti: phone, email
├─ Per clienti con esigenze legali complesse (consulenze, documentazione)
├─ Relazione: belongsTo(Client)
└─ Business Logic: Gestione documentale, compliance legale, supporto normativo
```

**Pattern Filament Resources**:
- Tutte le Resources estendono `XotBaseResource` (mai direttamente `Resource`)
- Pagine List **DEVONO** implementare `getTableColumns()` quando usate come RelationManager
- `XotBaseRelationManager` riutilizza colonne dalla pagina List principale
- Pattern DRY: un solo punto di definizione colonne
- Array associativo con chiavi stringa per tutte le colonne
- Type safety: `@return array<string, TextColumn>`

**Esempio Pattern getTableColumns()**:
```php
public function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name')->sortable()->searchable(),
        'email' => TextColumn::make('email')->searchable()->sortable(),
        'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
    ];
}
```

**Perché è Necessario**:
- `XotBaseRelationManager::getTableColumns()` chiama questo metodo sulla pagina List
- Se manca, si verifica `BadMethodCallException` quando Resource è usata come RelationManager
- Garantisce coerenza tra vista principale e RelationManager
- Pattern DRY: riuso codice colonne

Vedi [filament-resources.md](./filament-resources.md#pattern-gettablecolumns-nelle-list-pages) per dettagli completi.

#### **Worker**
```
Tecnici/Operatori:
├─ Extended profile from User module
├─ Dati anagrafici + geolocalizzazione
├─ Codice fiscale formattato
├─ hasMany(Device) → Dispositivi assegnati
└─ GeoTrait per routing ottimizzato
```

---

## 4. POLITICA - Regole Business e Validazioni

### Regole di Validazione Business

**1. Client Management**
```php
// Unicità business
- vat_number → UNIQUE (Partita IVA)
- fiscal_code → UNIQUE (Codice Fiscale)

// Geocoding automatico
- Se latitude/longitude null → UpdateAllClientCoordinatesAction
- Bulk action via Geo module integration

// Status management
- business_closed: boolean → Filtra clienti attivi
```

**2. Device Lifecycle**
```php
// Verifica necessaria se:
needs_verification = true QUANDO:
  - latest_verification === null
  - next_verification_date <= now()

// Calcolo automatico prossima verifica
- Basato su normative e tipo dispositivo
- Notifiche scadenze
```

**3. Appointment Scheduling**
```php
// Vincoli temporali
- date >= now() (solo future appointments)
- client_id → REQUIRED
- notes → Optional but recommended

// Business rules
- Un appointment può avere N machines
- Machines associate solo a valid appointments
```

**4. Communication Tracking**
```php
PhoneCallEnum:
- INBOUND → Chiamate ricevute
- OUTBOUND → Chiamate effettuate

// Logging automatico con timestamp
// Duration tracking per analytics
```

**5. Compliance Italiana**
```php
// PEC obbligatoria per PA
// Codice fiscale validazione formato
// Partita IVA 11 cifre
// Az ULSS competente (healthcare)
```

---

## 5. RELIGIONE - Dogmi del Dominio Tecnico

### I Comandamenti di TechPlanner

**1. "Thou Shall Extend XotBase"**
```php
// Mai estendere direttamente da Filament
// SEMPRE da XotBase per coerenza architetturale
```

**2. "Thou Shall Use Enums For Schema"**
```php
CompanyItemEnum::getFormSchema() // → Form fields
AddressItemEnum::columns()        // → Migration columns
ContactTypeEnum::getFormSchema()  // → Contact fields
```

**3. "Thou Shall Not Use property_exists()"**
```php
// ❌ WRONG con Eloquent models
if (property_exists($client, 'full_name')) {}

// ✅ CORRECT
if (isset($client->full_name)) {}
```

**4. "Separation of Concerns is Sacred"**
```
Business Logic → Spatie Actions (testable)
UI Logic → Filament BulkActions (UI integration)
Data Access → Eloquent models
Presentation → Blade views
```

**5. "Geocoding is Infrastructure"**
```php
// Non reimplementare geocoding
// Usa Geo module actions
UpdateCoordinatesBulkAction::class
GetCoordinatesAction::class
```

**6. "Multi-lingua via Translation Files Only"**
```php
// ❌ NEVER
->label('Nome Cliente')

// ✅ ALWAYS
->label(trans('techplanner::client.fields.name'))
```

---

## 6. SCOPO - Obiettivo Business del Modulo

### Obiettivo Primario
**Gestire in modo completo ed efficiente la pianificazione tecnica e manutenzione dispositivi per aziende di assistenza tecnica nel settore medicale/industriale italiano.**

### Casi d'Uso Target

**1. Aziende Verifiche Dispositivi Medici**
```
Cliente tipo:
- Ospedali, cliniche, studi medici
- Dispositivi: Apparecchi RX, TAC, Risonanza
- Compliance: Verifiche periodiche obbligatorie
- Normativa: Decreto 81/2008, norme UNI EN
```

**2. Service Tecnici Multi-Cliente**
```
Necessità:
- Routing tecnici ottimizzato geograficamente
- Scheduling intelligente appuntamenti
- Tracking device lifecycle
- Gestione scadenze certificazioni
- Multi-contact per emergenze
```

**3. Compliance Healthcare Italiana**
```
Requirements specifici:
- Direttore sanitario obbligatorio
- PEC per comunicazioni ufficiali
- Az ULSS competente tracking
- Rappresentanti legali gestiti
- Documentazione certificata
```

---

## 7. ZEN - L'Essenza del Business Domain

### Il Cuore del Sistema

**TechPlanner è sostanzialmente un CRM specializzato per assistenza tecnica con scheduling intelligente e compliance tracking.**

**L'essenza in una frase:**
> "Collegare clienti, dispositivi, tecnici e appuntamenti nello spazio e nel tempo, garantendo compliance e tracciabilità completa."

### I Tre Pilastri Zen

**1. SPAZIO (Geografia)**
```
Client → Coordinate GPS
Worker → Coordinate GPS
         ↓
Routing ottimizzato tecnici
Map visualization (ClientMapWidget)
Distance-based queries
```

**2. TEMPO (Scheduling)**
```
Appointment → DateTime
DeviceVerification → Scadenze
         ↓
Calendar management
Verification deadlines
Notification triggers
```

**3. TRACCIABILITÀ (Audit)**
```
created_by / updated_by
PhoneCall logging
DeviceVerification history
         ↓
Complete audit trail
Compliance proof
Business intelligence
```

### Pattern Filosofici Osservati

**DRY via Enums**
```php
CompanyItemEnum → Definisce una volta, usa ovunque
- Form fields
- Migration columns
- Translations
- Validation rules
```

**KISS via XotBase**
```php
// Invece di riscrivere tutto
class ClientResource extends XotBaseResource {
    // Solo customizzazioni specifiche
    public static function getFormSchema(): array {
        return [
            'company' => CompanySection::make(),
            'address' => AddressSection::make(),
            'contacts' => ContactSection::make(),
        ];
    }
}
```

**Composition over Inheritance**
```php
Client usa:
├─ GeographicalScopes (trait)
├─ HasAddress (trait)
├─ HasDynamicFillable (trait)
└─ Updater (trait)

Invece di ereditare da 4 classi diverse
```

### Il Momento "Aha!" del Dominio

**La comprensione chiave è che TechPlanner non è solo "gestione appuntamenti".**

È un **sistema di orchestrazione spazio-temporale** che:
1. Connette **ENTITÀ** (clienti, dispositivi, tecnici)
2. Nel **TEMPO** (appuntamenti, verifiche, scadenze)
3. Nello **SPAZIO** (geolocalizzazione, routing)
4. Con **COMPLIANCE** (legale, sanitaria, fiscale)
5. Tracciando **TUTTO** (audit, comunicazioni, storia)

---

## CONCLUSIONE

Il modulo TechPlanner rappresenta un **dominio business complesso** gestito con **architettura modulare pulita** seguendo rigorosamente i principi **DRY + KISS + SOLID**.

### Metriche Modulo
- **16 modelli** per gestire il dominio business
- **8 Filament Resources** con CRUD completi e type safety
- **6+ RelationManagers** per relazioni nidificate
- **2 Enums** centralizzati per business logic (CompanyItemEnum, PhoneCallEnum)
- **3 Widgets** per visualizzazioni (map, coordinates, stats)
- **50+ file documentazione** (eccellente coverage)

### Punti di Forza Architetturali
- **Enum-Driven Configuration**: Single source of truth per definizioni business
- **Modular Composition**: Dipendenze esplicite, integrazione pulita
- **Geographic Integration**: Geo module per geolocalizzazione e routing
- **Communication Hub**: Notify module per multi-channel (phone, email, PEC, WhatsApp)
- **Compliance-First**: Gestione normativa integrata (Italian healthcare)
- **Audit Trail Complete**: Tracciamento completo con created_by/updated_by
- **Type Safety**: PHPStan Level 10 compliance
- **XotBase Pattern**: Estensione corretta di tutte le classi base

### Pattern Implementati
- **getTableColumns()**: Pattern obbligatorio per List pages usate come RelationManager
- **XotBaseResource**: Estensione corretta (mai direttamente Resource)
- **Enum per Fillable**: Pattern centralizzato per campi modelli
- **Bulk Actions**: Operazioni efficienti su più record
- **Trait Composition**: Riutilizzo funzionalità senza ereditarietà multipla

### Filosofia Finale
> "TechPlanner è Zen perché rende **semplice** ciò che è **complesso**: gestire centinaia di clienti, migliaia di dispositivi, scheduling dinamico e compliance rigorosa con un'interfaccia pulita e workflow chiari."

**Principi Guida**:
- **DRY**: Zero duplicazione, enum centralizzati, pattern riutilizzabili
- **KISS**: Workflow lineari, interfacce semplici, logica chiara
- **SOLID**: Responsabilità singole, dipendenze esplicite, estensibilità
- **Robust**: Type safety, validazione completa, error handling
- **Laraxot**: Conformità totale agli standard del framework

---

## Collegamenti Utili

### Documentazione Core
- [README.md](./README.md) - Overview completo del modulo
- [00-index.md](./00-index.md) - Indice documentazione
- [models-and-relationships.md](./models-and-relationships.md) - Struttura dati e relazioni
- [filament-resources.md](./filament-resources.md) - Risorse Filament e pattern

### Pattern e Best Practices
- [using-geo-components.md](./using-geo-components.md) - Integrazione Geo module
- [company-enum-integration.md](./company-enum-integration.md) - Pattern Enum-driven
- [address-item-enum-integration.md](./address-item-enum-integration.md) - AddressItemEnum pattern
- [model-fillable-enum-pattern.md](./model-fillable-enum-pattern.md) - Fillable con enum
- [dry-kiss-improvements.md](./dry-kiss-improvements.md) - Miglioramenti DRY + KISS

### Troubleshooting
- [troubleshooting.md](./troubleshooting.md) - Errori comuni e soluzioni
- [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md) - Compliance PHPStan

### Moduli Correlati
- [Xot Module](../../Xot/docs/README.md) - Foundation module
- [Geo Module](../../Geo/docs/README.md) - Geographic services
- [Notify Module](../../Notify/docs/README.md) - Communication hub
- [User Module](../../User/docs/README.md) - Authentication
