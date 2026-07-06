---
title: "PHPStan generics cleanup 2026-07-03"
type: concept
tags: [phpstan, generics, larastan, cleanup]
created: 2026-07-03
updated: 2026-07-03
---

# PHPStan generics cleanup 2026-07-03

Larastan level 10 richiede template espliciti per Builder, Factory e relazioni Eloquent.

Regola operativa: correggere il tipo nel punto sorgente con PHPDoc `@return` / `@param` mirati, senza modificare `phpstan.neon` e senza baseline. Per trait riutilizzabili non agganciati da modelli runtime, usare un probe minimale solo se il trait deve restare disponibile.
