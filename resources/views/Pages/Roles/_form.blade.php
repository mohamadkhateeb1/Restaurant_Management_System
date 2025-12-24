<div class="card-body">
    {{-- حقل اسم الدور باستخدام الـ Component الخاص بك --}}
    <div class="form-group mb-4">
        <x-form.input type="text" name="name" placeholder="Enter Role Name" label="Role Name" :value="old('name', $role->name ?? '')" />
    </div>

    {{-- قسم إدارة القدرات --}}
    <fieldset class="mt-3 border p-3 rounded shadow-sm bg-white">
        <legend class="w-auto px-3 text-primary font-weight-bold" style="font-size: 1.1rem;">
            Abilities Management
        </legend>

        {{-- عرض أخطاء الصلاحيات --}}
        @if ($errors->has('abilities') || $errors->has('abilities.*'))
            <div class="custom-error-banner mb-3 shadow-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first('abilities') ?: 'Please select a value for the permissions.' }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped border mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 40%">Ability Name</th>
                        <th class="text-center text-success">Allow</th>
                        <th class="text-center text-danger">Deny</th>
                        <th class="text-center text-secondary">Inherit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (config('abilities') as $ability_code => $ability_name)
                        <tr>
                            <td class="align-middle font-weight-bold text-muted">
                                {{ $ability_name }}
                                <small class="d-block text-xs text-gray">{{ $ability_code }}</small>
                            </td>

                            {{-- خيار Allow --}}
                            <td class="text-center align-middle">
                                <input type="radio" name="abilities[{{ $ability_code }}]" value="allow"
                                    style="transform: scale(1.2);"
                                    {{ old("abilities.$ability_code", $role_abilities[$ability_code] ?? '') == 'allow' ? 'checked' : '' }}>
                            </td>

                            {{-- خيار Deny --}}
                            <td class="text-center align-middle">
                                <input type="radio" name="abilities[{{ $ability_code }}]" value="deny"
                                    style="transform: scale(1.2);"
                                    {{ old("abilities.$ability_code", $role_abilities[$ability_code] ?? '') == 'deny' ? 'checked' : '' }}>
                            </td>

                            {{-- خيار Inherit --}}
                            <td class="text-center align-middle">
                                <input type="radio" name="abilities[{{ $ability_code }}]" value="inherit"
                                    style="transform: scale(1.2);"
                                    {{ old("abilities.$ability_code", $role_abilities[$ability_code] ?? 'inherit') == 'inherit' ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
</div>

@push('styles')
    <style>
        .custom-error-banner {
            background-color: #fff5f5;
            color: #c53030;
            border-left: 4px solid #fc8181;
            padding: 12px 15px;
            border-radius: 4px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        fieldset {
            border: 1px solid #dee2e6 !important;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.03);
        }

        input[type="radio"] {
            cursor: pointer;
        }

        .font-weight-bold {
            font-weight: 600 !important;
        }
    </style>
@endpush
