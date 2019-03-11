<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Task;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function generateRandomTaskIds()
    {
        $taskList = \Illuminate\Support\Arr::random(
            Task::rootTasks()->get()->all(),
            3
        );
        return [
            $taskList[0]->id,
            $taskList[1]->id,
            $taskList[2]->id
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'Atanas Kostovski';
        $user->email = 'atanasmk16@gmail.com';
        $user->password = bcrypt('sotiegajle');
        $user->save();
        $user->topics()->attach([1, 2, 3]);
        $user->tasks()->attach(
            $this->generateRandomTaskIds()
        );

        $user = new User();
        $user->username = Str::random(10);
        $user->email = Str::random('10') . '@gmail.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->topics()->attach([2, 3, 4]);
        $user->tasks()->attach(
            $this->generateRandomTaskIds()
        );

        $user = new User();
        $user->username = Str::random(10);
        $user->email = Str::random('10') . '@gmail.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->topics()->attach([1]);
        $user->tasks()->attach(
            $this->generateRandomTaskIds()
        );

        $user = new User();
        $user->username = Str::random(10);
        $user->email = Str::random('10') . '@gmail.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->topics()->attach([1, 4]);
        $user->tasks()->attach(
            $this->generateRandomTaskIds()
        );

    }
}
