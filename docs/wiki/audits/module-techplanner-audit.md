---
title: "Audit modulo TechPlanner"
type: audit
module: TechPlanner
status: verified-with-open-items
created: 2026-10-29
updated: 2026-10-29
tags: [audit, techplanner, sicurezza, qualita]
qmd: "techplanner module audit domain filament security quality"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ../index.md
---

# Audit modulo TechPlanner (2026-10-29)

Sola lettura sul codice. Unico file scritto: questo. PHPStan eseguito sul modulo: `[OK] No errors`. Pest non eseguito (DB di test assente, vincolo del brief).

## 1. Sintesi e scorecard

TechPlanner e' un back-office Filament per clienti, apparecchi radiologici e verifiche periodiche, con l'import da un vecchio database Access. Il codice e' pulito per i tipi (0 errori PHPStan, 0 `@phpstan-ignore`, `strict_types` in 189/189 file) ma **non e' coerente col dominio**. Modelli, migrazioni e form descrivono schemi diversi per MedicalDirector, LegalRepresentative, LegalOffice e DeviceVerification: i dati inseriti dalla UI vengono scartati in silenzio. Le regole di business richieste (conflitti di appuntamento, assegnazione tecnici, fusi orari, scadenze di manutenzione) **non esistono nel codice**: l'appuntamento ha solo `client_id`, `date`, `notes`. Non c'e' nessuna Policy: chiunque entri nel pannello puo' fare tutto, comprese cancellazioni definitive a cascata. I test reali sono 5 asserzioni tautologiche.

| Area | Voto | Motivo (una riga) |
|---|---|---|
| Architettura/convenzioni | D | `BaseModel` estende `Eloquent\Model` (non `XotBaseModel`); 4 modelli senza base e su connessione diversa; Device/Machine sulla stessa tabella; 2 migrazioni `profiles`; resti `.o` tracciati |
| Correttezza | D | 4 entita' di compliance con fillable/form/schema in conflitto; relation manager su relazione inesistente; filtro con `created_at` che non filtra; ricerca su colonna inesistente |
| Sicurezza | D | Nessuna Policy (Filament consente tutto), nessun ruolo interno, nessun tenant, hard delete a cascata; PII dei clienti senza controlli. Nessuna injection trovata |
| Test | E | 1 file reale (5 test su una classe anonima), 2 file `.obsolete` di un altro dominio; 0 test su flussi di business |
| PHPStan/tipi | A | 0 errori, 0 ignore, 6 `mixed` tutti difendibili |
| UI/UX/a11y | C | Mobile gestito da Xot (`stackedOnMobile`) e dalla passata in corso; chiavi i18n con namespace sbagliato mostrate grezze; stringhe hardcoded; input senza label |
| Performance | C | Eager loading automatico di Filament ok; accessor con 4 query per chiamata; geocoding sincrono su tutti i clienti nella request |
| Docs | D | 67/94 `.md` senza frontmatter, 58/236 link rotti, README e `api-reference.md` descrivono funzioni e campi che non esistono |
| Ridondanza | D | 3 relation manager per le verifiche, 2 implementazioni del geocoding, 2 view mappa, `MailTemplateResource` copiato da un altro progetto |

## 2. Scopo e mappa

**Cosa fa.** Pannello `techplanner::admin` (percorso `techplanner/admin`, generato da `XotBasePanelProvider.php:87-88`). Entita' (`app/Models`, 15 classi): Client (hub, 421 righe), Device (tabella `machines`) e Machine (sottoclasse, stessa tabella), DeviceVerification, Appointment, PhoneCall, LegalOffice, LegalRepresentative, MedicalDirector, Profile. Residui senza UI: Worker, Event, Location, Participant.

**Dipendenze** (verificate dagli `use`): Xot (resource/tabelle/form/migrazioni base), Geo (`GeoTrait`, `HasAddress`, `AddressItemEnum`, azioni coordinate), Notify (`ContactColumn`, `SendRecordsNotificationBulkAction`, `MailTemplateResource`), Lang (`LangBasePanelProvider`), User (`BaseProfile`). `composer.json` ha `require: {}`: le dipendenze non sono dichiarate. Nessun altro modulo usa TechPlanner (verificato con grep): e' una foglia.

**Punti d'ingresso.**
- Pannello Filament con 8 resource (Appointment, Client, Device, LegalOffice, LegalRepresentative, MailTemplate, MedicalDirector, PhoneCall). Le pagine, le tabelle e i form sono risolti per convenzione da `XotBaseResource`.
- Widget: `ClientMapWidget` e `CoordinatesWidget` sono registrati in `config/filament.php`; `MapWidget` e' uno stub.
- Comandi: `techplanner:clients-update-coordinates`, `techplanner:import-access-data` (non scrive nulla), `techplanner:analyze-mdb` (rotto, vedi TPL-021).
- Import Filament: Client, Device, MedicalDirector.
- Rotte: `routes/web.php` e `routes/api.php` vuote. Nessun controller, nessuna API.
- Connessione DB: `tech_planner` (`BaseModel.php:66`), registrata a runtime. Non e' in nessun file di config: `artisan config:show database.connections` la mostra come `mysql`, database `techplanner_data`, `strict=false`. Dove venga creata non l'ho individuato.

**Dimensioni.** 189 file PHP, 11.225 righe, 9 Blade, 2 JS, 94 `.md`. Il repository del modulo ha 18 commit; l'ultimo e' `1ec0b1b` del 2026-10-28.

## 3. Metriche

Dal JSON (`metrics/module-TechPlanner.json`) e dalle mie misure.

| Metrica | Valore | Note |
|---|---|---|
| `@phpstan-ignore` | 0 | verificato con grep su `app database tests` |
| `mixed` dichiarati | 6 | Worker (4), MailTemplateForm (2) |
| TODO | 1 | `Worker.php:246` |
| Funzioni pericolose | 2 | `shell_exec` in `ImportAccessDataCommand.php:36,61`: **falso positivo**, argomento con `escapeshellarg()` |
| SQL raw | 1 | `ListMedicalDirectors.php:25`, `selectRaw('DATE(created_at)')` senza input: sicuro |
| `{!!` | 1 | `resources/views/index.blade.php`: stampa `config('techplanner.name')`, costante; innocuo. La vista e' boilerplate "Hello World" |
| Inline style | 2 | `height: 400px` nelle viste mappa |
| `$guarded=[]`, segreti, marker di conflitto, `RefreshDatabase`, test skippati, debug | 0 | |
| File > 800 righe | 0 | il massimo e' `Client.php` con 421 righe |
| Test | 3 file: 1 reale (`tests/Unit/Models/BaseModelTest.php`, 5 test), 2 `.obsolete` | rapporto test/PHP circa 0,5% |
| Modelli senza factory / senza migrazione dedicata | Appointment, Machine / Location, Participant | Worker ha tabella `workers` ma nessuna factory |
| Lang | it 16 file, en 10, de 10, fr 1, es 1 | foglie it: 991, di cui 407 segnaposto con valore uguale alla chiave (41%); en e de: 153/603 (25%) |
| Docs | 94 `.md`; 67 senza frontmatter; 3 nomi fuori convenzione piu' le due storie `2026-10-06-*`; 58 link rotti su 236 (contati da me su tutta `docs/`) | |
| Stato git | 10 file modificati e 1 untracked, tutti di un'altra sessione | vedi sotto |

**Modifiche non committate di altre sessioni** (non toccate). Sono la passata "mobile UX" (`docs/stories/mobile-ux-pass.story.md`, untracked) su 7 tabelle/form, piu' `lang/en/device.php` e i due indici docs. Stato attuale: coerente e innocuo.
- Colonne `id`, `created_at`, `updated_at` nascoste di default (`toggleable`), colonne secondarie con `visibleFrom('md')`, `autocomplete(false)` sulle matricole, `duration` come `integer()->minValue(0)`.
- `DevicesTable.php:22-25` passa dal `client_id` grezzo a `client.company_name`: miglioramento reale. Filament carica la relazione da solo (`vendor/filament/tables/src/Concerns/HasRecords.php:66`), quindi non c'e' N+1.
- La chiave `techplanner::device.fields.client_id.label` e' stata aggiunta in `it` e `en`, ma **manca in `de`** (verificato): in tedesco compare la chiave grezza.
- Non risolve nulla di quanto sotto (campi inesistenti, `LegalOfficesTable` che cerca su `country`, nessun cliente nel form appuntamento).

## 4. Findings

Gli ID seguono l'ordine di gravita' (poi per area).

| ID | Sev | Conf | Area | file:riga | Evidenza | Impatto | Correzione proposta | Sforzo |
|---|---|---|---|---|---|---|---|---|
| TPL-001 | CRITICAL | alta (codice) / media (DB reale non letto) | Correttezza/dati | `MedicalDirector.php:52`, `LegalRepresentative.php:54`, `LegalOffice.php:58`, `DeviceVerification.php:54` vs `MedicalDirectorForm.php:21-32`, `LegalRepresentativeForm.php:19-27`, `LegalOfficeForm.php:19-31`, `ClientResource/RelationManagers/{MedicalDirectors,LegalRepresentatives,LegalOffices}RelationManager.php`, `DeviceResource/RelationManagers/DeviceVerificationsRelationManager.php:31-39` | **MedicalDirector**: la migrazione ha `client_id,name,fiscal_code,phone,email,notes`; il fillable ha `last_name,first_name,residence,birth_date,...` (schema Access); il form standalone ha `license_number,specialization,license_expiry`; il relation manager ha `appointment_date,expiry_date,is_active`. Quattro schemi diversi. **LegalRepresentative**: migrazione `name,fiscal_code,phone,email,notes`; fillable `name,identification_number,phone,email`; form `surname,tax_code,role`; relation manager `first_name,last_name,mobile,is_inactive`. **LegalOffice**: la migrazione non ha `country`, il fillable (name,address,phone,email) non ha `city/postal_code/province`. **DeviceVerification**: il fillable e' solo `device_id,verification_date,status`; la migrazione richiede `next_verification_date,result,exposure_parameters,verification_type` (NOT NULL); il form manda `verification_result,verifier_name,verifier_company`. Nessun `preventSilentlyDiscardingAttributes` nel repo (grep) | Filament crea il record con `new Model($data)`: gli attributi non fillable sono **scartati senza errore**. L'utente vede "salvato" ma restano solo i campi coincidenti; le colonne NOT NULL restano vuote (connessione `strict=false`: nessun errore). Riguarda le entita' di compliance (direttore sanitario, rappresentante legale) e la data della prossima verifica. Gli import `MedicalDirectorImporter` (colonne Access) scrivono su colonne che non esistono | Decidere lo schema per entita' (una sola fonte) e allinearlo: migrazione, fillable, form, tabella, relation manager, factory. Aggiungere un test "contratto" per modello: campi form ⊆ fillable ⊆ colonne (sqlite). Abilitare `Model::preventSilentlyDiscardingAttributes()` fuori produzione | L |
| TPL-002 | HIGH | alta | Sicurezza | `app/` (nessuna `Policies/`), `config/config.php:21-26`, `XotBasePanelProvider.php:84-86`, `BaseUser.php:327-338` | 0 Policy per 14 modelli (`audit-policy-inventory`: "Senza cartella Policies/: AI, Employee, TechPlanner"). Senza Policy Filament **consente** l'azione (`vendor/filament/filament/src/helpers.php:60-64`; il commento in `HasXotTable.php` sulle bulk lo conferma). `config('techplanner.permissions')` (`techplanner.manage/create/edit/delete`) non e' letto da nessuno (grep). `->tenant()` e' commentato nel provider. L'unico controllo e' `canAccessPanel`: il ruolo `techplanner::admin` | Ogni utente con quel ruolo legge e modifica tutti i clienti (telefono, email, PEC, WhatsApp, codice fiscale, dati anagrafici dei direttori), li esporta e li cancella. Nessuna distinzione fra tecnico e amministrativo, nessun perimetro per tenant. Non sfruttabile da anonimi | Una `*Policy` per modello (con `XotBasePolicy`) che legga i permessi gia' previsti in config; ruoli `tecnico`/`amministrativo`; abilitare `Filament::strictAuthorization()` in ambiente di test | M |
| TPL-003 | HIGH | alta | Dati | `BaseModel.php:16-18`, `2024_12_26_230220_create_*_table.php:17`, `2024_12_26_230221_create_legal_offices_table.php:17`, `Updater.php` (Xot) ~96-105 | Le migrazioni creano `deleted_at/deleted_by` (`updateTimestamps(hasSoftDeletes: true)`), ma nessun modello usa `SoftDeletes` (`BaseModel` = `Eloquent\Model` + `Updater`). Le FK `client_id` di legal_representatives, medical_directors e legal_offices hanno `cascadeOnDelete()`. L'azione `DeleteAction` e' di default su ogni riga (`HasXotTable.php` ~362) | Cancellare un cliente elimina **in modo irreversibile** rappresentanti legali, direttori sanitari e sedi legali collegati; le colonne soft-delete restano inutilizzate. `deleted_by` non viene mai persistito (il trait imposta l'attributo ma non salva) | `SoftDeletes` su `BaseModel` (o su `XotBaseModel`) e `TrashedFilter`/`RestoreAction`; policy `delete` ristretta; sostituire `cascadeOnDelete` con `restrictOnDelete` per i dati di compliance | M |
| TPL-004 | HIGH | media-alta (non verificato a runtime) | Correttezza | `DeviceResource/RelationManagers/DeviceVerificationsRelationManager.php:22`, `Device.php:131`, `XotBaseResource.php:365-401` | Il relation manager dichiara `$relationship = 'deviceVerifications'`; `Device` ha solo `verifications()`. `XotBaseResource::getRelations()` carica per glob tutti i `*RelationManager.php` della cartella, quindi questo e' montato sulle pagine view/edit di Device | Aprire un apparecchio probabilmente solleva `BadMethodCallException`: le verifiche (cuore regolatorio) non sono consultabili. Esistono altri due relation manager sulle verifiche non collegati a nulla: `RelationManagers/VerificheRelationManager.php` (relazione `verifiche`, colonne `data_verifica/esito/note`) e `Resources/RelationManagers/DeviceVerificationsRelationManager.php` (campo `title`) | Tenere un solo manager con relazione `verifications` e i campi veri (vedi TPL-001); cancellare gli altri due; aggiungere `DeviceVerification::device()`; test Livewire di apertura view/edit | S |
| TPL-005 | HIGH | alta | Funzionalita' | `2019_12_12_000005_create_appointments_table.php:23-25`, `Appointment.php:49-53`, `Client.php:167`, `Worker.php:141` | Le regole di business richieste **non ci sono**. Appuntamento = `client_id`, `date` (datetime senza cast), `notes`: niente stato, durata/fine, tecnico, luogo, fuso. Nessun controllo di sovrapposizione, nessuna assegnazione. `Worker` non ha resource ne' relazioni (`Worker::devices()` usa un FK `worker_id` che non esiste su `machines`). `Client::$fillable` contiene `assigned_worker_id` e `administrative_reference`, senza colonna in nessuna migrazione. Il README dichiara "status tracking", "worker assignment", "workload distribution" | Doppie prenotazioni non rilevabili; nessuna pianificazione dei tecnici. Il modulo si chiama TechPlanner ma e' un'anagrafica | Decidere il modello: `appointments` con `starts_at/ends_at` (datetime UTC), `status` (enum backed), `technician_id`; vincolo/regola di non sovrapposizione per tecnico; viste calendario. Prima di tutto correggere il README | L |
| TPL-006 | HIGH | alta | Business/performance | `Device.php:139-161`, nessun scheduler (grep `Schedule::`/`->schedule(` = 0) | `needs_verification` non e' usato da UI, job o notifica (grep). La logica ha tre difetti: (1) `getLatestVerificationAttribute` esegue due volte `->latest()->first()` (2 query) e `needs_verification` legge l'accessor due volte (4 query per chiamata, 0 cache); (2) `latest()` ordina per `created_at`, non per `verification_date`: un inserimento retroattivo diventa "ultimo"; (3) confronta una stringa data con `now()` (nessun cast su `next_verification_date`) | Nessun avviso di scadenza delle verifiche periodiche (obbligo di legge nel dominio). Se usato in lista, N+1 pesante | Cast `date` su `DeviceVerification`; relazione `latestOfMany('verification_date')`; scope `scopeDueWithin()`; comando schedulato + notifica; colonna/filtro "da verificare" | M |
| TPL-007 | HIGH | alta | Test | `tests/Unit/Models/BaseModelTest.php:19-41`, `tests/Feature/ProjectManagementTest.php.obsolete{,2}` | Un solo file reale, con 5 test su una classe anonima che estende `BaseModel` ("estende Model", "ha timestamps"). I due `.obsolete` testano un dominio "Project" (`createProject`, `toBeProject`) che qui non esiste. `tests/Pest.php` contiene solo commenti. Nessun test su Resource, azioni, importer, comandi, widget, policy | Qualsiasi regressione di business passa inosservata; quelle di TPL-001/004 non sarebbero state viste | Vedi la lista dei 10 test prioritari sotto | M |
| TPL-008 | HIGH | alta | Correttezza | `LegalOfficesTable.php:24` vs `2024_12_26_230221_create_legal_offices_table.php` | La tabella ha `country` con `->searchable()`; la colonna non esiste nella migrazione (grep: nessun `country` in quel file). Filament costruisce `WHERE (name LIKE ... OR country LIKE ...)` per la ricerca | Qualsiasi ricerca nell'elenco sedi legali restituisce "Unknown column 'country'" (500) | Togliere `country` (o aggiungerlo alla migrazione dopo la decisione di TPL-001) | S |
| TPL-009 | MEDIUM | alta | Architettura | `BaseModel.php:16,66`; `Appointment.php:47`, `Event.php:34`, `Participant.php:20`, `Location.php:61` | `BaseModel` estende direttamente `Eloquent\Model`, non `XotBaseModel` (manca `HasXotFactory`, `RelationX`). Quattro modelli estendono `Model` e finiscono sulla connessione di default, mentre gli altri sono su `tech_planner` (audit `audit-eloquent-basemodel-hierarchy`: FAIL, 4 violazioni). `Appointment::machines()` collega a `Machine` (`tech_planner`) attraverso connessioni diverse | In ambienti dove `tech_planner` e `default` non puntano allo stesso database, appuntamenti e anagrafica stanno in posti diversi e la FK `machines.appointment_id` non e' valida. Oggi coincidono (`techplanner_data`) e questo ne nasconde l'effetto | `BaseModel extends XotBaseModel`; `Appointment` su `BaseModel`. Rimuovere o archiviare Event/Location/Participant | M |
| TPL-010 | MEDIUM | alta | Migrazioni | `2019_12_12_000012_create_machines_table.php:18,30-32`, `2024_12_26_000001_create_device_table.php` (stessa tabella), `Device.php:102-114` | `Machine` e `Device` risolvono entrambi la tabella `machines`. La migrazione 2019 la crea con `appointment_id` **NOT NULL con FK** a `appointments`. `Device::$fillable` non ha `appointment_id` e `DeviceForm` non lo imposta. Il blocco UPDATE aggiunge `appointment_id` nullable solo se manca | Su DB nuovo, creare un apparecchio da UI fallisce (FK) oppure, con `strict=false`, scrive `appointment_id=0` e rompe la FK. In produzione la tabella e' quella importata da Access, quindi il rischio e' sulle installazioni da zero [schema reale non letto] | Una migrazione per modello: rendere `appointment_id` nullable o toglierlo; unificare Device/Machine (Machine e' un alias) | M |
| TPL-011 | MEDIUM | alta | Migrazioni | `2019_12_12_000005_create_appointments_table.php:37-45`, `2024_12_26_000001_create_device_table.php:35-45`, `2024_12_26_000000_create_phone_call_table.php:33-43`, `2026_02_22_000000_create_profiles_table.php:76-123` | Le FK `client_id` di appointments, machines e phone_calls sono create solo `if hasTable('clients')`, ma `clients` nasce piu' tardi (`2024_12_26_000008`): su DB nuovo la FK **non viene mai creata**. Il `try/catch` attorno a `$table->foreign()` e' inefficace (Blueprint registra il comando, l'eccezione arriva dopo). Due migrazioni `create_profiles_table` (2024 e 2026); quella del 2026 e' una classe con nome (`CreateProfilesTable`) e, se `id` e' UUID, copia, **droppa e rinomina** la tabella senza transazione | Orfani possibili su appuntamenti/apparecchi/chiamate; una migrazione fallita a meta' sulla tabella profili puo' perdere dati (DDL MySQL non transazionale) | Una sola migrazione `profiles`; FK in una migrazione successiva a `clients`; togliere il `try/catch` finto; rendere reversibile la conversione UUID | M |
| TPL-012 | MEDIUM | alta | i18n/UI | `ListClients.php:91-93`, `ClientInfolist.php:20,28,40`, `lang/it/client.php:116-123`, `lang/it/client_infolist.php:7-16` | 6 chiamate `trans('tech_planner::...')`: il namespace registrato e' `techplanner` (`XotBaseServiceProvider.php:107`; tutte le altre chiamate usano `techplanner::`). Le chiavi compaiono **grezze** (titoli delle sezioni dell'infolist, testo del modale "Aggiorna coordinate"). Il salvataggio automatico delle traduzioni ha scritto nei file lang array con chiavi letterali `'tech_planner::client' => [...]` | UI incomprensibile in 2 schermate; file lang inquinati | Sostituire con `techplanner::`; ripulire i due file lang | S |
| TPL-013 | MEDIUM | alta | i18n/UI | `Client.php:278,288,323`; `ListClients.php:138,143-160,198-226`; `CoordinatesWidget.php:56-60`; `DeviceInfolist.php:20-38`; `ClientImporter.php:52`, `DeviceImporter.php:46`, `MedicalDirectorImporter.php:47`; `coordinates-widget.blade.php` | Testo UI hardcoded in italiano e inglese ("Chiama:", "Nessun contatto", "Coordinates Updated Successfully", "Device Information", "Your client import has completed" copiato anche negli importer di Device e MedicalDirector). 41% delle foglie `it` sono segnaposto uguali alla chiave; `lang/it/.php` e' un file chiamato `.php`; esiste `resources/lang/it/` duplicato; fr/es hanno 1 file | Inglese/italiano mescolati; impossibile tradurre; in tedesco e francese quasi tutto manca | Spostare in `lang/`; eliminare `resources/lang` e `lang/it/.php`; non generare segnaposto | M |
| TPL-014 | MEDIUM | alta | Correttezza | `AppointmentForm.php:20-21`, `PhoneCallForm.php:23-27`, `PhoneCallsTable.php:19-22`, `AppointmentsTable.php:22` | Dal resource "root" un appuntamento o una chiamata si crea **senza cliente** (`client_id` e' nullable e il form non lo chiede). La lista chiamate non mostra nemmeno il cliente. La lista appuntamenti mostra `client.name`, che e' il "Location name" di `AddressItemEnum` (di norma vuoto): il resto del modulo usa `company_name` (`DevicesTable.php:23`) | Record orfani invisibili; colonna cliente vuota | `Select::make('client_id')->relationship('client','company_name')->required()` nei form; colonna `client.company_name`; test | S |
| TPL-015 | MEDIUM | media-alta | Correttezza | `ListMedicalDirectors.php:23-37` | `SelectFilter::make('created_at')` con opzioni `DATE(created_at)`: Filament filtra con `created_at = '2026-10-29'`, che in MySQL corrisponde solo alla mezzanotte esatta. Le date si ricalcolano a ogni apertura (nessuna cache) | Il filtro quasi mai trova record | `Filter::make('created_at')` con `DatePicker` e `whereDate`, oppure togliere il filtro | S |
| TPL-016 | MEDIUM | alta | Performance | `ListClients.php:107-141`, `UpdateAllClientCoordinatesAction.php:23-39`, `UpdateClientCoordinatesCommand.php` | Tre implementazioni dello stesso lavoro. Quella della UI geocodifica **tutti** i clienti senza coordinate dentro la request web (chiamate HTTP esterne in cascata) e usa `chunk(50)` su un insieme che cambia mentre lo scorre (le righe aggiornate escono dal filtro: `chunk` salta record; serve `chunkById`). La Action queueable carica tutto con `->get()` e usa un'altra Action Geo (`GetCoordinatesAction`) di quella della UI (`UpdateCoordinatesFromAddressAction`) | Timeout, coordinate mancanti a caso, codice triplicato | Una sola Action queueable con `chunkById` e rate limit; la UI la accoda; il comando la richiama | M |
| TPL-017 | MEDIUM | media | Correttezza/UX | `CoordinatesWidget.php:50-54`, `ListClients.php:232-243` | L'evento `sort-by-distance` e' indirizzato con `->to('filament.techplanner::admin.resources.clients.index')`: e' un nome di rotta, non di componente Livewire. `applySort('distance')` fa solo `resetTable()`. Il messaggio di successo ("La tabella e' stata ordinata") non e' garantito. Le coordinate dell'ultimo cliente cliccato restano in sessione e in cookie per 30 giorni (`ListClients.php:207-212`, `CoordinatesWidget.php:44-45`); `latitude/longitude` sono proprieta' Livewire pubbliche senza validazione | Ordinamento per distanza non affidabile; posizione di un'attivita' in cookie di lunga durata | Evento senza `->to()` e ascoltato dal componente; validare `numeric|between`; non usare cookie | S |
| TPL-018 | MEDIUM | alta | Correttezza | `GeoTrait.php:81` (Geo), `ClientsTable.php:21-24` | La distanza usa il raggio in km (6371) moltiplicato per 1,1515 (fattore da miglia nautiche a miglia), ma l'etichetta e' "km": valori gonfiati di circa il 15%. La colonna `distance` e' sempre visibile e, senza coordinate impostate, mostra "0.00 km" per tutti (`formatStateUsing` trasforma `null` in 0) | Distanze sbagliate per pianificare le trasferte; "0.00 km" ovunque finche' non si imposta un punto | Togliere 1,1515; nascondere la colonna quando `distance` e' null | S |
| TPL-019 | MEDIUM | alta | Architettura | `MailTemplateResource.php:11,15-18,39-52` | Copia di un altro progetto: docblock su "Progressioni", `use Modules\Progressioni\...` (modulo inesistente), `where('slug','like','%')` che mostra **tutti** i template del sistema. `MailTemplateForm`/`MailTemplatesTable` ricalcano quelle di Notify | Un utente TechPlanner modifica template di altri moduli; codice morto | Filtro `slug like 'techplanner-%'` o usare direttamente la resource Notify; rimuovere la copia | S |
| TPL-020 | MEDIUM | alta | Importer | `ClientImporter.php:46`, `DeviceImporter.php:40`, `MedicalDirectorImporter.php:41`, `Client.php:154` | `resolveRecord()` restituisce sempre un nuovo record: reimportare lo stesso file **duplica** tutto. Nessuna regola di validazione, nessuna chiave naturale (`vat_number`). `id` e' importato ma non e' nel fillable di Client: scartato. `ImportAccessDataCommand` legge e non scrive nulla ma esce con codice 0 (`:87-89`, con warning) | Duplicati; import non verificabile | `firstOrNew` per `vat_number`/`id`, `rules()`, transazione; far fallire il comando finche' non e' implementato | M |
| TPL-021 | MEDIUM | alta | Comandi | `AnalyzeMdbCommand.php:21,31-33` | Percorso di default hardcoded `/mnt/nas02/var/www/_bases/Sottana.com/Sorvegli01.mdb` (nome di un database cliente) e `module_path('TechPlanner','scripts')`: la cartella `scripts/` **non esiste** nel modulo, quindi `chmod` lancia eccezione. Cambia i permessi di file del repository a runtime | Comando inutilizzabile; dato interno nel sorgente | Rimuovere il default; verificare l'esistenza; non fare `chmod` | S |
| TPL-022 | MEDIUM | alta | Validazione | `CompanyItemEnum.php:86-100`, `ClientForm.php`, `config/local/techplanner/database.php:20,57` | Il form cliente rende obbligatoria solo `company_name`. Nessuna `maxLength` (colonne `varchar(255)`), nessun formato per P.IVA (11 cifre) e codice fiscale (16 caratteri), nessun `unique` su `vat_number`. La connessione e' `strict=false`: troncamenti silenziosi invece di errori. `DeviceForm`: `kv/ma` numerici senza min/max su `decimal(5,2)` | Dati sporchi in anagrafica e duplicati | Regole per campo nell'enum, `unique(ignoreRecord)` su P.IVA, `strict=true` | M |
| TPL-023 | MEDIUM | media | Sicurezza/GDPR | `ListClients.php:103`, `ClientMapWidget.php:35-41`, `docs/gdpr-compliance-analysis.md` | `SendRecordsNotificationBulkAction` invia comunicazioni ai clienti senza verifica di consenso (il modulo Gdpr esiste ma non e' integrato). `ClientMapWidget` espone fino a 500 clienti (coordinate e nome) a qualunque utente del pannello. La documentazione GDPR parla del "sito web", non di questo trattamento | Rischio di non conformita' sui dati dei clienti | Integrare Gdpr (consensi, esportazione, cancellazione), limitare il widget per ruolo | M |
| TPL-024 | MEDIUM | media | Audit trail | `Updater.php` (Xot) 76-86 | `creating` imposta `created_by` solo se la chiave e' gia' fra gli attributi: su un modello nuovo non lo e', quindi `created_by` non viene mai valorizzato (`updated_by` si, perche' il modello e' caricato dal DB). Problema condiviso con altri moduli | Impossibile sapere chi ha creato un cliente/apparecchio | Correggere nel trait (Xot) e aggiungere un test | S |
| TPL-025 | LOW | alta | Codice morto | `Worker.php:141-273`, `Event.php`, `Location.php`, `Participant.php`, `Transformers/*`, `Resources/*.o` (4 file tracciati), `Resources/Pages/*` (4), `Resources/RelationManagers/*`, `MapWidget.php`, `views/filament/widgets/client-map.blade.php`, `views/widgets/coordinates-widget.blade.php` (identica alla versione in `filament/`), `resources/Resources/views` (R maiuscola), `Machine.php` | Worker non ha UI; `scopeOfJobRoleId` restituisce "tutti" (`:246`); `setBirthDayAttribute` ingoia ogni eccezione (`:203`); `getCodFiscAttribute` altera la visualizzazione del codice fiscale. Event ha 3 schemi (migrazione `name,start_at,end_at`; fillable `title,start_date,end_date`; Transformer `title`). Location e Participant non hanno tabella. `MapWidget` passa `locations` a una vista che legge `$clients`. `client-map.blade.php` usa la chiave `services.google.maps_key` (l'altra vista `maps_api_key`) ed e' inutilizzata. `Machine::verifications()` cercherebbe `machine_id` | ~15 file senza funzione, confusione sul dominio | Cancellare (git conserva la storia) dopo conferma del proprietario | S |
| TPL-026 | LOW | alta | Client/UI | `Client.php:172-192, 268-420` | Il modello contiene 150 righe di HTML/SVG (`getContactsHtmlAttribute`) che duplicano `ContactColumn` di Notify. `getFullAddressAttribute` sovrascrive quello di `HasAddress` e usa `city/province` (legacy) mentre il form scrive `locality/administrative_area_level_2`: stringa tipo "Via X, 12 - 35100, ()". L'escaping dell'HTML e' corretto (`htmlspecialchars`) | Duplicazione; indirizzi incompleti | Eliminare l'accessor HTML; usare quello del trait | S |
| TPL-027 | LOW | alta | A11y | `coordinates-widget.blade.php`, `map.blade.php:14-23` | Gli input latitudine/longitudine hanno solo `placeholder`, nessuna `label`/`aria-label`. Nella mappa `title: '{{ $client['name'] }}'` e' escapato per HTML ma non per JS (un ritorno a capo rompe lo script): usare `@js()`. Chiave Google Maps nel frontend: va ristretta per referrer | Utenti con screen reader; script fragile | `<label>`/`aria-label`, `@js()` | S |
| TPL-028 | LOW | alta | Config | `composer.json`, `.gitmodules`, `.github/`, root | `require: {}` e nome `laraxot/module_techplanner_fila3`; `.gitmodules` punta al submodule `doc_activity` (commentato); 2 file `.code-workspace` (audit `module-workspaces`); `.github/` ha `CONTRIBUTING.md`/`contributing.md` e `SECURITY.md`/`security.md` duplicati; manca `.github/.gitkeep` secondo l'audit radice | Disordine | Pulizia | S |
| TPL-029 | LOW | alta | Docs | vedi sez. 7 | README, `api-reference.md`, `roadmap.md` e gli indici descrivono funzioni inesistenti; 67 file senza frontmatter; 58 link rotti | Documentazione che inganna | Riscrivere README e `api-reference.md` dal codice; frontmatter | M |
| TPL-030 | LOW | media | Performance | `2024_12_26_000008_create_client_table.php` | Nessun indice su `company_name`, `vat_number`, `latitude/longitude`, `appointments.date`. `ListClients.php:56-64` mette in cache globale il filtro attivita' (1 ora) senza chiave per tenant | Trascurabile oggi; cresce con la tabella | Indici a bisogno | S |

### Percorsi critici senza test e primi 10 test da scrivere (non scritti)

Percorsi senza copertura: tutta la CRUD dei form (8 resource), importer, geocoding, `needs_verification`, accesso al pannello, cancellazioni a cascata, widget, comandi.

1. **Contratto schema per modello** (Unit, sqlite): per Client, Device, DeviceVerification, MedicalDirector, LegalRepresentative, LegalOffice, PhoneCall, Appointment verificare che `$fillable` ⊆ colonne e che ogni campo di form/relation manager ⊆ `$fillable`. Fallirebbe oggi (TPL-001).
2. **Smoke di migrazione**: `xot:build-test-sqlite --fresh`, poi verificare tabelle, colonne NOT NULL e FK `client_id` (TPL-010/011).
3. **`Device::needs_verification`**: nessuna verifica, scaduta, in scadenza oggi, futura, inserimento retroattivo (TPL-006).
4. **Relation manager Device→verifiche**: Livewire test di apertura di view/edit di Device e creazione di una verifica con tutti i campi (TPL-004).
5. **Accesso al pannello e autorizzazione**: utente senza ruolo `techplanner::admin` rifiutato; con ruolo, `viewAny/delete` per ciascuna resource (guida per TPL-002).
6. **Cancellazione cliente**: cosa succede a figli e apparecchi (documenta TPL-003).
7. **Creazione appuntamento e chiamata**: cliente obbligatorio; futura regola di non sovrapposizione per tecnico (TPL-005/014).
8. **`Client::getFullAddressAttribute` e `getContactsHtmlAttribute`**: email con `"><script>`, telefono con spazi, `wa.me`, indirizzo con campi strutturati.
9. **ListClients**: filtro `business_closed` di default, `withDistance` con coordinate non valide, ordinamento; `populateAllCoordinates` con Action Geo finta (TPL-016).
10. **ClientImporter**: mappatura delle colonne, reimport dello stesso file (duplicati), righe invalide (TPL-020); aggiungere `ListMedicalDirectors` filtro `created_at` (TPL-015).

### Modello dati ricostruito

- `clients` (hub): 12+ colonne indirizzo da `AddressItemEnum` (con alias legacy `address/city/province/region/cap`), contatti (`phone,mobile,fax,email,pec,whatsapp`), aziendali (`company_name,vat_number,fiscal_code,tax_code,activity,business_closed,competent_health_unit`), `latitude/longitude`.
- Relazioni da Client (hasMany): `devices` (FK `client_id`), `appointments`, `legalOffices`, `legalRepresentatives`, `medicalDirectors`, `phoneCalls`. Device hasMany `verifications` (`device_id` → `machines.id`). Appointment hasMany `machines` (via `appointment_id`).
- Stati: nessuna colonna di stato nei modelli attivi. `PhoneCallEnum` (`inbound/outbound`) e' un backed enum e coincide con l'enum del DB (`create_phone_call_table.php`). `Device.status` e `Machine.status` sono stringhe libere nullable. `Event.status` e `DeviceVerification.result` sono stringhe libere. Nessun `STATUS_*` costante: il punto e' positivo ma lo stato non esiste.
- Fusi orari: `app.timezone` = `Europe/Berlin` (override locale; `UTC` nel config base). Berlino e Roma hanno lo stesso offset, quindi oggi funziona; `appointments.date` non ha cast e non c'e' nessuna logica di fuso.
- Autorizzazione: vedi TPL-002. Non c'e' vincolo tenant su nessun modello.
- PII in chiaro: telefono, mobile, email, PEC, WhatsApp, indirizzo, codice fiscale (clients, legal_*, medical_directors), luogo/data di nascita (fillable di MedicalDirector). Nessun mascheramento, nessun log di dati personali trovato, nessun segreto nel codice.

### Tabelle Filament e form (esito)

| Resource | stackedOnMobile | Ricerca | Filtri | Azioni bulk | N+1 | Form |
|---|---|---|---|---|---|---|
| Client | si, da `HasXotTable.php:284` | `AddressColumn` e `ContactColumn` cercano su indirizzo e contatti, piu' `company_name/activity` | `business_closed` (default false), `activity` | coordinate + notifiche, **senza** delete | nessuno | solo `company_name` obbligatorio (TPL-022) |
| Appointment | si | `client.name` (vuoto, TPL-014) | nessun filtro per data/stato | delete bulk di default | no (eager automatico) | data obbligatoria, nessun cliente |
| Device | si | tutte le colonne | nessuno | delete bulk | no | `client_id` opzionale, nessun campo di scadenza |
| LegalOffice / LegalRepresentative / MedicalDirector / PhoneCall | si | si (TPL-008 per sedi) | MedicalDirector: filtro rotto (TPL-015) | delete bulk | no | in conflitto con lo schema (TPL-001) |

## 5. Revisione `@phpstan-ignore` e `mixed`

- **`@phpstan-ignore`: 0** nel modulo (grep su `app database tests`). PHPStan sul modulo: `[OK] No errors`.
- `mixed` (6 dichiarazioni, nessuna da correggere con urgenza):
  - `Worker.php:233` `safeStringCast(mixed $value)`: confine di cast, accettabile (il modello e' comunque codice morto, TPL-025).
  - `Worker.php:29-30`: `@property-write mixed` generati da ide-helper.
  - `MailTemplateForm.php:62,66`: `fn (mixed $record)`; si puo' tipizzare `?Model`.
  - `array<string, mixed>` in `ClientMapWidget`, `MapWidget` e nei Transformer: forme di dati, legittime.
- Gli ignore che nascondono bug stanno altrove: gli ignore di `HasXotTable.php` coprono `method.deprecated` e `argument.type` nel codice base di Xot, fuori da questa unita'.

## 6. File cancellati dal 2026-10-20

`lost/Modules-TechPlanner.txt` e' vuoto e `git log --since=2026-10-20 --diff-filter=D` nel repository del modulo non restituisce nulla. **Nessuna perdita.** I 4 file `.o` e i 2 `.obsolete` sono presenti e tracciati: sono rinominati da tempo, non cancellati di recente.

## 7. Stato degli audit precedenti nelle docs e salute docs

Nel modulo non c'e' nessun file `*audit*.md`. Fanno da audit precedenti:

| Documento | Stato | Esito |
|---|---|---|
| `code-quality-report.md` (2026-07-17) | in parte vero | "3 file di test, 0 errori PHPStan" resta vero; "114 file in app/" non e' piu' riscontrabile; raccomanda gia' i test, mai fatti |
| `code-quality-improvement-report.md` (2026-07-17) | obsoleto | "141 candidati senza strict types": oggi sono 0 (189/189) |
| `quality-analysis-report.md` ("December 2025") | obsoleto | senza frontmatter; descrive la correzione di `ListClients`, che e' rimasta con i problemi di TPL-012/016 |
| `phpstan-compliance*.md` (7 file: `phpstan-compliance`, `-status`, `-complete-fixes`, `-errors-analysis`, `-fixes-implemented`, `-level-10-compliance`, `-widget-formschema-and-pest-bridge-fixes`) + 4 storie `phpstan-cleanup-techplanner.*` (2 con prefisso data, duplicate) | ridondanti | tutti dicono "0 errori"; uno basta |
| `dry-kiss-improvements.md` (570 righe), `clean-code-violation-fix.md`, `memory-optimization-summary.md` | storici | non verificabili; i link a `../Geo/docs/...` sono rotti |

**Cinque affermazioni controllate contro il codice**

1. README: "Appointment ... Status tracking throughout appointment lifecycle": **falso**, nessuna colonna di stato (TPL-005).
2. README: "Workforce Management: worker assignment, workload distribution": **falso**, Worker non ha UI ne' relazioni.
3. README: `XotBaseModel (Model foundation)` per i modelli: **falso**, `BaseModel` estende `Eloquent\Model` (TPL-009).
4. `api-reference.md`: proprieta' `business_name`, `legal_representative_id`, `medical_director_id` e relazioni `BelongsTo`: **falso**, sono `hasMany` e le colonne non esistono; non esistono rotte API (`routes/api.php` vuoto).
5. `code-quality-improvement-report.md`: "141 senza strict types": **falso** oggi.

**Salute docs.** `README.md` (254 righe, "Ultima modifica 2025-01-23") e `index.md`/`00-index.md` esistono, ma `00-index.md` e' fermo a "13 Dicembre 2025". 67 `.md` su 94 senza frontmatter (la maggior parte sotto `docs/wiki/`, `models/`, `concepts/`). Nomi fuori convenzione: `filosofia_modulo_techplanner.md`, `filament_v4_upgrade_notes.md`, `concepts/PHILOSOPHY.md`, `wiki/**/INDEX.md`, le due storie `2026-10-06-*`. 58 link rotti su 236 (esempi: `README.md` verso `./business-logic.md`, `./api-documentation.md`, `./phpstan-complete-fixes-2025.md`). `docs-archive-2026/` e' vuota. La storia `mobile-ux-pass.story.md` (untracked) e' ben formata.

## 8. Non verificato / limiti

- **Letto davvero**: tutti i 15 modelli (Profile solo in parte), le 8 resource, i form/tabelle/infolist di 7 resource (Appointment, Client, Device, LegalOffice, LegalRepresentative, MedicalDirector, PhoneCall) e MailTemplate, i relation manager (6 letti per intero, 2 con grep), `ListClients` e `ListMedicalDirectors` per intero, i 3 widget, i 3 importer, la Action, i 3 comandi, i 4 provider, 2 enum, 11 migrazioni (le 2 di `profiles` solo in parte), 5 factory su 11, il seeder, i 3 test, 5 viste su 9, le lang (statistiche su tutte, `it/client.php` per intero). Circa 120 dei 189 file PHP; le ~25 pagine Create/Edit/View sono sottili (verificato per grep che estendono `XotBase*`).
- **Non letto**: `ProfileFactory` e le altre 5 factory, 3 Transformer su 3 (letto 1), i file `.o`, `docs/wiki/**`, `docs/models/**`, `docs/filament/**`, `gdpr-compliance-analysis.md` oltre l'intestazione, `ParticipantResource`/`LocationResource`.
- **Servirebbe per chiudere**: (a) lo schema reale del DB `techplanner_data` (`SHOW CREATE TABLE`): decide se TPL-001/010 sono bug dell'app o delle migrazioni; (b) un utente con ruolo `techplanner::admin` per aprire view/edit di Device (TPL-004), l'ordinamento per distanza (TPL-017) e il filtro direttori (TPL-015); (c) un DB di test sqlite per eseguire i test di contratto; (d) conferma del proprietario che Worker/Event/Location/Participant sono davvero dismessi; (e) l'origine della registrazione runtime della connessione `tech_planner`.
- Sono stati eseguiti `phpstan analyse Modules/TechPlanner`, `artisan config:show` (lettura della configurazione, senza accesso al DB) e script PHP/Python in sola lettura. Nessun comando ha toccato il database.
- Una mia prima ipotesi e' caduta: `x-filament::card` e `x-filament::widget` esistono in Filament 5 (`vendor/filament/support/resources/views/components/{card,widget}.blade.php`); la vista dei widget non e' rotta.

## 9. Piano di correzione priorizzato

| # | Azione | Findings | Dipende da | Sforzo |
|---|---|---|---|---|
| 1 | Leggere lo schema reale del DB e fissare uno schema per entita' (MedicalDirector, LegalRepresentative, LegalOffice, DeviceVerification); allineare migrazione, fillable, form, tabella, relation manager, factory | 001, 008, 010 | (a) | L |
| 2 | Test di contratto schema/fillable/form + smoke di migrazione su sqlite (i primi 2 test della lista) | 007, 001 | 1 | S |
| 3 | Correggere `DeviceVerificationsRelationManager` (relazione `verifications`), cancellare i due manager orfani, aggiungere `DeviceVerification::device()` e i cast | 004, 025 | 1 | S |
| 4 | Policy per modello e ruoli (tecnico/amministrativo); strict authorization in test | 002, 023 | — | M |
| 5 | `SoftDeletes` sui modelli, `restrictOnDelete` sui dati di compliance, `TrashedFilter` | 003 | 4 | M |
| 6 | Scadenze: `latestOfMany`, scope "in scadenza", comando schedulato e notifica | 006 | 3 | M |
| 7 | Pianificazione: stato/durata/tecnico su `appointments`, regola di non sovrapposizione, cliente obbligatorio nei form | 005, 014 | 1, 4 | L |
| 8 | i18n: namespace `techplanner::` ovunque, stringhe in `lang/`, pulizia dei file lang | 012, 013 | — | S |
| 9 | Geocoding: una sola Action queueable con `chunkById`; correggere la formula della distanza e la colonna `distance` | 016, 017, 018 | — | M |
| 10 | Pulizia: `BaseModel extends XotBaseModel` (e `Appointment` sulla stessa base), eliminare Worker/Event/Location/Participant/`.o`/`.obsolete`/viste duplicate, ripulire docs (frontmatter, link, README dal codice) | 009, 019, 025, 028, 029 | conferma proprietario | M |

## 10. Comandi di verifica ripetibili

```bash
cd /mnt/nas07/var/www/_bases/base_techplanner_fila5/laravel
./vendor/bin/phpstan analyse Modules/TechPlanner --memory-limit=-1 --no-progress          # [OK] No errors
grep -rnE "phpstan-ignore" Modules/TechPlanner/app Modules/TechPlanner/database Modules/TechPlanner/tests   # nessun risultato
ls Modules/TechPlanner/app/Policies 2>&1                                                    # No such file
grep -rn "tech_planner::" Modules/TechPlanner/app                                           # 6 righe (TPL-012)
grep -rn "deviceVerifications\|function verifications" Modules/TechPlanner/app              # TPL-004
grep -n "country" Modules/TechPlanner/database/migrations/2024_12_26_230221_create_legal_offices_table.php   # vuoto (TPL-008)
grep -n "fillable" -A8 Modules/TechPlanner/app/Models/MedicalDirector.php                  # TPL-001
sed -n 36,50p Modules/TechPlanner/app/Filament/Resources/DeviceResource/RelationManagers/DeviceVerificationsRelationManager.php
php artisan config:show database.connections.tech_planner                                    # driver mysql, strict false
php artisan config:show app.timezone                                                          # Europe/Berlin
grep -n "1.1515" Modules/Geo/app/Models/Traits/GeoTrait.php                                  # TPL-018
git -C Modules/TechPlanner log --since=2026-10-20 --diff-filter=D --name-only                # vuoto (sez. 6)
git -C Modules/TechPlanner ls-files | grep -E '\.(o|obsolete|obsolete2)$'                    # 6 file
python3 -I - <<'EOF'   # frontmatter mancanti: 67 su 94
import glob; print(sum(1 for f in glob.glob('Modules/TechPlanner/docs/**/*.md', recursive=True) if not open(f,encoding='utf8').readline().startswith('---')))
EOF
```
