@extends('layouts.app')

@section('content')  

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @can('create-post')
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    @endcan

    <div>
        <!-- Display a list of posts -->
        @forelse($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    <p class="card-text">{{ $post->content }}</p>

                    @if ($post->status === 'pending_review')
                        <span class="badge bg-warning text-dark">Pending Review</span>
                    @endif

                    @can('edit-post', $post)
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">Edit</a>
                    @endcan

                    @can('delete-post', $post)
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: red" class="btn btn-danger no-border">Delete</button>
                        </form>
                    @endcan

                    @if ($post->status === 'pending_review')
                        <!-- Display a button to submit for review -->
                        <form action="{{ route('posts.submitForReview', $post) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning">Submit for Review</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p>No posts found.</p>
        @endforelse
    </div>
@endsection
