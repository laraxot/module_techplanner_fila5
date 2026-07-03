<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Models\LegalRepresentative;

/**
 * Class LegalRepresentativeFactory.
 */
class LegalRepresentativeFactory extends Factory
{
    protected $model = LegalRepresentative::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'identification_number' => $this->faker->unique()->numerify('ID-######'),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
