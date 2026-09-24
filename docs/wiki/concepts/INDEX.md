---
title: "TechPlanner Concepts Index"
type: index
module: TechPlanner
tags: [techplanner, concepts, index, wiki]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner concepts index business domain ai harness second brain"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ./techplanner-business-domain.md
  - ./ai-harness-techplanner-discipline.md
---

# Concepts — TechPlanner

| Pagina | Argomento |
|--------|-----------|
| [techplanner-business-domain.md](./techplanner-business-domain.md) | Dominio business (SSoT perché) |
| [ai-harness-techplanner-discipline.md](./ai-harness-techplanner-discipline.md) | Harness agenti modulo |
| [second-brain-local-discipline.md](./second-brain-local-discipline.md) | Stub → canon Xot |


## Resource schema contract

Ogni Resource concreta espone tre classi speculari nel proprio namespace: `Schemas/<Name>Form`, `Schemas/<Name>Infolist` e `Tables/<PluralName>Table`. Queste classi estendono rispettivamente `XotBaseResourceForm`, `XotBaseResourceInfolist` e `XotBaseResourceTable`; i componenti Filament sono usati nella composizione, mai come superclassi. `MailTemplateResource` mantiene così il filtro TechPlanner ma possiede il contratto UI localmente, senza dipendere dal resolver namespace di Notify.
