<div class="row text-white">

    {{-- القسم الأول: البيانات الشخصية والأمان --}}

    <div class="col-md-6 border-start border-secondary px-4">
        <h6 class="text-info border-bottom border-secondary pb-2 mb-3">
            <i class="fas fa-user-circle me-2"></i> المعلومات الشخصية والأمان
        </h6>

        <div class="mb-3">
            <x-form.input label="الاسم الكامل" type="text" placeholder="أدخل الاسم الكامل" name="name" :value="$employee->name ?? old('name')"  />
        </div>

        <div class="mb-3">
            <x-form.input label="البريد الإلكتروني" type="email" placeholder="email@example.com" name="email" :value="$employee->email ?? old('email')"   />
        </div>

        <div class="mb-3">
            <x-form.input label="كلمة المرور" type="password" placeholder="أدخل كلمة المرور" name="password"  />
            @if(isset($employee))
                <small class="text-secondary d-block mt-1">اتركه فارغاً إذا كنت لا تريد تغيير كلمة المرور</small>
            @endif
        </div>

        <div class="mb-3">
            <x-form.input label="رقم الهاتف" type="tel" placeholder="09xxxxxxxx" name="phone" :value="$employee->phone ?? old('phone')"  />
        </div>
    </div>

    {{-- القسم الثاني: بيانات العمل والحالة --}}

    <div class="col-md-6 px-4">
        <h6 class="text-info border-bottom border-secondary pb-2 mb-3">
            <i class="fas fa-briefcase me-2"></i> تفاصيل الوظيفة والراتب
        </h6>

        <div class="mb-3">
            <x-form.select label="المسمى الوظيفي" name="position" 
                :options="['Manager' => 'مدير', 'Chef' => 'طاهي', 'Waiter' => 'نادل', 'Cashier' => 'محاسب']" 
                :selected="$employee->position ?? old('position')"  />
        </div>

        <div class="mb-3">
            <x-form.input label="الراتب الشهري" name="salary" type="number" step="0.01" placeholder="0.00"
                class="text-end" :value="$employee->salary ?? old('salary')"  />
        </div>

        <div class="mb-3">
            <x-form.input label="تاريخ التوظيف" type="date" name="hire_date" :value="$employee->hire_date ?? old('hire_date', date('Y-m-d'))"  />
        </div>

        <div class="mb-3">
            <x-form.select label="حالة الموظف الحالية" name="status" 
                :options="['active' => 'نشط (على رأس عمله)', 'inactive' => 'غير نشط (مستقيل/مجاز)']" 
                :selected="$employee->status ?? old('status', 'active')" />
                
        </div>
    </div>

    {{-- القسم الثالث: ملاحظات إضافية --}}
    <div class="col-12 mt-3 px-4">
        <div class="mb-3">
            <label for="notes" class="form-label text-info fw-bold">
                <i class="fas fa-sticky-note me-2"></i> ملاحظات الموارد البشرية (اختياري)
            </label>
            <textarea class="form-control bg-secondary text-white border-0 text-end" 
                id="notes" name="notes" rows="3" placeholder="أدخل أي ملاحظات إضافية هنا...">{{ $employee->notes ?? old('notes') }}</textarea>
        </div>
    </div>
</div>