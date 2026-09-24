<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditClient extends XotBaseEditRecord
{
    protected static string $resource = ClientResource::class;
}
