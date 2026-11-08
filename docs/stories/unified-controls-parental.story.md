---
status: in-progress
owner: techplanner
title: Unified controls with Parental single-table inheritance
---

# Unified controls with Parental single-table inheritance

## Story

As a technical operator, I want RX, intraoral RX, health authorization and future
checks managed through one domain model, so that the studio history, deadlines and
documents are searchable without duplicating CRUD code.

## Architecture decision

Use one `controls` table and `tightenco/parental` single-table inheritance. The
Parental discriminator is `control_type`; it is not a tree parent-child relation.
Existing `DeviceVerification` remains legacy until a data migration is verified.

## Acceptance criteria

1. Each supported control type persists in `controls` and hydrates as its Parental
   child model.
2. Controls can relate to a client, optionally to a device and worker, and expose
   common status/date/result fields.
3. The Filament resource uses one CRUD surface with the shared control fields
   and a typed discriminator; subtype-specific fields remain future extensions.
4. Pest tests cover discriminator hydration, relationships and legacy compatibility
   once the shared Xot test bootstrap is available.
5. PHPStan and the focused TechPlanner tests pass for the changed scope; a blocked
   verification is not recorded as a passing acceptance criterion.

## Owned scope

- `Modules/TechPlanner/app/Enums/ControlTypeEnum.php`
- `Modules/TechPlanner/app/Models/Control*.php`
- `Modules/TechPlanner/database/migrations/*controls*`
- `Modules/TechPlanner/app/Filament/Resources/ControlResource/**`
- `Modules/TechPlanner/tests/Unit/Models/Control*`
- `Modules/TechPlanner/docs/wiki/entities/control.md`

## Out of scope

Do not delete or rewrite `DeviceVerification` until an explicit data migration and
production verification exist. Do not model nested control cases in this story.

## Testing strategy

Use Pest with SQLite testing configuration. Verify model persistence, Parental
hydration, relationship keys, enum metadata, and Filament schema construction.

## Implementation notes

- `controls` table: `client_id` FK→clients, `device_id` and `appointment_id`
  nullable FKs, `worker_id` nullable index (tabella `workers` legacy senza FK),
  discriminante `control_type`, `status`, `result`, `control_date`,
  `next_control_date`, `notes`, `metadata` + timestamps/softDeletes Xot.
- `Control` (HasChildren, `childColumn = control_type`) + figli
  `RxControl`, `IntraoralControl`, `HealthAuthorizationControl`, `OtherControl`
  (HasParent). Casting `control_type` → `ControlTypeEnum`.
- `ControlTypeEnum`: rx, intraoral, electromedical, health_authorization, other — label/color/icon
  via `techplanner::control_type.enums.*` (lang de/en/es/fr/it).
- `ControlResource` Filament: form con Select relationship null-safe
  (stesso pattern fix DeviceForm), `control_type` disabledOn edit; tabella con
  badge enum + filtri; pagine List/Create/Edit/View + ControlInfolist.
- `tightenco/parental ^1.6` dichiarato in `Modules/TechPlanner/composer.json`.
- Verificato: `php -l` sui file nuovi, PHPStan 0 errori sui file nuovi e
  idratazione STI via bootstrap (`rx`→RxControl,
  `health_authorization`→HealthAuthorizationControl).
- Bloccato: Pest non bootstrappa perché il test case condiviso
  `Modules\\Xot\\Tests\\XotBaseTestCase` non è autoloadabile. È un blocco
  infrastrutturale condiviso; non equivale a test verdi per questa story.
- Da verificare quando il bootstrap sarà ripristinato: persistenza SQLite,
  relazioni con chiavi nullable e schema Filament completo.
