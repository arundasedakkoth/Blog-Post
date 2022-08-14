<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*Below code is helpful while
         *running the "bd:seed command" &
         *runs twice while [bug]
         *running the "migrate:refresh --seed" command
         */

        if ($this->command->confirm('Do you want to refresh database?', true)) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database refreshed successfully');

        }

        Cache::tags(['blog_post'])->flush();

        $this->call([
            UsersTableSeeder::class, 
            BlogPostsTableSeeder::class, 
            CommentsTableSeeder::class,
            TagsTableSeeder::class,
            BlogPostTagTableSeeder::class
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // DB::table('users')->insert([
        //     'name' => fake()->name(),
        //     'email' => fake()->safeEmail(),
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);

        // $cstmuser = User::factory()->testUser()->create(); 
        // $fctryusers = User::factory(20)->create();
        // $users = $fctryusers->concat([$cstmuser]);

        // $posts = BlogPost::factory(10)->make()->each(function ($post) use ($users) {
        //     $post->user_id = $users->random()->id;
        //     $post->save();
        // });

        // $comments = Comment::factory(100)->make()->each(function ($comment) use ($posts) {
        //     $comment->blog_post_id = $posts->random()->id;
        //     $comment->save();
        // });
    }
}
