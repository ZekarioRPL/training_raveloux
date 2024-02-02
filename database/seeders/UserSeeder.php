<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserRole;
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

        $roleAdmin = Role::where('guard_name', 'admin')->first();

        UserRole::create([
            'role_id' => $roleAdmin->id,
            'user_id' => $admin->id
        ]);

        # insert random account
        $roleSimple = Role::where('guard_name', 'simple')->first();
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

            UserRole::create([
                'role_id' => $roleSimple->id,
                'user_id' => $user->id
            ]);
        }
    }
}
