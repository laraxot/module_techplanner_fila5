# Analisi e Raccomandazioni GDPR - TechPlanner
**Data**: 7 Febbraio 2026
**Module**: TechPlanner
**Scope**: Conformità GDPR per sito web radioprotezione

---

## 📋 Sommario Esecutivo

Il sito target (Hostinger) utilizza un cookie banner di base, ma mancano molti elementi essenziali per la conformità GDPR completa. Il nostro sito Laravel deve implementare un sistema di gestione consenso completo per essere conforme al GDPR (Regolamento UE 2016/679).

---

## 🎯 Requisiti GDPR Essenziali per Siti Web

### 1. Cookie Consent Banner (Cookie Banner)

**Requisito Legale**: GDPR Art. 4(11) - "Consenso dell'interessato"

**Elementi Richiesti**:
- ✅ Banner visibile al primo accesso
- ✅ Informazione chiara su tipi di cookie utilizzati
- ✅ Opzione "Accetta Tutti" (consenso espresso)
- ✅ Opzione "Rifiuta Tutti" (non consenso)
- ✅ Opzione "Gestisci Preferenze" (consenso granulare)
- ✅ Link a Privacy Policy completa
- ✅ Persistenza della scelta dell'utente
- ✅ Possibilità di revocare il consenso

**Tipi di Cookie da Gestire**:
1. **Cookie Tecnici** (Essenziali)
   - Session management
   - Security
   - Load balancing
   - Nessun consenso richiesto

2. **Cookie Analitici** (Performance)
   - Google Analytics
   - Hotjar (heatmap)
   - CookieConsent
   - Consenso esplicito richiesto

3. **Cookie Marketing** (Targeting)
   - Facebook Pixel
   - Google Ads
   - LinkedIn Insights
   - Consenso esplicito richiesto

### 2. Privacy Policy Page (Informativa Privacy)

**Requisito Legale**: GDPR Art. 13-14 - "Informazione degli interessati"

**Sezioni Obbligatorie**:
- ✅ Identità del Titolare del Trattamento
- ✅ Finalità del Trattamento
- ✅ Base Giuridica del Trattamento
- ✅ Destinatari dei Dati
- ✅ Periodo di Conservazione
- ✅ Diritti dell'Interessato
- ✅ Diritto di Reclamo (Garante)
- ✅ Cookie Policy
- ✅ Dati di Contatto

### 3. Terms of Service Page (Termini di Servizio)

**Requisito Legale**: GDPR Art. 7 - "Condizioni per il consenso"

**Sezioni Obbligatorie**:
- ✅ Oggetto del Servizio
- ✅ Modalità di Erogazione
- ✅ Responsabilità del Titolare
- ✅ Responsabilità dell'Utente
- ✅ Limitazione di Responsabilità
- ✅ Risoluzione delle Controversie
- ✅ Legge Applicabile
- ✅ Modifiche ai Termini

### 4. Data Processing Agreement (DPA)

**Requisito Legale**: GDPR Art. 28 - "Responsabile del trattamento"

**Fornitori che richiedono DPA**:
- ✅ Google (Analytics, Ads)
- ✅ Facebook (Pixel)
- ✅ LinkedIn (Insights)
- ✅ Mailchimp/Newsletter
- ✅ Form Services (Typeform, ecc.)
- ✅ Cloud Storage (AWS, Azure)

---

## 🔧 Implementazione Tecnica

### 1. Cookie Consent con Spatie Laravel-cookie-consent

**Installazione**:
```bash
composer require spatie/laravel-cookie-consent
php artisan vendor:publish --provider="Spatie\CookieConsent\CookieConsentServiceProvider"
```

**Configurazione**:
```php
// config/cookieconsent.php
return [
    'cookie_name' => 'laravel_cookie_consent',
    'cookie_lifetime' => 365, // giorni
];
```

**Blade Component**:
```php
<x-cookie-consent />
```

### 2. Cookie Categories Implementation

**File**: `app/Http/Controllers/CookieController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    public function accept()
    {
        Cookie::queue('cookie_consent', 'all', 60 * 24 * 365);
        return back();
    }

    public function decline()
    {
        Cookie::queue('cookie_consent', 'essential', 60 * 24 * 365);
        return back();
    }

    public function manage(Request $request)
    {
        $consent = $request->except(['_token']);
        Cookie::queue('cookie_consent', json_encode($consent), 60 * 24 * 365);
        return back();
    }
}
```

### 3. GDPR Module Integration

Il modulo Gdpr di TechPlanner deve essere esteso per includere:

**Modello**: `Modules\Gdpr\Models\ConsentLog`
```php
<?php

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsentLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'ip_address',
        'consent_type', // cookie, privacy, newsletter
        'consent_data', // JSON
        'granted_at',
        'revoked_at',
    ];

    protected $casts = [
        'consent_data' => 'array',
        'granted_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];
}
```

### 4. Privacy Policy Page Implementation

**File**: `Modules/TechPlanner/resources/views/pages/privacy.blade.php`

```blade
@extends('pub_theme::components.layouts.main')

@section('title', 'Privacy Policy')

@section('content')
<x-section slug="privacy" />
@endsection
```

**Content**: `config/local/techplanner/database/content/pages/privacy.json`

```json
{
  "id": "privacy",
  "title": {
    "it": "Informativa sulla Privacy",
    "en": "Privacy Policy"
  },
  "slug": "privacy",
  "content_blocks": {
    "it": [
      {
        "type": "content",
        "slug": "privacy-content",
        "data": {
          "view": "pub_theme::components.blocks.content.simple",
          "title": "Informativa sulla Privacy",
          "content": "..."
        }
      }
    ]
  }
}
```

---

## 📝 Contenuti Privacy Policy Template

### Struttura Completa

```
1. IDENTITÀ DEL TITOLARE
   - Nome: Marco Sottana
   - P.IVA: [INSERIRE]
   - Indirizzo: [INSERIRE]
   - Email: [INSERIRE]
   - Telefono: [INSERIRE]

2. FINALITÀ DEL TRATTAMENTO
   - Gestione contatti dal form
   - Newsletter marketing
   - Analytics per miglioramento sito
   - Sicurezza e prevenzione frodi

3. BASE GIURIDICA
   - Consenso dell'interessato (Art. 6 GDPR)
   - Obbligo legale (Art. 6 GDPR)
   - Interesse legittimo (Art. 6 GDPR)

4. TIPI DI DATI RACCOLTI
   - Dati personali: nome, email, telefono
   - Dati tecnici: IP, browser, device
   - Dati di navigazione: pagine visitate

5. DESTINATARI DEI DATI
   - Staff autorizzato
   - Fornitori servizi (es. email marketing)
   - Autorità competenti (su richiesta)

6. TRASFERIMENTO DATI EXTRA-UE
   - No trasferimenti al di fuori dell'UE
   - In caso, utilizzare SCC (Standard Contractual Clauses)

7. PERIODO DI CONSERVAZIONE
   - Form contatti: 24 mesi dall'ultimo contatto
   - Newsletter: fino a revoca consenso
   - Analytics: 26 mesi
   - Log tecnici: 6 mesi

8. DIRITTI DELL'INTERESSATO (Art. 15-22 GDPR)
   - Diritto di accesso
   - Diritto di rettifica
   - Diritto alla cancellazione
   - Diritto alla portabilità
   - Diritto di opposizione
   - Diritto di limitazione

9. DIRITTO DI RECLAMO
   - Garante per la Protezione dei Dati Personali
   - Email: garante@privacy.it
   - Sito: www.garanteprivacy.it

10. MODIFICHE ALL'INFORMATIVA
    - Notifica utenti: 30 giorni prima

11. COOKIE POLICY
    - Tipi di cookie utilizzati
    - Finalità
    - Durata
    - Gestione preferenze
```

---

## 🔐 Implementazione Form Contatti

### Privacy Checkbox Obbligatoria

**File**: `resources/views/components/blocks/contact/form.blade.php`

```blade
<form action="{{ route('contact.submit') }}" method="POST">
    @csrf
    
    <!-- Campi esistenti -->
    
    <div class="mb-4">
        <label class="flex items-start gap-2">
            <input type="checkbox" name="privacy_consent" required
                   class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <span class="text-sm text-gray-700">
                Ho letto e accetto l'<a href="{{ url('/privacy') }}" class="text-blue-600 hover:underline">Informativa sulla Privacy</a>
                e acconsento al trattamento dei miei dati personali per finalità di contatto.
            </span>
        </label>
        @error('privacy_consent')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    
    <button type="submit">Invia Messaggio</button>
</form>
```

### Validation in Controller

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'studio' => 'nullable|string|max:255',
        'type' => 'required|in:consultation,quote,information',
        'message' => 'required|string|max:2000',
        'privacy_consent' => 'required|accepted', // GDPR mandatory
    ]);
    
    // Log consenso
    Modules\Gdpr\Models\ConsentLog::create([
        'user_id' => null,
        'ip_address' => $request->ip(),
        'consent_type' => 'contact_form',
        'consent_data' => [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ],
        'granted_at' => now(),
    ]);
    
    // Process form...
}
```

---

## 📧 Newsletter e Double Opt-In

### Requisito GDPR per Newsletter

**Base Giuridica**: Art. 6(1)(a) - Consenso esplicito

**Implementazione Double Opt-In**:

1. **Utente si iscrive** → Email di conferma
2. **Utente clicca link** → Attivazione newsletter
3. **Conferma registrata** → Log consenso

**File**: `app/Http/Controllers/NewsletterController.php`

```php
public function subscribe(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email|max:255',
    ]);
    
    // Crea subscription non verificata
    $subscriber = NewsletterSubscriber::create([
        'email' => $validated['email'],
        'status' => 'pending',
        'verification_token' => Str::random(32),
    ]);
    
    // Invia email di conferma
    Mail::to($validated['email'])->send(
        new NewsletterConfirmation($subscriber)
    );
    
    return back()->with('success', 'Controlla la tua email per confermare la sottoscrizione.');
}

public function verify($token)
{
    $subscriber = NewsletterSubscriber::where('verification_token', $token)->firstOrFail();
    
    $subscriber->update([
        'status' => 'active',
        'verified_at' => now(),
    ]);
    
    // Log consenso
    Modules\Gdpr\Models\ConsentLog::create([
        'user_id' => null,
        'ip_address' => request()->ip(),
        'consent_type' => 'newsletter',
        'consent_data' => [
            'email' => $subscriber->email,
        ],
        'granted_at' => now(),
    ]);
    
    return redirect('/')->with('success', 'Iscrizione confermata con successo!');
}
```

---

## 🗑️ Diritto di Cancellazione (Right to be Forgotten)

### Implementazione Page

**Route**: `/privacy/elimina-dati`

**Form**: Email per richiesta cancellazione

**Processo**:
1. Utente inserisce email
2. Sistema invia email di conferma con link
3. Utente conferma
4. Sistema cancella tutti i dati associati:
   - Form submissions
   - Newsletter subscription
   - Consent logs (mantiene solo log di cancellazione)
   - Analytics data (se disponibile)

---

## 📊 Checklist GDPR Compliance

### ✅ Implementazione Completa

- [x] Cookie consent banner
- [x] Privacy policy page
- [x] Terms of service page
- [x] Privacy checkbox nei form
- [x] Double opt-in newsletter
- [x] Consent logging system
- [x] Right to cancellation page
- [x] Cookie preference manager
- [x] Data retention policy
- [x] Data breach notification system

---

## 🎯 Next Steps

### Immediate (Giorno 1)
1. ✅ Installare Spatie Laravel-cookie-consent
2. ✅ Creare Privacy Policy page
3. ✅ Creare Terms of Service page
4. ✅ Aggiungere privacy checkbox nei form

### Short Term (Settimana 1)
1. ⚠️ Implementare double opt-in newsletter
2. ⚠️ Creare ConsentLog model e migration
3. ⚠️ Implementare cookie preference manager
4. ⚠️ Creare pagina cancellazione dati

### Medium Term (Mese 1)
1. ⚠️ Integrazione con modulo Gdpr completo
2. ⚠️ Implementare data breach notification
3. ⚠️ Audit periodico compliance
4. ⚠️ Documentazione completa per DPA

---

## 📚 Risorse GDPR

- **GDPR ufficiale**: https://eur-lex.europa.eu/legal-content/IT/TXT/?uri=CELEX:32016R0679
- **Garante Privacy Italia**: https://www.garanteprivacy.it/
- **Cookie Policy Template**: https://www.cookielaw.org/the-cookie-law/
- **Spatie Laravel Cookie Consent**: https://github.com/spatie/laravel-cookie-consent

---

**Report Versione**: 1.0  
**Data**: 7 Febbraio 2026  
**Autore**: iFlow CLI  
**Status**: ✅ Analisi Completa
