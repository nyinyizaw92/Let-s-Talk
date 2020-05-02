<?php

namespace App\Http\Controllers;

use App\ReplyComment;
use App\Comment;
use App\Post;
use App\Http\Requests\ReplyCommentRequest;
use App\Http\Requests\ReplyCommentUpdateRequest;
use App\Services\UserPostLikeService;
use Illuminate\Http\Request;

class ReplyCommentController extends Controller
{
    public function store(ReplyCommentRequest $request, UserPostLikeService $postcomment)
    {

        $has_reply = Comment::findOrFail($request->comment_id);
        $has_reply->has_reply = true;
        $has_reply->update();

        $comment_count_inc_dec = $postcomment->post_comment_inc_dec($request->post_id, "increment");
        $comment_count_inc_dec->update();

        $create = $request->except('image');
        $image = $request->file('image');

        $reply_comment = new ReplyComment();
        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $create['image'] = $files;
            }
        }

        $reply_comment->create($create);

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReplyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyCommentUpdateRequest $request, ReplyComment $replyComment)
    {
        $update = $request->except('image');
        $image = $request->file('image');

        if ($image) {
            $target_path = public_path('/comments/');
            $files =  date('YmdHis') . "." . $image->getClientOriginalExtension();
            if ($image->move($target_path, $files)) {
                $update['image'] = $files;
            }
        }

        $replyComment->update($update);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReplyComment  $replyComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReplyComment $replyComment, UserPostLikeService $postcomment)
    {
        $comment = Comment::findOrFail($replyComment->comment_id);
        $comment_count_inc_dec = $postcomment->post_comment_inc_dec($comment->post_id, "decrement");
        $comment_count_inc_dec->update();
        $replyComment->delete();
        return back();
    }
}
