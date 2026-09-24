---
title: "TechPlanner — dominio business"
type: concept
module: TechPlanner
tags: [techplanner, business, client, device, appointment, compliance]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner business domain client device appointment legal office medical director planning"
repo: "laraxot/base_techplanner_fila5"
repo_module_target: "laraxot/module_techplanner_fila5"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ../entities/client.md
  - ../entities/device.md
  - ../entities/appointment.md
  - ../../philosophy.md
  - ../../models-and-relationships.md
  - ../../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md
  - ../../../../../../docs/wiki/memories/frontmatter-github-links-mandatory-standing.md
---

# TechPlanner — dominio business

## GitHub (tracciamento)

| Tipo | Link | Argomento |
|------|------|-----------|
| Issue | [#15 — SSoT dominio business TechPlanner](https://github.com/laraxot/base_techplanner_fila5/issues/15) | Client, Device, Appointment, conformità, XotBase |
| Discussion | PENDING | Coordinamento wiki LLM modulo owner |

**Repo owner:** `git remote -v` monorepo → `laraxot/base_techplanner_fila5`. Remote modulo `laraxot/module_techplanner_fila5` (non pubblicato): issue su monorepo fino a repo modulo live.

## Perché esiste

TechPlanner è il **modulo owner** della pianificazione tecnica operativa: aziende di servizi che gestiscono clienti, ispezioni dispositivi, appuntamenti sul campo e adempimenti normativi (rappresentanti legali, direttori sanitari, uffici legali).

Non è infrastruttura (Xot) né auth (User): è il **cuore applicativo** di `base_techplanner_fila5`.

## Entità centrale: Client

```
Client
 ├── Device / Machine (+ DeviceVerification)
 ├── Appointment (+ Participant, Worker)
 ├── LegalRepresentative, MedicalDirector, LegalOffice
 └── PhoneCall (log comunicazioni)
```

Tutto ruota attorno all'anagrafica cliente: coordinate Geo, PEC, assegnazione worker, stato operativo.

## Flussi principali

| Flusso | Owner code | Wiki |
|--------|------------|------|
| Anagrafica + mappa | `ClientResource`, widget Geo | [client.md](../entities/client.md) |
| Parco dispositivi | `DeviceResource`, RM su Client | [device.md](../entities/device.md) |
| Visite / appuntamenti | `AppointmentResource` | [appointment.md](../entities/appointment.md) |
| Comunicazioni | `PhoneCallResource` | source `docs/client-notifications.md` |

## Regole architetturali (modulo)

- **XotBase** su Resource, RelationManager, Widget — mai Filament diretto
- **Enum in fillable** — pattern documentato in `docs/model-fillable-enum-pattern.md`
- **Geo** — coordinate e mappe via modulo Geo, non duplicare logica mappa
- **Profile** — se dipende da `main_module`, migration in TechPlanner non in User
- **Actions** — logica coordinate/refactor in Actions, non Services

## Filosofia (sintesi)

- **Politica**: oversight strutturato su clienti, risorse e scadenze
- **Religione**: pianificazione e tracciabilità come prerequisito operativo
- **Zen**: progresso trasparente in Filament, dipendenze esplicite tra entità

Fonte estesa: [philosophy.md](../../philosophy.md)

## Anti-pattern

## Promotion & Discipline

Questo documento è il **SSoT (Single Source of Truth)** per il dominio business di TechPlanner. Ogni modifica architetturale o di business logic deve riflettersi qui e nel log del modulo.

- **Frequenza aggiornamento**: Mensile o ad ogni cambio di requisito normativo
- **Owner**: Medical Director / Legal Office (approvazione concettuale)
- **Implementazione**: Team Sviluppo (conformità XotBase)

*— LLM Wiki System (Gemini 2.0 Flash)*
