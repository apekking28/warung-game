<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::unsetEventDispatcher();

        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            Customer::create([
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'created_by' => 1, 
                'updated_by' => 1, 
            ]);
        }

        Customer::create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'address' => 'Jl. Test No. 123, Jakarta',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}