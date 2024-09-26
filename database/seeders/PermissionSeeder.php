<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role_index',
            'role_create',
            'role_show',
            'role_update',
            'role_delete',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission,'guard_name' => 'api']);
        }

        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin','guard_name' => 'api']);

        $role->givePermissionTo($permissions);
    }
}
