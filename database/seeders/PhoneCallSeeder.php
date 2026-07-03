<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\TechPlanner\Models\PhoneCall;

class PhoneCallSeeder extends Seeder
{
    public function run(): void
    {
        // PhoneCall::factory(50)->create();

        // Placeholder per il seeder
        $this->command->info('PhoneCall seeder completed (factory disabled)');
    }
}
