---
title: "TechPlanner, passata UX mobile (clienti, appuntamenti, dispositivi, chiamate)"
type: story
module: TechPlanner
status: done
created: 2026-10-28
updated: 2026-10-28
tags: [bmad, mobile, ux, filament, tables, forms]
qmd: "techplanner mobile ux clienti appuntamenti dispositivi tabelle card visibleFrom toggleable duration integer"
related:
  - ../../../UI/docs/bmad/filament-blueprint.md
  - ../../../UI/docs/table-layout-toggle.md
  - ../../../UI/docs/stories/mobile-ux-pass.story.md
---

# TechPlanner, passata UX mobile

## Richiesta

Il tecnico sul campo usa clienti, appuntamenti e dispositivi dal telefono (360-430 px, una mano, rete lenta). Nessuna schermata di questi flussi deve essere scomoda o rotta.

## Cosa si e' scoperto prima di toccare qualcosa

| Fatto | Evidenza | Conseguenza |
|-------|----------|-------------|
| `Section::columns(2)` e `columns(3)` (`CompanySection`, `AddressSection`, `ContactSection`) collassano gia' a 1 colonna sotto 1024 px | `vendor/filament/schemas/src/Concerns/HasColumns.php:19-25`: un intero diventa `['lg' => n]` | Nessuna modifica ai form del cliente: l'ipotesi "3 colonne a 360 px" era sbagliata. |
| Il pannello non ha un tema Tailwind: le utility nelle viste Blade del modulo sono inerti | `public_html/css/filament/filament/app.css` contiene solo `fi-*` (zero `.w-full`, `.hidden`, `.flex-col`); commento in `Modules/Xot/app/Providers/Filament/AdminPanelProvider.php:30` | Le viste del modulo che le usano (`coordinates-widget.blade.php`: `grid-cols-2`, `x-filament::card`) non sono rinforzabili con altre utility. Tutte raggiungibili dal tecnico sono pero' componenti Filament nativi (tabelle, form, infolist). |
| Le righe di tabella diventano card sotto 640 px, una riga per colonna visibile | `Modules/Xot/app/Filament/Traits/HasXotTable.php` (`->stackedOnMobile()`), altro agente | Il lavoro utile e' accorciare la card: poche colonne, quelle che servono a decidere. |
| I bersagli di tocco delle azioni di riga sono gia' portati a 44 px | `Modules/Xot/resources/css/mobile-touch-targets.css` | Non toccato (chrome condiviso). |
| `DatePicker`/`DateTimePicker` sono nativi di default (selettore del telefono) | `vendor/filament/forms/src/Components/Concerns/CanBeNative.php:9` | Nessuna modifica. |

## Difetti reali e correzioni

| # | Difetto (flusso) | Dove (prima della modifica) | Correzione |
|---|------------------|------------------------------|------------|
| 1 | **Dispositivi**: la colonna "Cliente" mostrava il numero grezzo `client_id` ("Cliente: 17"), inutile per sapere di chi e' l'apparecchio | `Tables/DevicesTable.php:20` | Colonna `client.company_name` (label `techplanner::device.fields.client_id.label`, "Cliente"), ordinabile e ricercabile per nome. Aggiunta l'etichetta `client_id` in `lang/en/device.php` (mancava). |
| 2 | **Dispositivi**: 11 righe per card (id, kV, mA, note...) | `Tables/DevicesTable.php:19-30` | `id` nascosto di default (riattivabile dal selettore colonne); `kv`, `ma`, `notes` con `visibleFrom('md')`. Restano cliente, tipo, marca, modello, matricole, prima verifica. |
| 3 | **Appuntamenti**: 6 colonne con id e date di sistema sempre visibili; solo cliente e data servono per aprirne uno | `Tables/AppointmentsTable.php:19,22-24` | `id`, `created_at`, `updated_at` nascosti di default (toggle); `notes` con `visibleFrom('md')`. |
| 4 | **Clienti**: "attivita'" merceologica come riga lunga (`wrap`) nella card, prima di indirizzo e contatti, che sono cio' che serve per navigare/chiamare | `Tables/ClientsTable.php:29-32` | `->visibleFrom('md')`. |
| 5 | **Sedi legali / Direttori sanitari** (relation manager del cliente): id e date di sistema sempre visibili; provincia/paese nelle sedi | `LegalOfficesTable.php:19,22-27`, `MedicalDirectorsTable.php:19,23-24` | id/date di sistema nascosti di default; provincia e paese `visibleFrom('md')`. |
| 6 | **Chiamate**: la durata (colonna `integer`, in secondi) era un `TextInput` libero: su telefono compare la tastiera alfabetica e un "3 min" rompe il salvataggio | `Schemas/PhoneCallForm.php:24` | `->integer()->minValue(0)`: tastierino numerico (`inputmode=numeric`), validazione client e server. |
| 7 | **Dispositivi** (form): matricole e modello ricevono i suggerimenti di autofill del browser (pensati per nomi/indirizzi) sopra il campo | `Schemas/DeviceForm.php:28-30` | `->autocomplete(false)` su `model`, `headset_serial`, `tube_serial`. |

## Cosa NON e' stato fatto, e perche'

| Tema | Motivo / decisione che spetta all'utente |
|------|-------------------------------------------|
| Tipo `tel`/`email` e `autocomplete` sui campi telefono/email del cliente | I campi vengono da `Modules/Notify/app/Enums/ContactTypeEnum.php` e `Modules/Geo/app/Enums/AddressItemEnum.php` (non hanno `->tel()`, `->email()`, `autocomplete`). Fuori ambito: serve una story in Notify/Geo. |
| Ordinamento/filtro "da oggi" per gli appuntamenti | E' una scelta di prodotto: `date` desc mostra prima i futuri piu' lontani, `asc` i passati piu' vecchi. Servirebbe un filtro "prossimi" (default), da decidere. |
| Nuovo appuntamento da `AppointmentResource` senza cliente | `Schemas/AppointmentForm.php` non ha il campo `client_id` (solo data e note): dalla risorsa non si puo' assegnare un cliente; si crea dal relation manager del cliente. Decidere se aggiungere il `Select` cliente. |
| `Pages/ListClients.php` azione "Ordina per distanza": etichetta e notifiche hardcoded | Preesistente e non di layout; nella card mobile sta gia' su una riga propria. |
| `populateCoordinates` (geocodifica di tutti i clienti in una richiesta web) | Operazione da amministratore, non da telefono. Rischio di timeout: andrebbe in una coda. Non toccata. |
| Widget mappa (`MapWidget`, `ClientMapWidget`, `CoordinatesWidget`) e viste `client-map`, `map`, `coordinates-widget` | Non montati (`ListClients.php:49` commentato, nessun riferimento): nessun utente li vede. Hanno utility inerti e mappa a 400 px fissi: da riscrivere se rimontati. |
| Tabelle `LegalRepresentative`, `MailTemplate` | Gestione amministrativa, non flusso da campo; non modificate. |
| Toggle griglia/lista, touch target delle azioni, chrome | Modules/UI e Modules/Xot (altri agenti). |

## Verifica

- `php -l` sui PHP modificati: nessun errore.
- PHPStan (`Modules/Employee Modules/TechPlanner`, max, config del repo): 0 errori.
- Nessun test Pest/artisan/migrate eseguito (DB `*_test` assente, dati sacri); nessuna richiesta POST al server di sviluppo.
- **Non verificato a occhio**: il rendering a 360/390/430 px richiede il login e non e' stato fatto. Da controllare: lista dispositivi (nome cliente, card corta), lista appuntamenti, lista clienti, form chiamata (tastierino su `durata`).
- Frontmatter: `python3 -I bashscripts/tools/docs/frontmatter-check.py check` sui file di questa story.
