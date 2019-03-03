<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
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

        $user = new User();
        $user->username = Str::random(10);
        $user->email = Str::random('10') . '@gmail.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->topics()->attach([2, 3, 4]);


        $user = new User();
        $user->username = Str::random(10);
        $user->email = Str::random('10') . '@gmail.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->topics()->attach([1]);


        $user = new User();
        $user->username = Str::random(10);
        $user->email = Str::random('10') . '@gmail.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->topics()->attach([1, 4]);

    }
}
