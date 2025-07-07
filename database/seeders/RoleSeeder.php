<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'role_name' => 'Volunteer',
                'description' => 'Base role for all volunteers in the system'
            ],
            [
                'role_name' => 'Admin',
                'description' => 'Administrator with full system access'
            ],
            [
                'role_name' => 'Program Coordinator',
                'description' => 'Manages and coordinates program activities'
            ],
            [
                'role_name' => 'Financial Coordinator',
                'description' => 'Manages financial aspects and donations'
            ],
            [
                'role_name' => 'Content Manager',
                'description' => 'Manages content creation and publication'
            ],
            [
                'role_name' => 'Member',
                'description' => 'Member of the organization with special privileges'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['role_name' => $role['role_name']],
                $role
            );
        }
    }
} 