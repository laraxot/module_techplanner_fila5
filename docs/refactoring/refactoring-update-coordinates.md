# Refactoring Update Coordinates Action

**Date**: 2025-12-18
**Context**: "Super Cow" Clean Code Refactoring

## Objective
Decouple coordinate update logic from `ListClients` UI and move it to `Modules/Geo` for reusability and clean architecture.

## Plan
1.  **Logic Layer**: Create `Modules\Geo\Actions\UpdateCoordinatesAction` (Spatie Queueable Action).
2.  **UI Layer**: Create `Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction` (Filament Bulk Action).
3.  **Refactor**: Replace inline logic in `ListClients.php` with the new Bulk Action.

## Philosophy
- **Single Responsibility**: The UI should not know how to fetch coordinates.
- **Reusability**: Other modules may need to update coordinates for their models.
- **Queueing**: Coordinate fetching is an external API call and should be queueable.
