<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MailTemplateResource\Pages;

use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates as NotifyListMailTemplates;
use Modules\TechPlanner\Filament\Resources\MailTemplateResource;

class ListMailTemplates extends NotifyListMailTemplates
{
    protected static string $resource = MailTemplateResource::class;
}
