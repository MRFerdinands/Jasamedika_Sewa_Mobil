<?php

namespace Database\Seeders;

use App\Models\Car;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Car::factory(10)->create();

        User::create([
            'role' => 'Admin',
            'no_sim' => '012345678912',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '081234567890',
            'password' => bcrypt('jasamedika'),
            'address' => 'Jl. Jalan Jalan No. 1',
        ]);

        User::create([
            'role' => 'User',
            'no_sim' => '012345678913',
            'name' => 'User',
            'email' => 'user@user.com',
            'phone' => '081234567891',
            'password' => bcrypt('jasamedika'),
            'address' => 'Jl. Jalan Jalan No. 2',
        ]);
    }
}
