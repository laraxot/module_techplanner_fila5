<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Modules\TechPlanner\Enums\PhoneCallEnum;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\CreatePhoneCall;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\EditPhoneCall;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\ListPhoneCalls;
use Modules\TechPlanner\Models\PhoneCall;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class PhoneCallResource extends XotBaseResource
{
    protected static ?string $model = PhoneCall::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'date' => DateTimePicker::make('date'),
            'duration' => TextInput::make('duration'),
            'notes' => Textarea::make('notes'),
            'call_type' => Select::make('call_type')->options(PhoneCallEnum::class),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListPhoneCalls::route('/'),
            'create' => CreatePhoneCall::route('/create'),
            'edit' => EditPhoneCall::route('/{record}/edit'),
        ];
    }
}
