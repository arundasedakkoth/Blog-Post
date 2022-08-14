@forelse ($comments as $comment)
    <p class="pt-3">{{ $comment->content }}
        <x-commented date="{{ $comment->created_at }}" name="{{ $comment->user->name }}">
            @slot('userId', $comment->user->id)
            added
        </x-commented>
    </p>
    <x-tags :tags="$comment->tags"></x-tags>
@empty
    <p class="text-muted pb-3">No comments</p>
@endforelse
