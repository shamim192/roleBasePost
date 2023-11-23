@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Review Post</h1>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <div class="card">
            <div class="card-header">
                {{ $post->title }}
            </div>
            <div class="card-body">
                <p>{{ $post->content }}</p>
            </div>
        </div>

        <form method="post" action="{{ route('posts.approve', $post) }}">
            @csrf
            <button type="submit" style="background-color: green" class="btn btn-success no-border">Approve</button>
        </form>

        <form method="post" action="{{ route('posts.reject', $post) }}">
            @csrf
            <button type="submit" style="background-color: red" class="btn btn-danger no-border">Reject</button>
        </form>
    </div>
@endsection