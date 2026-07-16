<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\TechPlanner\Filament\Resources\ClientResource\Schemas\ClientInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Override;

class ViewClient extends XotBaseViewRecord
{
    protected static string $resource = ClientResource::class;

    #[Override]
    protected function getInfolistSchema(): array
    {
        return ClientInfolist::getInfolistSchema();
    }

    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
