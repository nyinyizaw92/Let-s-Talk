<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\ReplyComment;

class CommentController extends Controller
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
    public function store(CommentRequest $request)
    {

        $image = $request->file('image');

        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->post_id = $request->post_id;
        $comment->answer = $request->answer;

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {

                $comment->image = $files;
                $comment->save();
            }
        } else {
            $comment->create($request->all());
        }



        $post_comment = Post::findOrFail($request->post_id);
        $post_comment->increment('comment_count');
        $post_comment->update();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //dd($comment);
        $image = $request->file('image');

        $update_comment = Comment::findOrFail($comment->id);
        $update_comment->answer = $request->answer;

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {

                $update_comment->image = $files;
                //$comment->save();
            }
        }

        $update_comment->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment = Comment::findOrFail($comment->id);

        if ($comment->has_reply == 1) {
            $reply_comment = ReplyComment::where('comment_id', $comment->id)->get();
            foreach ($reply_comment as $rpl_cmt) {
                $delete = $rpl_cmt->delete();

                $post_id = Post::findOrFail($comment->post_id);
                $post_id->decrement('comment_count');
                $post_id->update();
            }

            $post_id = Post::findOrFail($comment->post_id);
            $post_id->decrement('comment_count');
            $post_id->update();
            $delete_comment = $comment->delete();
        } else {
            $post_id = Post::findOrFail($comment->post_id);
            $post_id->decrement('comment_count');
            $post_id->update();
            $delete_comment = $comment->delete();
        }

        return back();
    }
}
