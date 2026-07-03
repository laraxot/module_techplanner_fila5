<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            // 'client_id' => Client::factory(),
            'client_id' => 1, // Placeholder
            'device_type' => $this->faker->randomElement(['X-Ray', 'MRI', 'CT', 'Ultrasound']),
            'brand' => $this->faker->company(),
            'model' => $this->faker->word().' '.$this->faker->numberBetween(1000, 9999),
            'headset_serial' => $this->faker->unique()->ean8(),
            'tube_serial' => $this->faker->unique()->ean8(),
            'power_kv' => $this->faker->numberBetween(40, 150).' kV',
            'current_ma' => $this->faker->numberBetween(100, 500).' mA',
            'first_verification_date' => $this->faker->date(),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
