<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserting data into the users table
        User::create([
            'name' => 'Ali baba',
            'email' => 'alibaba@example.com',
            'password' => Hash::make('password123'),  // Make sure to hash the password
        ]);

        // You can add more users if needed
        User::create([
            'name' => 'AAk Bro',
            'email' => 'aakbro@example.com',
            'password' => Hash::make('password456'),
        ]);

        // Or you can use a loop to insert multiple users
        // \App\Models\User::factory(10)->create(); // If you want to use a factory to create dummy users
    }
}
