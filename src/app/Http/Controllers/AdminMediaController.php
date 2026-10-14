<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AdminLoginRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminMediaController extends Controller
{
    /**
     * 管理者用のログイン画面を表示する。
     */
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()?->is_admin) {
            return redirect()->route('media.admin.index');
        }

        return view('media.admin.login');
    }

    /**
     * 管理者だけログインさせ、管理者一覧へ進む。
     */
    public function store(AdminLoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        if (! $request->user()->is_admin) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('media.admin.login')
                ->withErrors(['email' => '管理者のみログインできます。']);
        }

        return redirect()->route('media.admin.index');
    }

    /**
     * 管理者だけが見られる記事一覧を表示する。
     */
    public function index(): View
    {
        $posts = Post::withTrashed()
            ->with('user')
            ->latest()
            ->get();

        return view('media.admin.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * 管理者だけが見られるユーザー一覧を表示する。
     */
    public function users(): View
    {
        $users = User::withTrashed()
            ->orderBy('id')
            ->get();

        return view('media.admin.users', [
            'users' => $users,
        ]);
    }

    /**
     * ユーザーを論理削除する。自分自身は削除しない。
     */
    public function destroyUser(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return redirect()
                ->route('media.admin.users')
                ->with('status', '自分のアカウントは削除できません。');
        }

        $user->delete();

        return redirect()
            ->route('media.admin.users')
            ->with('status', '削除しました！');
    }
}
