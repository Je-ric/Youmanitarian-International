<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoleAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $roles = [
            'Volunteer' => 'Base role for all volunteers in the system',
            'Admin' => 'Administrator with full system access',
            'Program Coordinator' => 'Manages and coordinates program activities',
            'Financial Coordinator' => 'Manages financial aspects and donations',
            'Content Manager' => 'Manages content creation and publication',
            'Member' => 'Member of the organization with special privileges'
        ];

        foreach ($roles as $roleName => $description) {
            Role::firstOrCreate(['role_name' => $roleName], [
                'role_name' => $roleName,
                'description' => $description
            ]);
        }

        // Clear existing user-role assignments to avoid duplicates
        DB::table('user_roles')->truncate();

        $users = User::all();
        $totalUsers = $users->count();

        foreach ($users as $user) {
            // 1. All users get Volunteer role
            $this->assignRole($user, 'Volunteer');

            // 2. Users with member records get Member role
            if ($user->member) {
                $this->assignRole($user, 'Member');
            }

            // 3. Distribute additional roles (some users get none, some get multiple)
            $additionalRoles = $this->getRandomRoles();
            foreach ($additionalRoles as $roleName) {
                $this->assignRole($user, $roleName);
            }
        }

        // Debug: Show role distribution
        $this->command->info("Role assignment completed! Total users: {$totalUsers}");
        
        // Show role distribution
        $roles = Role::all();
        foreach ($roles as $role) {
            $count = User::whereHas('roles', function($query) use ($role) {
                $query->where('role_id', $role->id);
            })->count();
            $this->command->info("{$role->role_name}: {$count} users");
        }
    }

    private function assignRole($user, $roleName)
    {
        if (!$user->hasRole($roleName)) {
            $role = Role::where('role_name', $roleName)->first();
            if ($role) {
                $user->roles()->attach($role->id, [
                    'assigned_by' => null,
                    'assigned_at' => now()
                ]);
            }
        }
    }

    private function getRandomRoles()
    {
        $roles = ['Admin', 'Content Manager', 'Financial Coordinator', 'Program Coordinator'];
        $selectedRoles = [];

        // 60% chance of getting no additional role
        if (rand(1, 100) <= 60) {
            return $selectedRoles;
        }

        // 30% chance of getting 1 role
        if (rand(1, 100) <= 30) {
            $selectedRoles[] = $roles[array_rand($roles)];
        } else {
            // 10% chance of getting 2-3 roles
            $numRoles = rand(2, 3);
            $shuffledRoles = $roles;
            shuffle($shuffledRoles);
            $selectedRoles = array_slice($shuffledRoles, 0, $numRoles);
        }

        return $selectedRoles;
    }
} 