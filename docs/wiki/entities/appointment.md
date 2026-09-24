---
title: "Entity — Appointment"
type: entity
module: TechPlanner
tags: [appointment, planning, participant, worker, entity]
created: 2026-06-06
updated: 2026-06-06
qmd: "techplanner appointment entity planning visit participant worker"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/7"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/8"
related:
  - ./client.md
  - ../concepts/techplanner-business-domain.md
  - ../../filament-resources/appointment-resource.md
---

# Appointment

**Model:** `Modules\TechPlanner\Models\Appointment`  
**Resource:** `AppointmentResource`  
**Correlati:** Participant, Worker, Event

## Ruolo

Pianificazione visite e interventi sul cliente: collegamento temporale tra client, worker e partecipanti.

## Relazioni

- `belongsTo` Client
- Collegamenti a Participant / Worker per squadra sul campo

## Filament

- List, Create, Edit
- Relation manager Appointments su ClientResource

## Source

Dettaglio implementazione: [appointment-resource.md](../../filament-resources/appointment-resource.md)
