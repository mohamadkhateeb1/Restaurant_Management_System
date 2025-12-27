<nav class="main-header navbar navbar-expand navbar-dark bg-dark shadow-sm py-2">
    <div class="container-fluid d-flex align-items-center flex-row-reverse">

        <div style="flex: 1;" class="d-none d-md-block"></div>

        <div style="flex: 2;" class="text-center">
            <h4 class="text-white mb-0 font-weight-bold shadow-text">
                @lang('Restaurant Management System')</h4>
        </div>

        <div style="flex: 1;" class="d-flex justify-content-start align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle text-white border-0 py-1" type="button"
                    data-toggle="dropdown">
                    <i class="fas fa-globe ml-1"></i> {{ LaravelLocalization::getCurrentLocaleNative() }}
                </button>
                <div class="dropdown-menu dropdown-menu-left shadow-lg border-0 mt-2">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                            class="dropdown-item {{ App::currentLocale() == $localeCode ? 'active' : '' }} text-right py-2">
                            {{ $properties['native'] }} <i class="fas fa-language ml-2 opacity-50"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</nav>
