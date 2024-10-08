<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        \App\Models\User::factory()->create([
            'name' => 'Khaled 1',
            'email' => 'khaledmoussa202@gmail.com',
            'phone' => '01015571129',
            'password' => '24001091Km',
            'usertype' => 'Admin',
            'type' => 'Admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Khaled 2',
            'email' => 'khaledmoussa909@gmail.com',
            'phone' => '01015571129',
            'password' => '24001091Km',
            'usertype' => 'Admin',
            'type' => 'Admin',
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Ahmed Abdelnaser',
        //     'email' => 'ag2834747@gmail.com',
        //     'password' => '12345@admin',
        //     'usertype' => 'Admin',
        //     'type' => 'Admin',
        // ]);
    }
}
