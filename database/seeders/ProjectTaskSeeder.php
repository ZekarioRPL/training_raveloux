<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;

class ProjectTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # init faker
        $faker = Faker::create('id_ID');
        $statuses = ['open', 'off', 'on', 'done'];
        # insert Project

        for($i = 1; $i <= 40; $i++) {
            $project = Project::create([
                'title' => "project_$i",
                'description' => $faker->text(),
                'user_id' => User::inRandomOrder()->first()->id,
                'client_id' => Client::inRandomOrder()->first()->id,
                'deadline' => $faker->date(),
                'status' => $statuses[($i % count($statuses))]
            ]);

            $task = Task::create([
                'title' => "task_$i",
                'description' => $faker->text(),
                'user_id' => User::inRandomOrder()->first()->id,
                'client_id' => Client::inRandomOrder()->first()->id,
                'project_id' => $project->id,
                'deadline' => $faker->date(),
                'status' => $statuses[($i % count($statuses))]
            ]);
        }

        # limit deadline
        $ten_days_ago = time() + 2*60*60*24;
        $date_3_days_ago = date('Y-m-d', $ten_days_ago);

        for($i = 1; $i <= 5;$i++) {
            $project = Project::create([
                'title' => "project_limit_$i",
                'description' => $faker->text(),
                'user_id' => User::inRandomOrder()->first()->id,
                'client_id' => Client::inRandomOrder()->first()->id,
                'deadline' => $date_3_days_ago,
                'status' => $statuses[($i % count($statuses))]
            ]);
            $task = Task::create([
                'title' => "task_limit_$i",
                'description' => $faker->text(),
                'user_id' => User::inRandomOrder()->first()->id,
                'client_id' => Client::inRandomOrder()->first()->id,
                'project_id' => $project->id,
                'deadline' => $date_3_days_ago,
                'status' => $statuses[($i % count($statuses))]
            ]);
        }
    }
}
