<aside class="main-sidebar p-3 d-flex flex-column">

    <div class="text-center mb-4">
        <a href="/" class="text-decoration-none">
            <h2 class="fw-black text-gold">SRMS</h2>
        </a>
    </div>

    <nav class="flex-fill">
        <ul class="nav flex-column gap-2">
            @foreach($sideItems as $item)
                <li class="nav-item">
                    <a href="{{ route($item['route']) }}"
                       class="nav-link text-light px-3 py-2 rounded
                       {{ request()->is($item['active_check']) ? 'bg-warning text-dark' : '' }}">
                        <i class="{{ $item['icon'] }} ms-2"></i>
                        {{ __($item['title']) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline-danger w-100 mt-3">
            <i class="fas fa-power-off"></i>
          @lang('Logout')
        </button>
    </form>
</aside>
<style>
/* ===== SIDEBAR ===== */
.main-sidebar {
    background: linear-gradient(180deg, #0b0d10, #141821);
    border-right: 1px solid rgba(212,175,55,.15);
}

/* الرابط العادي */
.main-sidebar .nav-link {
    color: #cbd5e1;
    transition: all .3s ease;
    position: relative;
}

/* Hover */
.main-sidebar .nav-link:hover {
    background: rgba(212,175,55,.12);
    color: #f5e6b8;
    transform: translateX(-4px);
}

/* ===== ACTIVE LINK ===== */
.main-sidebar .nav-link.bg-warning {
    background: linear-gradient(135deg, #d4af37, #b8962e) !important;
    color: #0b0d10 !important;
    font-weight: 800;
    box-shadow:
        0 8px 20px rgba(212,175,55,.45),
        inset 0 0 12px rgba(255,255,255,.25);
    transform: translateX(-6px);
}

/* أيقونة العنصر النشط */
.main-sidebar .nav-link.bg-warning i {
    color: #0b0d10;
}

/* خط ذهبي جانبي */
.main-sidebar .nav-link.bg-warning::before {
    content: "";
    position: absolute;
    right: 0;
    top: 10%;
    height: 80%;
    width: 4px;
    background: #0b0d10;
    border-radius: 4px;
}

/* ===== LOGOUT BUTTON ===== */
.main-sidebar button {
    transition: all .3s ease;
}

.main-sidebar button:hover {
    transform: scale(1.03);
    box-shadow: 0 0 20px rgba(239,68,68,.4);
}
</style>