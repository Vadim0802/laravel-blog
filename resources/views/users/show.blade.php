@extends('layouts.app')

@section('content')
    <div class="container shadow-sm bg-white rounded-3 p-3">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex flex-column py-3 gap-1">
                    <h4>{{ $user->name }}</h4>
                    <small>On Articabr since {{ $user->created_at->format('d F Y')  }}</small>
                    @if($user->is(auth()->user()))
                        <a class="btn btn-outline-primary w-50" href="{{ route('users.edit', $user) }}">Edit profile</a>
                    @endif
                </div>
            </div>
            <div class="col-lg-8">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column align-items-center py-3">
                        <h3>Articles</h3>
                        <h4 class="text-secondary">{{ $user->articles->count() }}</h4>
                    </div>
                    <div class="d-flex flex-column align-items-center py-3">
                        <h3>Liked articles</h3>
                        <h4 class="text-secondary">{{ $user->likes->count() }}</h4>
                    </div>
                    <div class="d-flex flex-column align-items-center py-3">
                        <h3>Likes on articles</h3>
                        <h4 class="text-secondary">{{ $user->articles()->sum('likes_count') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
