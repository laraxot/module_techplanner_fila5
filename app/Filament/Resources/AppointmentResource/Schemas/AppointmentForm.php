<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas;

use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\TechPlanner\Actions\CheckAppointmentConflictAction;
use Modules\TechPlanner\Enums\AppointmentStatusEnum;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Worker;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class AppointmentForm extends XotBaseResourceForm
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
            'worker_id' => Select::make('worker_id')
                ->relationship('worker', 'first_name')
                ->getOptionLabelFromRecordUsing(
                    static fn (Worker $worker): string => $worker->full_name
                        ?: 'Worker',
                )
                ->searchable()
                ->rule(fn (Get $get, ?Model $record): Closure => $this->conflictRule($get, $record)),
            'date' => DateTimePicker::make('date')
                ->required()
                ->rule(fn (Get $get, ?Model $record): Closure => $this->conflictRule($get, $record)),
            'duration_minutes' => TextInput::make('duration_minutes')
                ->numeric()
                ->minValue(15)
                ->maxValue(480)
                ->default(60)
                ->rule(fn (Get $get, ?Model $record): Closure => $this->conflictRule($get, $record)),
            'status' => Select::make('status')
                ->options(AppointmentStatusEnum::class)
                ->default(AppointmentStatusEnum::SCHEDULED->value),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
            'outcome' => Textarea::make('outcome')
                ->maxLength(65535)
                ->columnSpanFull()
                ->visibleOn('edit'),
        ];
    }

    /**
     * Regola di validazione: impedisce doppie prenotazioni dello stesso tecnico
     * nella stessa fascia oraria (gli stati terminali non contano).
     */
    private function conflictRule(Get $get, ?Model $record): Closure
    {
        return static function (string $attribute, mixed $value, Closure $fail) use ($get, $record): void {
            $workerId = $get('worker_id');
            $date = $get('date');

            if (! is_numeric($workerId) || (int) $workerId <= 0 || $date === null || $date === '') {
                return;
            }

            if ($date instanceof \DateTimeInterface) {
                $start = Carbon::instance($date);
            } elseif (is_string($date) || is_int($date)) {
                $start = Carbon::parse((string) $date);
            } else {
                return;
            }

            $rawDuration = $get('duration_minutes');
            $duration = is_numeric($rawDuration) ? (int) $rawDuration : 60;
            $excludeKey = $record instanceof Model && $record->exists ? $record->getKey() : null;
            $excludeId = is_numeric($excludeKey) ? (int) $excludeKey : null;

            $conflict = app(CheckAppointmentConflictAction::class)->execute(
                (int) $workerId,
                $start,
                $duration,
                $excludeId,
            );

            if ($conflict instanceof Appointment) {
                $fail(__('techplanner::appointment.validation.conflict', [
                    'worker' => $conflict->worker instanceof Worker ? $conflict->worker->full_name : '',
                    'date' => $conflict->date?->format('d/m/Y H:i') ?? '',
                ]));
            }
        };
    }
}
