<?php

return [
    [
        'title' => 'Dashboard',
        'route' => 'Pages.dashboard',
        'icon'  => 'fas fa-home',
        'active_check' => 'dashboard*',
        'gate' => null, // متاح للجميع
    ],
    [
        'title' => 'Roles Management',
        'route' => 'Pages.roles.index',
        'icon'  => 'fas fa-users-cog',
        'active_check' => 'roles*',
        'gate' => null, 
    ],
    [
        'title' => 'Employees',
        'route' => 'Pages.employee.index',
        'icon'  => 'fas fa-users',
        'active_check' => 'employee*',
        'gate' => null,
    ],
    [
        'title' => 'Food Categories',
        'route' => 'Pages.categories.index',
        'icon'  => 'fas fa-utensils',
        'active_check' => 'categories*',
        'gate' => null,
    ],
    [
        'title' => 'Items Menu',
        'route' => 'Pages.Items.index',
        'icon'  => 'fas fa-hamburger',
        'active_check' => 'items*',
        'gate' => null,
    ],
    [
        'title' => 'Cashier Screen',
        'route' => 'Pages.cashier.index',
        'icon'  => 'fas fa-cash-register',
        'active_check' => 'cashier*',
        'gate' => null,
    ],
    [
        'title' => 'Tables Management',
        'route' => 'Pages.Tables.index',
        'icon'  => 'fas fa-table',
        'active_check' => 'tables*',
        'gate' => null,
        
    ],
    [
        'title' => 'Kitchen Screen',
        'route' => 'Pages.kitchen.index',
        'icon'  => 'fas fa-concierge-bell',
        'active_check' => 'kitchen*',
        'gate' => null,
    ],
    [
        'title' => 'Waiter Screen',
        'route' => 'Pages.waiter.index',
        'icon'  => 'fas fa-user-tie',
        'active_check' => 'waiter*',
        'gate' => null,
    ],
    
    [
        'title' => 'Inventory',
        'route' => 'Pages.inventory.index',
        'icon'  => 'fas fa-warehouse',
        'active_check' => 'inventory*',
        'gate' => null,
    ],
    [
        'title' => 'Reports',
        'route' => 'Pages.reports.index',
        'icon'  => 'fas fa-chart-line',
        'active_check' => 'reports*',
        'gate' => null, 
    ],
];