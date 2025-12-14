<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ route('Admin.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold">
            <i class="fas fa-utensils"></i> SRMS
        </span>
    </a>

    <div class="sidebar">

        {{-- قائمة التنقل --}}
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- الرئيسية --}}
                <li class="nav-item">
                    <a href="{{ route('Admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('Admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home mr-2"></i>
                        <p>الرئيسية</p>
                    </a>
                </li>

                {{-- قائمة الطعام --}}
                <li class="nav-item">
                    <a href="{{ url('/menu') }}" class="nav-link {{ request()->is('menu*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-utensils mr-2"></i>
                        <p>قائمة الطعام</p>
                    </a>
                </li>

                {{-- الموظفين --}}
                <li class="nav-item">
                    <a href="{{ route('Admin.employee.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users mr-2"></i>
                        <p>الموظفين</p>
                    </a>
                </li>

                {{-- الطاولات --}}
                <li class="nav-item">
                    <a href="{{ url('/tables') }}" class="nav-link {{ request()->is('tables*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chair mr-2"></i>
                        <p>الطاولات</p>
                    </a>
                </li>

                {{-- الطلبات --}}
                <li class="nav-item">
                    <a href="{{ url('/orders') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart mr-2"></i>
                        <p>الطلبات</p>
                    </a>
                </li>

                {{-- التقارير --}}
                <li class="nav-item">
                    <a href="{{ url('/reports') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar mr-2"></i>
                        <p>التقارير</p>
                    </a>
                </li>

                {{-- المخزون --}}
                <li class="nav-item">
                    <a href="{{ url('/inventory') }}"
                        class="nav-link {{ request()->is('inventory*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes mr-2"></i>
                        <p>المخزون</p>
                    </a>
                </li>

                {{-- الإعدادات --}}
                <li class="nav-item">
                    <a href="{{ url('/settings') }}"
                        class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog mr-2"></i>
                        <p>الإعدادات</p>
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
</aside>
