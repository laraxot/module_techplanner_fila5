<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Rules\ItalianFiscalCodeRule;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

/**
 * Campi allineati alla tabella `legal_representatives` (2026-11-10): il modulo chiedeva cognome, codice
 * tributario e ruolo, colonne inesistenti, e non chiedeva il cliente (obbligatorio): non si salvava nulla.
 */
class LegalRepresentativeForm extends XotBaseResourceForm
{
    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [
            'client_id' => Select::make('client_id')
                ->relationship('client', 'company_name')
                ->searchable()
                ->preload()
                ->required()
                // Dalla scheda del cliente il cliente è già quello: il campo non serve.
                ->hidden(static fn (mixed $livewire): bool => $livewire instanceof RelationManager),
            'name' => TextInput::make('name')->required()->maxLength(255),
            'fiscal_code' => TextInput::make('fiscal_code')->maxLength(16)->rule(new ItalianFiscalCodeRule()),
            'phone' => TextInput::make('phone')->tel()->maxLength(255),
            'email' => TextInput::make('email')->email()->maxLength(255),
            'notes' => Textarea::make('notes')->maxLength(65535)->columnSpanFull(),
        ];
    }
}
