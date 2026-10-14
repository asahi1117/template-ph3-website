<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WebsiteController extends Controller
{
    /**
     * POSSE website のトップページを表示する。
     */
    public function index(): View
    {
        return view('website.index');
    }
}
