<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(1)->create();

        \App\Models\User::factory()->create([
            'name' => 'Khaled',
            'email' => 'khaledmoussa202@gmail.com',
            'phone' => '01015571129',
            'password' => Hash::make('24001091Km'),
            'usertype' => 'Admin',
            'type' => 'Admin',
        ]);
        
        // \App\Models\User::factory()->create([
        //     'name' => 'Customer',
        //     'email' => 'customer@gmail.com',
        //     'password' => Hash::make('24001091Km'),
        //     'usertype' => 'Customer',
        //     'type' => 'Customer',
        // ]);
    }
}
