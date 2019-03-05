<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Topic;
use \App\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (Topic::all() as $topic) {
            // Create 4 tasks in each topic
            for ($i = 0; $i < 4; $i++) {
                $task = new Task();
                $task->name = $faker->sentence;
                $task->description = $faker->text(350);
                $topic->tasks()->save($task);

                // Create 2 subtasks for each task
                for ($j = 0; $j < 2; $j++) {
                    $subTask = new Task();
                    $subTask->name = $faker->sentence;
                    $subTask->description = $faker->text(350);
                    $subTask->topic()->associate($topic);
                    $task->subTasks()->save($subTask);
                }
            }
        }



    }
}
