<?php

use Illuminate\Database\Seeder;
use App\Topic;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic = new Topic();
        $topic->title = 'Music';
        $topic->description = 'Music desc';
        $topic->save();

        $topic = new Topic();
        $topic->title = 'Programming';
        $topic->description = 'Prog desc';
        $topic->save();

        $topic = new Topic();
        $topic->title = 'Drawing';
        $topic->description = 'Drawing desc';
        $topic->save();

        $topic = new Topic();
        $topic->title = 'Physics';
        $topic->description = 'Physics desc';
        $topic->save();
    }
}
