<?php

namespace Database\Factories;

use App\Models\AssistantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Uid\UuidV7;

/**
 * @extends Factory<AssistantProfile>
 */
class AssistantProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'id' => UuidV7::generate(),
            'doctor_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
