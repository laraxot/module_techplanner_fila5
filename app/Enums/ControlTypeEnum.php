<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ControlTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    case RX = 'rx';
    case INTRAORAL = 'intraoral';
    case HEALTH_AUTHORIZATION = 'health_authorization';
    case ELECTROMEDICAL = 'electromedical';
    case OTHER = 'other';

    public function getLabel(): string
    {
        $label = trans('techplanner::control_type.enums.'.$this->value.'.label');

        return is_string($label) ? $label : $this->value;
    }

    public function getColor(): string
    {
        $color = trans('techplanner::control_type.enums.'.$this->value.'.color');

        return is_string($color) ? $color : 'gray';
    }

    public function getIcon(): string
    {
        $icon = trans('techplanner::control_type.enums.'.$this->value.'.icon');

        return is_string($icon) ? $icon : 'heroicon-o-clipboard-document-check';
    }

    /**
     * Cadenza periodica predefinita in mesi per questo tipo di controllo.
     *
     * Usata per precompilare `next_control_date` alla chiusura di un controllo:
     * i controlli normati (RX, endorale, elettromedicale, autorizzazione
     * sanitaria) seguono il ciclo annuale; `other` non ha cadenza fissa.
     */
    public function defaultRecurrenceMonths(): ?int
    {
        return match ($this) {
            self::OTHER => null,
            default => 12,
        };
    }
}
