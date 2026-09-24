<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources;

use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\CreatePhoneCall;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\EditPhoneCall;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\ListPhoneCalls;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Pages\ViewPhoneCall;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallForm;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallInfolist;
use Modules\TechPlanner\Models\PhoneCall;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class PhoneCallResource extends XotBaseResource
{
    protected static ?string $model = PhoneCall::class;

   
}
