<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\CreateLegalOffice;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\EditLegalOffice;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\ListLegalOffices;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Pages\ViewLegalOffice;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeForm;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeInfolist;
use Modules\TechPlanner\Models\LegalOffice;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class LegalOfficeResource extends XotBaseResource
{
    protected static ?string $model = LegalOffice::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return LegalOfficeForm::getFormSchema();
    }

    #[Override]
    public static function getInfolistSchema(): array
    {
        return LegalOfficeInfolist::getInfolistSchema();
    }

    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListLegalOffices::route('/'),
            'create' => CreateLegalOffice::route('/create'),
            'view' => ViewLegalOffice::route('/{record}'),
            'edit' => EditLegalOffice::route('/{record}/edit'),
        ];
    }
}
