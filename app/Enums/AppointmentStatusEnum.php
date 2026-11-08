<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum AppointmentStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';

    public function getLabel(): string
    {
        $label = trans('techplanner::appointment_status.enums.'.$this->value.'.label');

        return is_string($label) ? $label : $this->value;
    }

    public function getColor(): string
    {
        $color = trans('techplanner::appointment_status.enums.'.$this->value.'.color');

        return is_string($color) ? $color : 'gray';
    }

    public function getIcon(): string
    {
        $icon = trans('techplanner::appointment_status.enums.'.$this->value.'.icon');

        return is_string($icon) ? $icon : 'heroicon-o-calendar';
    }
}
