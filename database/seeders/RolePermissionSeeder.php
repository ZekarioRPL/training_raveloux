<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\role_has_permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            "Admin" => [
                'Manage Users',
                'Manage Client',
                'Manage Project',
                'Manage Profile',
                'Manage Task',
            ],
            "Simple" => [
                'Manage Client',
                'Manage Project',
                'Manage Profile',
                'Manage Task',
            ]
        ];

        foreach($roles as $roleName => $features ) {
            # insert role
            $role = Role::create([
                'name' => $roleName,
                'guard_name' => strtolower(str_replace(" ", "-", $roleName))
            ]);
            
            foreach($features as $featureName) {
                $permission = Permission::create([
                    'name' => $featureName,
                    'guard_name' => strtolower(str_replace(" ", "-", $featureName))
                ]);
                role_has_permission::create([
                    'permission_id' => $permission->id,
                    'role_id' => $role->id
                ]);
            }
        }
    }
}
