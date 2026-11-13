<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Filament\Tables\Columns;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Filament\Resources\AppointmentResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class AppointmentsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'appointments';

    /**
     * Titolo della scheda nella pagina del record: la stessa etichetta del menu, in italiano.
     * Senza override Filament mostra il nome inglese della relazione (es. «Phone Calls»).
     */
    #[Override]
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        $title = __('techplanner::appointment.navigation.plural_label');

        return is_string($title) ? $title : parent::getTitle($ownerRecord, $pageClass);
    }

    /** Nome del record nei titoli delle finestre («Salva Chiamata»), dal file lang. */
    #[Override]
    protected static function getModelLabel(): ?string
    {
        $label = __('techplanner::appointment.label');

        return is_string($label) ? $label : parent::getModelLabel();
    }

    protected static string $resource = AppointmentResource::class;

    /**
     * Get table columns for the relation manager.
     *
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'date' => TextColumn::make('date')->dateTime('d/m/Y H:i')->sortable(),
            'notes' => TextColumn::make('notes')->limit(50),
            /*
             * 'machines_count' => Columns\TextColumn::make('machines_count')
             * ->label('Machines Checked')
             * ->counts('machines'),
             */
        ];
    }

    public function canAttach(): bool
    {
        return false;
    }

    public function canCreate(): bool
    {
        return true;
    }
}
