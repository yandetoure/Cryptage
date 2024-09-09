@extends('layouts.app')

@section('content')
<h1>Edit Post</h1>
<form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ $post->title }}" required>
    </div>
    <div>
        <label for="content">Content:</label>
        <textarea name="content" id="content" required>{{ $post->content }}</textarea>
    </div>
    <div>
        <label for="file">File:</label>
        <input type="file" name="file" id="file">
        @if ($post->file)
            <a href="{{ Storage::url($post->file) }}">Download current file</a>
        @endif
    </div>
    <button type="submit">Update</button>
</form>
@endsection
