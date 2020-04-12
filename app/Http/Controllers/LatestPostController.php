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
        $posts = Post::orderBy('id', 'desc')->take(5)->with('userlike')->get();

        //dd($posts);
        // if (Auth::check()) {
        //     $likes = [];
        //     foreach ($posts as $post) {
        //         $user_likes = UserLikePost::where([
        //             ['user_id', '=', Auth::user()->id],
        //             ['post_id', '=', $post->id]
        //         ])->get();
        //         array_push($likes, $user_likes);
        //     }

        //     //$posts = Post::orderBy('id', 'desc')->take(5)->with('userlike')->get();
        // } else {
        //     $likes = null;
        // }
        $popular_posts = Post::where([['like_count', '>=', 2]])->get();
        $top_users = User::where([['comment_count', '>=', 2]])->get();
        return view('home', compact(['posts', 'popular_posts', 'top_users']));
    }
}
