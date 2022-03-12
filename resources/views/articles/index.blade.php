@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form class="d-flex gap-3" action="{{ route('articles.index') }}" method="GET">
                    <div class="form-group flex-grow-1">
                        <input class="form-control" type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                    </div>
                    <div class="form-group">
                        <select class="form-select" name="tag">
                            <option
                                value=""
                                @if(!request('tag'))
                                    selected="selected"
                                @endif
                            >All</option>
                            @foreach($tags as $tag)
                                <option
                                    value="{{ $tag->name }}"
                                    @if($tag->name === request('tag'))
                                        selected
                                    @endif
                                >{{ $tag->name }}</option>
                            @endforeach
                        </select>
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
                        <div class="card-footer p-1 d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                @foreach($article->tags as $tag)
                                    @break($loop->index > 4)
                                    <div class="bg-white shadow-sm border-secondary rounded-3 p-1">
                                        {{ $tag->name }}
                                    </div>
                                @endforeach
                            </div>
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
