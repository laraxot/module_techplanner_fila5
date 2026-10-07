---
title: "[STORY] PHPStan cleanup — TechPlanner"
type: story
module: TechPlanner
status: done
priority: medium
created: 2026-10-06
updated: 2026-10-06
tags: [phpstan, cleanup, bmad, techplanner]
---

# [STORY] PHPStan cleanup — TechPlanner

## User Request

«sistema tutte le segnalazioni di phpstan [...] concentrati sullo scopo/funzionalità, non sull'errore; aumenta la qualità del codice; usa enum al posto delle costanti».

Perimetro: segnalazioni PHPStan (level max) del modulo TechPlanner. Errori di partenza: 2 `variable.unused` in `ImportAccessDataCommand` (`$clientiRows`, `$apparecchiRows`).

## Analysis

**Scopo del codice.** `techplanner:import-access-data {mdbPath}` doveva importare in TechPlanner i dati di un database Access (`.mdb`): esporta le tabelle `Clienti` e
`Apparecchi` con `mdb-export` e poi, per ogni riga CSV, creare i record. La parte di creazione e' **solo commentata** (riferita a `Cliente`/`Apparecchio`, modelli che oggi si chiamano
`Client`/`Device`, con schema e campi diversi), mentre il comando stampava comunque 'Import completed successfully!'. Le righe esportate venivano calcolate e scartate:
e' esattamente il caso di 'calcolato e mai usato = logica mancante'.

Cosa e' stato fatto (senza inventare la mappatura, che richiede lo schema Access `Sorvegli01.mdb` non presente nel repository e scritture DB che non sono state richieste):
- le righe esportate sono ora usate: il comando riporta quante righe ha letto per tabella;
- il messaggio finale non dichiara piu' un import riuscito: avvisa che la mappatura Access -> `Client`/`Device` non e' implementata e nessun record e' stato scritto;
- `mdb-export` riceve il percorso con `escapeshellarg()` (prima `'{$mdbPath}'`: un apice nel nome rompeva il quoting);
- nel working tree le variabili erano gia' state rinominate `$_clientiRows`/`$_apparecchiRows` (zittisce PHPStan ma lascia il problema): ripristinato il nome e introdotto l'uso.

**Decisione richiesta all'utente:** completare l'import (serve la mappatura colonne Access -> `Client`/`Device`/`Address`) oppure ritirare il comando.
Esistono gia' `app/Filament/Imports/ClientImporter.php` e `DeviceImporter.php` (import CSV da Filament) che potrebbero coprire lo stesso bisogno.

## Acceptance Criteria

- [x] Le righe esportate da `mdb-export` sono usate (conteggio per tabella)
- [x] Il comando non dichiara un import completato quando non scrive nulla
- [x] Percorso del file passato a `mdb-export` con `escapeshellarg()`
- [x] PHPStan: 0 errori sul modulo TechPlanner (run per path e run completo)

## GitHub (tracciamento)

- Issue: TODO (gh non installato su questa macchina)
- Discussion: TODO

Dev story: [2026-10-06-phpstan-cleanup-techplanner.dev.md](./2026-10-06-phpstan-cleanup-techplanner.dev.md)
