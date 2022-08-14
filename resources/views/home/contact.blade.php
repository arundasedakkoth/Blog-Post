@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <div style="text-center">
        <h1>Contact</h1>
        @can('home.secret')
        <p>
            <a href="{{ route('secret') }}">
                Confidential contact
            </a>
        </p>
        @endcan
    </div>
@endsection