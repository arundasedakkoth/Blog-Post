<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = BlogPost::all();
        $users = User::all();

        if ($posts->count() === 0 || $users->count() === 0) {
            $this->command->info('There is no Posts or Users to comment!!!');
        } else {
            $cmntsCount = $this->command->ask('How many comments to be seeded?', 100);
    
            Comment::factory($cmntsCount)->make()->each(function ($comment) use ($posts, $users) {
                $comment->commentable_id = $posts->random()->id;
                $comment->commentable_type = 'App\Models\BlogPost';
                $comment->user_id = $users->random()->id;
                $comment->save();
            });

            Comment::factory($cmntsCount)->make()->each(function ($comment) use ($users) {
                $comment->commentable_id = $users->random()->id;
                $comment->commentable_type = 'App\Models\User';
                $comment->user_id = $users->random()->id;
                $comment->save();
            });
        }

    }
}
