<div class="card-body p-4">

    {{-- Role Name --}}
    <div class="mb-5">
        <label class="fw-bold text-light mb-2">
            <i class="fas fa-user-tag text-info me-2"></i> Role Name
        </label>
        <x-form.input type="text" name="name" class="form-control form-control-lg dark-input" :value="old('name', $role->name ?? '')" />
    </div>

    {{-- Permissions --}}
    <h5 class="fw-bold text-light mb-4">
        <i class="fas fa-shield-alt text-info me-2"></i>
        Permissions Matrix
    </h5>
{{-- Bulk Actions --}}
<div class="d-flex flex-wrap gap-2 justify-content-end mb-4">

    <button type="button"
        onclick="setAllAbilities('allow')"
        class="btn btn-ability allow">
        <i class="fas fa-check-circle me-1"></i> Allow All
    </button>

    <button type="button"
        onclick="setAllAbilities('deny')"
        class="btn btn-ability deny">
        <i class="fas fa-times-circle me-1"></i> Deny All
    </button>

    <button type="button"
        onclick="setAllAbilities('inherit')"
        class="btn btn-ability inherit">
        <i class="fas fa-undo me-1"></i> Inherit All
    </button>

</div>

    <div class="table-responsive permissions-wrapper">
        <table class="table table-dark table-hover align-middle mb-0 permissions-table">
            <thead>
                <tr>
                    <th>Permission</th>
                    <th class="text-center">Allow</th>
                    <th class="text-center">Deny</th>
                    <th class="text-center">Inherit</th>
                </tr>
            </thead>
            <tbody>
                @foreach (config('abilities') as $code => $name)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $name }}</div>
                            <small class="text-muted">{{ $code }}</small>
                        </td>

                        @foreach (['allow', 'deny', 'inherit'] as $state)
                            <td class="text-center">
                                <label class="radio-dark {{ $state }}">
                                    <input type="radio" name="abilities[{{ $code }}]"
                                        value="{{ $state }}"
                                        {{ old("abilities.$code", $role_abilities[$code] ?? 'inherit') === $state ? 'checked' : '' }}>
                                    <span></span>
                                </label>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@push('styles')
    <style>
        /* ===== Input ===== */
        .dark-input {
            background: #020617;
            border: 1px solid #1e293b;
            color: #e5e7eb;
        }

        .dark-input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 10px rgba(56, 189, 248, .4);
        }

        /* ===== Table ===== */
        .permissions-wrapper {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(0, 0, 0, .9);
        }

        .permissions-table thead {
            background: #020617;
            text-transform: uppercase;
            font-size: .75rem;
            color: #94a3b8;
        }

        .permissions-table tbody tr {
            transition: .3s;
        }

        .permissions-table tbody tr:hover {
            background: #020617;
            box-shadow: inset 6px 0 0 #38bdf8;
        }

        /* ===== Radio Buttons ===== */
        .radio-dark {
            position: relative;
            cursor: pointer;
        }

        .radio-dark input {
            display: none;
        }

        .radio-dark span {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid #334155;
            transition: .3s;
        }

        .radio-dark.allow span {
            border-color: #22c55e;
        }

        .radio-dark.deny span {
            border-color: #ef4444;
        }

        .radio-dark.inherit span {
            border-color: #64748b;
        }

        .radio-dark input:checked+span {
            background: currentColor;
            box-shadow: 0 0 12px currentColor;
        }

        .radio-dark.allow {
            color: #22c55e;
        }

        .radio-dark.deny {
            color: #ef4444;
        }

        .radio-dark.inherit {
            color: #64748b;
        }
        /* ===== Bulk Buttons ===== */
.btn-ability{
    border:none;
    padding:10px 20px;
    border-radius:12px;
    font-weight:700;
    font-size:.85rem;
    display:flex;
    align-items:center;
    gap:6px;
    transition:.3s;
    box-shadow:0 0 20px rgba(0,0,0,.6);
}

.btn-ability.allow{
    background:linear-gradient(135deg,#16a34a,#22c55e);
    color:#022c22;
}
.btn-ability.allow:hover{
    box-shadow:0 0 30px rgba(34,197,94,.8);
    transform:translateY(-2px);
}

.btn-ability.deny{
    background:linear-gradient(135deg,#7f1d1d,#ef4444);
    color:#fff;
}
.btn-ability.deny:hover{
    box-shadow:0 0 30px rgba(239,68,68,.8);
    transform:translateY(-2px);
}

.btn-ability.inherit{
    background:linear-gradient(135deg,#334155,#64748b);
    color:#e5e7eb;
}
.btn-ability.inherit:hover{
    box-shadow:0 0 30px rgba(148,163,184,.8);
    transform:translateY(-2px);
}

    </style>
@endpush
@push('scripts')
    <script>
        function setAllAbilities(state) {
            const radios = document.querySelectorAll('.permissions-table tbody input[type="radio"]');
            radios.forEach(radio => {
                if (radio.parentElement.classList.contains(state)) {
                    radio.checked = true;
                }
            });
        }
    </script>
