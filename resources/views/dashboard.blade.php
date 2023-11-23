@extends('layouts.app')

@section('content')
    @role('admin')
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-4">Create Post</a>
    @endrole

    <div class="container">
        @forelse ($posts as $post)
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    <p class="card-text">{{ $post->content }}</p>

                    @if ($post->status === 'pending_review')
                        <span class="badge bg-warning text-dark">Pending Review</span>
                    @endif

                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary no-border">Edit</a>

                    @if ($post->status !== 'pending_review')
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif

                    @if ($post->status === 'pending_review')
                        <form action="{{ route('posts.submitForReview', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" style="background-color: #ffc107" class="btn btn-warning no-border">Submit for Review</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p>No posts found.</p>
        @endforelse
    </div>
    @if (Auth::user()->hasRole('super-admin'))
        <div class="container mt-4">
            <h2 class="mb-4">Posts for Review</h2>

            @foreach ($postsForReview as $post)
                <div class="card mb-4">
                    <div class="card-header">
                        {{ $post->title }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $post->content }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('posts.review', $post) }}" class="btn btn-primary">Review</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    </div>
    </div>
@endsection
