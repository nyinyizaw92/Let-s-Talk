<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostResourceCollection;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        return new PostResourceCollection(Post::paginate(10));
    }

    public function show($id){
        $other_posts = Post::where('category_id',$id)->get();
        return json_decode($other_posts);
    }
}
