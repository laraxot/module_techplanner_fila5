---
title: "Entity — Client"
type: entity
module: TechPlanner
tags: [client, entity, geo, filament, core]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner client entity model filament resource relation manager geo coordinates"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ../concepts/techplanner-business-domain.md
  - ./device.md
  - ./appointment.md
  - ../../models-and-relationships.md
---

# Client

**Model:** `Modules\TechPlanner\Models\Client`  
**Resource:** `ClientResource` — hub Filament del modulo.

## Ruolo

Entità centrale: anagrafica aziendale, contatti, coordinate, assegnazione worker, stato operativo (`business_closed`).

## Relazioni principali

- `hasMany` Device, Appointment, LegalRepresentative, MedicalDirector, LegalOffice, PhoneCall
- BelongsTo Worker (assegnazione)

## Filament

- Pagine: List, Create, Edit, View
- Relation managers: Devices, Appointments, LegalRepresentatives, MedicalDirectors, LegalOffices, PhoneCalls
- Widget mappa: integrazione Geo (vedi `using-geo-components.md`)

## Campi critici

Identità fiscale (VAT, fiscal_code), indirizzo + lat/lng, PEC, `assigned_worker_id`, note amministrative.

Dettaglio schema: [models-and-relationships.md](../../models-and-relationships.md)
