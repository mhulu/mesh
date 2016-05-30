<?php

namespace Star\Permission\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!$request->user()->hasPermission($permission)) {
            // throw new AccessDeniedHttpException($this->getAccessDeniedMessage());
             return redirect('/');
        }

        return $next($request);
    }

    // private function getAccessDeniedMessage()
    // {
    //     return '您的权限不足... ...';
    // }
}
