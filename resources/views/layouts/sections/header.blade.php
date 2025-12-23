<nav class="main-header navbar navbar-expand navbar-dark">
    <ul class="navbar-nav ml-2">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-globe mr-1"></i>
                {{ LaravelLocalization::getCurrentLocaleNative() }}
            </a>
            <div class="dropdown-menu dropdown-menu-left p-0">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a rel="alternate" hreflang="{{ $localeCode }}" 
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                       class="dropdown-item {{ App::getLocale() == $localeCode ? 'active' : '' }}">
                        {{ $properties['native'] }}
                    </a>
                @endforeach
            </div>
        </li>
    </ul>

    <div class="navbar-nav mx-auto">
        <h4 class="text-white mb-0 font-weight-bold">Restaurant Pages Dashboard</h4>
    </div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="#" id="theme-toggle" role="button">
                <i class="fas fa-sun" id="theme-icon"></i>
            </a>
        </li>
    </ul>
</nav>