<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\MailTemplateResource\Pages;

use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\CreateMailTemplate as NotifyCreateMailTemplate;
use Modules\TechPlanner\Filament\Resources\MailTemplateResource;

class CreateMailTemplate extends NotifyCreateMailTemplate
{
    protected static string $resource = MailTemplateResource::class;
}
