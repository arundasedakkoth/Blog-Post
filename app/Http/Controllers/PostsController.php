<?php

namespace App\Http\Controllers;

use App\Contracts\CounterContract;
use App\Events\BlogPostPosted;
use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\DB;

// [
// 'show' => 'view',
// 'create' => 'create',
// 'store' => 'create',
// 'edit' => 'update',
// 'update' => 'update',
// 'destroy' => 'delete',
// ]

class PostsController extends Controller
{
    private $counter;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(CounterContract $counter)
    {
        $this->middleware('auth')
            ->only(['create', 'edit', 'update', 'destroy']);

        $this->counter = $counter;
    }

    public function index()
    {
        // DB::connection();
        // DB::enableQueryLog();

        // $posts = BlogPost::with('comments')->get();
        // foreach($posts as $post) {
        //     foreach($post->comments as $comment) {
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        // $mostCommented = Cache::remember('blog-post-commented', now()->addSeconds(10), function () {
        //     return BlogPost::mostCommented()->take(5)->get();
        // });

        // $mostActive = Cache::remember('users-most-active', now()->addSeconds(10), function () {
        //     return User::withMostBlogPosts()->take(5)->get();
        // });

        // $mostActiveLastMonth = Cache::remember('users-most-active-lm', now()->addSeconds(10), function () {
        //     return User::withMostBlogPostsLastMonth()->take(5)->get();
        // });

        return view('posts.index',
            [
                'posts' => Blogpost::latestWithRelations()->get(),
                // 'mostCommented' => $mostCommented,
                // 'mostActive' => $mostActive,
                // 'mostActiveLastMonth' => $mostActiveLastMonth,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        // $post = new BlogPost();
        // $post->title = $validated['title'];
        // $post->content = $validated['content'];
        // $post->save();

        $validated = $request->validated();
        // $validated['user_id'] = auth()->user()->id;
        $validated['user_id'] = $request->user()->id;

        $post = BlogPost::create($validated);

        if ($request->hasfile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            $post->image()->save(
                Image::make(['path' => $path])
            );
        }

        event(new BlogPostPosted($post));

        session()->flash('status', 'Post was successful!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // abort_if(!isset($this->posts[$id]), 404);

        // return view('posts.show', [
        //     'post' => Blogpost::with(['comments', function ($query) {
        //         return $query->latest()
        //     }])->findOrfail($id),
        // ]);

        $blogPost = Cache::tags(['blog-post'])
            ->remember('blog-post-{$id}', 5, function () use ($id) {
                return Blogpost::with(
                    'comments',
                    'tags',
                    'user',
                    'comments.user')
                        ->findOrfail($id);
            });

        // $counter = resolve(Counter::class);

        return view('posts.show', [
            'post' => $blogPost,
            'counter' => $this->counter->increment("blog-post-{$id}", ['blog-post']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrfail($id);

        $this->authorize($post);
        // can also call like this: $this->authorize('edit', $post);

        return view('posts.edit', ['post' => Blogpost::findOrfail($id)]); // or $post
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrfail($id);

        $this->authorize($post);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this post");
        // } //General Way

        $validated = $request->validated();
        $post->fill($validated);

        if ($request->hasfile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails');

            if ($post->image) {
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            } else {
                $post->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

        $post->save();

        session()->flash('status', 'Post updated successfully');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Blogpost::findOrfail($id);

        $this->authorize($post);

        $post->delete();

        session()->flash('status', 'Post deleted successfully!');

        return redirect()->route('posts.index');
    }
}
