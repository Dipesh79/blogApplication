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

            'user_index',
            'user_create',
            'user_show',
            'user_update',
            'user_delete',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Author']);

        $admin->givePermissionTo($permissions);
    }
}
