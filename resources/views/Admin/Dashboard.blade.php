@extends('layouts.app')

@section('title', 'إدارة الموظفين')

{{-- تم وضع المحتوى والتباعد هنا لضبطه بشكل أفضل --}}
@section('restaurant_dashboard_content')

    <div class="p-4 md:p-8">

        {{-- قسم الإحصائيات (KPIs) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            {{-- ... بطاقات الإحصائيات ... --}}
            {{-- ---------------- بطاقة 1: المبيعات اليومية ---------- --}}
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border-t-4 border-green-500">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-400 text-sm font-medium">المبيعات اليومية</h3>
                    <i class="fas fa-dollar-sign text-green-500 text-2xl"></i>
                </div>
                <p class="text-3xl font-extrabold mt-1">2,450 $</p>
                <p class="text-green-400 text-sm mt-2">↑ 15% من أمس</p>
            </div>
            {{-- ---------------- بطاقة 2: الطلبات المكتملة ---------- --}}
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border-t-4 border-blue-500">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-400 text-sm font-medium">الطلبات المكتملة (شهر)</h3>
                    <i class="fas fa-receipt text-blue-500 text-2xl"></i>
                </div>

                <p class="text-3xl font-extrabold mt-1">450 طلب</p>
                <p class="text-blue-400 text-sm mt-2">معدل الإنجاز 98%</p>
            </div>
            {{-- ---------------- بطاقة 3: الموظفون النشطون ---------- --}}
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border-t-4 border-yellow-500">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-400 text-sm font-medium">الموظفون النشطون</h3>
                    <i class="fas fa-users text-yellow-500 text-2xl"></i>
                </div>
                <p class="text-3xl font-extrabold mt-1">15 موظف</p>
                <p class="text-yellow-400 text-sm mt-2">12 نادل، 3 مطبخ</p>
            </div>
            {{-- ---------------- بطاقة 4: متوسط التقييم ---------- --}}
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border-t-4 border-red-500">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-gray-400 text-sm font-medium">متوسط التقييم</h3>
                    <i class="fas fa-star text-red-500 text-2xl"></i>
                </div>
                <p class="text-3xl font-extrabold mt-1">4.7 / 5.0</p>
                <p class="text-red-400 text-sm mt-2">بناءً على 50 تقييماً</p>
            </div>

        </div>

        {{-- قسم جدول الموظفين --}}

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg mt-6">
                <h1 class="text-xl font-bold mb-6 border-b border-gray-700 pb-3">جدول الموظفين</h1>
                <div class="overflow-x-auto">
                    <table class="w-full text-right table-auto">
                        <thead>
                            <tr class="text-gray-400 uppercase text-sm font-semibold border-b border-gray-700">
                                <th class="py-3 px-4">اسم الموظف</th>
                                <th class="py-3 px-4">المسمى الوظيفي</th>
                                <th class="py-3 px-4">القسم</th>
                                <th class="py-3 px-4">تاريخ التوظيف</th>
                                <th class="py-3 px-4">الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-700 hover:bg-gray-700 transition duration-150">
                                <td class="py-3 px-4">اسم الموظف مثال</td>
                                <td class="py-3 px-4">المسمى الوظيفي مثال</td>
                                <td class="py-3 px-4">القسم مثال</td>
                                <td class="py-3 px-4 text-sm text-gray-400">2023-01-01</td>
                                <td class="py-3 px-4">
                                    <span
                                        class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">نشط</span>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
