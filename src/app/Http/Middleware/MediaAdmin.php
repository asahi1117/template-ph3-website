<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaAdmin
{
    /**
     * 未ログインは管理者ログインへ、管理者以外は website のトップへ戻す。
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->route('media.admin.login');
        }

        if (! $user->is_admin) {
            return redirect()->route('website.index');
        }

        return $next($request);
    }
}
