---
title: "[STORY] TechPlanner - verifiche periodiche degli apparecchi salvabili e corrette (P1)"
type: story
status: review
priority: high
created: 2026-11-05
updated: 2026-11-05
module: TechPlanner
tags: [bmad, techplanner, device, verification, migration, filament, relation-manager]
qmd: "techplanner device_verifications verifications relation manager machines foreign key exposure_parameters needs_verification latest_verification appointment phone call client_id"
related:
  - ../../app/Models/DeviceVerification.php
  - ../../app/Models/Device.php
  - ../../app/Filament/Resources/DeviceResource/RelationManagers/DeviceVerificationsRelationManager.php
  - ../../database/migrations/2026_11_05_220010_create_device_verifications_table.php
  - ../../tests/Feature/DeviceVerificationTest.php
---

# TechPlanner - verifiche periodiche degli apparecchi

## Scopo

Registrare le verifiche degli apparecchi radiologici è il cuore del prodotto: dalla data della prossima verifica
dipende quando tornare dal cliente. Prima di questa story nessuna verifica poteva essere salvata dal pannello.
Corrisponde al finding TPL-02 dell'audit del 2026-10-29 (report riservato in `bashscripts/docs/audit/`).

## Difetti trovati (verificati nel codice, 2026-11-05)

| # | Dove | Difetto | Effetto |
|---|---|---|---|
| 1 | `DeviceVerificationsRelationManager` | `$relationship = 'deviceVerifications'`, ma `Device` definisce `verifications()` | La scheda Verifiche dell'apparecchio va in errore |
| 2 | migrazione | `exposure_parameters` NOT NULL senza campo nel form | L'insert fallisce |
| 3 | `DeviceVerification::$fillable` | `status` (colonna inesistente); mancavano data prossima verifica, esito, tipo, note | Campi persi in silenzio |
| 4 | form del relation manager | `verification_result`, `verifier_name`, `verifier_company` non esistono nella tabella | Errore SQL al salvataggio |
| 5 | `Device::getLatestVerificationAttribute` | `latest()` ordina per `created_at`; due query identiche | Una verifica vecchia inserita dopo diventava «l'ultima» |
| 6 | `AppointmentForm`, `PhoneCallForm` | Nessun campo cliente fuori dalla scheda del cliente; `PhoneCall` senza relazione `client()` | Dal menu si creavano appuntamenti e chiamate orfani |
| 7 | `AppointmentsTable` | Colonna `client.name`, vuota per i clienti importati (hanno `company_name`) | Elenco appuntamenti senza cliente leggibile |

## Soluzione

- Modello `DeviceVerification`: `$fillable` = colonne reali, cast `date`, relazione `device()`.
- `Device`: ultima verifica per `verification_date` (poi `id`), una query; `needs_verification` tipizzato.
- Relation manager: relazione `verifications`, campi = colonne, `next_verification_date >= verification_date`,
  ordinamento predefinito per data decrescente.
- Migrazione (stesso file, regola «1 modello = 1 migrazione»): `tableCreate` usa `foreignIdFor(Device::class)` verso
  la tabella del modello (`machines`, letta da `Device::getTable()`); `tableUpdate` rende `exposure_parameters`
  facoltativo. Non cancella né riscrive righe.

**Correzione di percorso (2026-11-05).** La prima analisi indicava come difetto la FK `device_id → machines`. Il test
ha mostrato che `Device` usa proprio la tabella `machines` (`$table = 'machines'`, condivisa con `Machine extends
Device`): la FK era corretta. Il blocco che la «riparava» è stato tolto prima di qualsiasi commit.
- Appuntamenti e chiamate: `Select` del cliente (ragione sociale, ricerca), nascosto dentro i relation manager del
  cliente; `PhoneCall::client()`; colonne `client.company_name` negli elenchi.

## Rischi e decisioni

- **`->change()` in produzione.** Rendere nullable `exposure_parameters` modifica la colonna: va provato su una copia
  del DB reale prima del rilascio. Nessun dato viene toccato.
- Non toccati (fuori ambito, censiti nell'audit): `VerificheRelationManager` e
  `Filament/Resources/RelationManagers/DeviceVerificationsRelationManager.php` (duplicati non registrati),
  `Filament/Resources/Pages/*Device*.php` (duplicati), assenza di policy (TPL-04), cancellazione a cascata (TPL-03).

## Criteri di accettazione

- [x] Una verifica con data, prossima data, tipo, esito, parametri e note si salva e si rilegge (test).
- [x] Installazione nuova: FK `device_id` → tabella di `Device` (`machines`) (test).
- [x] Installazione esistente con `exposure_parameters` NOT NULL: diventa facoltativo, la verifica si salva (test).
- [x] `needs_verification` vero senza verifiche o con prossima data passata, falso altrimenti (test).
- [x] L'ultima verifica è quella con la data più recente, non l'ultima inserita (test).
- [x] Il relation manager punta a una relazione esistente (test).
- [x] Appuntamenti e chiamate hanno la relazione `client` (test).
- [ ] Prova nel pannello su un ambiente con DB reale (da fare).
- [ ] `migrate` provato su una copia del DB di produzione (da fare, utente).

## Verifiche eseguite (2026-11-05, PHP 8.4.27, SQLite in memoria)

- Pest `Modules/TechPlanner/tests`: 48 passati. I 12 test nuovi sul codice originale: 9 falliti, 3 passati.
- PHPStan livello max sui 14 file toccati: 0 errori (esclusi i `method.internalClass` di Pest, comuni a tutti i test).
- Pint applicato. Dettagli e limiti dell'ambiente: `docs/audit/TEST_RESULTS.md` nella root del repo.
