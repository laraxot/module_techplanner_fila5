---
title: "Audit completo codebase — 2026-10-12"
type: audit
status: in-progress
---

# Audit completo — Findings e fix applicati

Audit parallelo a 4 agenti (domain code, Filament/UI, tests+docs, code quality) + verifiche dirette.

## Fix applicati in questa sessione

### Critici

| # | Problema | Fix |
|---|---|---|
| C2 | `DeviceVerificationsRelationManager`: `$relationship='deviceVerifications'` inesistente → crash `BadMethodCall` su view/edit device; campi form non corrispondenti allo schema (`verification_result`, `verifier_name`, `verifier_company` non sono colonne) | `relationship='verifications'`; form allineato alle colonne reali (`verification_date`, `next_verification_date`, `result`, `exposure_parameters`, `verification_type`, `notes`); `DeviceVerification::$fillable` corretto (era `status`, inesistente); aggiunta relazione `device()`; eliminati 2 RM morti (`Resources/RelationManagers/...` con campo `title`, `Filament/RelationManagers/VerificheRelationManager` con colonne italiane) e import morto in `DeviceResource` |
| UX3 | `ControlForm`: `control_date` ritornava `Carbon` dove Filament attende stringa → TypeError | formattazione esplicita `d/m/Y H:i` |
| — | Popup mappa "usa come origine": errore dead-end su cliente senza coordinate | fallback `UpdateCoordinatesFromAddressAction` (geocoding automatico) + refresh + warning se fallisce; label tradotta su icona bottone |

### Alti (code quality agent)

- **`Modules/Lang/composer.json`**: chiavi JSON duplicate + homepage `fila3` stale — da fixare.
- **`Notify/.../NotificationTrackingController.php`**: controller orfano contro regola esplicita del modulo + `redirect()->away($url)` = open-redirect latente.
- **`Geo/.../Forms/LocationForm.php:39-83`**: label/placeholder passano **chiavi di traduzione come literal** (`->label('geo::fields.region.label')`) → UI mostra la chiave grezza. Bug funzionale.
- **`Geo/.../FilterCoordinatesInRadius.php:33`**: condizione invertita sospetta (`>=` tiene punti FUORI raggio).

### Alti (Filament/domain agent — NON ancora fixati)

- **C1 Compliance entities**: mismatch massiccio form↔schema su `MedicalDirector`, `LegalRepresentative`, `LegalOffice` (standalone resource + relation manager). Serve initiative dedicata: decidere vocabolario dominio, allineare migration/fillable/form/table/infolist, test per ogni campo.
- `ClientResource`: manca `ControlsRelationManager`; `DevicesRelationManager` commentato con fallback generico; `business_closed` filter default `false` nasconde clienti chiusi; `populateAllCoordinates` sincrono va in coda; cache activity non tenant-aware; `AppointmentsTable` riferimento `client.company_name` da verificare.
- Nessuna `Policies/` in TechPlanner → autorizzazione eccessiva.

### Medi/bassi

- ~320 label hardcoded in Filament (User ~90, TechPlanner ~31, Xot ~30, Cms ~27, Notify ~20, altri).
- 3 `.navigation` self-referencing in `it` (Employee `absence_request`, Cms `themes`/`appearance`) + `en` mancante.
- Estensioni Filament dirette fuori Xot: Job ×3 (`ScheduleOptions` dup in 2 namespace, `ScheduleArguments`), Media ×2 (`VideoEntry`, `ConvertAction` morto).
- Controller orfani: Employee `EmployeeController`, Media `ConvertController`/`BaseController`, User `Auth/*` + `UpgradeController`.
- ~10 file stale in `app/`: `.disabled`, `.fila3`, `.maybe_profile`, `.php-cs-fixer.dist.php` misplaced.
- `composer.json`: `require` vuoti (Geo/Tenant/Job), `php` in `require` (Activity), drift PHP `^8.2`/`^8.4`, junk composer.json in `Geo/docs/**` e `User/resources/views/`.
- Geo: ~6 coppie di Action duplicate (`Bing/BingMaps`, `FilterCoordinates*`, `CalculateGeoDistance` ×2, `IsPointInPolygon` ×2, `OptimizeRoute` ×2), `GeocodingServiceInterface` duplicato byte-identico, `GeoServiceFacade` morto.
- `mixed` in `Geo/.../PointMap.php` (7 prop constructor non tipizzate).
- 29 TODO in app code (peggiore: `User/Api/LogoutController.php` ×4, rotta live).

## Verifiche eseguite

- `php -l` ✅ · PHPStan 0 errori sui file toccati · Pint ✅
- `php artisan test Modules/TechPlanner/tests/Unit/Models`: 10 passati, 1 skip
- Precedente: TechPlanner Unit 47/47, PHPStan `Modules/TechPlanner/app` 0 errori

## Non verificato / residuo

- Smoke runtime Livewire: device view/edit (fix C2), client edit Address section, RM create.
- Axe MCP non connesso → validazione a11y mappe solo statica.
- Suite completa repo: PHPStan globale e ~90 failure preesistenti Geo tests non a zero.
- C1 compliance: initiative separata necessaria (schema-first).

---

## Addendum — PageSpeed sottana.com (mobile, target 100)

Analisi live + fix applicati (Theme Two = tema pubblico di sottana.com):

| Problema | Evidenza | Fix |
|---|---|---|
| Immagini 404 in produzione | `service-patient-safety.jpg`, `veterinary-radiology.jpg` → 404 text/html | Immagini pubblicate in `Themes/Two/public/themes/Two/images/` (doppiamente annidate) invece di `public/images/`; copiati 36 file da `resources/images` in `public/images/`; fixato `sync-public` in `package.json` per copiare anche in `public_html/themes/Two/images/` |
| Immagini enormi | 29 JPG da 1.8–9.7 MB, totale ~62 MB | Ricompressi via GD (max 2000px, q82): **62 MB → 13 MB** (-79%), inclusi `photo-*` senza estensione |
| CSS 994 KB | `app.css` importava esplicitamente **tutti i CSS Filament** (support/actions/forms/infolists/notifications/schemas/tables/widgets) | Rimossi gli 8 `@import` filament → rebuild Vite: **994 KB → 395 KB** (gzip ~48 KB), nuovo hash `app-BHZEP00w.css` |
| JS Filament su pagine pubbliche | `@filamentScripts` (5 bundle) + `@livewire('notifications')` in tutti i layout | Rimossi da `layouts/{base,app}`, `components/layouts/{main,base}`, `errors/404` — verificato nessun uso di `Notification::make` nel frontend |
| `livewire.js` non minificato 610 KB | `APP_DEBUG=true` | `APP_ENV=production`, `APP_DEBUG=false` in `.env` → ora `livewire.min.js` (~262 KB) |
| Vecchi hash CSS accumulati | `emptyOutDir:false` | 4 vecchi `app-*.css` da ~1MB in `public/assets` — solo spazzatura, non servita |

### Verificato in locale (192.168.1.40:8000)

- `/it` → 200; CSS nuovo hash servito (394 KB); `livewire.min.js`; nessuno script filament; immagine 200 `image/jpeg` 678 KB
- Test `Modules/TechPlanner/tests/Unit/Content`: 10/10 passati

### NON ancora applicato (richiede deploy/ops)

- **Produzione è remota** (sottana.com → 46.225.90.178, Hostinger): le fix sono nel repo, servono deploy (DeployHQ/git) + `.env` di produzione con `APP_DEBUG=false`
- **Cache headers immutabili** per asset hashati: config nginx raccomandata in `bashscripts/docs/audit/live-site-reaudit/production-readiness.md` (PROD-011) — nginx non è nel repo
- **TBT/INP**: senza Lighthouse runtime non misurabile; le rimozioni JS dovrebbero avvicinare a 100
- Consolidamento dei 4 alberi asset (PROD-011/020): images dedup (31.5 MB di duplicati byte-identici rimossi nel rebuild, ma le copie `photo-*` esistono ancora)
