<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // إذا لم يكن مسجل دخول أو لا يملك الدور المطلوب (وليس سوبر أدمن)
        if (!$request->user() || (!$request->user()->hasRole($role) && !$request->user()->super_admin)) {
            abort(403, 'غير مصرح لك بدخول هذه الصفحة.');
        }

        return $next($request);
    }
}