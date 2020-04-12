<?php

namespace App\Http\Controllers;

use App\Post;
use App\UserLikePost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_posts = Post::where('user_id', $user->id)->with(['category', 'comment', 'userlike'])->get();
        $user_like_posts = UserLikePost::where('user_id', $user->id)
            ->with(['post'])->get();

        return view('partials.user.index', compact(['user', 'user_posts', 'user_like_posts']));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update_user = User::findOrFail($id);
        $image = $request->file('user_profile');
        $update_user->name = $request['user_name'];
        $update_user->email = $request['user_email'];

        if ($image) {
            $target_path = public_path('/profile/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $update_user->profile = $files;
            }
        }
        $update_user->save();
        return redirect('/user')->with('success', 'post save');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
