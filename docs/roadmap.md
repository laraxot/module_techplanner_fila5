# TechPlanner Module Roadmap

**Module**: TechPlanner
**Status**: Active Development
**Last Updated**: 2026-11-06
**Fonte strategica**: [analisi competitor FSM/CMMS](../../../../docs/research/market-fsm-competitors-research.md) e [concept competitor-landscape](./wiki/concepts/competitor-landscape.md)

## Contest

TechPlanner serve un'impresa di assistenza tecnica che esegue sopralluoghi
periodici presso studi dentistici e veterinari. La ricerca di mercato
(2026-11-06) ha confrontato FSM globali (Jobber, Housecall Pro, ServiceTitan,
Workiz, Service Fusion, mHelpDesk, Simpro, Fergus, FieldEdge), CMMS
biomedicali (Bravio, InspectWrk, FieldEx, Medusa) e FSM italiani (Radix+,
Sistema, Machina Web, ADonePRO, Soraia, IDxitaly, Appsistance, Assist, ARCA,
Romaldent, CMMS Medical).

**Conclusione**: nessun concorrente SMB combina (a) tassonomia di controllo
medicale/dentistica di prima classe, (b) mappa+prossimità, (c) ciclo di vita
delle scadenze. I biomed CMMS sono ospedalieri e cari; gli FSM italiani
generici non hanno gli oggetti di conformità.

## Completato

- Gestione Client (anagrafica, geo, contatti, uffici legali, rappresentanti)
- Device/Machine registry per cliente (`machines`, `device_verifications` legacy)
- **Unified controls STI** (`controls` + Parental): rx, intraoral,
  electromedical, health_authorization, other — `control_type` discriminante
- **Expiry workflow controlli** (2026-11-06):
  - `ExpiringControlsWidget` in `ListControls`
  - `techplanner:controls:expiring-reminder` digest admin, daily 07:00
  - Auto-cadenza `next_control_date` (12 mesi per tipi normati)
  - Filtro `schedule_status` + filtri/colonne scadenze su ClientsTable
- **Clients proximity workflow**: ordinamento per distanza da origine
  (sessione+cookie), widget coordinate, azione per-record, mappa Leaflet
  self-hosted con marker/popup/azioni
- Multi-canale notify (email/SMS/WhatsApp/Telegram/Firebase) via modulo Notify
- GDPR, audit, PHPStan L10 cleanup

## Prossime priorità (gap vs concorrenti)

### P1 — ciclo di vita visite
- [ ] **Promemoria appuntamento al cliente** via Notify (SMS/email/WhatsApp):
      canali pronti, manca workflow su `Appointment` (tutti i concorrenti
      lo danno per scontato)
- [ ] **Rapporto intervento firmato/PDF** ("rapportino"): firma cliente,
      checklists per tipo, export PDF — differenziale chiave degli FSM italiani
- [ ] **Appointment potenziato**: nota tecnica, esito visita, collegamento
      ai controls eseguiti, storico per cliente

### P2 — pianificazione e asset
- [ ] **Dispatch/agenda tecnico**: vista calendario/board dei tecnici,
      assegnazione appuntamenti a `worker_id`
- [ ] **Storico per matricola device**: `Device` collegato a Control,
      garanzia/scadenza, vista "tutto ciò che è stato fatto su questo apparecchio"
- [ ] **Checklist per tipo di controllo**: VSE (IEC 60601), CQ radiologici
      (D.Lgs. 187/101), autorizzazione sanitaria — `metadata` JSON esiste già,
      serve UI/struttura

### P3 — reporting e automazione
- [ ] **KPI**: produttività tecnico, controlli scaduti per cliente,
      tempo medio tra scadenze e visita
- [ ] **Report/export audit-ready** per conformità (pattern InspectWrk/Bravio)

## Non obiettivi (decisioni consapevoli)

- **Fatturazione/preventivi**: resta nel gestionale esterno; TechPlanner è
  il livello operativo (visite, controlli, scadenze)
- **Route optimization complessa**: sort-by-distance + mappa coprono il caso
  d'uso; routing vero solo se il volume giustificherà un servizio esterno
- **Multi-tenant SaaS**: self-hosted single-tenant per l'azienda

## Riferimenti

- Story: `stories/controls-expiry-workflow.story.md`,
  `stories/unified-controls-parental.story.md`,
  `stories/clients-distance-sort.story.md`
- Wiki: `wiki/entities/control.md`, `wiki/entities/client.md`,
  `wiki/concepts/competitor-landscape.md`
