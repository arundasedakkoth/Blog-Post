@extends('layouts.app')

@section('title', 'Create Post')

@section('content')

    <div>
        <div>
            <h1>Add Post</h1>
        </div>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @include('posts.partial._form')
            <div><input type="submit" value="Create" class="btn btn-primary w-100"></div>
        </form>
    @endsection
</div>
