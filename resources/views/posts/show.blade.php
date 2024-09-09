@extends('layouts.app')

@section('content')
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>
@if ($post->file)
    <a href="{{ Storage::url($post->file) }}">Download attached file</a>
@endif
<a href="{{ route('posts.index') }}">Back to Posts</a>
@endsection
