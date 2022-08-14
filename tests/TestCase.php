<?php

namespace Tests;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function user()
    {
        return User::factory()->testUser()->create()->first();
    }

    protected function createTestBlog()
    {
        return BlogPost::factory()->create([
            'user_id' => $this->user()->id,
        ]);
    }
}
