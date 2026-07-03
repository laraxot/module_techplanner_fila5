<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Models\MedicalDirector;

/**
 * Class MedicalDirectorFactory.
 */
class MedicalDirectorFactory extends Factory
{
    protected $model = MedicalDirector::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'license_number' => $this->faker->unique()->numerify('LIC-######'),
            'specialization' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
