<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Generator $faker)
    {
        $demoUser = User::create([
            'name'              => $faker->name,
            'email'             => 'demo@demo.com',
            'password'          => Hash::make('demo'),
            'email_verified_at' => now(),
        ]);

        $demoUser2 = User::create([
            'name'              => $faker->name,
            'email'             => 'admin@presus.com',
            'password'          => Hash::make('adminpresus1'),
            'email_verified_at' => now(),
        ]);

        $demoUser3 = User::create([
            'name'              => 'Rod',
            'email'             => 'rvillchav@gmail.com',
            'password'          => Hash::make('987654321'),
            'email_verified_at' => now(),
        ]);
    }
}
