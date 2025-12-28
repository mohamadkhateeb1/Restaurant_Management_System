<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Employee;
use App\Policies\EmployeePolicy;
use App\Models\CategoriesRestaurant;
use App\Policies\CategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Employee::class => EmployeePolicy::class,
        CategoriesRestaurant::class => CategoryPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();


        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });
        $abilities = config('abilities');
        if (is_array($abilities)) {
            foreach ($abilities as $ability => $label) {
                Gate::define($ability, function ($user) use ($ability) {
                    return $user->hasAbility($ability);
                });
            }
        }
    }
}
