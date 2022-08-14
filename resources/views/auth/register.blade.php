@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="form-control{{ $errors->has('name') ? ' is-invalid': '' }}">
            @if ($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
            <br>
        </div>

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
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" required class="form-control">
            <br>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
@endsection
