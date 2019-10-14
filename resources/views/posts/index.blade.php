@extends('layouts.app')

@section('content')
<div class="container">
    @if ($posts->count() > 0)
    @foreach($posts as $post)
    <div class="row">
        <div class="col-6 offset-3">
            <a href="/p/{{ $post->id }}">
                <img src="{{ $post->image }}" alt="" class="w-100">
            </a>
        </div>
    </div>
    <div class="row pt-2 pb-4">
        <div class="col-6 offset-3">
            <div>
                <p>
                    <span class="font-weight-bold">
                        <a href="/profile/{{ $post->user_id }}">
                            <span class="text-dark"> {{ $post->user->username }}</span>
                        </a>
                    </span>
                    {{ $post->caption }}
                </p>
            </div>
            <hr>
        </div>

    </div>

    @endforeach

    <div class="row col-12 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
    @else
    <h3>No Posts Found</h3>
    @endif
</div>
@endsection
