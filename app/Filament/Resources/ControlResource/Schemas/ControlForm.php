<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ControlResource\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Enums\ControlTypeEnum;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\Worker;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class ControlForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'client_id' => Select::make('client_id')
                ->relationship('client', 'company_name')
                ->getOptionLabelFromRecordUsing(
                    static fn (Client $client): string => $client->company_name
                        ?: ($client->name ?: 'Client'),
                )
                ->searchable()
                ->preload()
                ->required(),
            'device_id' => Select::make('device_id')
                ->relationship('device', 'name')
                ->getOptionLabelFromRecordUsing(
                    static fn (Device $device): string => $device->name
                        ?: ($device->serial_number ?: 'Device'),
                )
                ->searchable(),
            'worker_id' => Select::make('worker_id')
                ->relationship('worker', 'first_name')
                ->getOptionLabelFromRecordUsing(
                    static fn (Worker $worker): string => $worker->full_name
                        ?: 'Worker',
                )
                ->searchable(),
            'appointment_id' => Select::make('appointment_id')
                ->relationship('appointment', 'date')
                ->getOptionLabelFromRecordUsing(
                    static fn (Appointment $appointment): string => $appointment->date?->format('d/m/Y H:i')
                        ?: 'Appointment #'.SafeStringCastAction::cast($appointment->getKey()),
                )
                ->searchable(),
            'control_type' => Select::make('control_type')
                ->options(ControlTypeEnum::class)
                ->required()
                ->disabledOn('edit'),
            'control_date' => DatePicker::make('control_date'),
            'next_control_date' => DatePicker::make('next_control_date'),
            'status' => TextInput::make('status')->maxLength(100),
            'result' => TextInput::make('result')->maxLength(100),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
            'checklist' => Repeater::make('checklist')
                ->statePath('metadata.checklist')
                ->schema([
                    TextInput::make('item')->label('Voce checklist')->required()->columnSpan(2),
                    Select::make('result')
                        ->options([
                            'ok' => 'OK',
                            'ko' => 'KO',
                            'na' => 'N/A',
                        ])
                        ->label('Esito'),
                    TextInput::make('note')->label('Nota')->maxLength(255),
                ])
                ->columns(4)
                ->defaultItems(0)
                ->addActionLabel('Aggiungi voce checklist')
                ->columnSpanFull()
                ->helperText('Checklist del controllo (es. controlli VSE/IEC 60601, qualità radiologica, requisiti autorizzazione sanitaria).'),
        ];
    }
}
