<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\CategoriesRestaurant;
use App\Policies\EmployeePolicy;
use App\Policies\RolePolicy;
use App\Policies\CategoriesRestaurantPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // ربط يدوي لأن اسم المودل لا يطابق اسم السياسة تلقائياً
        Employee::class => EmployeePolicy::class,
        Role::class => RolePolicy::class,
        CategoriesRestaurant::class => CategoriesRestaurantPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // السوبر أدمن يتخطى كافة الفحوصات (هذا يحل مشكلة السوبر أدمن عندك)
        Gate::before(function ($user, $ability) {
            return $user->super_admin ? true : null;
        });
    }
}