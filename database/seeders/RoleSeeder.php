<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        foreach (UserTypeEnum::cases() as $case) {
            Role::firstOrCreate(
                ['name' => $case->value],
                ['description' => ucfirst($case->value) . ' role']
            );
        }
    }
}
