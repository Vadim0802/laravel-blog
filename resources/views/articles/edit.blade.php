@extends('layouts.app')

@section('content')
    <div class="col-lg-5 mx-auto">
        <form class="border rounded p-3 bg-white shadow-sm" action="{{ route('articles.update', $article) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group py-3">
                <label for="title"><strong>Title</strong></label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title') ?? $article->title }}">
            </div>
            @error('slug')
            <div class="alert alert-warning py-1" role="alert">
                {{ Str::swap(['slug' => 'title'], $message) }}
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
            <div class="form-group py-3">
                <label for="tags"><strong>Tags</strong></label>
                <select multiple size="5" name="tags[]" id="tags" class="form-select">
                    @forelse($tags as $tag)
                        <option
                            value="{{ $tag->id }}"
                            @if($article->tags->contains($tag->id)))
                                selected
                            @endif
                        >{{ $tag->name }}</option>
                    @empty
                        <option selected>No tags available</option>
                    @endforelse
                </select>
            </div>
            @error('tags')
            <div class="alert alert-warning py-1" role="alert">
                {{ $message }}
            </div>
            @enderror
            <button class="btn btn-outline-primary" type="submit">Update</button>
        </form>
    </div>
@endsection
