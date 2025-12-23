<?php

return [
    [
        'title' => 'Dashboard', // كانت "الرئيسية"
        'route' => 'Pages.dashboard',
        'icon'  => 'fas fa-home',
        'active_check' => 'dashboard*',
    ],
    [
        'title' => 'Roles', // كانت "الصلاحيات"
        'route' => 'Pages.roles.index',
        'icon'  => 'fas fa-users-cog',
        'active_check' => 'roles*',
    ],
    [
        'title' => 'Employees', // كانت "الموظفين"
        'route' => 'Pages.employee.index',
        'icon'  => 'fas fa-users',
        'active_check' => 'employees*',
    ],
    [
        'title' => 'Food Categories', // كانت "أصناف الطعام"
        'route' => 'Pages.categories.index',
        'icon'  => 'fas fa-utensils',
        'active_check' => 'categories*',
    ],
    [
        'title' => 'Tables', // كانت "الطاولات"
        'route' => 'Pages.Tables.index',
        'icon'  => 'fas fa-chair',
        'active_check' => 'tables*',
    ],
    [
        'title' => 'Item Categories', // كانت "فئات الاصناف"
        'route' => 'Pages.Items.index',
        'icon'  => 'fas fa-shopping-cart',
        'active_check' => 'items*',
    ],
    [
        'title' => 'Waiter Screen', // كانت "شاشة النادل"
        'route' => 'Pages.waiter.index',
        'icon'  => 'fas fa-user-tie',
        'active_check' => 'waiter*',
    ],
    [
        'title' => 'Cashier Screen', // كانت "شاشة الكاشير"
        'route' => 'Pages.cashier.index',
        'icon'  => 'fas fa-cash-register',
        'active_check' => 'cashier*',
    ],
    [
        'title' => 'Kitchen Screen', // كانت "شاشة المطبخ"
        'route' => 'Pages.kitchen.index',
        'icon'  => 'fas fa-blender',
        'active_check' => 'kitchen*',
    ],
];