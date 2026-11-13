---
title: "Story: TechPlanner pronto al rilascio (permessi, cestino, scadenze, dashboard, qualità dati, rilascio)"
type: story
status: review
created: 2026-11-10
updated: 2026-11-10
tags: [bmad, story, techplanner, produzione, policy, soft-delete, dashboard, deploy]
related:
  - ../../../../../docs/audit/BACKLOG_AND_ROADMAP.md
  - ../../../../../docs/audit/RELEASE.md
  - ./device-verifications-fix.story.md
  - ../manual/manuale-uso.md
---

# Story: TechPlanner pronto al rilascio

**Come** responsabile dello studio di verifiche, **voglio** che il pannello protegga i dati, mostri cosa scade e si
possa rilasciare in modo ripetibile, **così che** segreteria e tecnici lavorino senza rischi e senza fogli a parte.

## Criteri di accettazione

| # | Criterio | Stato | Prova |
|---|---|---|---|
| 1 | Operatori (`techplanner::operator`) consultano, creano e modificano ma non cancellano; `techplanner::admin` fa tutto; `super-admin` entra ovunque | ✅ | `tests/Unit/Policies/TechPlannerPolicyMatrixTest.php`, browser |
| 2 | «Elimina» porta nel cestino il record e quello che gli appartiene; «Ripristina» lo riporta | ✅ | `tests/Feature/SoftDeleteCascadeTest.php` |
| 3 | Elenco apparecchi con «Prossima verifica» colorata e filtro per scadenza | ✅ | `tests/Feature/DueVerificationsTest.php` |
| 4 | Pagina iniziale con scadute, in scadenza, mai verificati, appuntamenti di oggi | ✅ | browser, manuale fig. 3 |
| 5 | Partita IVA e codice fiscale validati; recapiti una sola volta nel modulo cliente | ✅ | `tests/Feature/ClientDataQualityTest.php` |
| 6 | Reimportare un file aggiorna invece di duplicare | ✅ | `tests/Feature/ClientDataQualityTest.php` |
| 7 | Ogni modulo chiede solo colonne esistenti e ha il cliente | ✅ | `tests/Feature/FormsMatchSchemaTest.php` |
| 8 | Installazione pulita e aggiornamento funzionano su MariaDB | ✅ | `migrate:fresh` e aggiornamento simulato (con righe orfane) su MariaDB 10.11 |
| 9 | Rilascio con lock, manutenzione, backup e ritorno indietro documentato | ✅ | `deploy.sh`, `docs/audit/RELEASE.md` |
| 10 | CI su `dev` | ✅ | `.github/workflows/techplanner-ci.yml` |
| 11 | Manuale d'uso aggiornato, in `.md` e `.pdf`, con screenshot | ✅ | `docs/manual/` |

## Decisioni

- Il ruolo operatore è generico (`{modulo}::operator`) e gestito in `BaseUser::canAccessPanel`: entra solo nel
  pannello del suo modulo, i permessi fini sono nelle policy del modulo.
- Cestino a cascata nel trait `CascadesSoftDeletes`; la cancellazione definitiva resta alle foreign key.
- Le migrazioni già eseguite in produzione non si riscrivono: la colonna `deleted_at` mancante la aggiunge una
  migrazione nuova, idempotente.
- I moduli delle schede del cliente usano gli stessi `*Form` del menu: una sola definizione per modello.

## Fuori da questa story

FUN-02 (tecnico, stato, calendario: da validare con gli utenti), USR-02, rotazione credenziali e prova delle
migrazioni sulla copia del DB di produzione (azioni dell'utente, `RELEASE.md`).
