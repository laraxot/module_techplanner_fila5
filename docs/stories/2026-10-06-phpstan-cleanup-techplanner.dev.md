---
title: "[DEV] PHPStan cleanup — TechPlanner"
type: dev
module: TechPlanner
story: "./2026-10-06-phpstan-cleanup-techplanner.story.md"
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, techplanner]
---

# [DEV] PHPStan cleanup — TechPlanner

## Technical Plan

- Non implementare una mappatura inventata: il commento nel codice referenzia modelli inesistenti
- Rendere onesto il comportamento e usare i dati letti

## Files to Modify

- `app/Console/Commands/ImportAccessDataCommand.php`
- `docs/testing/coverage.md` (le due voci `UnusedLocalVariable` sono ora risolte), `docs/00-index.md` (write-back)

## Implementation Steps

- [x] Letto il comando, la storia git (`1b3b708`), i modelli `Client`/`Device`, gli importer Filament e `AnalyzeMdbCommand`
- [x] Usate le righe lette (info con il conteggio)
- [x] Sostituito il messaggio finale con un avviso
- [x] `escapeshellarg()` per il percorso
- [x] PHPStan + `php -l`

## Testing

Test eseguiti: nessuno (il comando richiede `mdb-export` e un file `.mdb`; non esistono test per questo comando).

## Verification

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Tenant Modules/Activity Modules/Media Modules/AI Modules/UI Modules/Job Modules/Gdpr Modules/TechPlanner Modules/Seo --memory-limit=-1 --no-progress
php -l <file toccati>

```

Esito: 0 errori sui 9 moduli del gruppo (anche con run completo `./vendor/bin/phpstan analyse` senza argomenti).

## Lessons Learned

- Un risultato calcolato e scartato in un comando 'import' indica che l'import non e' stato scritto: l'uscita ('completed successfully') deve riflettere la realta'.
- Rinominare la variabile in `$_x` e' un fix cosmetico: non lo si e' mantenuto.
- Quando un commento rimanda a modelli rinominati (`Cliente` -> `Client`), il codice commentato non e' piu' una specifica: serve lo schema sorgente per completare.
- I percorsi passati a `shell_exec` vanno sempre quotati con `escapeshellarg()`.
