---
title: "Entity — Device"
type: entity
module: TechPlanner
tags: [device, machine, verification, entity]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner device machine verification entity model resource"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ./client.md
  - ../concepts/techplanner-business-domain.md
  - ../../models-and-relationships.md
---

# Device / Machine

**Model:** `Modules\TechPlanner\Models\Device` (e correlati Machine, DeviceVerification)  
**Resource:** `DeviceResource`

## Ruolo

Parco impianti/dispositivi del cliente: ispezioni, scadenze verifiche, storico `DeviceVerification`.

## Relazioni

- `belongsTo` Client
- `hasMany` DeviceVerification (relation manager dedicato)

## Filament

- CRUD Device + RM verifiche su Client e su Device
- View page per dettaglio dispositivo

## Note agente

Non confondere con moduli infrastrutturali: il **business** del device (scadenze, conformità cliente) vive qui; Geo fornisce solo componenti mappa se necessari.
