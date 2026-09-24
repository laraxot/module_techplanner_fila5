---
title: "TechPlanner Module Wiki Index"
type: index
module: TechPlanner
tags: [techplanner, wiki, index, client, device, appointment, planning]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner module wiki index business domain client device appointment filament"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ../../../../../docs/wiki/concepts/agent-bootstrap-compact.md
  - ../../../../../docs/wiki/skills/cursor-second-brain-max-workflow.md
  - ./concepts/techplanner-business-domain.md
  - ./concepts/ai-harness-techplanner-discipline.md
---

# TechPlanner Module LLM Wiki

Modulo **dominio business** del progetto: gestione clienti, dispositivi, appuntamenti, conformità e pianificazione tecnica.

## AI / second brain

- [ai-harness-techplanner-discipline](./concepts/ai-harness-techplanner-discipline.md)
- [techplanner-business-domain](./concepts/techplanner-business-domain.md) — **perché** del modulo
- [second-brain-local-discipline](./concepts/second-brain-local-discipline.md) — stub → canon Xot
- [cursor-second-brain-max-workflow](../../../../../docs/wiki/skills/cursor-second-brain-max-workflow.md)

## QMD

```bash
bashscripts/docs/llm-wiki-qmd.sh search "TechPlanner client" -c tp-mod-techplanner-wiki -n 5 --files
```

## Struttura

| Cartella | Contenuto |
|----------|-----------|
| [concepts/](./concepts/INDEX.md) | Business logic, pattern Filament, harness |
| [entities/](./entities/INDEX.md) | Modelli core (Client, Device, Appointment) |
| [troubleshooting/](./troubleshooting/) | Runbook errori noti |
| [../](../00-index.md) | Corpus sorgente legacy (`docs/` non-wiki) |

## Scopo operativo

1. **Client** come entità centrale — anagrafica, geo, contatti, uffici legali
2. **Device / Machine** — verifiche, scadenze, relation manager su Client
3. **Appointment** — pianificazione visite, partecipanti, worker
4. **Filament admin** — risorse XotBase, widget mappa (Geo), enum in fillable

## Source layer (evidence)

- [philosophy.md](../philosophy.md)
- [models-and-relationships.md](../models-and-relationships.md)
- [filament-resources.md](../filament-resources.md)
- [using-geo-components.md](../using-geo-components.md)
