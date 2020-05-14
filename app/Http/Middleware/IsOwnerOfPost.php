<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsOwnerOfPost
{

    public function handle($request, Closure $next)
    {
        $post = app('App\Repositories\PostRepository')->find($request->route('post'));
        if (!$post || Auth::id() != $post->user_id) {
            if ($request->ajax()) {
                return response(["error" => 'This post not belongs to you!'], 403);
            }
            return redirect()->route('posts.user')->with(['message' => 'This post not belongs to you!', 'alert-class' => 'alert-warning']);
        }
        return $next($request);
    }
}
