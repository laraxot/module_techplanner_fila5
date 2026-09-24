---
title: "Repo indipendente TechPlanner — tracking upstream"
type: how-to
module: TechPlanner
tags: [git, gitmodules, remote, upstream, forward-only]
created: 2026-07-24
updated: 2026-07-24
qmd: "TechPlanner git remote laraxot/dev upstream gitmodules.ini"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/42"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/43"
related:
  - ./README.md
  - ../../../../bashscripts/tools/prompts/17-gitmodules-path-iteration.md
  - ../../../../docs/chat/gitmodules-multi-repo-sync.md
---

# Repo indipendente TechPlanner

## Perché

Il path `laravel/Modules/TechPlanner` è elencato in `gitmodules.ini` ma **non** è un submodule Git della root: è una repo a sé (`laraxot/module_techplanner_fila5`). Senza upstream tracking, `ahead/behind` non è leggibile e il sync multi-agente fallisce silenziosamente.

## Stato (sessione 17)

| Campo | Valore |
|-------|--------|
| Remote | `laraxot` → `git@github.com:laraxot/module_techplanner_fila5.git` |
| Branch | `dev` |
| Upstream | `laraxot/dev` (impostato se mancava) |
| Working tree | clean |

## Comandi

```bash
cd laravel/Modules/TechPlanner
git remote -v
git status -sb
git branch -u laraxot/dev   # solo se manca upstream; non creare branch nuovi
```

## Canon

- Prompt: [17-gitmodules-path-iteration.md](../../../../bashscripts/tools/prompts/17-gitmodules-path-iteration.md)
- Coordinamento: [gitmodules-multi-repo-sync.md](../../../../docs/chat/gitmodules-multi-repo-sync.md)
