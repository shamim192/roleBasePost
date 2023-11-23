@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" required>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="content">Content:</label>
        <textarea name="content" required>{{ old('content', $post->content) }}</textarea>
        @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="pending_review" {{ old('status', $post->status) === 'pending_review' ? 'selected' : '' }}>Pending Review</option>
            <option value="approved" {{ old('status', $post->status) === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ old('status', $post->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        @error('status')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit">Update Post</button>
    </form>
@endsection