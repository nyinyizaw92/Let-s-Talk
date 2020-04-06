@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div> --}}
@include('partials.navbar.secondnav')
<div class="latest-post">
    {{-- @if(session('success'))
       {{session('success')}} 
    @endif --}}

   <div class="latest">
    @if($posts !== "null")
        @foreach ($posts as $post)
            <div class="post">
                <div class="user-profile">
                    @if($post->user->profile == null)
                    <img src="/icons/icons8-male-user-50.png" alt="profile">
                    @else 
                        <img src="/icons/{{$post->user->profile}}" alt="profile">
                    @endif
                </div>
                <div class="post-list">
                    <a href="{{URL::to('post/show/'.$post->id)}}">
                        <div class="post-header">
                            <h3>{{$post->title}}</h3>
                            <p>{{substr($post->content, 0,35)}}.....</p>
                        </div>
                    </a>
                   
                    <div class="post-body">
                        <div class="comment-vote">
                            <div class="comment">
                                <img src="/icons/icons8-comments-24.png" alt="comment">
                               <span>0 &nbsp;&nbsp; comments</span>
                            </div>
                            <div class="vote">
                                <img src="/icons/icons8-heart-outline-24.png" alt="vote">
                                <span>0 &nbsp;&nbsp; votes</span>
                            </div>
                        </div>
                        <div class="edit-delete">
                            @if(Auth::check())
                                @if($post->user->id == Auth::user()->id)
                                  
                                        <div class="edit">
                                            <a href="{{ URL::to('post/' . $post->id . '/edit')}}">Edit</a>
                                        </div>
                                        <div class="delete">
                                            <form action="{{URL::to('post/'.$post->id)}}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="submit" value="Delete">
                                        </form>
                                        </div>
                                  
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else 
        <h4>No new post</h4>
    @endif
   </div>
   <div class="user-info">

   </div>
</div>

@endsection
@section('scripts')
@endsection