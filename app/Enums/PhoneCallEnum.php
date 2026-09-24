<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PhoneCallEnum: string implements HasColor, HasIcon, HasLabel
{
    case INBOUND = 'inbound';
    case OUTBOUND = 'outbound';

    public function getLabel(): string
    {
        $label = trans('techplanner::phone_call.enums.'.$this->value.'.label');

        return is_string($label) ? $label : $this->value;
    }

    public function getColor(): string
    {
        $color = trans('techplanner::phone_call.enums.'.$this->value.'.color');

        return is_string($color) ? $color : 'gray';
    }

    public function getIcon(): string
    {
        $icon = trans('techplanner::phone_call.enums.'.$this->value.'.icon');

        return is_string($icon) ? $icon : 'heroicon-o-phone';
    }
}
