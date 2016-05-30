<?php

namespace Star\Permission\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            // $this->getAccessDeniedMessage();
            return redirect('/');
        }

        return $next($request);
    }

    // private function getAccessDeniedMessage()
    // {
    //     return response()->json([
    //                 'error' => [
    //                     'message' => '您的权限不足,不能操作'
    //                 ]
    //                 ], 401);
    // }
}
