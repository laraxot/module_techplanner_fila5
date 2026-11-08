---
title: "Client coordinate editing UX"
type: decision
module: TechPlanner
tags: [client, coordinates, geocoding, filament, ux]
updated: 2026-11-07
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ../entities/client.md
  - ../../stories/clients-distance-sort.story.md
  - ../../using-geo-components.md
---

# Client coordinate editing UX

Le coordinate appartengono a una sotto-sezione **annidata dentro la sezione
Indirizzo** del form Client (accorpamento voluto: l'indirizzo è la fonte da cui
si derivano). `ClientCoordinatesSection` (basata su `XotBaseSection`) viene
iniettata in `AddressSection` tramite `extraComponents()`, un hook opzionale
aggiunto al componente Geo condiviso. Contatti e note restano in sezioni
separate. Questo rende esplicito che sono dati derivati, utilizzati per
ordinamento per distanza e mappa.

## Contratto operativo

1. L'operatore completa o corregge l'indirizzo.
2. Salva il record, così il geocoder usa l'indirizzo persistito.
3. Nell'area **Coordinate** preme **Aggiorna da indirizzo**.
4. L'azione aggiorna latitudine e longitudine insieme, mostra una notifica e
   lascia i campi modificabili per correzioni manuali entro i rispettivi range.

La logica di geocoding resta in
`Modules\\Geo\\Actions\\UpdateCoordinatesFromAddressAction`. Il salvataggio del
form non viene eseguito implicitamente dall'azione, evitando di persistere altri
campi modificati accidentalmente.

La mappa sotto la sezione è uno stato di sola lettura delle coordinate salvate e
offre collegamenti a Google Maps e ViaMichelin. Se le coordinate mancano mostra
un'istruzione di recupero invece di una mappa vuota.
