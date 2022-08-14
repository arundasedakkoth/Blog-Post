<div class="mb-2 bg-white pt-4 px-4 pb-3 rounded">
    <h3 class="mb-2">
        @if ($post->trashed())
            <del>
        @endif
        <a href="{{ route('posts.show', ['post' => $post->id]) }}"
            class="{{ $post->trashed() ? 'text-muted text-decoration-none' : 'text-dark text-decoration-none' }}">{{ $post->title }}
        </a>
        @if ($post->trashed())
            </del>
        @endif
    </h3>

    <x-updatedby name="{{ $post->user->name }}" date="{{ $post->created_at }}">
        @slot( 'userId', $post->user->id )
    </x-updatedby>

    <x-tags :tags="$post->tags"></x-tags>

    <div class="d-flex justify-content-end">
        @auth
            @can('update', $post)
                <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary mr-2">
                    Edit
                </a>
            @endcan
        @endauth
        @auth
            @if (!$post->trashed())
                @can('delete', $post)
                    <form class="d-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-secondary mx-2">
                    </form>
                @endcan
            @endif
        @endauth
    </div>
    {{-- @if ($post->comments_count)
        <p class="d-inline">{{ $post->comments_count }} comments</p>
    @else
        <p class="d-inline">No comments</p>
    @endif --}}

    {{ trans_choice('messages.comments', $post->comments_count) }}
</div>
