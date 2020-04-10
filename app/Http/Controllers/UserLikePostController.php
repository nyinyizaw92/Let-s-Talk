<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLikePostRequest;
use Illuminate\Http\Request;
use App\UserLikePost;
use App\Post;

class UserLikePostController extends Controller
{
    public function store(UserLikePostRequest $request)
    {
        $post_like_table = UserLikePost::where([
            ['user_id', '=', $request->user_id],
            ['post_id', '=', $request->post_id],
        ])->get();


        if (count($post_like_table) == 0) {
            $post_like = new UserLikePost();
            $post_like->create($request->all());

            $like_count_inc = Post::findOrFail($request->post_id);
            $like_count_inc->increment('like_count');
            $like_count_inc->update();
        } else {
            $post_like_delete = UserLikePost::findOrFail($post_like_table[0]->id)->delete();
            $like_count_dec = Post::findOrFail($request->post_id);
            $like_count_dec->decrement('like_count');
            $like_count_dec->update();
            //dd($post_like_table[0]->id);
        }



        return back();
    }
}
