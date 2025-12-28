<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Employee;
use App\Policies\EmployeePolicy;
use App\Models\CategoriesRestaurant;
use App\Policies\CategoriesRestaurantPolicy;
use App\Models\Role;
use App\Policies\RolePolicy;
use App\Models\ItemsRestaurant;
use App\Policies\ItemsRestaurantPolicy;
use App\Models\Cachier;
use App\Policies\CachierPolicy;
use App\Models\TablesRestaurant;
use App\Policies\TablesRestaurantPolicy;
use App\Models\Waiter;
use App\Policies\WaiterPolicy;
use App\Models\Kitchen;
use App\Policies\KitchenPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Employee::class => EmployeePolicy::class,
        CategoriesRestaurant::class => CategoriesRestaurantPolicy::class,
        Role::class => RolePolicy::class,
        ItemsRestaurant::class => ItemsRestaurantPolicy::class,
        Cachier::class => CachierPolicy::class,
        TablesRestaurant::class => TablesRestaurantPolicy::class,
        Waiter::class => WaiterPolicy::class,
        Kitchen::class => KitchenPolicy::class,


    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if (isset($user->super_admin) && $user->super_admin) {
                return true;
            }
        });

        $abilities = config('abilities');
        if (is_array($abilities)) {
            foreach ($abilities as $ability => $label) {
                Gate::define($ability, function ($user) use ($ability) {
                    return method_exists($user, 'hasAbility') ? $user->hasAbility($ability) : false;
                });
            }
        }
    }
}
