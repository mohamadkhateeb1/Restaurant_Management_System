<?php

return [
    [
        'title' => 'Dashboard',
        'route' => 'Pages.dashboard',
        'icon'  => 'fas fa-home',
        'active_check' => 'dashboard*',
        'ability' => null, // متاح للجميع
    ],
    [
        'title' => 'Roles Management',
        'route' => 'Pages.roles.index',
        'icon'  => 'fas fa-users-cog',
        'active_check' => 'roles*',
        'ability' => 'viewAny', 
        'model'   => App\Models\Role::class,
    ],
    [
        'title' => 'Employees',
        'route' => 'Pages.employee.index',
        'icon'  => 'fas fa-users',
        'active_check' => 'employee*',
        'ability' => 'viewAny',
        'model'   => App\Models\Employee::class,
    ],
    [
        'title' => 'Food Categories',
        'route' => 'Pages.categories.index',
        'icon'  => 'fas fa-utensils',
        'active_check' => 'categories*',
        'ability' => 'viewAny',
        'model'   => App\Models\CategoriesRestaurant::class,
    ],
    [
        'title' => 'Items Menu',
        'route' => 'Pages.Items.index',
        'icon'  => 'fas fa-hamburger',
        'active_check' => 'items*',
        'ability' => 'viewAny',
        'model'   => App\Models\ItemsRestaurant::class, // تأكد من اسم المودل عندك
    ],
    [
        'title' => 'Cashier Screen',
        'route' => 'Pages.cashier.index',
        'icon'  => 'fas fa-cash-register',
        'active_check' => 'cashier*',
        'ability' => 'viewAny',
        'model'   => App\Models\Cachier::class,
    ],
    [
        'title' => 'Inventory',
        'route' => 'Pages.inventory.index',
        'icon'  => 'fas fa-warehouse',
        'active_check' => 'inventory*',
        'ability' => 'viewAny',
        'model'   => App\Models\Inventory::class,
    ],
    [
        'title' => 'Reports',
        'route' => 'Pages.reports.index',
        'icon'  => 'fas fa-chart-line',
        'active_check' => 'reports*',
        'ability' => null, // عدلها لاحقاً إذا أضفت ReportPolicy
    ],
];