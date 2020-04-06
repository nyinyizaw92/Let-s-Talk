@extends('layouts.app')

@section('content')
@include('partials.navbar.secondnav')
<div class="post-detail">
    <div class="post">
        <div class="user-profile">
            @if($post_detail->user->profile == null)
            <img src="/icons/icons8-male-user-50.png" alt="profile">
            @else 
                <img src="/icons/{{$post_detail->user->profile}}" alt="profile">
            @endif
        </div>
        <div class="post-list">
           
                <div class="post-header">
                    <h3>{{$post_detail->title}}</h3>
                    <p>{{$post_detail->content}}</p>
                    @if($post_detail->image !== null)
                       <div class="post-img">
                            <img src="/uploads/{{$post_detail->image}}" alt="image">
                       </div>
                    @endif            
                </div>
         
           
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
              
            </div>
        </div>
    </div>
</div>
@endsection
