<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <title>Blog - @yield('title')</title>
    <style>
        body {
            background-color: rgb(97, 97, 99);
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-4 px-md-4 bg-dark mb-4">
        <h3 class="my-0 text-white">E-Blog</h3>
        <nav class="my-2 my-md-0 mr-md-3 ms-auto">
            <a class="p-2 text-white text-decoration-none" href="{{ route('home.index') }}">{{ __('Home') }}</a>
            <a class="p-2 text-white text-decoration-none" href="{{ route('home.contact') }}">{{ __('Contact') }}</a>
            <a class="p-2 text-white text-decoration-none" href="{{ route('posts.index') }}">{{ __('Posts') }}</a>
            <a class="p-2 text-white text-decoration-none" href="{{ route('posts.create') }}">{{ __('Add') }}</a>

            @guest
                @if (Route::has('register'))
                    <a class="p-2 text-decoration-none" href="{{ route('register') }}">{{ __('Register') }}</a>
                @endif
                <a class="p-2 text-decoration-none" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
                <a class="p-2 text-decoration-none text-white" 
                    href="{{ route('users.show', ['user' => Auth::user()->id]) }}">
                    {{ __('Profile') }}
                </a>
                <a class="p-2 text-decoration-none text-white" 
                    href="{{ route('users.edit', ['user' => Auth::user()->id]) }}">
                    {{ __('Edit Profile') }}
                </a>

                <a class="p-2 text-decoration-none" href="{{ route('logout') }}" 

                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }} ( {{ Auth::user()->name }} )
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
            @endguest
        </nav>
    </div>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div>
            @yield('content')
        </div>
    </div>
</body>

</html>
