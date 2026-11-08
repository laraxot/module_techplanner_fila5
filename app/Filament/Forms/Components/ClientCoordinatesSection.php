<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

class ClientCoordinatesSection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->columns(2);
        $this->headerActions([
            Action::make('geocodeCoordinates')
                ->label(__('techplanner::client.actions.geocodeCoordinates.label'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->size('sm')
                ->visible(static fn (?Model $record): bool => $record instanceof Client)
                ->action(static function (?Model $record, Set $set): void {
                    if (! $record instanceof Client) {
                        return;
                    }

                    $action = app(UpdateCoordinatesFromAddressAction::class);

                    if (! $action->execute($record)) {
                        Notification::make()
                            ->warning()
                            ->title(__('techplanner::client.actions.geocodeCoordinates.failed_title'))
                            ->body(implode(' ', $action->getErrors()->all()))
                            ->send();

                        return;
                    }

                    $record->refresh();
                    $set('/latitude', $record->getAttribute('latitude'));
                    $set('/longitude', $record->getAttribute('longitude'));

                    Notification::make()
                        ->success()
                        ->title(__('techplanner::client.actions.geocodeCoordinates.success_title'))
                        ->send();
                }),
        ]);
        $this->schema($this->getFormSchema());
    }

    /**
     * @return array<string, TextInput>
     */
    protected function getFormSchema(): array
    {
        return [
            'latitude' => TextInput::make('latitude')
                ->label(__('techplanner::client.fields.latitude.label'))
                ->numeric()
                ->minValue(-90)
                ->maxValue(90)
                ->rule('regex:/^-?\d{1,2}(\.\d{1,7})?$/'),
            'longitude' => TextInput::make('longitude')
                ->label(__('techplanner::client.fields.longitude.label'))
                ->numeric()
                ->minValue(-180)
                ->maxValue(180)
                ->rule('regex:/^-?\d{1,3}(\.\d{1,7})?$/'),
        ];
    }
}
