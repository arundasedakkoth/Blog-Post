<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use HasFactory;

    public function testNoPostWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No Posts Found');
    }

    public function testSeePostIfThereIs1WithComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();
        
        Comment::factory()->count(5)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Models\BlogPost',
            'user_id' => $post->user->id
        ]);

        // Act
        $response = $this->get('/posts');
        
        // Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('5 comments');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);
    }

    public function testStoreValid()
    {
        $this->withoutMiddleware();

        $params = [
            'title' => 'A valid title',
            'content' => 'And a valid content to the blog'
        ];

        // $user = $this->user();

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Post was successful!');
    }

    public function testStoreFail()
    {
        $this->withoutMiddleware();

        $params = [
            'title' => 'a',
            'content' => 'b'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $errmsgs = session('errors')->getMessages();

        $this->assertEquals($errmsgs['title'][0], 'The title must be at least 4 characters.');
        $this->assertEquals($errmsgs['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $this->withoutMiddleware();

        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());

        $params = [
            'title' => 'Title that is updated',
            'content' => 'content of the blog that is updated'
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Post updated successfully');

        $this->assertDatabaseMissing('blog_posts', $post->toArray());

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'Title that is updated'
        ]);
    }

    public function testDelete()
    {
        $this->withoutMiddleware();

        $user = $this->user();

        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', $post->toArray());
    
        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Post deleted successfully!');

        // $post = BlogPost::onlyTrashed()->find($post->id);
        // $this->assertDatabaseMissing('blog_posts', $post->toArray());
        
        $this->assertSoftDeleted('blog_posts', $post->toArray());
    }

    private function createDummyBlogPost($userId = null):BlogPost
    {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the test Blog';
        // $post->save();

        $post = BlogPost::factory()->newTitle()->create([
            'user_id' => $userId ?? $this->user()->id,
        ]);

        return $post;
    }
}
