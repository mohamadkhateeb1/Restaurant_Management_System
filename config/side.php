<?php

return [
    [
        'title' => 'Dashboard',
        'route' => 'Pages.dashboard',
        'icon'  => 'fas fa-home',
        'active_check' => 'dashboard*',
        'ability' => 'dashboard.view', 
    ],
    [
        'title' => 'Roles',
        'route' => 'Pages.roles.index',
        'icon'  => 'fas fa-users-cog',
        'active_check' => 'roles*',
        'ability' => 'role.view', // تم التعديل ليطابق ملف الصلاحيات
    ],
    [
        'title' => 'Employees',
        'route' => 'Pages.employee.index',
        'icon'  => 'fas fa-users',
        'active_check' => 'employees*',
        'ability' => 'employee.view', // تم التعديل ليطابق ملف الصلاحيات
    ],
    [
        'title' => 'Food Categories',
        'route' => 'Pages.categories.index',
        'icon'  => 'fas fa-utensils',
        'active_check' => 'categories*',
        'ability' => 'category.view', 
    ],
    [
        'title' => 'Tables',
        'route' => 'Pages.Tables.index',
        'icon'  => 'fas fa-chair',
        'active_check' => 'tables*',
        'ability' => 'table.view',
    ],
    [
        'title' => 'Item Categories',
        'route' => 'Pages.Items.index',
        'icon'  => 'fas fa-shopping-cart',
        'active_check' => 'items*',
        'ability' => 'item.view',
    ],
    [
        'title' => 'Waiter Screen',
        'route' => 'Pages.waiter.index',
        'icon'  => 'fas fa-user-tie',
        'active_check' => 'waiter*',
        'ability' => 'waiter.view',
    ],
    [
        'title' => 'Cashier Screen',
        'route' => 'Pages.cashier.index',
        'icon'  => 'fas fa-cash-register',
        'active_check' => 'cashier*',
        'ability' => 'cashier.view',
    ],
    [
        'title' => 'Kitchen Screen',
        'route' => 'Pages.kitchen.index',
        'icon'  => 'fas fa-blender',
        'active_check' => 'kitchen*',
        'ability' => 'kitchen.view',
    ],
    [
        'title' => 'Inventory Management',
        'route' => 'Pages.inventory.index',
        'icon'  => 'fas fa-warehouse',
        'active_check' => 'inventory*',
        // 'ability' => 'inventory.view', // تم التعليق مؤقتاً لتجنب مشاكل الصلاحيات
        'ability' => null,
    ],
    [
        'title'=>'Invoice Warehouse',
        'route'=>'Pages.OrderItems.index',
        'icon'=>'fas fa-boxes',
        'active_check'=>'order_items*',
        'ability'=>'orderitem.view',
    ],
    [
        'title' => 'Reports',
        'route' => 'Pages.reports.index',
        'icon'  => 'fas fa-chart-line',
        'active_check' => 'reports*',
        'ability' => 'report.view',
    ],
];