@extends('layouts.app')

@section('content')
@include('partials.navbar.secondnav')
<div class="post-list">
    @foreach ($posts as $post)
       {{$post->user->name}} |  {{$post->title}}
    @endforeach
</div>
@endsection
