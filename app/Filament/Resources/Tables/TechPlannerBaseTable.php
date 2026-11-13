<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\Tables;

use Filament\Actions\Action;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Override;

/**
 * Tabelle del pannello TechPlanner.
 *
 * I modelli del modulo usano `SoftDeletes` (TPL-03): «Elimina» sposta il record nel cestino invece di
 * cancellarlo, e con lui non sparivano più a cascata apparecchi, verifiche e chiamate del cliente.
 * Qui il filtro «Record eliminati» e le azioni «Ripristina» / «Elimina definitivamente», visibili solo
 * a chi ha il permesso (policy: amministratore del modulo).
 */
abstract class TechPlannerBaseTable extends XotBaseResourceTable
{
    #[Override]
    public function getTableFilters(): array
    {
        if (! $this->usesSoftDeletes()) {
            return parent::getTableFilters();
        }

        return [
            ...parent::getTableFilters(),
            'trashed' => TrashedFilter::make(),
        ];
    }

    #[Override]
    public function getTableActions(): array
    {
        if (! $this->usesSoftDeletes()) {
            return parent::getTableActions();
        }

        $actions = parent::getTableActions();
        // Un record nel cestino non ha pagina di dettaglio o modifica (404): si ripristina prima.
        foreach (['view', 'edit'] as $name) {
            if (($actions[$name] ?? null) instanceof Action) {
                $actions[$name]->hidden(static fn (Model $record): bool => method_exists($record, 'trashed') && $record->trashed());
            }
        }

        return [
            ...$actions,
            'restore' => RestoreAction::make()->iconButton(),
            'forceDelete' => ForceDeleteAction::make()->iconButton(),
        ];
    }

    #[Override]
    public function getTableBulkActions(): array
    {
        if (! $this->usesSoftDeletes()) {
            return parent::getTableBulkActions();
        }

        return [
            ...parent::getTableBulkActions(),
            'restore' => RestoreBulkAction::make(),
            'forceDelete' => ForceDeleteBulkAction::make(),
        ];
    }

    protected function usesSoftDeletes(): bool
    {
        return \in_array(SoftDeletes::class, class_uses_recursive(static::getModelClass()), true);
    }
}
