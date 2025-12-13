{{-- @extends('layouts.app') --}}

{{-- @section('title', 'إدارة الموظفين') --}}

{{-- @section('content') --}}

{{-- 1. الحاوية الخارجية: عرض كامل w-full --}}
{{-- <div class="w-full"> --}}
    
    {{-- 2. حاوية العنوان: لضمان التباعد الجانبي (mx-6) كما هو الحال في البطاقة --}}
    {{-- <div class="px-6 pt-6 flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-200"> --}}
            قائمة الموظفين
        {{-- </h2>
        <a href="{{-- route('admin.employees.create') --}}"
           class="inline-flex items-center px-6 py-3 bg-sky-600 border border-transparent rounded-lg font-bold text-sm text-white shadow-lg tracking-wider hover:bg-sky-500 focus:bg-sky-700 transition duration-150 transform hover:scale-[1.01]">
            <i class="fas fa-plus me-2"></i> --}}
            {{-- إضافة موظف جديد --}}
        {{-- </a>
    </div> --}}
    
    {{-- 3. بطاقة الجدول الرئيسية: تبقى بعرض كامل مع تباعد خارجي (mx-6 و mb-6) --}}
    {{-- <div class="bg-gray-800 shadow-xl rounded-lg overflow-hidden mx-6 mb-6">
        
        <div class="overflow-x-auto">
            {{-- table-fixed و min-w-full لفرض توزيع العرض بالتساوي --}}
            {{-- <table class="min-w-full divide-y divide-gray-700 table-fixed"> 
                <thead class="bg-gray-700">
                    <tr> --}}
                        {{-- 7 أعمدة: يتم توزيع العرض الكلي (W-40/40) --}}
                        {{-- <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-8/40">  --}}
                            {{-- الاسم  --}}
                        {{-- </th> --}}
                        {{-- <th scope="col" --}}
                            {{-- class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-8/40">  --}}
                            {{-- البريد الإلكتروني  --}} --}}
                        {{-- </th> --}}
                        {{-- <th scope="col" --}}
                            {{-- class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-4/40">  --}}
                            {{-- رقم الهاتف  --}}
                        {{-- </th> --}}
                        {{-- <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-6/40"> 
                            وظيفة الموظف 
                        </th>
                        <th scope="col" --}}
                            {{-- class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-4/40"> 
                            راتب الموظف 
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-4/40"> 
                            تاريخ التوظيف  --}}
              {{-- ؟          </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider w-6/40"> 
                            الإجراءات 
                        </th>
                    </tr>
                </thead> --}}

                {{-- <tbody class="divide-y divide-gray-700">
                    @forelse (isset($employees) ? $employees : [] as $employee)
                        <tr class="hover:bg-gray-700/50 transition duration-100">
                            يجب تكرار نفس فئات العرض هنا لـ <td> --}}
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white w-8/40">
                                {{ $employee->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 w-8/40">
                                {{ $employee->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap w-4/40"> --}}
                                {{-- {{ $employee->phone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 w-6/40">
                                {{ $employee->position }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 w-4/40">
                                {{ $employee->salary }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 w-4/40">
                                {{ $employee->hire_date }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium w-6/40">
                                <div class="flex justify-end space-x-3 rtl:space-x-reverse">

                                    <a href="#" class="text-sky-400 hover:text-sky-300 transition" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition"
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                لا يوجد موظفين مسجلين حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

    @endsection--}}