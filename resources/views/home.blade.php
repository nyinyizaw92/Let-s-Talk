
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
                        <img src="/profile/{{$post->user->profile}}" alt="profile">
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
                     
                                <img src="/icons/icons8-comments-24.png" alt="comment" class="comment-box" data-id="{{$post->id}}">
                                <span>{{$post->comment_count}}</span>
                            </div>
                            <div class="vote">
                            
                                @if(Auth::check())
                                    @if(count($post->userlike) == 0)
                                        <img src="/icons/icons8-heart-outline-24.png" alt="vote">     
                                    @else
                                        @foreach($post->userlike as $like)
                                            @if($like->user_id == Auth::user()->id) 
                                                <img src="/icons/icons8-heart-outline-24-blue.png" alt="vote"
                                                style="z-index:1">  
                                            @else  
                                                <img src="/icons/icons8-heart-outline-24.png" alt="vote">  
                                            @endif  
                                        @endforeach
                                         
                                    @endif

                                    <form action="{{route('post-like.store')}}" method="POST"
                                    >
                                    @csrf
                                    <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                                    <input type="hidden" name="post_id" value="{{$post->id}}" />
                                    <input type="submit" value="">
                                    </form>
                                    <span>{{$post->like_count}}</span>
                                @else  
                                    <form action="{{route('post-like.store')}}" method="POST"
                                    >
                                    @csrf
                                    <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                                    <input type="hidden" name="post_id" value="{{$post->id}}" />
                                    <input type="submit" value="">
                                    </form>
                                    <img src="/icons/icons8-heart-outline-24.png" alt="vote">
                                    <span>{{$post->like_count}}</span>
                                @endif
{{--                                 
                               @if(Auth::check() && $post->user->userlike !== null)
                                    @php
                                        dd($post->user->name);
                                    @endphp
                               @endif --}}
                                {{-- @if($likes !== null)
                                    @foreach ($likes as $like)
                                        @if(count($like) !== 0 && $like[0]->post_id == $post->id && $like[0]->user_id == Auth::user()->id)
                                            <img src="/icons/icons8-heart-outline-24-blue.png" alt="vote">        
                                        @else
                                            <img src="/icons/icons8-heart-outline-24.png" alt="vote">
                                        @endif
                                    @endforeach
                                    <form action="{{route('post-like.store')}}" method="POST"
                                    >
                                    @csrf
                                    <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                                    <input type="hidden" name="post_id" value="{{$post->id}}" />
                                    <input type="submit" value="">
                                    </form>
                                    <img src="/icons/icons8-heart-outline-24.png" alt="vote">    
                                    <span>{{$post->like_count}}</span>
                                @else --}}
                                {{-- @if(Auth::check() && count($post->userlike) >0)
                                        @foreach($post->userlike as $userlike)
                                            @if($userlike->user_id == Auth::user()->id)
                                                <img src="/icons/icons8-heart-outline-24-blue.png" alt="vote">
                                            @else 
                                            <img src="/icons/icons8-heart-outline-24.png" alt="vote"> 
                                            @endif
                                            
                                        @endforeach
                                        <form action="{{route('post-like.store')}}" method="POST"
                                        >
                                        @csrf
                                        <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                                        <input type="hidden" name="post_id" value="{{$post->id}}" />
                                        <input type="submit" value="">
                                        </form>
                                        
                                        <span>{{$post->like_count}}</span>
                                @else  --}}
                                
                                {{-- @endif --}}
                                
                              
                              
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

                    <div class="add-comment" id="{{$post->id}}">
                        <form action="{{route('comment.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                            <input type="hidden" name="post_id" value="{{$post->id}}" />
                            <textarea name="answer" id="answer" cols="30" rows="2"
                            placeholder="comment...."></textarea>

                            <label for="image">
                                <img src="/icons/icons8-image-file-50.png" />
                                <input id="image" name="image" type="file"  />
                            </label>
                            
                           
                            {{-- <input type="file" name="image" id="image" value="upload"> --}}
                            <input type="button" value="Cancle" id="reset">
                           
                                <input type="submit" value="Submit">
                            
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else 
        <h4>No new post</h4>
    @endif
   </div>
   <div class="info">
        <h4>Popular Post</h4>
        @if(count($popular_posts) !== 0)
           
        <div class="popular-post">
            @foreach ($popular_posts as $popular_post)
              
                    {{-- <div class="user-profile">
                        @if($popular_post->user->profile == null)
                        <img src="/icons/icons8-male-user-50.png" alt="profile">
                        @else 
                            <img src="/icons/{{$popular_post->user->profile}}" alt="profile">
                        @endif
                    </div> --}}
                    <div class="post-list">
                        <a href="{{URL::to('post/show/'.$popular_post->id)}}">
                            <div class="post-header">
                                <h3>{{$popular_post->title}}</h3>
                                <p>{{substr($popular_post->content, 0,35)}}.....</p>
                            </div>
                        </a>
                    </div>
               
            @endforeach
        </div>
        @else 
                <p>No popular post</p>
        @endif
     
       <div class="top-user">
        <h4>Top User</h4>
        @if(count($top_users) !== 0)
            
       
            @foreach ($top_users as $top_user)
            <div class="top">
                    <div class="user-profile">
                        @if($top_user->profile == null)
                        <img src="/icons/icons8-male-user-50.png" alt="profile">
                        @else 
                            <img src="/profile/{{$top_user->profile}}" alt="profile">
                        @endif
                    </div>
                    <div class="post-list">
                        <a href="#">
                            <div class="post-header">
                                <h3>{{$top_user->name}}</h3>

                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        
        @else 
                <p>No Top Users</p>
        @endif
       </div>
   </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('.comment-box').click(function(){
        var id = $(this).data('id');
            $('#'+id+'').toggle();
            $('#reset').click(function(){
                $('#'+id+'').css("display","none");
            })
        });
    });
</script>
@endsection