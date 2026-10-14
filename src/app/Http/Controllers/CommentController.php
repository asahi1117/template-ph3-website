<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * 記事にコメントを追加する。
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        $comment = new Comment([
            'body' => $request->validated('body'),
        ]);
        $comment->user()->associate($request->user());
        $post->comments()->save($comment);

        return redirect()
            ->route('media.show', ['post' => $post->id])
            ->with('status', 'コメントを投稿しました。');
    }

    /**
     * 自分のコメントの編集フォームを表示する。
     */
    public function edit(Comment $comment): View
    {
        $this->authorize('update', $comment);

        return view('media.comments.edit', [
            'comment' => $comment,
        ]);
    }

    /**
     * 自分のコメントを更新する。
     */
    public function update(StoreCommentRequest $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);
        $comment->update([
            'body' => $request->validated('body'),
        ]);

        return redirect()
            ->route('media.show', ['post' => $comment->post_id])
            ->with('status', '更新されました！');
    }

    /**
     * 自分のコメントを論理削除する。
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);
        $postId = $comment->post_id;
        $comment->delete();

        return redirect()
            ->route('media.show', ['post' => $postId])
            ->with('status', '削除しました！');
    }
}
