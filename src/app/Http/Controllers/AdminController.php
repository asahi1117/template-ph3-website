<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * 管理者用の空のダッシュボードを表示する。
     */
    public function index(): View
    {
        return view('admin.dashboard');
    }
}
