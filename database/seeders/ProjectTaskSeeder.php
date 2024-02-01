<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProjectTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # init faker
        $faker = Faker::create('id_ID');

        # insert Project

        for($i = 1; $i <= 40; $i++) {
            $project = Project::create([
                'title' => "project_$i",
                'description' => $faker->text(),
                'user_id' => User::inRandomOrder()->first()->id,
                'client_id' => Client::inRandomOrder()->first()->id,
                'deadline' => $faker->date(),
                'status' => 'open'
            ]);

            Task::create([
                'title' => "task_$i",
                'description' => $faker->text(),
                'user_id' => User::inRandomOrder()->first()->id,
                'client_id' => Client::inRandomOrder()->first()->id,
                'project_id' => $project->id,
                'deadline' => $faker->date(),
                'status' => 'open'
            ]);
        }
    }
}
