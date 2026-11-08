---
title: "Appointment conflict detection (double-booking guard)"
type: story
status: done
owner: TechPlanner
created: 2026-11-19
---

# Appointment conflict detection

## Why

Un tecnico non può essere in due posti contemporaneamente: la prenotazione
doppia nella stessa fascia oraria è il difetto più costoso per unFSM
(service companies). I concorrenti (Jobber, Housecall Pro, ServiceTitan)
tutti hanno conflict warning in agenda.

## What

- `appointments.duration_minutes` (default 60) — la fascia oraria occupata.
- `Appointment::endAt()` — `date + duration_minutes`.
- `CheckAppointmentConflictAction` (QueueableAction): overlap half-open
  `[start, end)`, esclude stati terminali (completed/cancelled/no_show),
  esclude l'appuntamento in modifica. Portabile sqlite/MySQL ( niente
  `DATE_ADD`: filtro PHP su candidati finestra).
- `AppointmentForm`: campo `duration_minutes` + regola di conflitto su
  `worker_id`, `date`, `duration_minutes` (si rivalida quando cambia
  qualsiasi input della fascia).
- Colonna/entry `duration_minutes` in tabella e infolist (suffisso tradotto).
- i18n `appointment.fields.duration_minutes` + `appointment.validation.conflict`
  in it/en/de (es: fallback, file appointment.php assente in es).

## Verification

- `CheckAppointmentConflictActionTest`: 6 casi (vuoto, overlap, adiacenza
  boundary, altro worker, stati terminali, exclude self) — verdi.
- TechPlanner Unit: 47 passati, 0 falliti.
- PHPStan 0 errori, Pint applicato, migration eseguita in locale.

## Non fatto / limite

- Il controllo è a livello form (validazione): insert da seed/import non è
  coperto. Se serve, spostare in un observer `saving`.
- Nessun buffer/trasferimento tra appuntamenti (gap successivo).
- Timezone: `date` è naive datetime; se i tenant cross-timezone servono,
  valutare `datetimez`/timezone per tenant.
