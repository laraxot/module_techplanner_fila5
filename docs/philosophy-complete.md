# TechPlanner - Filosofia Completa: Logica, Religione, Politica, Zen

**Data Creazione**: 2025-12-23  
**Status**: Documentazione Filosofica Completa  
**Versione**: 1.0.0

## 📋 Indice Filosofico

1. [Logica (Logic)](#logica-logic)
2. [Religione (Religion)](#religione-religion)
3. [Politica (Politics)](#politica-politics)
4. [Zen (Zen)](#zen-zen)
5. [Manifestazioni Pratiche](#manifestazioni-pratiche)

---

## 🧠 Logica (Logic)

### Principio Fondamentale

**TechPlanner gestisce il ciclo di vita completo delle aziende di servizi tecnici: clienti, appuntamenti, dispositivi e compliance.**

### Dominio di Business

Il modulo serve **aziende di servizi tecnici** che operano in settori regolamentati (principalmente healthcare):
- Ispezioni dispositivi medici
- Certificazioni e compliance
- Manutenzione preventiva
- Consulenza legale e normativa
- Gestione multi-location

### Entità Core e Relazioni

```
Client (Centro dell'Universo)
├── Appointments (Appuntamenti tecnici)
├── Devices/Machines (Dispositivi da ispezionare)
├── LegalRepresentatives (Compliance legale)
├── MedicalDirectors (Responsabilità mediche)
├── Workers/Participants (Forza lavoro tecnica)
└── Addresses (Geo module - geolocalizzazione)
```

### Business Workflow Principale

1. **Onboarding Cliente**
   - Registrazione dati anagrafici e fiscali
   - Configurazione contatti multi-canale (phone, email, PEC, WhatsApp)
   - Assegnazione rappresentante legale e direttore medico
   - Setup geografico con geocoding automatico

2. **Registrazione Dispositivi**
   - Registrazione dispositivi/attrezzature del cliente
   - Tracking stato certificazioni
   - Lifecycle management (installazione, manutenzione, dismissione)

3. **Scheduling Appuntamenti**
   - Creazione appuntamenti tecnici collegati a clienti
   - Assegnazione dispositivi specifici da ispezionare
   - Assegnazione tecnici (workers/participants)
   - Gestione note e requisiti

4. **Compliance Management**
   - Tracciamento rappresentanti legali
   - Gestione direttori medici per strutture sanitarie
   - Uffici legali per clienti complessi
   - Documentazione normativa

### Manifestazione nel Codice

```php
// Client è l'entità centrale
class Client extends BaseModel
{
    // Gestione contatti multi-canale
    public function getContactsHtmlAttribute(): string
    {
        // Formatta phone, mobile, email, PEC, WhatsApp
    }
    
    // Relazioni core business
    public function appointments(): HasMany
    public function devices(): HasMany
    public function legalRepresentatives(): HasMany
    public function workers(): HasMany
}
```

---

## 📜 Religione (Religion)

### Comandamenti Sacri

1. **Client è il Centro dell'Universo** - Tutto ruota intorno al cliente
2. **Compliance è Sacra** - Rappresentanti legali e direttori medici sono obbligatori quando richiesto
3. **Geolocalizzazione Automatica** - Coordinate devono essere sempre aggiornate (integrazione Geo module)
4. **Comunicazione Multi-Canale** - Supporto completo: phone, email, PEC, WhatsApp (integrazione Notify module)
5. **Tracking Completo** - Ogni dispositivo deve essere tracciato con stato e certificazioni
6. **Workflow Implicito** - Il sistema "sa" automaticamente il prossimo passo

### Best Practices

- Usare **Bulk Actions** per operazioni su più clienti (es. aggiornamento coordinate)
- Integrare sempre con moduli supporto (Geo, Notify, Media) invece di duplicare logica
- Usare **Enum** per stati e tipologie (consistency garantita)
- **Relazioni polimorfe** per flessibilità futura

### Integrazione Moduli

Il modulo TechPlanner **dipende** da:
- **Xot**: Foundation (XotBaseResource, XotBaseModel)
- **Geo**: Geolocalizzazione (`UpdateCoordinatesBulkAction`, `AddressColumn`)
- **Notify**: Comunicazioni (`SendNotificationBulkAction`)
- **User**: Autenticazione (workers sono User)
- **Media**: Documenti e allegati

**Filosofia**: Non reinventare, integrare. Ogni modulo ha la sua responsabilità.

---

## 🏛️ Politica (Politics)

### Decisioni Architetturali

1. **Client-Centric Design** - Tutto parte dal cliente
2. **Multi-Contact Strategy** - Supporto completo canali comunicazione
3. **Device Lifecycle Management** - Tracking completo dispositivi
4. **Compliance-First** - Gestione normativa integrata nel modello dati
5. **Geographic Awareness** - Integrazione profonda con Geo module

### Governance del Modulo

- **Indipendenza Logica**: Business logic isolata, ma dipende da moduli supporto
- **Estensibilità**: Modello progettato per crescita futura (nuovi tipi dispositivi, compliance, etc.)
- **Type Safety**: Uso estensivo di Enum per stati e tipologie
- **Bulk Operations**: Supporto operazioni su più record simultaneamente

### Pattern Implementativi

```php
// Pattern: Bulk Actions per efficienza
class UpdateCoordinatesBulkAction extends BulkAction
{
    // Aggiorna coordinate per più clienti contemporaneamente
    // Integra Geo module invece di duplicare logica
}

// Pattern: Enum per consistency
enum AppointmentStatus: string
{
    case SCHEDULED = 'scheduled';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
}
```

---

## 🧘 Zen (Zen)

### Il Vuoto della Complessità

Apprezziamo il concetto zen del **"vuoto che sostiene"**:

- **No Business Logic Duplicata**: Integra Geo, Notify, Media invece di replicare
- **Workflow Impliciti**: Il sistema "sa" cosa fare in base allo stato
- **Relazioni Naturali**: Client → Appointment → Device è naturale, non forzato
- **Compliance Trasparente**: Gestione normativa integrata, non aggiunta

### Flusso Naturale

Il flusso di lavoro deve essere **naturale e intuitivo**:

1. Cliente registrato → Sistema suggerisce prossimi step
2. Dispositivo registrato → Sistema propone appuntamenti di manutenzione
3. Appuntamento schedulato → Sistema notifica automaticamente tutti i canali
4. Compliance → Sistema traccia automaticamente scadenze e responsabilità

### Semplicità nella Complessità

Il modulo gestisce complessità (compliance, multi-location, multi-device) ma:
- **Interfaccia semplice**: Filament resources con auto-discovery traduzioni
- **Workflow lineari**: Processi chiari senza confusion
- **Feedback immediato**: Notifiche e aggiornamenti in tempo reale
- **Type Safety**: Enum e tipizzazione prevengono errori

---

## 🎯 Manifestazioni Pratiche

### 1. Client Model - Entità Centrale

```php
class Client extends BaseModel
{
    // Business Identity
    public string $name;
    public ?string $company_name;
    public ?string $vat_number;
    public ?string $fiscal_code;
    
    // Multi-Contact Management
    public ?string $phone;
    public ?string $mobile;
    public ?string $email;
    public ?string $pec;        // PEC per comunicazioni legali
    public ?string $whatsapp;   // WhatsApp per comunicazioni rapide
    
    // Geographic (integrato Geo module)
    public ?float $latitude;
    public ?float $longitude;
    public function addresses(): MorphMany  // Relazione polimorfa
    
    // Compliance (core business)
    public function legalRepresentatives(): HasMany
    public function medicalDirectors(): HasMany
    
    // Core Business
    public function appointments(): HasMany
    public function devices(): HasMany
    public function workers(): HasMany
}
```

### 2. Appointment Model - Workflow Operativo

```php
class Appointment extends BaseModel
{
    // Collegamento cliente (centro universo)
    public int $client_id;
    public function client(): BelongsTo
    
    // Dispositivi da ispezionare
    public function machines(): HasMany
    
    // Forza lavoro
    public function participants(): HasMany
    
    // Stato e date
    public string $date;
    public ?string $notes;
}
```

### 3. Integration Pattern - Moduli Supporto

```php
// Geo Integration
use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;

// Notify Integration  
use Modules\Notify\Filament\Actions\SendNotificationBulkAction;

// Pattern: Bulk Actions per efficienza
protected function getTableBulkActions(): array
{
    return [
        'update_coordinates' => UpdateCoordinatesBulkAction::make(),
        'send_notification' => SendNotificationBulkAction::make(),
    ];
}
```

---

## 🔗 Collegamenti

- [Business Logic Overview](./README.md)
- [Models and Relationships](./models-and-relationships.md)
- [Filament Resources](./filament-resources.md)
- [Xot Module Foundation](../../Xot/docs/philosophy-complete.md)
- [Geo Module Integration](../../Geo/docs/philosophy.md)
- [Notify Module Integration](../../Notify/docs/philosophy.md)

---

**Filosofia**: Client-Centric, Compliance-First, Integration Over Duplication, Workflow Implicit
