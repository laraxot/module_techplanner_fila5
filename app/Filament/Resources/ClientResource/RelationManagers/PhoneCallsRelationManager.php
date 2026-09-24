<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\RelationManagers;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class PhoneCallsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'phoneCalls';

    protected static string $resource = PhoneCallResource::class;
}
