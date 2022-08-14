@extends('layouts.app')
@csrf

@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-8">
            @forelse($posts as $key => $post)
                <div>
                    @include('posts.partial.post')
                </div>
            @empty
                No Posts Found
            @endforelse
        </div>
        <div class="col-4">
            @include('posts._activity')
        </div>
    </div>

@endsection
