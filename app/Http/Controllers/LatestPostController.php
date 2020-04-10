<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Post;
use App\UserLikePost;
use App\User;
use Illuminate\Support\Facades\Auth;

class LatestPostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->take(5)->get();
        if (Auth::check()) {
            $likes =  UserLikePost::all();
            //dd($likes);
        } else {
            $likes = null;
        }
        $popular_posts = Post::where([['like_count', '>=', 2]])->get();
        $top_users = User::where([['comment_count', '>=', 2]])->get();
        return view('home', compact(['posts', 'likes', 'popular_posts', 'top_users']));
    }
}
