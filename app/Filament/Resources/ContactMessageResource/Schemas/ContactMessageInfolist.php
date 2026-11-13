<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Resources\ContactMessageResource\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceInfolist;

class ContactMessageInfolist extends XotBaseResourceInfolist
{
    /**
     * @return array<string, Component>
     */
    public function getInfolistSchema(): array
    {
        return [
            'created_at' => TextEntry::make('created_at')->dateTime('d/m/Y H:i'),
            'status' => TextEntry::make('status')
                ->badge()
                ->formatStateUsing(static fn (ContactMessageStatusEnum $state): string => ContactMessageStatusEnum::label($state))
                ->color(static fn (ContactMessageStatusEnum $state): string => ContactMessageStatusEnum::color($state)),
            'name' => TextEntry::make('name'),
            'studio' => TextEntry::make('studio')->placeholder('—'),
            'email' => TextEntry::make('email')->copyable()->url(static fn (string $state): string => 'mailto:'.$state),
            'phone' => TextEntry::make('phone')->placeholder('—')->url(static fn (?string $state): ?string => $state === null ? null : 'tel:'.$state),
            'type' => TextEntry::make('type')->placeholder('—'),
            'message' => TextEntry::make('message')->columnSpanFull(),
            'privacy_accepted_at' => TextEntry::make('privacy_accepted_at')->dateTime('d/m/Y H:i'),
        ];
    }
}
