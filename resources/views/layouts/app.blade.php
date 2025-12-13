@extends('layouts.app')

@section('title', 'إدارة الموظفين')

@section('content')

<div class="container-fluid px-4 py-6">
    
    {{-- Header Section --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">
            <i class="fas fa-users me-2 text-sky-600"></i>
            قائمة الموظفين
        </h2>
        <a href="{{-- route('admin.employees.create') --}}"
            class="inline-flex items-center px-6 py-3 bg-sky-600 border border-transparent rounded-lg font-bold text-sm text-white shadow-lg tracking-wider hover:bg-sky-700 focus:ring-4 focus:ring-sky-300 transition duration-200 transform hover:scale-105">
            <i class="fas fa-plus me-2"></i>
            إضافة موظف جديد
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        
        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gradient-to-r from-sky-600 to-sky-700">
                    <tr>
                        <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            الاسم
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            البريد الإلكتروني
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            رقم الهاتف
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            الوظيفة
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            الراتب
                        </th>
                        <th class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            تاريخ التوظيف
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-bold text-white uppercase tracking-wider">
                            الإجراءات
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse (isset($employees) ? $employees : [] as $employee)
                        <tr class="hover:bg-sky-50 transition duration-150">
                            
                            {{-- الاسم --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-sky-600 flex items-center justify-center text-white font-bold">
                                            {{ mb_substr($employee->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $employee->name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- البريد الإلكتروني --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">
                                    <i class="fas fa-envelope text-sky-500 me-2"></i>
                                    {{ $employee->email }}
                                </div>
                            </td>

                            {{-- رقم الهاتف --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-sky-100 text-sky-800">
                                    <i class="fas fa-phone me-2"></i>
                                    {{ $employee->phone }}
                                </span>
                            </td>

                            {{-- الوظيفة --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-briefcase me-2"></i>
                                    {{ $employee->position }}
                                </span>
                            </td>

                            {{-- الراتب --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-green-600">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    {{ number_format($employee->salary, 2) }} ر.س
                                </div>
                            </td>

                            {{-- تاريخ التوظيف --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-calendar-alt text-gray-400 me-2"></i>
                                    {{ $employee->hire_date }}
                                </div>
                            </td>

                            {{-- الإجراءات --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center items-center gap-3">
                                    
                                    {{-- زر عرض --}}
                                    <a href="#" 
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition duration-150" 
                                        title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- زر تعديل --}}
                                    <a href="#" 
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 transition duration-150" 
                                        title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- زر حذف --}}
                                    <form method="POST" 
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الموظف؟')" 
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition duration-150"
                                            title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                                    <h3 class="text-xl font-semibold text-gray-700 mb-2">
                                        لا يوجد موظفين مسجلين
                                    </h3>
                                    <p class="text-gray-500">
                                        قم بإضافة موظفين جدد من خلال الزر أعلاه
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (إذا كان موجود) --}}
        @if(isset($employees) && method_exists($employees, 'links'))
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $employees->links() }}
        </div>
        @endif

    </div>

    {{-- إحصائيات سريعة (اختياري) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        
        <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">إجمالي الموظفين</p>
                    <p class="text-3xl font-bold mt-2">{{ isset($employees) ? count($employees) : 0 }}</p>
                </div>
                <i class="fas fa-users text-4xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">الموظفين النشطين</p>
                    <p class="text-3xl font-bold mt-2">--</p>
                </div>
                <i class="fas fa-user-check text-4xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">إجمالي الرواتب</p>
                    <p class="text-3xl font-bold mt-2">--</p>
                </div>
                <i class="fas fa-dollar-sign text-4xl opacity-20"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90">الوظائف المختلفة</p>
                    <p class="text-3xl font-bold mt-2">--</p>
                </div>
                <i class="fas fa-briefcase text-4xl opacity-20"></i>
            </div>
        </div>

    </div>

</div>

@endsection