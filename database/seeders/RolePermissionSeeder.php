<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            "admin" => [
                'create-user',
                'update-user',
                'delete-user',
                'view-user',

                'create-client',
                'update-client',
                'delete-client',
                'view-client',

                'create-project',
                'update-project',
                'delete-project',
                'view-project',

                'create-task',
                'update-task',
                'delete-task',
                'view-task',

                'edit-profile',
            ],
            "simple" => [
                'create-client',
                'update-client',
                'delete-client',
                'view-client',

                // 'create-project',
                // 'update-project',
                // 'delete-project',
                'view-project',

                // 'create-task',
                // 'update-task',
                // 'delete-task',
                'view-task',

                'edit-profile',
            ]
        ];

        foreach($roles as $roleName => $features ) {
            # Role
            $role = Role::create(['name' => $roleName ]);
            
            foreach($features as $featureName) {
                # Permission
                $permission = Permission::firstOrCreate(['name' => $featureName]);

                $role->givePermissionTo($permission);
            }
        }
    }
}
