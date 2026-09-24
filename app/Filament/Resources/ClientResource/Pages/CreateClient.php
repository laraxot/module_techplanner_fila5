<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateClient extends XotBaseCreateRecord
{
    protected static string $resource = ClientResource::class;
}
