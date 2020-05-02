@extends('layouts.app')
@section('content')
@include('partials.navbar.secondnav')
@if($post_by_category !== [] || $post_by_title !== [])
    <div class="search-list">
        @if($post_by_category)
            <div class="item">
                @foreach($post_by_category[0] as $post)
                <div class="item-list">
                    <a href="{{URL::to('post/show/'.$post->id)}}">
                        <h4>{{$post->title}}</h4>
                        <p>{{$post->content}}</p>
                    </a>
                </div>
            @endforeach  
            </div>
        @elseif($post_by_title)
            <div class="item">
                @foreach($post_by_title[0] as $post)
                <div class="item-list">
                    <a href="{{URL::to('post/show/'.$post->searchable->id)}}">
                        <h4>{{$post->searchable->title}}</h4>
                        <p>{{$post->searchable->content}}</p>
                    </a>
                </div>
                @endforeach 
            </div>
        @endif
    </div>
@else 
    <div>no search list</div>
@endif
@endsection
