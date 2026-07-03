<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Models\PhoneCall;

class PhoneCallFactory extends Factory
{
    protected $model = PhoneCall::class;

    public function definition(): array
    {
        return [
            // 'client_id' => Client::factory(),
            'client_id' => 1, // Placeholder
            'call_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'call_type' => $this->faker->randomElement(['Incoming', 'Outgoing', 'Missed']),
            'duration' => $this->faker->numberBetween(30, 1800), // seconds
            'notes' => $this->faker->optional()->paragraph(),
            'phone_number' => $this->faker->phoneNumber,
        ];
    }
}
