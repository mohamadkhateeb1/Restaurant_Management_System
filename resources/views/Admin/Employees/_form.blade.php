
<div class="row">

    {{-- القسم الأول: البيانات الشخصية --}}
    <div class="col-md-6">
        <h6 class="text-primary border-bottom pb-2 mb-3">المعلومات الشخصية</h6>

        {{-- 1. الاسم --}}
        <div class="mb-3">
            <x-form.input label="الاسم الكامل" type="text" placeholder="الاسم الكامل" name="name" :value="$employee->name ?? ''" />
        </div>

        {{-- 2. البريد الإلكتروني --}}
        <div class="mb-3">
            {{-- (txt)  هون عملت الايميل من نوع  
              عملت تحقق على انه ايميل (validition)  وبال--}}
            <x-form.input label="البريد الإلكتروني" type="text" placeholder="البريد الإلكتروني" name="email"
                :value="$employee->email ?? ''" />
        </div>

        {{-- 3. حالة الموظف (Select) --}}
        <div class="mb-3">
            <x-form.select label="حالة الموظف" name="status" :options="['active' => 'نشط','inactive' => 'غير نشط',]" :selected="$employee->status ?? ''" />
        </div>

        {{-- 4. رقم الهاتف --}}
        <div class="mb-3">
            <x-form.input label="رقم الهاتف" type="tel" placeholder="رقم الهاتف" name="phone" :value="$employee->phone ?? ''" />
        </div>
    </div>

    {{-- القسم الثاني: بيانات العمل --}}
    <div class="col-md-6"><h6 class="text-primary border-bottom pb-2 mb-3">بيانات التوظيف</h6>
        {{-- 5. الوظيفة --}}
        <div class="mb-3">
            <x-form.select label="الوظيفة" name="position" :options="['Manager' => 'مدير','Chef' => 'طاهي','Waiter' => 'نادل','Cashier' => 'محاسب',]" :selected="$employee->position ?? ''" />
        </div>

        {{-- 6. الراتب --}}
        <div class="mb-3">
            {{-- للتأكد من المحاذاة اليمين للرقم، نستخدم text-end مباشرة --}}
            <x-form.input label="الراتب الشهري" name="salary" type="number" step="0.01" placeholder="0.00"
                class="text-end" :value="$employee->salary ?? ''" />
        </div>

        {{-- 7. تاريخ التوظيف --}}
        <div class="mb-3">
            <x-form.input label="تاريخ التوظيف" type="date" name="hire_date" :value="$employee->hire_date ?? ''" />
        </div>

        {{-- 8. ملاحظات (Textarea) --}}
        <div class="mb-3">
            <label for="notes" class="form-label text-white">ملاحظات (اختياري)</label>
            {{-- تم إضافة text-end لـ textarea --}}
            <textarea class="form-control bg-secondary text-white border-secondary text-end" id="notes" name="notes"
                rows="3">{{ $employee->notes ?? '' }} </textarea>
        </div>
    </div>
</div>
