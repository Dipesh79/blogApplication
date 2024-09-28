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
        $adminPermissions = [
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

            'category_create',
            'category_show',
            'category_update',
            'category_delete',

            'tag_create',
            'tag_show',
            'tag_update',
            'tag_delete',
        ];

        $authorPermissions = [
            'category_index',

            'tag_index',

            'post_index',
            'post_create',
            'post_show',
            'post_update',
            'post_delete',

            'comment_store',
            'comment_update',
            'comment_delete',
        ];


        $permissions = array_merge($authorPermissions, $adminPermissions);

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $author = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Author']);

        $author->givePermissionTo($authorPermissions);

        $admin->givePermissionTo($permissions);
    }
}
