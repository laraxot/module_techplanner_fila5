---
title: "Competitor landscape FSM/CMMS per assistenza tecnica medicale"
type: comparison
module: TechPlanner
status: active
tags: [competitor, fsm, cmms, market-research, preventive-maintenance]
qmd: "techplanner competitor fsm cmms jobber serv titan radish radice assistenza elettromedicale expiry alerts"
related:
  - ../entities/control.md
  - ../entities/client.md
  - ../../../../../docs/research/market-fsm-competitors-research.md
  - ../../stories/controls-expiry-workflow.story.md
---

# Competitor landscape — FSM/CMMS per assistenza tecnica medicale

Ricerca di mercato 2026-11-06 (report completo:
[`docs/research/market-fsm-competitors-research.md`](../../../../../docs/research/market-fsm-competitors-research.md)).
Tre segmenti: FSM SMB globali, CMMS biomedicali/healthcare, FSM italiani.

## Sintesi

- **FSM SMB US** (Jobber, Housecall Pro, Service Fusion, mHelpDesk, Fergus):
  scheduling/dispatch, preventivi→fatture, app mobile. Deboli su registro
  asset e PM vero — solo Simpro (mid-market) e HCP Property Profile hanno
  asset registry seria.
- **CMMS biomedicali** (Bravio, InspectWrk, FieldEx, Medusa): profondità
  conformità (test elettrici, audit-ready service record) ma ospedalieri,
  pricing demo, no localizzazione italiana.
- **FSM italiani** (Radix+, Sistema, Machina Web, HiLINE HD, ADonePRO,
  Assistance Web, Soraia, IDxitaly, Appsistance, Assist, ARCA eAssistance):
  i più vicini — matricole/impianti, contratti con scadenze, rapportini,
  app offline, e-invoicing. **Nessuno ha la tassonomia di controllo
  medicale/dentistica di TechPlanner** (RX, endorale, elettromedicale,
  autorizzazione sanitaria come oggetti di prima classe).
- **Romaldent** (FR) e **CMMS Medical** (IT, lato studio) provano la domanda
  di registri di conformità dentistica.

## Gap chiusi da questa ricerca

| Gap | Stato |
|---|---|
| Alert scadenze controlli (widget + digest admin + scheduler) | Fatto — `controls-expiry-workflow.story.md` |
| Auto-cadenza `next_control_date` (PM engine minimale) | Fatto — `ControlTypeEnum::defaultRecurrenceMonths()` |
| Filtri scadenza su ControlsTable | Fatto — `schedule_status` filter |

## Gap aperti (priorità nel report)

1. Promemoria appuntamento al cliente (canali Notify già pronti)
2. Rapporto intervento firmato/PDF ("rapportino" — differenziale italiano)
3. Dispatch board / agenda tecnico (Appointment minimale)
4. Storico per matricola device + garanzia
5. Checklist per tipo di controllo (VSE, CQ radiologici — D.Lgs. 187/101)
6. KPI/reporting produttività

## Punti di forza TechPlanner vs mercato

- Tassonomia controllo medicale nativa — **unicità rispetto a ogni FSM SMB**
- Mappa + sort-by-distance live (i concorrenti lo paywallano)
- Self-hosted: nessun canone per utente
- Controlli STI con `next_control_date` come spina dorsale PM
