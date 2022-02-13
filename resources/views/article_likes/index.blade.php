@extends('layouts.app')

@section('content')
    <div class="col-lg-5 mx-auto">
        <ul class="list-group">
            @foreach ($likes as $like)
                <li class="list-group-item">{{ $like->user->name }}</li>
            @endforeach
        </ul>
        <div class="my-3">
            {{ $likes->links() }}
        </div>
    </div>
@endsection
