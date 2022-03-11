@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-5 mx-auto">
            @if (session('success'))
                <div class="alert alert-success mt-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form class="d-flex gap-3 mb-3" action="{{ route('admin_manage_tags_store') }}" method="POST">
                @csrf
                <input class="form-control" type="text" placeholder="Tag" name="name">
                <button class="btn btn-outline-primary" type="submit">Add</button>
            </form>
            @error('name')
                <div class="alert alert-warning py-1" role="alert">
                    {{ $message }}
                </div
            @enderror
            <table class="table table-striped table-bordered">
                <thead>
                    <th scope="col">Name</th>
                    <th></th>
                </thead>
                <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td>
                            <a class="btn btn-danger" href="{{ route('admin_manage_tags_destroy', $tag) }}" data-method="delete">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tags->links() }}
        </div>
    </div>
@endsection
