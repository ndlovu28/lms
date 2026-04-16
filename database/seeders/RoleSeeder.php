<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'su',
                'description' => 'Super user',
            ],
            [
                'name' => 'admin',
                'description' => 'School admin',
            ],
            [
                'name' => 'tutor',
                'description' => 'Tutor',
            ],
            [
                'name' => 'student',
                'description' => 'Student',
            ],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(
                ['name' => $role['name']],
                ['description' => $role['description']],
            );
        }
    }
}
