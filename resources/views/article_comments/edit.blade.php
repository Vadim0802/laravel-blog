@extends('layouts.app')

@section('content')
    <div class="col-lg-7 mx-auto">
        <form class="border border-white rounded p-3 bg-white" action="{{ route('articles.comments.update', [$article, $comment]) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group pb-3">
                <label for="comment"><strong>Comment</strong></label>
                <textarea class="form-control" name="content" id="comment" cols="30" rows="6">{{ old('content') ?? $comment->content }}</textarea>
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
