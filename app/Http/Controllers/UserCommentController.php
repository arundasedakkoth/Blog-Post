<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(User $user, StoreComment $request)
    {
        // $validated = $request->validated();
        // $validated['user_id'] = $request->user()->id;
        // $validated['content'] = $request->input('content');
        // $validated['blog_post_id'] = intval($request->post);

        // $comment = Comment::create($validated);

        $user->commentsOn()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()->back()->withStatus('Comment was successful!');
    }
}
