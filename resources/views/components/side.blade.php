<aside class="main-sidebar elevation-4">
    <a href="{{ route('Pages.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-bold"><i class="fas fa-utensils"></i> SRMS</span>
    </a>
    <div class="sidebar">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                @foreach ($sideItems as $item)
                    @if (is_null($item['ability']) || Gate::allows($item['ability'], $item['model'] ?? null))
                        <li class="nav-item">
                            <a href="{{ route($item['route']) }}"
                                class="nav-link {{ request()->is($item['active_check']) ? 'active' : '' }}">
                                <i class="nav-icon {{ $item['icon'] }} mr-2"></i>
                                <p>{{ __($item['title']) }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach

                <li class="nav-item mt-3 pt-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit"
                            class="nav-link btn btn-link text-danger w-100 text-left p-0 d-flex align-items-center">
                            <i class="nav-icon fas fa-sign-out-alt mr-2"></i>
                            <p class="m-0">@lang('logout')</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
