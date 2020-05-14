<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class ValidateTagId
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->tagId)) {
            $tag = app('App\Repositories\TagRepository')->find($request->tagId);
            if (!$tag)
                return redirect()->route('posts.index');
        }
        return $next($request);
    }
}
