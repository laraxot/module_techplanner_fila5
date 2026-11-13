<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Modules\TechPlanner\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use Modules\TechPlanner\Filament\Resources\ContactMessageResource\Pages\ViewContactMessage;
use Modules\TechPlanner\Models\ContactMessage;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * FUN-09: le richieste arrivate dal modulo «Contatti» del sito. Prima finivano solo in un'e-mail (se la casella
 * era configurata) e nel database, senza nessun modo di vederle dal pannello. Sola lettura: si creano dal sito.
 */
class ContactMessageResource extends XotBaseResource
{
    protected static ?string $model = ContactMessage::class;

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListContactMessages::route('/'),
            'view' => ViewContactMessage::route('/{record}'),
        ];
    }

    #[Override]
    public static function getNavigationBadge(): ?string
    {
        $pending = ContactMessage::query()->where('created_at', '>=', now()->subDays(7))->count();

        return $pending > 0 ? (string) $pending : null;
    }
}
