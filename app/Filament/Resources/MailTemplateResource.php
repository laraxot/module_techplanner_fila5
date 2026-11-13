<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Filament\Resources\Pages\PageRegistration;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Filament\Resources\MailTemplateResource as NotifyBaseMailTemplateResource;
use Modules\TechPlanner\Models\Policies\TechPlannerBasePolicy;
use Modules\Xot\Contracts\UserContract;
use Override;
use UnitEnum;

/**
 * Modelli e-mail nel pannello TechPlanner.
 *
 * Estende la resource di Notify con la stessa struttura e mostra tutti i modelli.
 * Il vecchio override di getEloquentQuery() filtrava `slug LIKE '%'`, cioè nulla
 * (slug obbligatorio e univoco): rimosso il 2026-11-05. Un filtro per prefisso di
 * slug (`techplanner-`) andrebbe aggiunto qui con un override di getEloquentQuery().
 *
 * Richiede SpatieTranslatablePlugin registrato nel panel.
 */
class MailTemplateResource extends NotifyBaseMailTemplateResource
{
    /**
     * La policy di Notify riserva i modelli e-mail al super-admin: nel pannello TechPlanner
     * li gestisce anche l'amministratore del modulo, l'operatore no.
     */
    #[Override]
    public static function getAuthorizationResponse(string|UnitEnum $action, ?Model $record = null): Response
    {
        $user = auth()->user();
        if ($user instanceof UserContract && $user->hasRole(TechPlannerBasePolicy::ROLE_ADMIN)) {
            return Response::allow();
        }

        return parent::getAuthorizationResponse($action, $record);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
        ];
    }
}
