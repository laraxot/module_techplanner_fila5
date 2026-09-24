---
title: "Standing — frontmatter GitHub modulo TechPlanner"
type: memory
module: TechPlanner
tags: [frontmatter, github, standing, techplanner, wiki]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner wiki frontmatter github issues discussions mandatory standing memory"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/11"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/12"
related:
  - ../../../../../../docs/wiki/memories/frontmatter-github-links-mandatory-standing.md
  - ../concepts/ai-harness-techplanner-discipline.md
---

# Standing modulo — issues + discussions su ogni .md

Stub locale → canon root: [frontmatter-github-links-mandatory-standing.md](../../../../../../docs/wiki/memories/frontmatter-github-links-mandatory-standing.md).

Repo modulo `module_techplanner_fila5` non ancora su GitHub: usare monorepo `base_techplanner_fila5` fino a pubblicazione remote.

## Checklist obbligatoria (ogni `.md` wiki TechPlanner)

1. `cd laravel/Modules/TechPlanner && git remote -v` → target `laraxot/module_techplanner_fila5` (issue su monorepo finché 404)
2. `gh issue list --repo laraxot/base_techplanner_fila5 --search "<topic del file>"`
3. Se assente → `gh issue create` + discussion collegata
4. Frontmatter: `issues:` e `discussions:` con URL **numerati** sull'**stesso argomento**
5. Sezione body `## GitHub (tracciamento)` con tabella link (SSoT dominio: issue [#7](https://github.com/laraxot/base_techplanner_fila5/issues/7), discussion [#8](https://github.com/laraxot/base_techplanner_fila5/discussions/8))
6. `bashscripts/tools/validate-wiki-frontmatter.sh <file.md>`
