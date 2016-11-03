<?php

namespace App\Http\Middleware;

use Closure;

class VerifyUserIsChef
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            if (! $this->isUserChef()) {
                abort(404);
            }
        }

        return $next($request);
    }

    protected function isUserChef()
    {
        return \Auth::user()->userable_type == 'chef';
    }
}
