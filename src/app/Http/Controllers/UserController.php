<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * 登録済みユーザーの一覧を表示する。
     */
    public function index(): View
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users,
        ]);
    }
}
