@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto d-grid gap-3">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $article->title }}</h2>
                        <div class="text-end">
                            <small>Author: {{ $article->author->name }}</small>
                        </div>
                        <div class="text-end">
                            <small>Created: {{ $article->created_at->format('Y/m/d') }}</small>
                        </div>
                        @canany(['update', 'delete'], $article)
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('articles.edit', $article) }}">Edit</a>
                                <a class="link-danger" href="{{ route('articles.destroy', $article) }}" data-method="delete" data-confirm="You sure?">Delete</a>
                            </div>
                        @endcanany
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $article->content }}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        @if ($article->likes_count)
                            <small><a href="{{ route('articles.likes.index', $article) }}">Likes: {{ $article->likes_count }}</a></small>
                        @else
                            <small>Likes: {{ $article->likes_count }}</small>
                        @endif
                        @auth
                            @if ($article->likes->pluck('user_id')->contains(auth()->id()))
                                <a class="btn btn-outline-danger" href="{{ route('articles.likes.destroy', [$article, $article->likes->firstWhere('user_id', auth()->id())]) }}" data-method="DELETE" rel="nofollow">Dislike</a>
                            @else
                                <a class="btn btn-outline-primary" href="{{ route('articles.likes.store', $article) }}" data-method="POST" rel="nofollow">I like</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            @if($article->tags->count() > 0)
                <div class="col-lg-2 border bg-light rounded-3 p-3">
                    <h4>Tags</h4>
                    <hr>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($article->tags as $tag)
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('articles.index', ['tag' => $tag->name]) }}">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="row gap-3 mt-3">
            <h2>Comments</h2>
            @forelse ($article->comments as $comment)
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <img class="rounded-3" src="{{ asset($comment->user->profile_picture) }}" width="40" height="40" alt="comment_author">
                                <span class="mx-2">
                                {{ $comment->user->name }}
                            </span>
                            </div>
                            @canany(['update', 'delete'], $comment)
                                <div>
                                    <a href="{{ route('articles.comments.edit', [$article, $comment]) }}">Edit</a>
                                    <a href="{{ route('articles.comments.destroy', [$article, $comment]) }}" data-method="delete" data-confirm="You sure?" rel="nofollow">Delete</a>
                                </div>
                            @endcanany
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ $comment->content }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-2">
                    <div class="alert alert-primary" role="alert">
                        No comments yet
                    </div>
                </div>
            @endforelse
        </div>
        @can('create', \App\Models\ArticleComment::class)
            <div class="col-lg-7 mt-3">
                <form class="border rounded p-3 bg-white shadow-sm" action="{{ route('articles.comments.store', $article) }}" method="POST">
                    @csrf
                    <div class="form-group pb-3">
                        <label for="comment"><strong>Comment</strong></label>
                        <textarea class="form-control" name="content" id="comment" cols="30" rows="6">{{ old('content') }}</textarea>
                    </div>
                    @error('content')
                    <div class="alert alert-warning py-1" role="alert">
                        {{ $message }}
                    </div>
                    @enderror
                    <button class="btn btn-outline-primary" type="submit">Create</button>
                </form>
            </div>
        @endcan
    </div>
@endsection
