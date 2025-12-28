<div class="row g-4 text-white">
    <div class="col-md-6">
        <div class="p-4 rounded-3 h-100"
            style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">
            <h6 class="text-info border-bottom border-secondary pb-3 mb-4 d-flex align-items-center">
                <i class="fas fa-user-circle me-2 fs-5"></i>@lang('Personal Information and Security')
            </h6>
            <div class="mb-3">
                <x-form.input label="الاسم الكامل" name="name" :value="$employee->name" placeholder="أدخل الاسم الكامل" />
            </div>
            <div class="mb-3">
                <x-form.input label="البريد الإلكتروني" type="email" name="email" :value="$employee->email"
                    placeholder="email@example.com" />
            </div>
            <div class="mb-3">
                <x-form.input label="كلمة المرور" type="password" name="password" placeholder="أدخل كلمة المرور" />
                @if (isset($employee->id))
                    <div class="mt-1 ps-1">
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="fas fa-info-circle me-1"></i> @lang('Leave it blank if you do not want to change')
                        </small>
                    </div>
                @endif
            </div>
            <div class="mb-0">
                <x-form.input label="رقم الهاتف" type="tel" name="phone" :value="$employee->phone"
                    placeholder="09xxxxxxxx" />
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-4 rounded-3 h-100"
            style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">
            <h6 class="text-info border-bottom border-secondary pb-3 mb-4 d-flex align-items-center">
                <i class="fas fa-briefcase me-2 fs-5"></i> @lang('Job Details and Status')
            </h6>
            <div class="mb-3">
                <x-form.select label="المسمى الوظيفي" name="position" :options="['Manager' => 'مدير', 'Chef' => 'طاهي', 'Waiter' => 'نادل', 'Cashier' => 'محاسب']" :selected="$employee->position ?? old('position')" />
            </div>
            <div class="mb-3">
                <x-form.input label="الراتب الشهري" name="salary" type="number" step="0.01" :value="$employee->salary"
                    class="text-end" placeholder="0.00" />
            </div>
            <div class="mb-3">
                <label class="form-label text-white fw-bold mb-2 small">@lang('Functional Roles (Permissions)')</label>
                <div class="p-3 rounded-2 shadow-inner"
                    style="background-color: #1a1d20; border: 1px solid #343a40; max-height: 120px; overflow-y: auto;">
                    <div class="row g-2">
                        @foreach ($roles as $role)
                            <div class="col-6">
                                <div class="form-check custom-card-check">
                                    <input class="form-check-input @error('roles') is-invalid @enderror" type="checkbox"
                                        name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                        {{ collect(old('roles', $employeeRoles ?? []))->contains($role->id) ? 'checked' : '' }}>
                                    <label class="form-check-label text-light-50 small" for="role_{{ $role->id }}"
                                        style="cursor: pointer;">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('roles')
                    <div class="text-danger mt-1" style="font-size: 0.75rem;">{{ $message }}</div>
                @enderror
            </div>
            <div class="row g-2">
                <div class="col-md-7">
                    <x-form.input label="تاريخ التوظيف" type="date" name="hire_date" :value="$employee->hire_date ?? date('Y-m-d')" />
                </div>
                <div class="col-md-5">
                    <x-form.select label="حالة الموظف" name="status" :options="['active' => 'نشط', 'inactive' => 'غير نشط']" :selected="$employee->status ?? 'active'" />
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="p-4 rounded-3"
            style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05);">
            <label for="notes" class="form-label text-info fw-bold mb-3 d-flex align-items-center">
                <i class="fas fa-sticky-note me-2"></i> ملاحظات إضافية (اختياري)
            </label>
            <textarea class="form-control text-white border-secondary @error('notes') is-invalid @enderror" id="notes"
                name="notes" rows="3" style="background-color: #1a1d20; border: 1px solid #343a40; resize: none;"
                placeholder="أدخل أي ملاحظات إضافية عن الموظف هنا...">{{ old('notes', $employee->notes ?? '') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<style>
    .shadow-inner::-webkit-scrollbar {
        width: 5px;
    }

    .shadow-inner::-webkit-scrollbar-track {
        background: #1a1d20;
    }

    .shadow-inner::-webkit-scrollbar-thumb {
        background: #343a40;
        border-radius: 10px;
    }

    .custom-card-check .form-check-input {
        background-color: #2b3035;
        border: 1px solid #495057;
        width: 1.1em;
        height: 1.1em;
        margin-top: 0.2em;
    }

    .custom-card-check .form-check-input:checked {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        box-shadow: 0 0 8px rgba(13, 202, 240, 0.3);
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #1a1d20 !important;
        border-color: #0dcaf0 !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 202, 240, 0.1);
        color: #fff !important;
    }

    .text-light-50 {
        color: rgba(255, 255, 255, 0.7);
    }
</style>
