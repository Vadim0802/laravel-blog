@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('articles.index') }}" method="get">
                    <div class="form-group">
                        <input class="form-control" type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @forelse ($articles as $article)
                    <div class="card my-3">
                        <div class="card-header">
                            <a class="link-secondary" href="{{ route('articles.show', $article) }}">
                                <strong>{{ $article->title }}</strong>
                            </a>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ Str::limit($article->content, 200) }}
                            </p>
                        </div>
                        <div class="card-footer p-1">
                            <p class="card-text text-end">
                                <small>
                                    <a href="{{ route('users.show', $article->author) }}">
                                        {{ $article->author->name }}
                                    </a>
                                </small>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning my-3" role="alert">
                        Not found
                    </div>
                @endforelse
                {{ $articles->appends(request()->query())->links() }}
            </div>
            <div class="col-lg-4">
                <div class="card my-3">
                    <div class="card-header">
                        <strong>Most Popular Articles</strong>
                    </div>
                    <div class="card-body" id="popular-articles-body">
                        @foreach ($popularArticles as $popularArticle)
                            <a class="" href="{{ route('articles.show', $popularArticle) }}">{{ $popularArticle->title }}</a>
                            <small>{{ $popularArticle->likes_count }} likes</small>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
