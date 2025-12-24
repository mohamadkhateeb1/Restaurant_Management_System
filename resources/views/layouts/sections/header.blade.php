<nav class="main-header navbar navbar-expand navbar-dark">
    {{-- هذا الشريط العلوي يستخدم AdminLTE القياسي --}}

  <ul>
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <li>
            <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                {{ $properties['native'] }}
            </a>
        </li>
    @endforeach
</ul>
<select>
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <option value="{{ LaravelLocalization::getLocalizedURL($localeCode)}}" @selected($localeCode== App::currentLocale())>
            {{ $properties['native'] }}
        </option>
    @endforeach
</select>

    {{-- عنوان لوحة التحكم في المنتصف --}}
    <div class="navbar-text mx-auto text-white">
        <h2>Restaurant Pages Dashboard</h2>
    </div>

    {{-- القائمة اليسرى (التي تظهر على اليمين في وضع RTL) --}}
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            {{-- زر تبديل السمة (Dark/Light Mode) --}}
            <a class="nav-link" href="#" id="theme-toggle" role="button" title="تبديل وضع العرض">
                <i class="fas fa-sun" id="theme-icon"></i>
            </a>
        </li>
    </ul>
</nav>
