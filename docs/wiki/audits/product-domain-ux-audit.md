---
title: "Audit prodotto e UX — dominio TechPlanner"
type: audit
module: TechPlanner
status: recommendations
tags: [audit, product, ux, domain, dentistry, veterinary, compliance]
qmd: "techplanner product ux domain audit dentistry veterinary compliance gaps"
related:
  - ../concepts/techplanner-business-domain.md
  - ../concepts/competitor-landscape.md
  - ../entities/appointment.md
  - ../entities/control.md
  - ./module-techplanner-audit.md
  - ../../stories/unified-controls-parental.story.md
---

# Audit prodotto e UX — dominio TechPlanner

## Scopo e metodo

Questo audit confronta la promessa pubblica di TechPlanner/Sottana Service con
il codice e la documentazione del modulo. Le fonti di promessa sono i contenuti
di `config/local/techplanner/database/content/pages/services.json`,
`Modules/TechPlanner/config/database/content/pages/faq.json` e `terms.json`.
Le evidenze applicative sono state ricavate da modelli, migration, Resource,
widget e documenti wiki presenti nel repository.

Il risultato non è una proposta funzionale eseguibile: è una baseline BMAD per
decidere il prossimo incremento senza confondere marketing, anagrafica,
controllo tecnico e gestione della visita.

## Sintesi

La base oggi copre bene anagrafica cliente, apparecchi, geolocalizzazione e una
prima gestione preventiva delle scadenze. La promessa è però più ampia:
propone un servizio completo per studi dentistici e cliniche veterinarie,
comprensivo di controlli normativi, documentazione, radioprotezione e gestione
operativa delle visite.

Le tre lacune più importanti sono:

1. manca il ciclo di vita completo della visita tecnica sul campo;
2. manca il fascicolo di evidenze e documenti di conformità;
3. esistono due fonti concorrenti per lo storico dei controlli.

Queste lacune sono prioritarie perché incidono rispettivamente sull'esecuzione
del servizio, sulla prova del risultato e sull'affidabilità dello storico.

## Matrice promessa → evidenza

| Promessa | Presente | Stato | Impatto UX/dominio |
|---|---|---|---|
| Clienti dentistici e veterinari | `Client`, settori nei contenuti marketing, `ClientResource` | Parziale | Il settore è descritto nei contenuti, ma non guida ancora checklist o campi specifici. |
| Controlli RX, intraorali ed elettromedicali | `Control` STI, `ControlTypeEnum`, `ControlResource` | Parziale/recente | Esistono tipo, data, esito e scadenza; mancano prove e schede tecniche specifiche. |
| Autorizzazioni sanitarie e conformità | `HealthAuthorizationControl`, campi generici `status/result/metadata` | Parziale | Un record non equivale a pratica, documento approvato o scadenza verificabile. |
| Visite e assistenza tecnica | `AppointmentResource`, `worker_id`, stato e outcome | Parziale | La registrazione base esiste; dispatch, durata, conflitti, rapportino e firma non risultano completi. |
| Gestione delle apparecchiature | `DeviceResource`, `Device`, relazione con `Client` | Presente ma frammentata | Lo storico è diviso tra `DeviceVerification` legacy e `Control`; la continuità per matricola non è garantita. |
| Avvisi di scadenza | widget, filtro e comando `techplanner:controls:expiring-reminder` | Presente in forma minima | È un buon fondamento PM, ma dipende dalla scelta della fonte canonica e non chiude il fascicolo normativo. |

## Le tre lacune prioritarie

### 1. Ciclo di vita della visita tecnica incompleto

**Evidenza.** `Appointment` e la relativa Resource ora espongono cliente,
tecnico, data, stato, note ed esito. La documentazione competitiva identifica
però come gap ancora aperti promemoria cliente, rapportino firmato/PDF,
dispatch board e KPI. Non risultano nel dominio una durata/fine visita, una
regola di sovrapposizione, una checklist eseguibile, firma del cliente,
collegamento obbligatorio ai controlli svolti o una vista agenda/dispatch.

**Lacuna prodotto.** Il sistema può registrare un appuntamento, ma non
accompagna il tecnico dalla pianificazione alla chiusura verificabile del
servizio. Per un tecnico dentistico/veterinario questo è il percorso principale:
cliente → apparecchiatura → controlli → esito → consegna del rapporto.

**Raccomandazione.** Definire prima il contratto di visita, senza implementarlo
in questo audit: stati e transizioni, intervallo temporale, tecnico assegnato,
controlli eseguiti, esito, allegati, firma e notifica. La prima release dovrebbe
privilegiare un rapportino auditabile e una agenda semplice; il routing
automatico può restare fuori scope.

**Criterio di completamento futuro.** Una visita chiusa deve avere un cliente,
un tecnico o una motivazione esplicita, un esito, i controlli collegati e un
rapporto recuperabile dallo storico del cliente e dell'apparecchio.

### 2. Fascicolo di evidenze e documenti di conformità assente

**Evidenza.** I contenuti promettono autorizzazioni sanitarie, DVR, relazioni
tecniche, nomine degli esperti di radioprotezione, dosimetria, sterilizzazione
e documentazione per gli organi di controllo. `Control` contiene invece dati
comuni (`status`, `result`, date, note e `metadata`), mentre `ControlInfolist`
e la Resource non espongono un fascicolo documentale, versioni, approvazioni,
validità, autore o evidenza firmata.

**Lacuna prodotto.** Un operatore può segnare che un controllo esiste o che una
scadenza si avvicina, ma non può dimostrare in modo strutturato cosa è stato
verificato, con quale documento, da chi e con quale validità. È la differenza
tra un registro interno e uno strumento di conformità utilizzabile in audit.

**Raccomandazione.** Modellare il fascicolo come capacità separata dal tipo STI:
documento/evidenza, categoria normativa, versione, data emissione, scadenza,
stato di revisione, autore/verificatore, collegamento a cliente, controllo,
apparecchio e visita. Definire anche permessi, conservazione e report/export.
Checklist RX, VSE/IEC 60601, autorizzazione sanitaria e radioprotezione devono
essere template versionati, non testo libero in `metadata`.

**Criterio di completamento futuro.** Ogni controllo normato deve poter aprire
un fascicolo e produrre un riepilogo audit-ready con stato, scadenze, evidenze e
responsabile, senza ricostruire la storia da note sparse.

### 3. Storico dei controlli diviso tra legacy e modello canonico

**Evidenza.** Il nuovo flusso usa `controls`, Parental/STI e
`next_control_date`; il modello storico `DeviceVerification` continua a
esistere. `Device` espone `verifications()`, mentre il relation manager
`DeviceVerificationsRelationManager` dichiara `deviceVerifications` e campi
che non coincidono con il fillable/migration del modello storico. La wiki
documenta la compatibilità legacy, ma non una migrazione, una regola di
precedenza o una lettura unificata.

**Lacuna prodotto.** Due operatori possono vedere storici diversi per lo stesso
apparecchio: uno consulta le verifiche legacy, l'altro i nuovi controlli. Gli
avvisi di scadenza e le proiezioni cliente del nuovo flusso non possono essere
considerati completi finché i dati storici non hanno una semantica definita.

**Raccomandazione.** Approvare una decisione di dominio prima di ulteriore UX:
`Control` come fonte canonica con import idempotente delle verifiche legacy,
oppure una separazione esplicita tra verifica apparecchio e controllo normativo.
In entrambi i casi servono mappa dei campi, identificazione dell'apparecchio,
provenienza del dato, deduplicazione, audit della migrazione e una sola vista
storica per cliente/matricola.

**Criterio di completamento futuro.** Per un apparecchio è possibile rispondere
con una sola timeline a: ultimo controllo, prossimo obbligo, esito, fonte del
dato e documento associato. L'assenza di dati deve essere distinta da un
controllo mai eseguito.

## Raccomandazioni ordinate

1. Approvare il contratto di dominio della visita e il rapportino minimo.
2. Decidere la fonte canonica dello storico e preparare una mappa di migrazione
   `DeviceVerification` → `Control` (o una separazione formalmente motivata).
3. Definire il fascicolo documentale e i template per odontoiatria e veterinaria.
4. Solo dopo, aggiungere le viste UX: agenda, timeline per matricola, fascicolo
   e dashboard KPI.

## Non obiettivi di questo audit

- nessuna modifica a PHP, migration, Blade, configurazione o database;
- nessuna decisione normativa sostitutiva del consulente di radioprotezione;
- nessuna promessa di fatturazione, preventivi o route optimization;
- nessuna conclusione sullo schema reale di produzione senza una verifica
  autorizzata del database.

## Tracciabilità BMAD

Le raccomandazioni devono essere trasformate in storie BMAD separate e
sequenziate, mantenendo questa pagina come baseline di prodotto. La story
[`unified-controls-parental.story.md`](../../stories/unified-controls-parental.story.md)
copre la base STI, non chiude da sola le tre lacune sopra elencate.
