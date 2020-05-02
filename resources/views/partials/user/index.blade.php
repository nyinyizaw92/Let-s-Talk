<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Forum</title>
</head>
<body style="margin:0 auto">
    <div class="login-user">
        <nav class="navbar">
            <div class="container">
                <h2>Welcome {{$user->name}}</h2> 
                <div class="nav-login collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                     
                        <li class="nav-item">   
                            <a href="{{ url('/post') }}">All Posts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        {{-- <h2>Welcome {{$user->name}}</h2> --}}
        <div class="profile">
            <div class="image">
                @if($user->profile == null)
                    <img src="/icons/icons8-user-100.png" alt="profile">
                @else 
                    <img src="/profile/{{$user->profile}}" alt="profile">
                @endif
            </div>
            <div class="name">
                <p>{{$user->name}} <br><span>{{$user->email}}</span></p>
                <button id="upd-btn">Update</button>
            </div>
            <div class="total-post">
                <p>Total Posts : <span>{{count($user->post)}}</span></p>
                <p>Save Posts : <span>{{count($user_like_posts)}}</span></p>
            </div>
           
        </div>
        <div class="update-form" id="myModal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h3>User Update</h3>
                </div>
                <div class="modal-body">
                    <form action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="user_name">
                                <label for="user_name">Name : </label>
                                <input type="text" name="user_name" id="user_name" value="{{$user->name}}" />
                            </div>
        
                            <div class="user_email">
                                <label for="user_email">Email : </label>
                                <input type="email" name="user_email" id="user_email" value="{{$user->email}}" />
                            </div>
        
                            <div class="user-image">
                                @if($user->profile !== null)
                                    <img src="/profile/{{$user->profile}}" alt="image">
                                @endif
                            </div>
                            <div class="user_profile">
                                <label for="user_profile">Update Image</label>
                                <input type="file" name="user_profile" id="user_profile">
                            </div>
                            
                            <div class="save">
                                <input type="submit" value="Post"/>
                            </div> 
                    </form>
                </div>
            </div>
        </div>
        <div class="about-user">
            <div class="user-post">
                <h3>Your Created Posts</h3>
                @foreach($user_posts as $user_post)
                    <div class="created-post">
                        <div class="left">
                            <a href="{{URL::to('post/show/'.$user_post->id)}}">
                                <h4>{{$user_post->title}} <span>{{$user_post->category->title}}</span></h4>
                                <p>{{substr($user_post->content, 0,35)}}.....</p>
                            </a>
                        </div>
                        <div class="right">
                            <div class="edit">
                                <a href="{{ URL::to('post/' . $user_post->id . '/edit')}}">Edit</a>
                            </div>
                            <div class="delete">
                                <form action="{{URL::to('post/'.$user_post->id)}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Delete">
                            </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="your-save-post">
                <h3>Your Save Post</h3>
             
                @foreach ($user_like_posts as $user_like_post)
              
                    <div class="save-post">
                        <div class="user-profile">
                            @if($user_like_post->post->user->profile == null)
                            <img src="/icons/icons8-male-user-50.png" alt="profile">
                            @else 
                                <img src="/profile/{{$user_like_post->post->user->profile}}" alt="profile">
                            @endif
                        </div>
                        <div class="post-list">
                            <a href="{{URL::to('post/show/'.$user_like_post->post->id)}}">
                                <div class="post-header">
                                    <h3>{{$user_like_post->post->title}}</h3>
                                    <p>{{substr($user_like_post->post->content, 0,35)}}.....</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("upd-btn");
        var span = document.getElementsByClassName("close")[0];
        
        btn.onclick = function() {
          modal.style.display = "block";
        }
        
        span.onclick = function() {
          modal.style.display = "none";
        }
        
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
        </script>
</body>
</html>
