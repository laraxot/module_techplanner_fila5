---
title: "AI harness — modulo TechPlanner"
type: concept
module: TechPlanner
tags: [techplanner, ai, harness, client, device, filament, geo]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner module ai harness client device appointment filament geo enum"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/9"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/10"
related:
  - ./techplanner-business-domain.md
  - ../../../../../../docs/wiki/concepts/llm-wiki-operational-discipline.md
  - ../../../../../../docs/wiki/skills/cursor-second-brain-max-workflow.md
  - ../../using-geo-components.md
---

# AI harness — TechPlanner

Allineato a [llm-wiki-operational-discipline](../../../../../../docs/wiki/concepts/llm-wiki-operational-discipline.md) per il **modulo dominio**.

## Scope agente

- `ClientResource` e relation managers (devices, appointments, legal, medical)
- `DeviceResource`, `AppointmentResource`, enum fillable
- Widget mappa / coordinate (confine Geo)
- Test Pest in `Modules/TechPlanner/tests/`

## Prima di editare

```bash
bashscripts/docs/llm-wiki-qmd.sh search "TechPlanner <topic>" -c tp-mod-techplanner-wiki -n 5 --files
```

## Regole locali

| Area | Canon |
|------|-------|
| Dominio | [techplanner-business-domain.md](./techplanner-business-domain.md) |
| Modelli | [entities/](../entities/INDEX.md) |
| Enum fillable | `docs/model-fillable-enum-pattern.md` |
| Geo / mappa | `docs/using-geo-components.md` |
| Filament | `docs/filament-resources.md` |
| PHP post-edit | PHPStan L10 su `laravel/Modules/TechPlanner/` |

## Prima di ogni `.md` wiki (obbligatorio)

1. `git remote -v` sul repo owner (`laravel/Modules/TechPlanner` → `module_techplanner_fila5`; se 404 su GitHub → monorepo `base_techplanner_fila5`)
2. `gh issue list --search "<argomento file>"` — se vuoto → `gh issue create`
3. Discussion pertinente → crea o riusa thread esistente (`gh api graphql` se serve)
4. Inserisci URL **completi** in `issues:` e `discussions:` nel frontmatter **prima** di considerare il file finito
5. `bashscripts/tools/validate-wiki-frontmatter.sh <file.md>`

Regola canon: [wiki-markdown-frontmatter-mandatory.md](../../../../../../docs/wiki/rules/wiki-markdown-frontmatter-mandatory.md) · Issue [#11](https://github.com/laraxot/base_techplanner_fila5/issues/11)
