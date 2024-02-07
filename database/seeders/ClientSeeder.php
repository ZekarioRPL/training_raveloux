<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # init faker
        $faker = Faker::create('id_ID');

        # Insert Random Client
        for($i = 1; $i <= 30; $i++) {
            Client::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'contact_name' => $faker->name(),
                'contact_email' => $faker->email(),
                'contact_phone_number' => $faker->phoneNumber(),
                'company_name' => $faker->company(),
                'company_address' => $faker->address(),
                'company_city' => $faker->city(),
                'company_zip' => "101$i",
                'company_val' => "101$i"
            ]);
        }
    }
}
