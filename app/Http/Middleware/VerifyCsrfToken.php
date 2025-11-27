<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Tambahkan endpoint API jika diperlukan
        // 'api/*'
    ];

    /**
     * Handle the request.
     */
    public function handle($request, \Closure $next)
    {
        // Tambahkan header untuk mengatasi session timeout
        $response = $next($request);

        // Ensure CSRF token is included in response
        if ($request->session()->has('_token')) {
            $response->headers->set('X-CSRF-TOKEN', $request->session()->token());
        }

        return $response;
    }
}
