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
                    <h3>{{$post_detail->title}} <span>{{$post_detail->category->title}}</span></h3>
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
                        <span >{{$post_detail->comment_count}} &nbsp;&nbsp; comments</span>
                        </div>
                        <div class="vote">
                            <img src="/icons/icons8-heart-outline-24.png" alt="vote">
                            <span>0 &nbsp;&nbsp; votes</span>
                        </div>
                    </div>
                
                </div>

                <div class="post-comment">
                    <form action="{{route('comment.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                        <input type="hidden" name="post_id" value="{{$post_detail->id}}" />
                        <textarea name="answer" id="answer" cols="30" rows="2"
                        placeholder="comment...."></textarea>
            
                        <label for="image">
                            <img src="/icons/icons8-image-file-50.png" />
                            <input id="image" name="image" type="file"  />
                        </label>
                        
                    
                        {{-- <input type="file" name="image" id="image" value="upload"> --}}
                        {{-- <input type="button" value="Cancle" id="reset"> --}}
                    
                            <input type="submit" value="">
                        
                    </form>
                </div>
                <div class="answer-comment">
                   @foreach($comments as $comment)
                        <div class="answer">
                            <div class="comment-user">
                                @if($comment->user->profile !== null)
                                <img src="/profile/{{$comment->user->profile}}" alt="user_profile" />
                                @else 
                                    <img src="/icons/icons8-male-user-50.png" alt="user_profile" />
                                @endif
                                <span>{{$comment->user->name}}</span>
                            </div>
                            <div class="comment-answer">
                               <p> {{$comment->answer}}</p>
                                @if($comment->image !== null)
                                    <img src="/comments/{{$comment->image}}" alt="image" />
                                @endif
                            </div>
                           
                        </div>
                   @endforeach
                </div>
        </div>
        
    </div>
    
   
</div>
@endsection
