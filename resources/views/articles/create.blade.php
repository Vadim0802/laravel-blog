@extends('layouts.app')

@section('content')
    <div class="col-lg-5 mx-auto">
        <form class="border border-white rounded p-3 bg-white shadow-sm" action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="form-group py-3">
                <label for="title"><strong>Title</strong></label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
            </div>
            @error('slug')
                <div class="alert alert-warning py-1" role="alert">
                    {{ Str::swap(['slug' => 'title'], $message) }}
                </div>
            @enderror
            <div class="form-group py-3">
                <label for="content"><strong>Content</strong></label>
                <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
            </div>
            @error('content')
                <div class="alert alert-warning py-1" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <button class="btn btn-outline-primary" type="submit">Create</button>
        </form>
    </div>
@endsection
