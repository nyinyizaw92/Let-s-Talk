@extends('layouts.app')

@section('content')
@include('partials.navbar.secondnav')
<div class="post-detail">
    <div class="post">
        {{-- start post detail --}}
        <div class="user-profile">
            @if($post_detail->user->profile == null)
            <img src="/icons/icons8-male-user-50.png" alt="profile">
            @else 
                <img src="/profile/{{$post_detail->user->profile}}" alt="profile">
            @endif

            <span>{{$post_detail->user->name}}</span>
        </div>
       
        <div class="post-list">
            <div class="post-header">
                <h3>{{$post_detail->title}} <span>{{$post_detail->category->title}}</span></h3>
                <p>{!!$post_detail->content!!}</p>
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
                        @foreach($post_detail->userlike as $like)
                        @if(Auth::check() && $like->user_id == Auth::user()->id) 
                            <img src="/icons/icons8-heart-outline-24-blue.png" alt="vote"
                            style="z-index:1">  
                        @else  
                            <img src="/icons/icons8-heart-outline-24.png" alt="vote">  
                        @endif  
                        @endforeach
                        <form action="{{route('post-like.store')}}" method="POST"
                        >
                        @csrf
                        <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                        <input type="hidden" name="post_id" value="{{$post_detail->id}}" />
                        <input type="submit" value="">
                        </form>
                        {{-- <img src="/icons/icons8-heart-outline-24.png" alt="vote"> --}}
                        <span>{{$post_detail->like_count}} &nbsp;&nbsp; votes</span>
                    </div>
                </div>
            
            </div>
        {{-- end post detail --}}
        {{-- start post comment --}}
            <div class="post-comment">
                <form action="{{route('comment.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                    <input type="hidden" name="post_id" value="{{$post_detail->id}}" />
                    <textarea name="answer" id="answer" cols="30" rows="2"
                    placeholder="comment...."></textarea>
        
                    <label for="image">
                        <img src="/icons/icons8-image-file-50.png" />
                        <input id="image" name="image" type="file"  class="preview_image" data-id="{{$post_detail->id}}" />
                    </label>
                
                    <input type="submit" value="">
                </form>
                <div class="preview" id="showimage{{$post_detail->id}}">
                    <img id="output_image{{$post_detail->id}}"/>
                </div>
            </div>
        {{-- end post comment --}}
            @foreach($comments as $comment)
            <div class="answer-comment">
                @if($comment->has_reply !== 2)
                    <div class="answer">
                        {{-- start comment list --}}
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
                            <div class="comment-image">
                                <img src="/comments/{{$comment->image}}" alt="image" />
                            </div>
                        @endif
                        </div>
                        {{-- end comment list --}}

                        {{--start update,delete,reply comment --}}
                        <div class="comment-edit">
                             {{-- start reply comment --}}
                             <div class="reply">
                                <div class="reply-img" data-id="{{$comment->id}}">
                                    <img src="/icons/icons8-reply-arrow-30.png" alt="reply"> 
                                    <span>{{count($comment->replyComment)}}</span>
                                </div>
                                
                            </div>

                            {{-- end reply comment --}}
                            @if(Auth::check() && $comment->user_id == Auth::user()->id)
                                <div class="edit">
                                    <button class="edit-btn" data-id="{{$comment->id}}">Edit</button>
                                    <div class="update-form"  id="{{$comment->id}}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="close">&times;</span>
                                                <h3>Comment Update</h3>
                                            </div>
                                            {{--start comment update modal box --}}
                                            <div class="modal-body">
                                                <form action="{{route('comment.update',$comment->id)}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                        
                                                        <textarea name="answer" id="answer" cols="30" rows="2"
                                                        placeholder="comment....">{{$comment->answer}}</textarea>

                                                        <div class="comment-image">
                                                            @if($comment->image !== null)
                                                                <img src="/comments/{{$comment->image}}" alt="image">
                                                                
                                                            @endif
                                                        
                                                        </div>
                                                        <div class="file">
                                                            <input id="image" name="image" type="file"
                                                            />
                                                        </div>
                                                        <input type="submit" value="Update">
                                                </form>
                                               
                                            </div>
                                            {{-- end comment update modal box --}}
                                        </div>
                                    </div>
                                </div>
                                {{--start comment delete --}}
                                <div class="delete">
                                    <form action="{{URL::to('comment/'.$comment->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input type="submit" value="Delete">
                                </form>
                                </div>
                            @endif
                               
                            
                        {{-- end update,delete,reply comment --}}
                        </div>
                        <div class="{{$comment->id}} reply-box">
                           @foreach($comment->replyComment as $reply)
                    
                               <div class="comment-user">
                                   @if($reply->user->profile !== null)
                                   <img src="/profile/{{$reply->user->profile}}" alt="user_profile" />
                                   @else 
                                       <img src="/icons/icons8-male-user-50.png" alt="user_profile" />
                                   @endif
                                   <span>{{$reply->user->name}}</span>
                                   <p>{{$reply->answer}}</p>
                                    @if($reply->image !== null)
                                    <div class="reply-image">
                                        <img src="/comments/{{$reply->image}}" alt="image" />
                                    </div>
                                    @endif  
                               </div>
                                
                                    @if(Auth::check() && $reply->user_id == Auth::user()->id)
                                        <div class="reply-comment-edit">
                                            <div class="reply-edit">
                                                <button class="edit-btn" data-id="{{$reply->id}}">Edit</button>
                                                <div class="update-form"  id="{{$reply->id}}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <span class="close">&times;</span>
                                                    <h3>Comment Update</h3>
                                                    </div>
                                                {{--start comment update modal box --}}
                                                    <div class="modal-body">
                                                        <form action="{{route('reply-comment.update',$reply->id)}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                                
                                                                <textarea name="answer" id="answer" cols="30" rows="2"
                                                                placeholder="comment....">{{$reply->answer}}</textarea>

                                                                <div class="comment-image">
                                                                    @if($reply->image !== null)
                                                                        <img src="/comments/{{$reply->image}}" alt="image">
                                                                        
                                                                    @endif
                                                                
                                                                </div>
                                                                <div class="file">
                                                                    <input id="image" name="image" type="file"  />
                                                                </div>
                                                                <input type="submit" value="Update">
                                                        </form>     
                                                    </div>
                                                {{-- end comment update modal box --}}
                                                </div>
                                                </div>
                                            </div>
                                            {{--start comment delete --}}
                                            <div class="reply-delete">
                                                <form action="{{URL::to('reply-comment/'.$reply->id)}}" method="POST" class="reply-comment-delete">
                                                @method('DELETE')
                                                @csrf
                                                <input type="submit" value="Delete" class="delete-form">
                                            </form>
                                            </div>
                                        </div>
                                    @endif
                               
                           @endforeach
                            {{-- end reply comment list --}}
                           <form action="{{route('reply-comment.store')}}" method="POST" enctype="multipart/form-data">
                               @csrf
                               <input type="hidden" name="user_id" @if(Auth::check()) value="{{Auth::user()->id}}" @endif />
                               <input type="hidden" name="comment_id" value="{{$comment->id}}">
                               <input type="hidden" name="has_reply" value="2">
                               <input type="hidden" name="post_id" value="{{$post_detail->id}}" />
                               <textarea name="answer" id="answer" cols="30" rows="2"
                               placeholder="comment...."></textarea>
                   
                               <label for="image">
                                   <img src="/icons/icons8-image-file-50.png" />
                                   <input id="image" name="image" type="file" class="preview_reply_image" data-id="{{$comment->id}}" />
                               </label>
        
                               <input type="submit" value="">
                           </form>

                        <div class="preview_reply" id="show_reply_image{{$comment->id}}">
                            <img id="output_reply_image{{$comment->id}}"/>
                        </div>
                        </div>
                    </div>
                @endif
                
            </div>
            @endforeach
        
    </div>
</div>
@endsection
@section('scripts')
<script>

$(document).ready(function(){
        $('.edit-btn').click(function(){
        var id = $(this).data('id');
            $('#'+id+'').toggle();

            $(".close").click(function(){
                $('#'+id+'').hide();
            })
        });

        $('.reply-img').click(function(){
            var id = $(this).data('id');
            $('.'+id+'').toggle();
        });

        $('.preview_image').change(function(e){
        var image_id = $(this).data('id');
        console.log(image_id);

        var reader = new FileReader();
        reader.onload = function()
        {        
            var output = document.getElementById('output_image'+image_id);
            $('#showimage'+image_id+'').css("display","block");
            output.src = reader.result;
        }
            reader.readAsDataURL(e.target.files[0]);
        
        })

        $('.preview_reply_image').change(function(e){
        var image_id = $(this).data('id');
        console.log(image_id);

        var reader = new FileReader();
        reader.onload = function()
        {        
            var output = document.getElementById('output_reply_image'+image_id);
            $('#show_reply_image'+image_id+'').css("display","block");
            output.src = reader.result;
        }
            reader.readAsDataURL(e.target.files[0]);
        
        })
    });
    
</script>
{{-- <script>
function loadPreview(input) {
   // id = id || '#preview_img';
    if (input.files && input.files[0]) {

        var image_holder = $("#preview_img");
        image_holder.empty();

        var reader = new FileReader();

        reader.onload = function (e) {
            // $(id)
            //         .attr('src', e.target.result)
            //         .width(200)
            //         .height(150);
             $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                }).appendTo(image_holder);
        };
         image_holder.show();

        reader.readAsDataURL(input.files[0]);
    }
}
</script> --}}
@endsection
