<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\User;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        if ($users->count() === 0) {
            $this->command->info('There is no users to post blog!!! ');
        } else {
            $bpCount = max($this->command->ask('How many blogposts to be seeded?', 30), 1);
    
            BlogPost::factory($bpCount)->make()->each(function ($post) use ($users) {
                $post->user_id = $users->random()->id;
                $post->save();
            });
        }

    }
}
