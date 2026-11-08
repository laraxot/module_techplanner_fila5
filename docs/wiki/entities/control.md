---
title: "Entity — Control"
type: entity
module: TechPlanner
status: implemented
tags: [control, inspection, parental, sti, entity]
qmd: "techplanner control controls single table inheritance parental verification client device worker"
related:
  - ./client.md
  - ./device.md
  - ./appointment.md
  - ../../stories/unified-controls-parental.story.md
---

# Control

## Ruolo di dominio

`Control` rappresenta una verifica tecnica o sanitaria eseguita nell'ambito
operativo di un cliente. Il dominio deve riunire nello stesso archivio le
verifiche RX, intraorali, autorizzazioni sanitarie e i futuri tipi di
controllo, mantenendo ricercabili storico, scadenze e documenti.

La story BMAD di riferimento è
[`unified-controls-parental.story.md`](../../stories/unified-controls-parental.story.md).
Questa pagina documenta l'implementazione corrente.

## Modello e STI

Il modello radice previsto è `Modules\TechPlanner\Models\Control`, con una
sola tabella `controls`. I tipi concreti sono sotto-modelli Parental e vengono
distinti dalla colonna `control_type`:

```text
Control
├── RxControl
├── IntraoralControl
├── ElectromedicalControl
├── HealthAuthorizationControl
└── OtherControl
```

Valori ammessi: `rx`, `intraoral`, `electromedical`, `health_authorization`, `other`. Il campo
è castato a `ControlTypeEnum`; i sotto-modelli correnti condividono i campi
comuni e sono pronti per comportamento specifico futuro.

La discriminazione STI significa che:

- ogni record vive in `controls`;
- `control_type` determina la classe concreta idratata da Parental;
- i campi comuni restano sul modello radice;
- eventuali campi specifici del tipo saranno gestiti dal sotto-modello e dal
  form unico;
- il CRUD Filament deve rimanere una superficie unica, non una Resource per
  ogni tipo.

Il campo `control_type` è un discriminatore di classe, non un collegamento
gerarchico.

## Relazioni

Ogni controllo:

- può appartenere a un `Client`; il database consente temporaneamente `client_id = null`
  per import, staging o controlli non ancora assegnati;
- può appartenere opzionalmente a un `Device`;
- può essere associato opzionalmente a un `Worker`;
- può essere associato opzionalmente a un `Appointment`;
- espone i dati comuni di stato, data, scadenza, esito e documentazione.

In termini Eloquent il grafo previsto è:

```text
Client 1 ─── * Control
Device 0..1 ─── * Control
Worker 0..1 ─── * Control
```

Le relazioni verso `Client`, `Device` e `Worker` descrivono il contesto
operativo della verifica; non determinano il tipo STI. Un controllo senza
cliente non deve essere mostrato come storico di quel cliente finché
`client_id` non viene valorizzato.

## Parental e gerarchia: distinzione obbligatoria

Parental/STI e gerarchia ad albero risolvono problemi diversi:

| Concetto | Scopo | Colonna/esempio |
|---|---|---|
| Parental/STI | Scegliere il comportamento e la classe concreta del record | `control_type` |
| Gerarchia | Collegare un controllo a un altro controllo padre | eventuale `parent_id` |

La story adotta Parental, ma **non** una gerarchia di controlli. Non bisogna
interpretare `control_type` come `parent_id`, né introdurre relazioni
`parent()`/`children()` per rappresentare i sotto-modelli.

Se in futuro il dominio richiederà controlli composti o sotto-verifiche,
`parent_id` dovrà essere una decisione separata, con regole di ciclo,
cancellazione e autorizzazione documentate. Tale estensione è fuori scope
della story corrente.

## Scadenze e ciclo di vita (expiry workflow)

`next_control_date` è la spina dorsale del preventive maintenance:

- **Auto-cadenza**: `Control::booted()` (`saving`) precompila
  `next_control_date = control_date + ControlTypeEnum::defaultRecurrenceMonths()`
  quando la data controllo esiste e la scadenza non è stata toccata
  (`isDirty` su `next_control_date` → la cancellazione esplicita non viene
  sovrascritta). Cadenza: 12 mesi per rx/intraoral/electromedical/
  health_authorization; `other` → nessuna cadenza automatica.
- **Widget** `ExpiringControlsWidget` in header di `ListControls`:
  scaduti / in scadenza 30gg / senza prossima data / clienti interessati
  (cache 15 min, guard `Schema::hasTable('controls')`).
- **Digest** `techplanner:controls:expiring-reminder {--days=30} {--dry-run}`:
  `GenericNotification` (database+mail) a `User::role(['admin','super-admin'])`,
  schedulato `dailyAt('07:00')` da `TechPlannerServiceProvider`.
- **Filtri**: `ControlsTable` ha `schedule_status` (scaduti/in scadenza/
  non pianificati); `ClientsTable` ha `has_controls`, `controls_expiring`,
  `never_controlled_type` e colonne `last_*_control_date` via
  `Client::scopeWithLatestControlDates()`.
- **i18n**: `techplanner::control.*` in it/en/de/es (navigation, fields,
  filters, widget, reminder) — fix del placeholder `control.navigation`.

Riferimento competitivo e gap residui:
[`concepts/competitor-landscape.md`](../concepts/competitor-landscape.md).

## Compatibilità legacy

`DeviceVerification` resta il modello storico. Non va eliminato né riscritto
come parte della sola introduzione di `Control`: la migrazione dei dati e la
verifica in produzione devono precedere qualsiasi sostituzione.

Riferimenti correlati:

- [`Client`](./client.md), anagrafica proprietaria del contesto;
- [`Device`](./device.md), apparecchio sottoposto a verifica;
- [`Appointment`](./appointment.md), evento operativo distinto dal controllo.
