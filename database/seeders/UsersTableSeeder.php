<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = max($this->command->ask('How many users to be seeded?', 20), 1);

        // User::factory()->testUser()->create();
        
        User::factory($usersCount)->create();
    }
}
