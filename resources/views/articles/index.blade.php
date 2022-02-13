@extends('layouts.app')

@section('content')
    <div class="col-lg-8 mx-auto">
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success')  }}
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
                        <p class="card-text text-end"><small>{{ $article->user->name }}</small></p>
                    </div>
                </div>
            @endforeach
            {{ $articles->links() }}
    </div>
@endsection
