@extends('layouts.app')

@section('content')
    <div class="col-lg-5 mx-auto">
        <form class="border border-white rounded p-3 bg-white" action="{{ route('articles.update', $article) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group py-3">
                <label for="title"><strong>Title</strong></label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') ?? $article->title }}">
            </div>
            @error('title')
            <div class="alert alert-warning py-1" role="alert">
                {{ $message }}
            </div>
            @enderror
            <div class="form-group py-3">
                <label for="content"><strong>Content</strong></label>
                <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ old('content') ?? $article->content }}</textarea>
            </div>
            @error('content')
            <div class="alert alert-warning py-1" role="alert">
                {{ $message }}
            </div>
            @enderror
            <button class="btn btn-outline-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
