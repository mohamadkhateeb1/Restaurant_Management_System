{{--
<aside class="main-sidebar elevation-4">

    <a href="{{ route('Pages.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold">
            <i class="fas fa-utensils"></i> SRMS
        </span>
    </a>

    <div class="sidebar">

   
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

         
                <li class="nav-item">
                    <a href="{{ route('Pages.dashboard') }}"
                        class="nav-link {{ request()->routeIs('Pages.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home mr-2"></i>
                        <p>الرئيسية</p>
                    </a>
                </li>
    
                <li class="nav-item">
                    <a href="{{ route('Pages.roles.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users mr-2"></i>
                        <p>الصلاحيات</p>
                    </a>
                </li>


               
                <li class="nav-item">
                    <a href="{{ route('Pages.employee.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users mr-2"></i>
                        <p>الموظفين</p>
                    </a>
                </li>
                {{-- @endcan 

                {{-- العملاء 
                {{-- قائمة الطعام 
                {{-- @can('categories.view', App\Models\Customer::class) 
                <li class="nav-item">
                    <a href="{{ route('Pages.categories.index') }}"
                        class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-utensils mr-2"></i>
                        <p> أصناف الطعام</p>
                    </a>
                </li>
                {{-- @endcan 

                {{-- الأصناف 


                {{-- الطاولات 
                <li class="nav-item">
                    <a href="{{ route('Pages.Tables.index') }}"
                        class="nav-link {{ request()->is('tables*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chair mr-2"></i>
                        <p>الطاولات</p>
                    </a>
                </li>

                {{-- الطلبات 
                <li class="nav-item">
                    <a href="{{ route('Pages.Items.index') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart mr-2"></i>
                        <p>فئات الاصناف</p>
                    </a>
                </li>

                {{-- التقارير 
                {{-- <li class="nav-item">
                    <a href="{{ route('Pages.OrderItems.index') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar mr-2"></i>
                        <p>الطلبات</p>
                    </a>
                </li> 

                {{-- المخزون 
                <li class="nav-item">
                    <a href="{{ route('Pages.waiter.index') }}"
                        class="nav-link {{ request()->is('waiter*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes mr-2"></i>
                        <p>شاشة النادل</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('Pages.cashier.index') }}"
                        class="nav-link {{ request()->is('cashier*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog mr-2"></i>
                        <p>شاشة الكاشير</p>
                    </a>
                </li>
                   <li class="nav-item">
                    <a href="{{ route('Pages.kitchen.index') }}"
                        class="nav-link {{ request()->is('kitchen*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog mr-2"></i>
                        <p>شاشة المطبخ</p>
                    </a>
                </li>

                <li class="nav-item mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                            class="nav-link btn btn-link text-danger w-100 text-right p-0 d-flex align-items-center justify-content-start">
                            <i class="nav-icon fas fa-sign-out-alt mr-2"></i>
                            <p class="m-0">تسجيل الخروج</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>--}}
<x-side />
