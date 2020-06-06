<?php

namespace App\Http\Controllers;

use App\UserSavePost;
use Illuminate\Http\Request;
use App\Services\UserPostLikeService;

class UserSavePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,UserPostLikeService $postsave)
    {
        //dd($request->all());
        $post_save = UserSavePost::where([
            ['user_id', '=', $request->user_id],
            ['post_id', '=', $request->post_id],
        ])->get();

        if (count($post_save) == 0) {
            $save_post = new UserSavePost();
            $save_post->create($request->all());
            $save_inc_dec = $postsave->user_save_post($request->user_id, "increment");
        } else {
            $save_post = UserSavePost::findOrFail($post_save[0]->id)->delete();
            $save_inc_dec = $postsave->user_save_post($request->user_id, "decrement");
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserSavePost  $userSavePost
     * @return \Illuminate\Http\Response
     */
    // public function show(UserSavePost $userSavePost)
    // {
    //    $save = UserSavePost::findOrFail($userSavePost);
    //    dd($save);
    // }

    public function show($id){
        $save = UserSavePost::where('post_id',$id)->get();
        return $save;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserSavePost  $userSavePost
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSavePost $userSavePost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSavePost  $userSavePost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSavePost $userSavePost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSavePost  $userSavePost
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSavePost $userSavePost)
    {
        //
    }
}
