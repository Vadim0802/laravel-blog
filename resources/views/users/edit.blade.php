@extends('layouts.app')

@section('content')
    <div class="col-lg-8 mx-auto">
        <h2>Update profile</h2>
        <form class="border border-white rounded p-3 bg-white shadow-sm" action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group py-3">
                <label for="name"><strong>Name</strong></label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') ?? $user->name }}">
            </div>
            @error('name')
                <div class="alert alert-warning py-1" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-group py-3">
                <label for="email"><strong>Email</strong></label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') ?? $user->email }}">
            </div>
            @error('email')
                <div class="alert alert-warning py-1" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <div class="form-group py-3">
                <label for="password"><strong>Password</strong></label>
                <input class="form-control" type="password" name="password" id="password" value="{{ old('password') }}">
            </div>
            @error('password')
                <div class="alert alert-warning py-1" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <button class="btn btn-outline-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
