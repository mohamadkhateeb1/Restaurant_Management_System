<div class="card-body p-4 p-md-5">

    {{-- Role Name --}}
    <div class="mb-5">
        <label class="fw-light text-gold mb-2 text-uppercase" style="letter-spacing: 1px;">
            <i class="fas fa-user-tag me-2"></i> @lang('Role Name')
        </label>
        <x-form.input type="text" name="name" class="form-control form-control-lg luxury-input"
            placeholder="e.g. Manager, Cashier..." :value="old('name', $role->name ?? '')" />
    </div>

    {{-- Permissions Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <h5 class="fw-light text-white mb-0">
            <i class="fas fa-shield-alt text-gold me-2"></i>
            @lang('Permissions Matrix')
        </h5>

        {{-- Bulk Actions --}}
        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
            <button type="button" onclick="setAllAbilities('allow')" class="btn btn-ability-luxury allow">
                <i class="fas fa-check-circle"></i> <span>Allow All</span>
            </button>
            <button type="button" onclick="setAllAbilities('deny')" class="btn btn-ability-luxury deny">
                <i class="fas fa-times-circle"></i> <span>Deny All</span>
            </button>
            <button type="button" onclick="setAllAbilities('inherit')" class="btn btn-ability-luxury inherit">
                <i class="fas fa-undo"></i> <span>Inherit</span>
            </button>
        </div>
    </div>

    {{-- Permissions Table --}}
    <div class="table-container-luxury">
        <div class="table-responsive">
            <table class="table table-dark custom-table-luxury align-middle mb-0 permissions-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Permission</th>
                        <th class="text-center">Allow</th>
                        <th class="text-center">Deny</th>
                        <th class="text-center">Inherit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (config('abilities') as $code => $name)
                        <tr>
                            <td>
                                <div class="fw-bold text-white">{{ $name }}</div>
                                <small class="text-muted font-monospace"
                                    style="font-size: 0.7rem;">{{ $code }}</small>
                            </td>

                            @foreach (['allow', 'deny', 'inherit'] as $state)
                                <td class="text-center" data-label="{{ ucfirst($state) }}">
                                    <label class="radio-luxury {{ $state }}">
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
</div>

@push('styles')
    <style>
        /* ===== Inputs & Selects ===== */
        .luxury-input {
            background-color: #0c0c0c !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            border-radius: 12px;
            padding: 12px 20px;
            transition: 0.3s;
        }

        .luxury-input:focus {
            border-color: var(--gold-primary) !important;
            box-shadow: 0 0 15px rgba(197, 160, 89, 0.1) !important;
        }

        /* ===== Bulk Buttons ===== */
        .btn-ability-luxury {
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(255, 255, 255, 0.02);
            color: #fff;
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-ability-luxury.allow:hover {
            border-color: #22c55e;
            color: #22c55e;
            background: rgba(34, 197, 94, 0.05);
        }

        .btn-ability-luxury.deny:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        .btn-ability-luxury.inherit:hover {
            border-color: var(--gold-primary);
            color: var(--gold-primary);
            background: rgba(197, 160, 89, 0.05);
        }

        /* ===== Table Styling ===== */
        .table-container-luxury {
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            overflow: hidden;
        }

        .custom-table-luxury thead {
            background: rgba(255, 255, 255, 0.02);
        }

        .custom-table-luxury thead th {
            color: var(--gold-primary) !important;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.7rem;
            padding: 15px !important;
            border: none !important;
        }

        .custom-table-luxury tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
            transition: 0.3s;
        }

        .custom-table-luxury tbody tr:hover {
            background: rgba(255, 255, 255, 0.01);
        }

        /* ===== Radio Buttons ===== */
        .radio-luxury {
            position: relative;
            cursor: pointer;
            padding: 5px;
        }

        .radio-luxury input {
            display: none;
        }

        .radio-luxury span {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            border: 2px solid #333;
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }

        .radio-luxury.allow span {
            border-color: rgba(34, 197, 94, 0.3);
        }

        .radio-luxury.deny span {
            border-color: rgba(239, 68, 68, 0.3);
        }

        .radio-luxury.inherit span {
            border-color: rgba(197, 160, 89, 0.3);
        }

        .radio-luxury input:checked+span {
            transform: scale(1.1);
        }

        .radio-luxury.allow input:checked+span {
            background: #22c55e;
            border-color: #22c55e;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
        }

        .radio-luxury.deny input:checked+span {
            background: #ef4444;
            border-color: #ef4444;
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
        }

        .radio-luxury.inherit input:checked+span {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
            box-shadow: 0 0 10px rgba(197, 160, 89, 0.5);
        }

        /* ===== Responsive Media Queries ===== */
        @media (max-width: 768px) {
            .btn-ability-luxury span {
                display: none;
            }

            /* إخفاء النص في الجوال لإبقاء الأيقونات */
            .btn-ability-luxury {
                padding: 10px;
            }

            /* تحويل الجدول إلى كروت في الشاشات الصغيرة جداً اختيارياً أو الاحتفاظ بالتمرير */
            .custom-table-luxury thead th {
                font-size: 0.6rem;
                padding: 10px !important;
            }

            .luxury-input {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .permissions-table td {
                padding: 12px 8px !important;
            }

            .radio-luxury span {
                width: 18px;
                height: 18px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function setAllAbilities(state) {
            const radios = document.querySelectorAll('.permissions-table tbody tr');
            radios.forEach(tr => {
                const radio = tr.querySelector(`.radio-luxury.${state} input`);
                if (radio) radio.checked = true;
            });
        }
    </script>
@endpush
