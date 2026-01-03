<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
     
        if (!Auth::guard('employee')->attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            return back()->withErrors([
                'email' => 'البيانات المدخلة غير صحيحة أو غير موجودة',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::guard('employee')->user();
        if($user->super_admin){
            return redirect()->intended(LaravelLocalization::localizeUrl(route('dashboard')));
        }

        // التوجيه بناءً على hasRole حصراً
        if ($user->hasRole('Admin')) {
            return redirect()->intended(LaravelLocalization::localizeUrl(route('dashboard')));
        }

        if ($user->hasRole('Waiter')) {
            return redirect()->intended(LaravelLocalization::localizeUrl(route('Pages.waiter.index')));
        }

        if ($user->hasRole('Cashier')) {
            return redirect()->intended(LaravelLocalization::localizeUrl(route('Pages.cashier.index')));
        }

        if ($user->hasRole('Kitchen')) {
            return redirect()->intended(LaravelLocalization::localizeUrl(route('Pages.kitchen.index')));
        }

        Auth::guard('employee')->logout();
        return redirect(LaravelLocalization::localizeUrl('/login'))
            ->withErrors(['email' => 'لا تملك صلاحية الوصول لأي واجهة عمل.']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('employee')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(LaravelLocalization::localizeUrl('/login'));
    }
}