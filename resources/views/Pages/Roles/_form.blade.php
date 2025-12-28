<div class="card shadow-sm border-0 rounded-lg">
    <div class="card-body p-4">
        <div class="form-group mb-5">
            <label class="font-weight-bold text-dark mb-2" style="font-size: 1rem; letter-spacing: 0.5px;">
                <i class="fas fa-user-tag text-primary mr-2"></i> @lang('Role Name')
            </label>
            <x-form.input type="text" name="name"
                class="form-control-lg border-2 shadow-none shadow-hover transition" placeholder="e.g. Senior Manager"
                :value="old('name', $role->name ?? '')" />
        </div>

        <fieldset class="mt-4 border-0 p-0">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <legend class="w-auto m-0 text-dark font-weight-bold h5">
                    <i class="fas fa-shield-alt text-primary mr-2"></i> @lang('Permissions Matrix')
                </legend>

                <div class="btn-group shadow-sm rounded p-1 bg-light border" role="group">
                    <button type="button" onclick="selectAllAbilities('allow')"
                        class="btn btn-sm btn-white border-0 text-success font-weight-bold px-3 hover-success">
                        <i class="fas fa-check-circle"></i> @lang('Allow All')
                    </button>
                    <button type="button" onclick="selectAllAbilities('deny')"
                        class="btn btn-sm btn-white border-0 text-danger font-weight-bold px-3 hover-danger">
                        <i class="fas fa-times-circle"></i> @lang('Deny All')
                    </button>
                    <button type="button" onclick="selectAllAbilities('inherit')"
                        class="btn btn-sm btn-white border-0 text-secondary font-weight-bold px-3 hover-secondary">
                        <i class="fas fa-undo"></i> @lang('Inherit All')
                    </button>
                </div>
            </div>

            @if ($errors->has('abilities') || $errors->has('abilities.*'))
                <div class="alert alert-custom-danger shadow-sm mb-4 border-0" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $errors->first('abilities') ?: 'Attention: Some permissions are missing selection.' }}
                </div>
            @endif

            <div class="table-responsive border rounded-lg bg-white shadow-sm">
                <table class="table table-borderless table-hover mb-0 custom-permissions-table">
                    <thead class="bg-dark text-white text-uppercase">
                        <tr>
                            <th class="py-3 px-4" style="font-size: 0.8rem; letter-spacing: 1px;">@lang('Permission')
                            </th>
                            <th class="text-center py-3" style="width: 120px;">@lang('Allow')</th>
                            <th class="text-center py-3" style="width: 120px;">@lang('Deny')</th>
                            <th class="text-center py-3" style="width: 120px;">@lang('Inherit')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (config('abilities') as $ability_code => $ability_name)
                            <tr class="border-bottom transition">
                                <td class="align-middle py-3 px-4">
                                    <span class="d-block font-weight-bold text-dark mb-0">{{ $ability_name }}</span>
                                    <code class="text-muted small bg-light px-1 rounded"
                                        style="font-size: 0.7rem;">#{{ $ability_code }}</code>
                                </td>

                                <td class="text-center align-middle bg-light-success-hover">
                                    <label class="custom-radio-wrapper m-0">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="allow"
                                            class="ability-radio radio-allow"
                                            {{ old("abilities.$ability_code", $role_abilities[$ability_code] ?? '') == 'allow' ? 'checked' : '' }}>
                                        <span class="checkmark checkmark-allow"></span>
                                    </label>
                                </td>

                                <td class="text-center align-middle bg-light-danger-hover">
                                    <label class="custom-radio-wrapper m-0">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="deny"
                                            class="ability-radio radio-deny"
                                            {{ old("abilities.$ability_code", $role_abilities[$ability_code] ?? '') == 'deny' ? 'checked' : '' }}>
                                        <span class="checkmark checkmark-deny"></span>
                                    </label>
                                </td>

                                <td class="text-center align-middle bg-light-secondary-hover">
                                    <label class="custom-radio-wrapper m-0">
                                        <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit"
                                            class="ability-radio radio-inherit"
                                            {{ old("abilities.$ability_code", $role_abilities[$ability_code] ?? 'inherit') == 'inherit' ? 'checked' : '' }}>
                                        <span class="checkmark checkmark-inherit"></span>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </fieldset>
    </div>
</div>

@push('styles')
    <style>
        :root {
            --primary-soft: #f0f7ff;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --secondary-color: #6c757d;
        }

        .shadow-hover:focus {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.1) !important;
        }

        .transition {
            transition: all 0.2s ease-in-out;
        }

        .alert-custom-danger {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 5px solid #fc8181;
            padding: 1rem;
            border-radius: 8px;
        }

        .custom-permissions-table tbody tr:hover {
            background-color: var(--primary-soft);
            transform: translateX(5px);
        }

        .bg-light-success-hover:hover {
            background-color: #e6ffed !important;
        }

        .bg-light-danger-hover:hover {
            background-color: #fff5f5 !important;
        }

        .bg-light-secondary-hover:hover {
            background-color: #f8f9fa !important;
        }

        .btn-white {
            background: #fff;
            transition: background 0.2s;
        }

        .hover-success:hover {
            background: #e6ffed;
            color: #1e7e34 !important;
        }

        .hover-danger:hover {
            background: #fff5f5;
            color: #bd2130 !important;
        }

        .hover-secondary:hover {
            background: #f8f9fa;
            color: #545b62 !important;
        }

        .custom-radio-wrapper {
            position: relative;
            display: inline-block;
            width: 22px;
            height: 22px;
            cursor: pointer;
        }

        .custom-radio-wrapper input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            background-color: #eee;
            border-radius: 50%;
            border: 2px solid #ddd;
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .custom-radio-wrapper input:checked~.checkmark-allow {
            background-color: var(--success-color);
            border-color: var(--success-color);
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.4);
        }

        .custom-radio-wrapper input:checked~.checkmark-deny {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            box-shadow: 0 0 8px rgba(220, 53, 69, 0.4);
        }

        .custom-radio-wrapper input:checked~.checkmark-inherit {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            box-shadow: 0 0 8px rgba(108, 117, 125, 0.4);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 11px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .custom-radio-wrapper input:checked~.checkmark:after {
            display: block;
        }
    </style>
@endpush

<script>
    function selectAllAbilities(value) {
        const radios = document.querySelectorAll(`input[type="radio"][value="${value}"]`);
        radios.forEach(radio => {
            radio.checked = true;
        });
        console.log(`Matrix updated: All set to ${value}`);
    }
</script>
