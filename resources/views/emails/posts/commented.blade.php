<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #000;
        color: #fff;
    }
</style>

<p>
    Hi {{ $comment->commentable->user->name}}
</p>
<br>
<p>
    Someone has commented on your post 
    <a href="{{ route('posts.show', ['post' => $comment->commentable->id]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>

<hr>
<br>

<p>
    {{-- <img src="{{ $comment->user->image->url() }}" alt="Image"> --}}
    
    <img src="{{ $message->embed(public_path('storage/' . $comment->user->image->path)) }}" alt="Image">

    <br>
    <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">
        {{ $comment->user->name }}
    </a>
    : {{ $comment->content }}
</p>