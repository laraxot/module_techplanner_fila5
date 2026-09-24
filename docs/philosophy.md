# TechPlanner Module: Core Domain

> **Technical Scheduling App** — Appointments, device tracking, client management, verification workflow.

---

## Zen

**"Appointments are sovereign. Devices are assets. Clients are the why."**

This is the main business domain (not framework).

---

## Quick

### Models (15)
- **Appointment** — Scheduled visit (client, device, date, status: pending/confirmed/completed)
- **Client** — Customer (contact info, address, coordinates)
- **Device** — Hardware (type, serial, model, location, owner)
- **DeviceVerification** — 2FA-like verification (token, expiry)
- **Company** — Org unit (address, service area)

### Pattern
```
Client requests service
  ↓
Create Appointment
  ↓
Assign Device to verify/repair
  ↓
Schedule Technician visit
  ↓
Verify Device on-site
  ↓
Mark Appointment completed
```

### Actions (1)
- `UpdateAllClientCoordinatesAction` — Batch geocode addresses (Geo integration)

### Forms (1)
- `CompanySection` — Company details editor

---

## Integrations

- **Geo** — Client addresses, location-based queries, distance calculation
- **Employee** — Technician scheduling, availability
- **Notify** — Appointment reminders, status updates
- **User** — Ownership, authorization
- **Media** — Device photos, repair documentation

---

## Best/Bad

✓ Immutable Appointment history (track changes, never delete)
✓ Device verification workflow (2FA-style confirmation)
❌ Direct date changes (log changes, use update action)

---

## Roadmap

- Route optimization (visit order by distance)
- Technician availability calendar
- Service history export
- Repeat appointment scheduling

---

```
┌──────────────────────────────┐
│ TechPlanner (Core Domain)    │
├──────────────────────────────┤
│ Purpose: Scheduling, tracking│
│ Models: 15                   │
│ Migrations: 13               │
│ Status: Stable               │
│ Dependencies: Geo, Employee, Notify, User, Media │
└──────────────────────────────┘
```

---

- **Generated**: 2026-09-06

