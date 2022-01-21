<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckToken
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
        $token = request()->bearerToken();

        if (!$token)
            return response()->json(['status' => 403, 'msg' => '请登录后再操作']);

        $user = User::where('token', $token)->first();

        if (!$user)
            return response()->json(['status' => 403, 'msg' => '请重新登录']);

        request()->user = $user;

        return $next($request);
    }
}
