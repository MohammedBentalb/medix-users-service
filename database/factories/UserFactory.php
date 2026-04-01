<?php

namespace Database\Factories;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Uid\UuidV7;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory {
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'id' => UuidV7::generate(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'image' => null,
            'national_id' => $this->faker->optional()->numerify('########'),
            'status' => $this->faker->randomElement(UserStatusEnum::cases())->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
