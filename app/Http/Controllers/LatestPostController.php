<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;


class LatestPostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->limit('5')->get();
        return view('home', compact('posts'));
    }
}
