<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Auth;
// class RoleMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//    public function handle(Request $request, Closure $next, ...$roles)
// {
//     // نفحص الحارس employee حصراً
//     if (!auth()->guard('employee')->check()) {
//         return redirect()->route('login');
//     }

//     $user = auth()->guard('employee')->user();

//     // إذا كان مدير عام، بيمر فوراً
//     if ($user->super_admin) {
//         return $next($request);
//     }

//     // فحص الرتبة (Role)
//     if (in_array($user->role, $roles)) {
//         return $next($request);
//     }

//     return abort(403, 'غير مصرح لك بالوصول');
// }
// }
