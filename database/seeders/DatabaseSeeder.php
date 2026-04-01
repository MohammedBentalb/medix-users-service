<?php

namespace Database\Seeders;

use App\Models\AssistantProfile;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\User;
use App\Models\Role;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call(RoleSeeder::class);
        
        $admin = User::factory()->create([
            'email'      => 'admin@example.com',
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'type'       => UserTypeEnum::ADMIN,
        ]);
        $admin->roles()->attach([
            Role::where('name', UserTypeEnum::USER->value)->first()->id,
            Role::where('name', UserTypeEnum::ADMIN->value)->first()->id
        ]);

        $doctors = User::factory(10)->create(['type' => UserTypeEnum::DOCTOR]);
        $doctorRole = Role::where('name', UserTypeEnum::DOCTOR->value)->first()->id;
        $userRole   = Role::where('name', UserTypeEnum::USER->value)->first()->id;
        $doctors->each(fn($u) => $u->roles()->attach([$userRole, $doctorRole]));

        $doctorsProfile = $doctors->map(function($doc){
            return DoctorProfile::factory()->create([
                'user_id' => $doc->id,
            ]);
        });

        $patients = User::factory(10)->create(['type' => UserTypeEnum::PATIENT]);
        $patientRole = Role::where('name', UserTypeEnum::PATIENT->value)->first()->id;
        $patients->each(fn($u) => $u->roles()->attach([$userRole, $patientRole]));

        $patientsProfile = $patients->map(function($patient){
            return PatientProfile::factory()->create([
                'user_id' => $patient->id,
            ]);
        });
        
        $assistants = User::factory(10)->create(['type' => UserTypeEnum::ASSISTANT]);
        $assistantRole = Role::where('name', UserTypeEnum::ASSISTANT->value)->first()->id;
        $assistants->each(fn($u) => $u->roles()->attach([$userRole, $assistantRole]));

        $assistants->take(5)->values()->each(function($assistant, $i) use($doctors) {
            return AssistantProfile::factory()->create([
                'user_id' => $assistant->id,
                'doctor_id' => $doctors[$i]->id,
            ]);
        });

        $assistants->slice(5)->values()->each(function($assistant) {
            return AssistantProfile::factory()->create([
                'user_id' => $assistant->id,
                'doctor_id' => null,
            ]);
        });

    }
}
