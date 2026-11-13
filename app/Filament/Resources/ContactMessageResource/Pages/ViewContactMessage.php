<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ContactMessageResource\Pages;

use Modules\TechPlanner\Filament\Resources\ContactMessageResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewContactMessage extends XotBaseViewRecord
{
    protected static string $resource = ContactMessageResource::class;
}
