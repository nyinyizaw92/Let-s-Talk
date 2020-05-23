<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLikePostRequest;
use Illuminate\Http\Request;
use App\UserLikePost;
use App\Post;
use App\Services\UserPostLikeService;

class UserLikePostController extends Controller
{
    public function store(UserLikePostRequest $request, UserPostLikeService $postlike)
    {
       // dd($request->all());
        $post_like_table = UserLikePost::where([
            ['user_id', '=', $request->user_id],
            ['post_id', '=', $request->post_id],
        ])->get();

        if (count($post_like_table) == 0) {
            $post_like = new UserLikePost();
            $post_like->create($request->all());
            $like_count_inc_dec = $postlike->post_inc_dec($request->post_id, "increment");
        } else {
            $post_like_delete = UserLikePost::findOrFail($post_like_table[0]->id)->delete();
            $like_count_inc_dec = $postlike->post_inc_dec($request->post_id, "decrement");
        }
        return back();
    }
}
