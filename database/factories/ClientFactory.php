<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Models\Client;

/**
 * Class ClientFactory.
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'vat_number' => $this->faker->unique()->numerify('VAT-######'),
            'fiscal_code' => $this->faker->unique()->bothify('###??##??#'),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            // 'province' => $this->faker->state,
            // 'province' => $this->faker->state,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
