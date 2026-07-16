<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\ClientResource\Schemas\ClientForm;
use Modules\TechPlanner\Filament\Resources\ClientResource\Schemas\ClientInfolist;
use Modules\TechPlanner\Models\Client;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

/**
 * @property ClientResource $resource
 */
class ClientResource extends XotBaseResource
{
    protected static ?string $model = Client::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return ClientForm::getFormSchema();
    }

    #[Override]
    public static function getInfolistSchema(): array
    {
        return ClientInfolist::getInfolistSchema();
    }
}
