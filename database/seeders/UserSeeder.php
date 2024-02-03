<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # init faker
        $faker = Faker::create('id_ID');

        # insert User Admin
        $admin = User::create([
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ]);

        UserDetail::create([
            'user_id' => $admin->id,
            'first_name' => $faker->name(),
            'last_name' => $faker->name(),
            'address' => $faker->address(),
            'phone_number' => $faker->phoneNumber(),
        ]);

        # role assigned
        $admin->assignRole('admin');

        # insert random account
        for($i = 1; $i < 10; $i++) {
            $user = User::create([
                'email' => strtolower(str_replace(" ", "_", $faker->name()) . '@gmail.com'),
                'password' => "password",
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'first_name' => $faker->name(),
                'last_name' => $faker->name(),
                'address' => $faker->address(),
                'phone_number' => $faker->phoneNumber(),
            ]);

            # role assigned
            $user->assignRole('simple');
        }
    }
}
