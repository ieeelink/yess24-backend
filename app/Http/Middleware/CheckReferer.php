<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class CheckReferer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected $allowed = ['https://yess.ieee-link.org/', 'https://test.ieee-link.org/'];

    public function handle(Request $request, Closure $next): Response
    {
        if(App::environment('production')) {
            $referer = $request->header('referer');
            if(! in_array($referer, $this->allowed)) {
                return response([
                    'message' => 'Unauthorized',
                    'data' => 'not_allowed'
                ],401);
            }
        }
        return $next($request);
    }
}
