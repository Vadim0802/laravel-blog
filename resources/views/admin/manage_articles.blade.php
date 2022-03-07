@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-8 mx-auto">
            @if (session('success'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table">
                <thead>
                    <th scope="col">Author</th>
                    <th scope="col">Article</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->author->name }}</td>
                            <td>{{ $article->title }}</td>
                            <td><a class="btn btn-danger" href="{{ route('admin_manage_articles_destroy', $article) }}" data-method="delete">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $articles->links() }}
        </div>
    </div>
@endsection