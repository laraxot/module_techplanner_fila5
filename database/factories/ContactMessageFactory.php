<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Models\ContactMessage;

/** @extends Factory<ContactMessage> */
class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->numerify('+39 ### #######'),
            'studio' => $this->faker->optional()->company(),
            'type' => $this->faker->optional()->randomElement(['Odontoiatrico', 'Veterinario', 'Altro']),
            'message' => $this->faker->paragraph(),
            'locale' => 'it',
            'status' => ContactMessageStatusEnum::Pending,
            'privacy_accepted_at' => now(),
            'forwarded_at' => null,
        ];
    }

    public function forwarded(): static
    {
        return $this->state(fn (): array => [
            'status' => ContactMessageStatusEnum::Forwarded,
            'forwarded_at' => now(),
        ]);
    }
}
