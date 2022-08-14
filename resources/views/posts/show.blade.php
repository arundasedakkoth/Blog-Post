@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="row">
        <div class="col-8">

            @if ($post->image)
                <div style="background-image: url('{{ $post->image->url() }}'); width:100%; min-height: 500px; background-size: cover; background-attachment: fixed; text-shadow: 1px 2px #000;"
                    class="rounded-top">
            @endif

            @if ($post->image)
                </div>
            @endif

        <div class="container bg-white">
            <div class="d-flex justify-content-between pt-4">
                <h5 class="font-weight-bold" style="color: rgb(12, 12, 110)">{{ $post->user->name, /*$post->user->id */}}</h5>
                <p class="d-flex justify-content-end text-muted px-3">{{ $post->created_at->diffForHumans() }}</p>
            </div>
            <h1>{{ $post->title }}</h1>

            <x-updatedby date="{{ $post->updated_at }}">
                Updated
            </x-updatedby>

            <p class="mb-5 pt-2">{{ $post->content }}</p>


            <x-tags :tags="$post->tags"></x-tags>



            <x-badge type="info" show="{{ now()->diffInMinutes($post->created_at) < 5 }}">
                New
            </x-badge>

            <h4 class="pt-5">Comments</h4>

            <x-commentForm route="{{ route('posts.comment.store', ['post' => $post->id]) }}"></x-commentForm>

            <x-commentList>
                @slot('comments', $post->comments)
            </x-commentList>
            
            <div class="d-flex flex-row-reverse pb-4">
                <span class="text-muted">{{ trans_choice('messages.people.reading', $counter) }}</span>
            </div>
        </div>
    </div>

        <div class="col-4">
            @include('posts._activity')
        </div>
    
@endsection
