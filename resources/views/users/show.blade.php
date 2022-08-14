@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-4">
            <img class="img-thumbnail avatar" src="{{ $user->image ? $user->image->url() : '' }}" alt="Profile Pic">
        </div>

        <div class="col-8 text-white">
            <h3>{{ $user->name }}</h3>
            
            <x-commentForm route="{{ route('users.comment.store', ['user' => $user->id]) }}"></x-commentForm>
    
            <x-commentList>
                @slot('comments', $user->commentsOn)
            </x-commentList>

            <p>Currently viewed by {{ $counter }} users</p>

        </div>


    </div>

@endsection