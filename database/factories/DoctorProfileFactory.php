<?php

namespace Database\Factories;

use App\Models\DoctorProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Uid\UuidV7;

/**
 * @extends Factory<DoctorProfile>
 */
class DoctorProfileFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array {
        return [
            'id' => UuidV7::generate(),
            'speciality' => $this->faker->randomElement(['Cardiology', 'Dermatology', 'General']),
            'license_number' => $this->faker->unique()->bothify('LIC-####'),
            'years_experience' => $this->faker->numberBetween(1, 20),
            'consultation_fee' => $this->faker->numberBetween(100, 500),
            'bio' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
