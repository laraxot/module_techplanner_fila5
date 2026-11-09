---
title: "Ultimo appuntamento e tipo di intervento"
type: decision
created: 2026-11-19
updated: 2026-11-19
tags: [appointment, control, client-table, filament]
related:
  - concepts/techplanner-business-domain.md
  - ../../../../../docs/wiki/concepts/public-asset-deployment.md
---

# Ultimo appuntamento e tipo di intervento

## Problema

In `/techplanner/admin/clients` lo staff deve sapere **per cosa** si è andati
 dall'ultimo cliente: RX, elettromedicali, controllo endorale, autorizzazione
 sanitaria o altro. La sola data non basta.

## Decisione: derivare il tipo dai `controls` dell'appuntamento

Lo schema esistente già modella la verità:

- `appointments` — l'evento (data, tecnico, stato, esito); **non ha un campo
  "tipo"** e non serve inventarne uno.
- `controls.appointment_id` + `control_type` — ogni controllo eseguito durante
  l'appuntamento porta il `ControlTypeEnum` canonico
  (`rx`, `intraoral`, `health_authorization`, `electromedical`, `other`).

Quindi "per cosa era l'appuntamento" = i `control_type` distinti dei `controls`
collegati. Un appuntamento può coprire più tipi (es. RX + elettromedicale).

## Implementazione

- `Client::latestAppointment()` — `hasOne(Appointment)->latestOfMany('date')`
- `Appointment::controls()` — `hasMany(Control)`
- `ClientsTable` — colonna `last_appointment` (data + etichette tipo,
  eager-load `latestAppointment.controls` in `ListClients::getTableQuery()`)
- Filtro `last_appointment_type` — `SelectFilter` con le opzioni
  `ControlTypeEnum` + `none` (clienti mai visitati); usa `whereHas` su
  `latestAppointment` così il filtro guarda **solo l'ultimo** appuntamento,
  non lo storico.

## Note

- Se un appuntamento non ha controlli collegati la colonna mostra solo la data.
- `machines.type` è testo libero: non è una fonte affidabile per il tipo —
  non usarlo per questo scopo.
- N+1 evitato via eager loading; la relazione `latestOfMany` usa una
  sottoquery SQL, non un `MAX` applicativo.
