<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\DeviceResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class DeviceVerificationsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'verifications';

    /**
     * Titolo della scheda nella pagina del record: la stessa etichetta del menu, in italiano.
     * Senza override Filament mostra il nome inglese della relazione (es. «Phone Calls»).
     */
    #[Override]
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        $title = __('techplanner::device_verification.navigation.plural_label');

        return is_string($title) ? $title : parent::getTitle($ownerRecord, $pageClass);
    }

    /** Nome del record nei titoli delle finestre («Salva Chiamata»), dal file lang. */
    #[Override]
    protected static function getModelLabel(): ?string
    {
        $label = __('techplanner::device_verification.label');

        return is_string($label) ? $label : parent::getModelLabel();
    }

    protected static ?string $recordTitleAttribute = 'verification_date';

    /**
     * @return array<int|string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            DatePicker::make('verification_date')->required(),
            DatePicker::make('next_verification_date')
                ->required()
                ->afterOrEqual('verification_date'),
            TextInput::make('verification_type')->required()->maxLength(255),
            TextInput::make('result')->required()->maxLength(255),
            TextInput::make('exposure_parameters')->maxLength(255),
            Textarea::make('notes')->maxLength(65535),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('verification_date')->date()->sortable(),
                TextColumn::make('next_verification_date')->date()->sortable(),
                TextColumn::make('verification_type')->searchable(),
                TextColumn::make('result')->searchable(),
            ])
            ->defaultSort('verification_date', 'desc')
            ->filters([

            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
