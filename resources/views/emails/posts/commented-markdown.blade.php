@component('mail::message')
# Commented on your post

Hi {{ $comment->commentable->user->name}}

{{ $comment->user->name }} has commented on your post 

@component('mail::panel')
"{{ $comment->content }}"
@endcomponent

@component('mail::button', ['url' => route('posts.show', ['post' => $comment->commentable->id]) ])
    View post
@endcomponent

@component('mail::button', ['url' => route('users.show', ['user' => $comment->user->id]) ])
    {{ $comment->user->name }}'s Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
