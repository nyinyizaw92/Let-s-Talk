<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Post;
use App\UserLikePost;
use App\User;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class LatestPostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->take(5)->with(['userlike','user'])->get();
        $post_list = [];
        $get = [];
      
        if(Auth::check()){
            $user = Auth::user()->id;
        }else{
            $user = 0;
        }

      
        $popular_posts = Post::where([['like_count', '>=', 2]])->get();
        $top_users = User::where([['comment_count', '>=', 2]])->get();
        return view('home', compact(['posts', 'popular_posts', 'top_users', 'post_list', 'get','user']));
    }
}
