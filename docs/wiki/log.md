---
title: "Wiki Log — TechPlanner"
type: log
module: TechPlanner
tags: [techplanner, wiki, log, changelog]
created: 2026-06-06
updated: 2026-11-07
qmd: "techplanner wiki log changelog bootstrap business domain"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ./index.md
  - ./concepts/techplanner-business-domain.md
---

## [2026-11-19] appointment conflict detection + indice moduli

- Nuova capability: `duration_minutes` su appointments (migration applicata),
  `Appointment::endAt()`, `CheckAppointmentConflictAction` (QueueableAction,
  overlap half-open, esclude stati terminali), regola di validazione Filament
  su worker_id/date/duration_minutes, colonna+infolist, i18n it/en/de.
- Test: `CheckAppointmentConflictActionTest` 6/6; suite Unit TechPlanner 47/47.
- Story: `docs/stories/appointment-conflict-detection.story.md`.
- `Modules/INDEX.md`: tutti i link PHILOSOPHY.md rotti corretti verso il doc
  filosofia reale di ogni modulo (verificato 0 link rotti).
- Rimossa directory stray `Modules/Techplanner/` (un file audit spostato in
  `TechPlanner/docs/audits/`).

## [2026-11-19] client form | mappa posizione dentro section Indirizzo

- `ClientForm`: la `View` `client-location-map` spostata da voce top-level a `extraComponents` di `AddressSection`, dopo `ClientCoordinatesSection` — coordinamento logico: indirizzo -> coordinate -> mappa.
- Blade `client-location-map`: rimosso wrapper `<x-filament::section>` (sezione dentro sezione); heading "Posizione cliente" mantenuto come `<h3>` sottosezione.
- Verifiche: `php -l`, PHPStan 0 errori, Pint passed.

## [2026-11-19] test-infra | regressione geocoding verificata con Pest

- `Modules/Geo/tests/Unit/Actions/UpdateCoordinatesFromAddressActionTest.php`: 3 test verdi — indirizzo vuoto, propagazione errori provider (regressione del fix `errors->merge()`), successo con `update()` lat/lng.
- `tests/Unit/Models/BaseModelTest.php`: `Model::withoutEvents()` intorno all'anonimo — il boot sparava `eloquent.booting` verso il subscriber event-sourcing non risolvibile in test (3 test di nuovo verdi).
- Suite `Modules/TechPlanner/tests/Unit`: 41 passati, 1 skipped, 0 falliti.
- PHPStan: 0 errori su tutti i file toccati; Pint applicato.

# Wiki Log — TechPlanner

## [2026-11-07] client coordinate editing UX

- Documented the dedicated coordinate subsection and its persisted-address
  geocoding contract in `concepts/client-coordinate-editing-ux.md`.
- Linked the decision from the Client entity page and the distance story.
- 2026-11-07 update: `ClientCoordinatesSection` is now nested inside
  `AddressSection` through the new `extraComponents()` hook on the shared
  Geo component; runtime fix: Filament injects `Set` (not `Closure`) for
  `$set` and record typed `?Model` instead of `mixed`.


## [2026-11-06] consolidamento docs/ modulo TechPlanner

- Creato `docs/phpstan/` e spostati i 7 documenti `phpstan-*` (convenzione
  docs/phpstan/ della standardizzazione docs).
- Spostati in `docs/audits/` i 3 report qualità sovrapposti
  (`code-quality-report`, `code-quality-improvement-report`, `quality-analysis-report`).
- Rinominati in kebab-case: `filament_v4_upgrade_notes.md` →
  `filament-v4-upgrade-notes.md`, `filosofia_modulo_techplanner.md` →
  `concepts/filosofia-modulo-techplanner.md`, `concepts/PHILOSOPHY.md` →
  `concepts/vision-and-philosophy.md` (canonico v2.0),
  `competitive-analysis-field-controls-2026-11-06.md` → senza data.
- Rimossa la copia datata duplicata `stories/2026-10-06-phpstan-cleanup-techplanner.*`.
- `00-index.md` ora è uno stub redirect verso `index.md` (canonico).
- `index.md` aggiornato: 0 link rotti (verificato via script).
- Link relativi corretti nei file spostati (un livello di profondità in più).
- Verificato: tutti i `docs/wiki/` di moduli e temi hanno già
  `README.md`/`agents.md`/`index.md`/`log.md` (standardizzazione del 2026-10-06).
  Creati per errore stub ridondanti `readme.md`/`AGENTS.md` e rimossi:
  il repo usa `README.md` maiuscolo + `agents.md` minuscolo.
- Residuo noto: `Modules/Techplanner/` (lowercase) è una directory stray
  non tracciata con una versione obsoleta di un audit SEO — da rimuovere
  manualmente se non serve.

## [2026-11-06] fix bootstrap Pest + sezione coordinate form cliente

- **Pest sbloccato**: `Modules/Xot/composer.json` aveva `autoload-dev` con
  `classmap: tests/` annidato dentro `autoload` (chiave invalida) + un secondo
  `autoload-dev: {}` vuoto → `Modules\Xot\Tests\*` non autoloadabile e TUTTA
  la suite falliva. Corretta la struttura JSON; `composer dump-autoload`;
  `BaseModelTest` 3/3 e `ControlTest` 4/4 passano (1 skip).
- ClientForm: `latitude`/`longitude` estratti da `AddressSection` (Geo) in una
  `Section` dedicata "Coordinate" con action `geocodeCoordinates`
  (`UpdateCoordinatesFromAddressAction` + `$set` sync + notification);
  validazione range -90/90 e -180/180. i18n `sections.coordinates.*` e
  `actions.geocodeCoordinates.*` in it/en/de/es.

## [2026-11-06] fix mappa clienti: asset Leaflet nel docroot dev

- La mappa non appariva in locale (`php artisan serve`): `asset('assets/geo/assets')`
  punta a `laravel/public`, che non conteneva i file Leaflet (erano solo in
  `public_html/` di produzione e in `Modules/Geo/public/`). Copiati
  `leaflet.js`, `leaflet.css` e `images/` in `laravel/public/assets/geo/assets/`
  e force-add in git (`public/` è gitignored): ora il path è servito in ogni
  ambiente.

## [2026-11-06] client form sections + location map

- `AddressSection` (Geo) non renderizza più i campi contatto
  (phone/mobile/fax/pec/whatsapp/email) né `notes`: restano solo in
  `ContactSection` e nel campo note canonico del form, eliminando i binding
  duplicati sullo stesso state path.
- `ClientInfolist`: `contact_info` spezzata in `address_info` + `contacts`
  (aggiunti pec/whatsapp mancanti); label i18n it/en/de/es.
- Client edit form: mappa Leaflet singolo cliente + link Google Maps e
  ViaMichelin (empty state guidato senza coordinate) — view
  `client-location-map.blade.php`.

## [2026-11-06] appointment workflow + coordinate self-healing

- Appointment: `worker_id`, `status` (AppointmentStatusEnum), `outcome`,
  `reminder_sent_at` (migration `2026_11_06_100000`); form con client/worker/
  status, tabella con badge+filtri, infolist completa.
- `techplanner:appointments:reminders` (daily 08:00): email cliente via
  `Notification::route('mail')` + digest admin; idempotente via
  `reminder_sent_at`.
- Device: relazione `controls()` + colonna `controls_count` in DevicesTable.
- ControlForm: Repeater checklist in `metadata.checklist` (ok/ko/na).
- ClientsTable: azione "punto di partenza" icon-only e con fallback
  geocoding (`UpdateCoordinatesFromAddressAction`); stesso fallback nel popup
  mappa; header action "Aggiorna Coordinate" ora con label.
- Fix: `en/de/appointment.php` erano stub senza `<?php` — ripristinati come
  array PHP validi.

## [2026-11-06] client control recency and competitive workflow

- Added the Control entity page and linked it from the entity index.
- Documented latest RX, intraoral, electromedical and health-authorisation
  projections and the relationship-based filters on the client list.
- Added a competitive analysis covering field-service routing, asset history and
  dental/veterinary compliance products.

## [2026-06-06] frontmatter GitHub | techplanner-business-domain SSoT

- Frontmatter: `repo`, `issues` [#7](https://github.com/laraxot/base_techplanner_fila5/issues/7), `discussions` [#8](https://github.com/laraxot/base_techplanner_fila5/discussions/8)
- Body: sezione `## GitHub (tracciamento)` con tabella link
- Bootstrap agente: passo 0 frontmatter+gh in `agent-bootstrap-compact.md`

## [2026-06-06] frontmatter GitHub | issues + discussions obbligatori

- Aggiunti `issues:` e `discussions:` a tutti i `.md` wiki del modulo
- Issue dominio: [#7](https://github.com/laraxot/base_techplanner_fila5/issues/7) · Discussion [#8](https://github.com/laraxot/base_techplanner_fila5/discussions/8)
- Issue harness: [#9](https://github.com/laraxot/base_techplanner_fila5/issues/9) · Discussion [#10](https://github.com/laraxot/base_techplanner_fila5/discussions/10)
- Regola progetto: [#11](https://github.com/laraxot/base_techplanner_fila5/issues/11) · Discussion [#12](https://github.com/laraxot/base_techplanner_fila5/discussions/12)

## [2026-11-06] competitor analysis + expiry workflow

- Ricerca FSM/CMMS (Jobber, ServiceTitan, Simpro, Radix+, Romaldent, ADonePRO,
  CMMS Medical, ecc.): report `docs/research/market-fsm-competitors-research.md`
- Nuova pagina concept: [competitor-landscape.md](./concepts/competitor-landscape.md)
- Expiry workflow controlli: widget, reminder giornaliero, auto-cadenza
  `next_control_date`, filtri — story `controls-expiry-workflow.story.md`
- Fix: `control.php` lang (placeholder `control.navigation`) + icona svg
- Fix infra: cache `_components.json` comandi stantia

## [2026-06-06] bootstrap | wiki modulo dominio business

- Creato `docs/wiki/` con index, concepts, entities, harness
- Sintesi: [techplanner-business-domain.md](./concepts/techplanner-business-domain.md)
- Entità: Client, Device, Appointment
- QMD collection: `tp-mod-techplanner-wiki`
- Remote modulo: `laraxot/module_techplanner_fila5` (monorepo owner fino a repo modulo pubblicato)

## 2026-10-12 — PageSpeed sottana.com + audit completo

- **Audit completo** (4 subagent + diretto): report in `docs/audits/full-codebase-audit-2026-10-12.md`
- **Fix crash Filament**: `DeviceVerificationsRelationManager` (`deviceVerifications`→`verifications` + campi reali), `LegalRepresentatives`/`MedicalDirectors`/`LegalOffices` RM e form allineati allo schema reale (migration = SSoT), `DeviceVerification::$fillable` corretto, `LegalOfficesTable` `country`→`postal_code`, `NotifyExpiringControlsCommand` groupBy enum-safe, `Appointment*` `client.name`→`company_name`
- **TestCase TechPlanner**: aggiunto `DatabaseTransactions` + `connectionsToTransact=['sqlite']`
- **`{{TYPE^}}`**: risolto in 27 file wiki AGENTS (Module/Theme)
- **phpunit.xml**: aggiunte suite `Seo` e `Themes` (~85 test che non giravano mai)
- **PageSpeed**: immagini 404 fixate (path nesting), 62→13MB ricompressi, CSS Filament rimosso (994→395KB), `@filamentScripts`/`@livewire('notifications')` rimossi dai layout pubblici, `APP_DEBUG=false`
- **In attesa deploy**: produzione remota — applicare `.env` prod + nginx cache headers
