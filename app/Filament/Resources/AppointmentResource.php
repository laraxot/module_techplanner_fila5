<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Models\Appointment;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * ---
 */
class AppointmentResource extends XotBaseResource
{
    protected static ?string $model = Appointment::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            /*
             * 'client_id' => Forms\Components\Select::make('client_id')
             * ->relationship('client', 'name')
             * ->required(),
             */
            'date' => DateTimePicker::make('date')->required(),
            /*
             * 'time' => Forms\Components\TimePicker::make('time')
             * ->required(),
             */
            /*
             * 'status' => Forms\Components\Select::make('status')
             * ->options([
             * 'scheduled' => 'Scheduled',
             * 'confirmed' => 'Confirmed',
             * 'completed' => 'Completed',
             * 'cancelled' => 'Cancelled',
             * ])
             * ->required(),
             */
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
        ];
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDetach(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }
}
