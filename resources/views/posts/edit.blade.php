@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

    <div>
        <h1>Edit Post</h1>
    </div>
    <form action="{{ route('posts.update', ['post' => $post->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('posts.partial._form')

        <div><input type="submit" value="Update" class="btn btn-primary w-100"></div>
    </form>
@endsection
