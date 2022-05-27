@extends('layouts.app')

@section('content')
    <div class="col-lg-5 mx-auto">
        <form class="border rounded p-3 bg-white shadow-sm" action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="form-group py-3">
                <label for="title"><strong>Title</strong></label>
                <input class="form-control @error('slug') is-invalid @enderror" type="text" name="title" id="title"
                       value="{{ old('title') }}">
                @error('slug')
                    <span class="invalid-feedback">
                        {{ Str::swap(['slug' => 'title'], $message) }}
                    </span>
                @enderror
            </div>
            <div class="form-group py-3">
                <label for="content"><strong>Content</strong></label>
                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content"
                          cols="30" rows="10">{{ old('content') }}</textarea>
                @error('content')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="form-group py-3">
                <label for="tags"><strong>Tags</strong></label>
                <select multiple size="5" name="tags[]" id="tags"
                        class="form-select @error('tags') is-invalid @enderror">
                    @forelse($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @empty
                        <option selected>No tags available</option>
                    @endforelse
                </select>
                @error('tags')
                <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            <button class="btn btn-outline-primary" type="submit">Create</button>
        </form>
    </div>
@endsection
