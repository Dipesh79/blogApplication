<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                PermissionSeeder::class,
                UserSeeder::class,
                CategorySeeder::class,
                TagSeeder::class,
                PostSeeder::class,
                CommentSeeder::class,
            ]
        );
    }
}
