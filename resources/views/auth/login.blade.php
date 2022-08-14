@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="form-control{{ $errors->has('email') ? ' is-invalid': '' }}">
            @if ($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
            <br>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required
                class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}">
            @if ($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
            <br>
        </div>

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" 
                value="{{ old('remember') ? 'checked': '' }}">

                <label for="remember" class="form-check-label">Remember Me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
@endsection
