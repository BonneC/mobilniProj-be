<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Task;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function generateRandomTaskIds()
    {
        $taskList = range(0, Task::all()->count() - 1);
        shuffle($taskList);
        return array_slice($taskList, 0, 3);
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
