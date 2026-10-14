<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * POSSE MEDIA の記事一覧を表示する。
     */
    public function index(): View
    {
        $posts = Post::query()
            ->with('user')
            ->latest()
            ->get();

        return view('media.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * 記事の投稿フォームを表示する。下書きがあればセッションから戻す。
     */
    public function create(Request $request): View
    {
        return view('media.create', [
            'draft' => $request->session()->get('media.post_draft', []),
        ]);
    }

    /**
     * 入力途中の記事をセッションに保存する。
     */
    public function draft(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:100'],
            'detail' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'title.max' => 'タイトルは100文字以内で入力してください。',
            'detail.max' => '詳細は2000文字以内で入力してください。',
            'image.image' => '画像は画像ファイルを指定してください。',
            'image.max' => '画像は2MB以内のファイルを指定してください。',
        ]);

        $draft = $request->session()->get('media.post_draft', []);
        $draft['title'] = $validated['title'] ?? '';
        $draft['detail'] = $validated['detail'] ?? '';

        if ($request->hasFile('image')) {
            if (! empty($draft['image'])) {
                Storage::disk('public')->delete($draft['image']);
            }
            $draft['image'] = $request->file('image')->store('posts/drafts', 'public');
        }

        $request->session()->put('media.post_draft', $draft);

        return redirect()
            ->route('media.create')
            ->with('status', '下書きを保存しました。');
    }

    /**
     * 記事を保存し、一覧へ戻す。
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $draftImage = $request->session()->get('media.post_draft.image');
        $imagePath = is_string($draftImage) ? $draftImage : null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            if (is_string($draftImage) && $draftImage !== '') {
                Storage::disk('public')->delete($draftImage);
            }
        }

        $request->user()->posts()->create([
            'title' => $validated['title'],
            'detail' => $validated['detail'],
            'image' => $imagePath,
        ]);

        $request->session()->forget('media.post_draft');

        return redirect()
            ->route('media.index')
            ->with('status', '記事を投稿しました。');
    }

    /**
     * 記事の詳細を表示する。
     */
    public function show(Post $post): View
    {
        $post->load(['user', 'comments.user']);

        return view('media.show', [
            'post' => $post,
        ]);
    }

    /**
     * 自分の記事の編集フォームを表示する。
     */
    public function edit(Post $post): View
    {
        $this->authorize('update', $post);

        return view('media.edit', [
            'post' => $post,
        ]);
    }

    /**
     * 自分の記事を更新する。
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);
        $validated = $request->validated();
        $imagePath = $post->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            if ($post->image !== '' && $post->image !== $imagePath) {
                Storage::disk('public')->delete($post->image);
            }
        }

        $post->update([
            'title' => $validated['title'],
            'detail' => $validated['detail'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('media.show', ['post' => $post->id])
            ->with('status', '更新されました！');
    }

    /**
     * 自分の記事を論理削除し、一覧へ戻す。
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()
            ->route('media.index')
            ->with('status', '削除しました！');
    }
}
