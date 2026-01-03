<nav class="main-header d-flex align-items-center px-4">
    <div class="flex-fill text-center">
        <h4 class="mb-0 fw-black text-gold">@lang('Restaurant Management System')</h4>
    </div>

    <div class="dropdown">
        <button class="btn btn-sm text-gold border border-warning"
                data-bs-toggle="dropdown">
            <i class="fas fa-globe"></i>
            {{ LaravelLocalization::getCurrentLocaleNative() }}
        </button>

        <div class="dropdown-menu bg-dark border-warning">
            @foreach(LaravelLocalization::getSupportedLocales() as $code => $props)
                <a class="dropdown-item text-light"
                   href="{{ LaravelLocalization::getLocalizedURL($code) }}">
                    {{ $props['native'] }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
