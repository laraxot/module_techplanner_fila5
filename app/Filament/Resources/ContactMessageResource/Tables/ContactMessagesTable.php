<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ContactMessageResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Filament\Resources\Tables\TechPlannerBaseTable;
use Override;

class ContactMessagesTable extends TechPlannerBaseTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'created_at' => TextColumn::make('created_at')->dateTime('d/m/Y H:i')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'studio' => TextColumn::make('studio')->searchable()->placeholder('—'),
            'type' => TextColumn::make('type')->placeholder('—')->visibleFrom('md'),
            'email' => TextColumn::make('email')->searchable()->visibleFrom('md'),
            'phone' => TextColumn::make('phone')->placeholder('—')->visibleFrom('lg'),
            'status' => TextColumn::make('status')
                ->badge()
                ->formatStateUsing(static fn (ContactMessageStatusEnum $state): string => ContactMessageStatusEnum::label($state))
                ->color(static fn (ContactMessageStatusEnum $state): string => ContactMessageStatusEnum::color($state)),
        ];
    }

    #[Override]
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading(__('techplanner::contact_message.empty.heading'))
            ->emptyStateDescription(__('techplanner::contact_message.empty.description'));
    }

    /**
     * @return array<string|int, BaseFilter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [
            'status' => SelectFilter::make('status')->options(ContactMessageStatusEnum::options()),
        ];
    }

    /**
     * Solo consultazione: niente modifica, il messaggio è quello scritto dal visitatore.
     *
     * @return array<string, Action>
     */
    #[Override]
    public function getTableActions(): array
    {
        return ['view' => ViewAction::make()->iconButton()];
    }

    /**
     * @return array<string, Action>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [];
    }

    /**
     * Niente «Nuovo» sopra la tabella: le richieste arrivano solo dal sito.
     *
     * @return array<string, Action>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        return [];
    }
}
