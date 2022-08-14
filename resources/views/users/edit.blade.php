@extends('layouts.app')

@section('content')
    <form class="form-horizontal" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img class="img-thumbnail avatar" src="{{ $user->image ? $user->image->url() : '' }}" alt="Profile Pic">
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="text-white">{{ __('Upload a different photo') }}</h6>
                        <input type="file" name="avatar" class="form-control-file">
                    </div>
                </div>
            </div>

            @error('avatar')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div class="col-8 text-white">
                <div class="form-group">
                    <label for="name">{{ __('Name:') }}</label>
                    <input class="form-control" type="text" name="name" id="">
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Language:') }}</label>
                    <select class="form-control" name="locale" id="">
                        @foreach (App\Models\User::LOCALES as $locale => $label)
                            <option value="{{ $locale }}" {{ $user->locale !== $locale ? : 'selected' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <br><br><br>

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{{ __('Save changes') }}">
                </div>
            </div>
        </div>

    </form>
@endsection
