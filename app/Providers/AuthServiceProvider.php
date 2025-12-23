<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Employee;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
  public function boot(): void
{
    // هذا السطر يضمن أن الـ super_admin يتخطى كل الفحوصات
    Gate::before(function ($user, $ability) {
        return $user->super_admin ? true : null; 
    });

    foreach (config('abilities', []) as $code => $label) {
        Gate::define($code, function ($user) use ($code) {
            // تأكد أن الموديل (Employee أو User) يستخدم الـ Trait
            return method_exists($user, 'hasAbility') ? $user->hasAbility($code) : false;
        });
    }
}
}
