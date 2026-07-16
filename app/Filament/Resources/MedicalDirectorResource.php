<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages\CreateMedicalDirector;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages\EditMedicalDirector;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages\ListMedicalDirectors;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Pages\ViewMedicalDirector;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorForm;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorInfolist;
use Modules\TechPlanner\Models\MedicalDirector;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MedicalDirectorResource extends XotBaseResource
{
    protected static ?string $model = MedicalDirector::class;

    #[Override]
    public static function getFormSchema(): array
    {
        return MedicalDirectorForm::getFormSchema();
    }

    #[Override]
    public static function getInfolistSchema(): array
    {
        return MedicalDirectorInfolist::getInfolistSchema();
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
            'index' => ListMedicalDirectors::route('/'),
            'create' => CreateMedicalDirector::route('/create'),
            'view' => ViewMedicalDirector::route('/{record}'),
            'edit' => EditMedicalDirector::route('/{record}/edit'),
        ];
    }
}
