---
status: done
owner: techplanner
title: Controls expiry workflow — alerts, recurrence, filters, competitor gap closure
type: story
module: TechPlanner
tags: [bmad, ecc, controls, preventive-maintenance, notifications, competitor-analysis]
qmd: "techplanner controls expiry next_control_date recurrence alerts competitor fsm"
related:
  - ../wiki/entities/control.md
  - ../wiki/entities/client.md
  - ../wiki/concepts/competitor-landscape.md
  - ../../../../../docs/research/market-fsm-competitors-research.md
  - unified-controls-parental.story.md
  - clients-distance-sort.story.md
---

# Controls expiry workflow — alerts, recurrence, filters

## Story

As an office manager, I want automatic visibility and notification of upcoming
control expirations — like every credible FSM/CMMS competitor offers — so that
site visits are planned *before* deadlines, not after them.

## Context — competitor analysis

Ricerca di mercato completa in
[`docs/research/market-fsm-competitors-research.md`](../../../../../docs/research/market-fsm-competitors-research.md):
FSM globali (Jobber, Housecall Pro, ServiceTitan, Workiz, Service Fusion,
mHelpDesk, Simpro, Fergus, FieldEdge), CMMS biomedicali (Bravio, InspectWrk,
FieldEx, Medusa) e strumenti italiani (Radix+, Sistema, Machina Web, ADonePRO,
Romaldent, Soraia, IDxitaly, Appsistance, Assist, ARCA). Conclusione: il gap
principale era l'assenza di un ciclo di vita delle scadenze — "expiry alerts"
sono table stakes in ogni concorrente credibile.

## Implemented

1. **`ExpiringControlsWidget`** (header di `ListControls`): statistiche
   scaduti / in scadenza 30gg / senza prossima data / clienti interessati,
   cache 15 min, guard `Schema::hasTable` per ambienti senza migrazione.
2. **`techplanner:controls:expiring-reminder {--days=30} {--dry-run}`**:
   digest giornaliero via `GenericNotification` (canali database+mail) a
   `User::role(['admin','super-admin'])`, con breakdown per `control_type` e
   link diretto all'elenco controlli. Schedulato `dailyAt('07:00')` in
   `TechPlannerServiceProvider::register()` via `callAfterResolving(Schedule)`.
3. **Auto-cadenza `next_control_date`**: `Control::booted()` `saving` hook —
   se `control_date` valorizzata e `next_control_date` assente/non sporca,
   imposta `control_date + defaultRecurrenceMonths()` (12 mesi per tutti i
   tipi normati, `null` per `other`). `ControlTypeEnum::defaultRecurrenceMonths()`.
4. **Filtro `schedule_status`** su `ControlsTable`: scaduti / in scadenza /
   non pianificati.
5. **Clients table**: colonne ultimate date per controllo (`last_rx_control_date`,
   `last_intraoral_control_date`, `last_electromedical_control_date`,
   `last_health_authorization_date`) via `Client::scopeWithLatestControlDates()`
   applicato in `ListClients::getTableQuery()`, con filtri has/never/expiring.
6. **Fix navigazione ControlResource**: creato `lang/{it,en,de,es}/control.php`
   (era `control.navigation` grezzo — placeholder rule) + icona
   `resources/svg/control.svg`.
7. **Fix infra comandi**: eliminata cache stale
   `app/Console/Commands/_components.json` che non registrava i nuovi command.

## Acceptance criteria

- [x] `php -l` su tutti i file toccati
- [x] PHPStan 0 errori sullo scope modificato
- [x] `php artisan schedule:list` mostra il reminder giornaliero 07:00
- [x] `ControlResource::getNavigationLabel()` risolve "Controlli" + icona
- [x] Command `--dry-run` esegue senza errori (guard tabella mancante ok)
- [ ] Verifica browser runtime post-deploy (widget, filtri, digest reale)
- [ ] Pest: bootstrap `XotBaseTestCase` rotto a livello infra (preesistente)

## Out of scope

- Report/rapporto intervento firmato (gap #5 — prossima story)
- Promemoria appuntamento al cliente via Notify (gap #4 — prossima story)
- Dispatch board / agenda tecnico (gap #6)
