@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success')  }}
                    </div>
                @endif

                @foreach($articles as $article)
                    <div class="card my-3">
                        <div class="card-header">
                            <a class="link-secondary" href="{{ route('articles.show', $article) }}">
                                <strong>{{ $article->title }}</strong>
                            </a>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ $article->content }}
                            </p>
                        </div>
                        <div class="card-footer p-1">
                            <p class="card-text text-end"><small>{{ $article->author->name }}</small></p>
                        </div>
                    </div>
                @endforeach
                {{ $articles->links() }}
            </div>
            <div class="col-lg-4">
                <div class="card my-3">
                    <div class="card-header">
                        <strong>Most Popular Articles</strong>
                    </div>
                    <div class="card-body">
                        @foreach ($popularArticles as $popularArticle)
                            <a href="{{ route('articles.show', $popularArticle) }}">{{ $popularArticle->title }}</a>
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
