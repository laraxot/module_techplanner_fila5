<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ControlInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public function getInfolistSchema(): array
    {
        return [
            'control_type' => TextEntry::make('control_type'),
            'client.company_name' => TextEntry::make('client.company_name'),
            'device.name' => TextEntry::make('device.name'),
            'worker.full_name' => TextEntry::make('worker.full_name'),
            'appointment.date' => TextEntry::make('appointment.date')->dateTime(),
            'status' => TextEntry::make('status'),
            'control_date' => TextEntry::make('control_date')->date(),
            'next_control_date' => TextEntry::make('next_control_date')->date(),
            'result' => TextEntry::make('result'),
            'notes' => TextEntry::make('notes'),
            'created_at' => TextEntry::make('created_at')->dateTime(),
            'updated_at' => TextEntry::make('updated_at')->dateTime(),
        ];
    }
}
