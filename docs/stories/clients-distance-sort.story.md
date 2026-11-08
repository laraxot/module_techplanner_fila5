---
status: in-progress
owner: techplanner
title: Clients distance sorting restored on ListClients
type: story
module: TechPlanner
tags: [bmad, geo, clients, distance, filament]
qmd: "techplanner clients distance sorting coordinates withDistance GeoTrait ListClients"
related:
  - ../wiki/entities/client.md
  - ../wiki/audits/module-techplanner-audit.md
---

# Clients distance sorting restored on ListClients

## Story

As a field technician, I want to sort clients by distance from a reference
point — either typed coordinates or another client's position — so that nearby
studios are planned first.

## Context

The feature existed but was unwired: `CoordinatesWidget` was registered in
`config/filament.php` yet missing from `ListClients::getHeaderWidgets()`; the
per-record `sortByDistance` action and `withDistance` query scope were already
in place. Audit TPL-017 also flagged an invalid `->to(route-name)` event
target and missing coordinate validation.

The feature is operationally restored, but the story remains in progress until
the distance contract is verified end to end. UI wiring must not be confused
with correctness of the distance formula or with the presence of coordinates
for every client.

## Changes

- `ListClients::getHeaderWidgets()` now returns `CoordinatesWidget`.
- `CoordinatesWidget::updateCoordinates()` validates lat ∈ [-90,90],
  lng ∈ [-180,180] before writing session/cookie, and dispatches
  `sort-by-distance` without the invalid `->to()` target (Livewire events
  propagate to `#[On]` listeners natively).
- Existing pieces kept: `Session user_latitude/user_longitude` + 30-day cookies,
  `ListClients::getTableQuery()` → `GeoTrait::scopeWithDistance`,
  per-record `sortByDistance` action in `getTableActions()`.

## Verification

- `php -l` both files OK; PHPStan 0 errors on changed scope.
- UI check pending on `/techplanner/admin/clients` after deploy.

## Distance contract and remaining checks

- The reference point is held in session and a 30-day cookie; it is not stored
  on the client record.
- `ListClients` applies `Client::withDistance()` only when both coordinates are
  numeric; invalid or missing reference coordinates leave the base query
  unchanged.
- `GeoTrait` exposes the SQL alias through `getDistanceAttribute()` so
  `$client->distance` is treated as a scalar attribute, not as an Eloquent
  relationship.
- A client without latitude or longitude cannot have a meaningful distance.
  The current table formatting displays such a value as `0.00 km`, which must
  be changed or explicitly documented before operational use.
- TPL-018 still requires verification of the Haversine unit conversion in
  `GeoTrait::scopeWithDistance()`; the displayed `km` unit must match the SQL
  result.

Completion evidence still required:

1. Livewire/Filament integration test for typed coordinates and the per-client
   sort action.
2. Tests for invalid coordinates, missing client coordinates, and an empty
   session reference point.
3. Runtime UI verification of ordering, null display, notification feedback,
   and pagination after deploy.

## Control recency continuation

The same list now exposes the latest RX, intraoral, electromedical and health
authorization dates from the unified `controls` table. Three ternary filters
(`has_rx_control`, `has_electromedical_control`, `has_health_authorization`)
use relationship existence queries so they remain valid with pagination and
combined table filters. The correlated date scope is guarded while the pending
controls migration is not yet applied.

Competitive rationale and the next product slices are recorded in
`../competitive-analysis-field-controls.md` and the Filament
blueprint.

## Map widget and table consolidation (continuation)

Concurrent edits moved filters/bulk actions/record actions from `ListClients`
into `ClientsTable` (the class Xot actually uses to build the Filament table).
`ListClients` keeps only page-level concerns: header widgets, header actions,
`getTableQuery()` distance scope, and Livewire event listeners.

- `ClientMapWidget` rewritten: Leaflet map (self-hosted assets copied to
  `public_html/assets/geo/assets/leaflet.{js,css}` + marker images, no API key,
  OSM tiles), up to 500 client markers, `divIcon` markers, popup with client
  name/address/phone + View/Edit links + "Use as origin" button.
- Origin selection paths now: map popup (`$wire.setDistanceOrigin`), per-record
  `sortByDistance` action in `ClientsTable`, `CoordinatesWidget` typed inputs.
- `ListClients::setDistanceOrigin` (`#[On('set-client-distance-origin')]`)
  persists session+cookie and `resetTable()`; `#[On('sort-by-distance')]` re-added
  for `CoordinatesWidget`/`ClientMapWidget` dispatches.
- `distance` column: `width('5rem')` + `whitespace-nowrap` + `—` placeholder for
  null (audit TPL-018); `GeoTrait` miles factor removed (true km now).
- i18n: `techplanner::client.map.*` keys added to it/en/de/es lang files.
- Client edit form now includes a single-client Leaflet map when coordinates
  exist, with explicit Google Maps and ViaMichelin links; missing coordinates
  produce a guided empty state instead of a broken map.

### Verification

- `php -l` all touched PHP files OK; PHPStan 0 errors on widget/page/table scope.
- `ClientMapWidget::render()` verified in tinker: 500 markers, correct
  view/edit URLs, origin null-safe.
- Blade compiles; `@script`/`$wire` is Livewire 4 `SupportScriptsAndAssets`.
- Pending: browser check of map render + popup actions after deploy.

## Map visibility hardening — 2026-11-07

The browser report was investigated against the current checkout. The Filament
header-widget hook, widget view, explicit map height, and self-hosted Leaflet
assets are present. The fragile part was the client-side lifecycle: the view
declared top-level JavaScript identifiers, did not handle an already-loading
Leaflet script, and did not invalidate the map size after lazy rendering.

The widget now scopes its state under `window.TechPlannerClientMaps`, waits for
the shared Leaflet script when necessary, guards duplicate initialization, and
invalidates the map after initial render and resize. This prevents a blank map
after Livewire/Filament schema rendering while preserving the existing marker
and popup actions.

Runtime browser verification remains required on the deployed host: the map
container, `leaflet-container`, Leaflet asset requests, OSM tiles, and popup
actions must be checked in DevTools after deployment.

## Client edit coordinate subsection — 2026-11-07

The Client edit form keeps `latitude` and `longitude` in a dedicated
`ClientCoordinatesSection` based on `XotBaseSection`, nested inside the
`AddressSection` via its `extraComponents()` hook (Geo shared component).
The section validates both ranges and exposes a header action that geocodes
the persisted address and updates both fields together. Address/contact
fields remain in their respective sections.

Acceptance evidence:

- the coordinate subsection renders inside the address section, before the
  single-client map;
- the action reports a recoverable warning when the saved address is empty or
  cannot be geocoded;
- successful geocoding updates both inputs without saving unrelated dirty form
  fields;
- the map and external map links continue to use the saved coordinates.
