<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ClientResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Modules\TechPlanner\Filament\Resources\ClientResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
<<<<<<< HEAD
use Modules\TechPlanner\Filament\Resources\ClientResource\Schemas\ClientInfolist;
=======
>>>>>>> laraxot/dev

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
<<<<<<< HEAD

    /**
     * @return array<string, \Filament\Schemas\Components\Component>
     */
    #[\Override]
    protected function getInfolistSchema(): array
    {
        return app(ClientInfolist::class)->getInfolistSchema();
    }
=======
>>>>>>> laraxot/dev
}
