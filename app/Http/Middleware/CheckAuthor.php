<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user !== null){
                if ($user->is_author()){
                    return $next($request);
                }
            }
        }
        return response()->json(array(
            'status' => 'Unauthorized',
            'message' => 'Bu işlem için yetkiniz yok.'
        ), 403);
    }
}
