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
}
