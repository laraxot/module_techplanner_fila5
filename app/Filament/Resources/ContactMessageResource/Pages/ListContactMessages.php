<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ContactMessageResource\Pages;

use Modules\TechPlanner\Filament\Resources\ContactMessageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListContactMessages extends XotBaseListRecords
{
    protected static string $resource = ContactMessageResource::class;

    /** Niente «Nuovo»: le richieste arrivano solo dal sito. */
    #[Override]
    protected function getHeaderActions(): array
    {
        return [];
    }
}
