@component('mail::message')
# Comment on a post that you commented

Hi {{ $user->name}}

{{ $comment->user->name }} also has commented on a post that you commented

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
