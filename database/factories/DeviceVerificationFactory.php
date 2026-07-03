<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Models\DeviceVerification;

/**
 * Class DeviceVerificationFactory.
 */
class DeviceVerificationFactory extends Factory
{
    protected $model = DeviceVerification::class;

    public function definition(): array
    {
        return [
            // 'device_id' => Device::factory(),
            'device_id' => 1, // Placeholder
            'verification_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'next_verification_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'verification_type' => $this->faker->randomElement(['Annual', 'Biannual', 'Quarterly']),
            'status' => $this->faker->randomElement(['Passed', 'Failed', 'Pending']),
            'notes' => $this->faker->optional()->paragraph(),
            'verified_by' => $this->faker->name,
        ];
    }
}
