<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

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

    if ($user->super_admin) {
        return redirect()->route('Pages.dashboard');
    }

    if ($user->hasRole('Waiter')) {
        return redirect()->route('Pages.waiter.index');
    }

    if ($user->hasRole('Cashier')) {
        return redirect()->route('Pages.cashier.index');
    }

    if ($user->hasRole('Kitchen')) {
        return redirect()->route('Pages.kitchen.index');
    }

    if ($user->hasRole('Admin')) {
        return redirect()->route('Pages.dashboard');
    }

    Auth::guard('employee')->logout();
    abort(403, 'لا تملك صلاحية الدخول');
}
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}