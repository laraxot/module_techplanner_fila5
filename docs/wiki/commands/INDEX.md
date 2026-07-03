---
title: "Commands Index — TechPlanner"
type: index
module: TechPlanner
tags: [techplanner, commands, index, qmd, phpstan, pest]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner commands index qmd search phpstan pest test"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/9"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/10"
related:
  - ../concepts/ai-harness-techplanner-discipline.md
---

# Commands — TechPlanner

```bash
bashscripts/docs/llm-wiki-qmd.sh search "TechPlanner" -c tp-mod-techplanner-wiki -n 5 --files
cd laravel && ./vendor/bin/phpstan analyse --memory-limit=-1          # tutti i moduli (gate)
cd laravel && ./vendor/bin/phpstan analyse Modules/TechPlanner --memory-limit=-1
php artisan test --filter=TechPlanner
```

Gate qualità: vedi [phpstan-modules-zero-2026-06-06.md](../../../../../../docs/wiki/memories/phpstan-modules-zero-2026-06-06.md)
