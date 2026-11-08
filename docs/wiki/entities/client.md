---
title: "Entity — Client"
type: entity
module: TechPlanner
tags: [client, entity, geo, filament, core]
created: 2026-06-06
updated: 2026-11-06
qmd: "techplanner client entity model filament resource relation manager geo coordinates"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ../concepts/techplanner-business-domain.md
  - ./device.md
  - ./appointment.md
  - ../audits/module-techplanner-audit.md
  - ../../stories/mobile-ux-pass.story.md
  - ../../stories/clients-distance-sort.story.md
  - ../../models-and-relationships.md
  - ../concepts/client-coordinate-editing-ux.md
---

# Client

**Model:** `Modules\TechPlanner\Models\Client`  
**Resource:** `ClientResource` — hub Filament del modulo.

## Ruolo

Entità centrale: anagrafica aziendale, contatti, coordinate, assegnazione worker, stato operativo (`business_closed`).

## Relazioni principali

- `hasMany` Device, Control, Appointment, LegalRepresentative, MedicalDirector, LegalOffice, PhoneCall
- BelongsTo Worker (assegnazione)

## Filament

- Pagine: List, Create, Edit, View
- Relation managers: Devices, Appointments, LegalRepresentatives, MedicalDirectors, LegalOffices, PhoneCalls
- Widget mappa: integrazione Geo (vedi `using-geo-components.md`)
- Nel form, `AddressSection` contiene solo dati geografici/indirizzo; telefono,
  cellulare, fax, PEC, WhatsApp ed email sono raccolti da `ContactSection`.

## Campi critici

Identità fiscale (VAT, fiscal_code), indirizzo + lat/lng, PEC, `assigned_worker_id`, note amministrative.

Dettaglio schema: [models-and-relationships.md](../../models-and-relationships.md)

## Caso d'uso: distanza dei clienti

La distanza serve al tecnico per ordinare i clienti in base alla prossimità
rispetto a un punto di partenza (per esempio la posizione operativa corrente),
così da pianificare visite e trasferte. Non è una relazione Eloquent e non è un
campo persistito: è un attributo calcolato dalla query quando vengono fornite
coordinate valide.

### Contratto corrente

- `Client` usa `Modules\Geo\Models\Traits\GeoTrait` e conserva `latitude` e
  `longitude` come coordinate del cliente.
- `GeoTrait::scopeWithDistance($lat, $lng)` aggiunge l'alias SQL `distance` e
  ordina il risultato; coordinate non finite o fuori intervallo lasciano la
  query invariata.
- `GeoTrait::getDistanceAttribute()` espone l'alias come `float|null`. Questo
  accessor è obbligatorio perché un accesso a `$client->distance` senza alias
  SQL farebbe interpretare `distance()` come una relazione Eloquent.
- `ListClients` applica lo scope solo dopo che il punto di partenza è stato
  validato e salvato in sessione; il widget coordinate comunica l'evento di
  riordinamento.
- `ClientsTable` visualizza la distanza in chilometri con due decimali;
  `width('5rem')` + `whitespace-nowrap` ne limitano l'ingombro e i valori non
  numerici mostrano il placeholder `—` invece di `0.00 km`.
- `ClientMapWidget` (header di `ListClients`) mostra un marker Leaflet per
  cliente con coordinate (max 500, OSM, niente API key); il popup riporta
  nome/indirizzo/telefono, link a view/edit e il pulsante "Usa come origine"
  che fissa il punto di riferimento distanza. Il punto di riferimento corrente
  è segnato sulla mappa con un marker dedicato.
- L'inizializzazione Leaflet è idempotente e tollera il rendering lazy di
  Filament/Livewire: lo stato è namespaced, lo script condiviso viene atteso,
  e `invalidateSize()` viene richiamato dopo il rendering e al resize.
- `ClientsTable` espone anche l'azione record "Usa come punto di partenza"
  (icon-button, solo icona + tooltip); `CoordinatesWidget` permette di
  digitare lat/lng e l'header action "Aggiorna Coordinate" geocodifica tutte
  le coordinate mancanti. Tutti e tre i percorsi confluiscono in
  `user_latitude`/`user_longitude` di sessione + cookie 30 gg.
- Se il cliente non ha coordinate, sia l'azione tabella sia il pulsante popup
  mappa tentano prima `UpdateCoordinatesFromAddressAction` (geocoding
  dell'indirizzo); solo se il geocoding fallisce mostrano il warning, con
  suggerimento all'azione batch.
- Il form di modifica mostra una mappa focalizzata sul singolo cliente quando
  le coordinate esistono e offre link esterni espliciti a Google Maps e
  ViaMichelin; senza coordinate mostra istruzioni per completare l'indirizzo
  e usare l'azione di aggiornamento massivo.

## Ultimo controllo per cliente

La lista proietta con subquery correlate le date massime dei controlli associati
al cliente (solo record con `client_id` valorizzato) presenti
in `controls`: `last_rx_control_date` (RX),
`last_intraoral_control_date` (controllo endorale),
`last_electromedical_control_date` e `last_health_authorization_date`.
Le colonne sono ordinabili e mostrano `—` quando il cliente non ha ancora una
verifica di quel tipo. Il filtro RX comprende i tipi `rx` e `intraoral`, mentre
elettromedicale e autorizzazione sanitaria hanno filtri separati. I filtri
ternari usano `whereHas`/`whereDoesntHave` e non gli alias SQL, così restano
corretti anche con paginazione e filtri combinati.

### Dati mancanti e stato di affidabilità

Un cliente senza una delle due coordinate non ha una distanza calcolabile e
non compare come marker sulla mappa. La cella `distance` mostra `—` per i
valori nulli. Il fattore `1.1515` (miglia) è stato rimosso da
`GeoTrait::scopeWithDistance()`: la colonna `km` ora coincide con il valore
SQL in chilometri (audit TPL-018 parzialmente chiuso).

Il geocoding degli indirizzi e l'ordinamento per distanza sono responsabilità
distinte: Geo fornisce coordinate, scope e primitive geografiche; TechPlanner
coordina il flusso Filament dei clienti. Il geocoding massivo non deve essere
eseguito sincronicamente nella richiesta della lista.

### Verifica e riferimenti

- Implementazione: `Modules/TechPlanner/app/Models/Client.php`,
  `ClientResource/Pages/ListClients.php` e `ClientResource/Tables/ClientsTable.php`.
- Primitive Geo: `Modules/Geo/app/Models/Traits/GeoTrait.php`.
- Problemi aperti e priorità: [audit del modulo](../audits/module-techplanner-audit.md),
  in particolare TPL-017 e TPL-018.
- Il pass UX mobile documenta esplicitamente che l'ordinamento per distanza è
  preesistente e non è stato chiuso dalla passata mobile:
  [mobile-ux-pass.story.md](../../stories/mobile-ux-pass.story.md).
