<p>
    @foreach ($tags as $tag)
    <a href="{{ route('posts.tags.index', ['tag' => $tag->id]) }}" class="badge bg-success badge-lg text-decoration-none">{{ $tag->name }}</a>        
    @endforeach
</p>