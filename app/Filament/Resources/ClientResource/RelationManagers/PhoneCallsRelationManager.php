<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Illuminate\Database\Eloquent\Model;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class PhoneCallsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'phoneCalls';

    /**
     * Titolo della scheda nella pagina del record: la stessa etichetta del menu, in italiano.
     * Senza override Filament mostra il nome inglese della relazione (es. «Phone Calls»).
     */
    #[Override]
    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        $title = __('techplanner::phone_call.navigation.plural_label');

        return is_string($title) ? $title : parent::getTitle($ownerRecord, $pageClass);
    }

    /** Nome del record nei titoli delle finestre («Salva Chiamata»), dal file lang. */
    #[Override]
    protected static function getModelLabel(): ?string
    {
        $label = __('techplanner::phone_call.label');

        return is_string($label) ? $label : parent::getModelLabel();
    }

    protected static string $resource = PhoneCallResource::class;
}
