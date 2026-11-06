<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Actions\Contact;

use Modules\TechPlanner\Actions\Contact\StoreContactMessageAction;
use Modules\TechPlanner\Datas\ContactMessageData;
use Modules\TechPlanner\Models\ContactMessage;

final class TechPlannerContactStoreFake extends StoreContactMessageAction
{
    private int $stored = 0;

    public function execute(ContactMessageData $data, string $locale): ContactMessage
    {
        ++$this->stored;

        return new ContactMessage(['name' => $data->name]);
    }

    public function storedCount(): int
    {
        return $this->stored;
    }
}
