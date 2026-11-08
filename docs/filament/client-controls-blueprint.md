---
title: Filament Blueprint — client control recency
type: blueprint
module: TechPlanner
updated: 2026-11-06
---

# Filament Blueprint

## Surface

`ClientResource` remains an XotBase resource. Table configuration belongs in
`ClientResource/Tables/ClientsTable.php`; page-level query and widgets belong in
`Pages/ListClients.php`.

## Table contract

| Concern | Component | Rule |
|---|---|---|
| Latest RX | `TextColumn` | correlated max date, sortable, `—` when absent |
| Latest intraoral | `TextColumn` | separate detail column, hidden-toggle friendly |
| Latest electromedical | `TextColumn` | correlated max date, sortable |
| Latest authorization | `TextColumn` | correlated max date, sortable |
| Presence filters | `TernaryFilter` | relationship query, not SQL alias query |
| Distance | `TextColumn` | `5rem`, no wrap, km or `—` |
| Map | header widget | progressive enhancement; table remains complete |

## Data contract

The `controls` table is shared by Parental STI. The list query is guarded with
`Schema::hasTable('controls')` so a deployment can ship code before running the
pending migration without making the clients index unavailable.

`Client::scopeWithLatestControlDates()` is the canonical query scope. It adds
correlated `MAX(control_date)` projections for the four displayed categories;
the `controls()` relation remains the canonical source for presence filters.
The migration currently permits a nullable `client_id`, so unassigned controls
are not part of any client's recency projection.

## Review checklist

- Keep `XotBaseResourceTable` and `XotBaseListRecords`.
- Do not query computed aliases in filters.
- Do not expose a map-only action.
- Keep labels translatable when adding new languages.
- Verify mobile table cards after changing columns.
