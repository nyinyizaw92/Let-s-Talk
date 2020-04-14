<?php

namespace App\Http\Controllers;

use App\ReplyComment;
use App\Comment;
use App\Post;
use App\Http\Requests\ReplyCommentRequest;
use Illuminate\Http\Request;

class ReplyCommentController extends Controller
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
    public function store(ReplyCommentRequest $request)
    {

        $has_reply = Comment::findOrFail($request->comment_id);
        $has_reply->has_reply = true;
        $has_reply->update();

        $post_comment = Post::findOrFail($request->post_id);
        $post_comment->increment('comment_count');
        $post_comment->update();

        $image = $request->file('image');

        $reply_comment = new ReplyComment();
        $reply_comment->user_id = $request->user_id;
        $reply_comment->comment_id = $request->comment_id;
        $reply_comment->answer = $request->answer;

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {

                $reply_comment->image = $files;
                // $reply_comment->save();
            }
        }

        $reply_comment->save();
        // $replyComment = new ReplyComment();
        // $replyComment->user_id = $request->user_id;
        // $replyComment->comment_id = $request->comment_id;
        // $replyComment->new_comment_id = $comment->id;
        // $replyComment->save();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReplyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function show(ReplyComment $replyComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReplyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function edit(ReplyComment $replyComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReplyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReplyComment $replyComment)
    {
        $image = $request->file('image');

        $update_comment = ReplyComment::findOrFail($replyComment->id);
        $update_comment->answer = $request->answer;

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {

                $update_comment->image = $files;
                // $comment->save();
            }
        }

        $update_comment->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReplyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReplyComment $replyComment)
    {
        $comment = Comment::findOrFail($replyComment->comment_id);
        $post_id = Post::findOrFail($comment->post_id);
        $post_id->decrement('comment_count');
        $post_id->update();

        $delete_rpl_cmt = ReplyComment::findOrFail($replyComment->id)->delete();
        return back();
    }
}
