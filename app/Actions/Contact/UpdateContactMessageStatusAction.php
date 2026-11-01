<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Models\ContactMessage;

class UpdateContactMessageStatusAction
{
    public function execute(ContactMessage $message, ContactMessageStatusEnum $status): void
    {
        $message->forceFill([
            'status' => $status,
            'forwarded_at' => $status === ContactMessageStatusEnum::Forwarded ? now() : null,
        ])->save();
    }
}
