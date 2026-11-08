<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\TechPlanner\Filament\Resources\ClientResource\Schemas\ClientInfolist;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewClient extends XotBaseViewRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, Component>
     */
    protected function getInfolistSchema(): array
    {
        return app(ClientInfolist::class)->getInfolistSchema();
    }
}
