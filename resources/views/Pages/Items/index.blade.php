@extends('layouts.app')

@section('content')
<div class="container py-4 text-end" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 text-white mb-1">قائمة الأصناف (الأطباق)</h2>
            <p class="text-muted small">إدارة وتصفية أصناف المنيو الخاصة بك</p>
        </div>
        <div class="d-flex gap-2">
            @if($items->count() > 0)
                <button type="button" onclick="confirmDeleteAll()" class="btn btn-outline-danger d-flex align-items-center px-3 shadow-sm">
                    <i class="fas fa-trash-alt me-2"></i> حذف الكل
                </button>
            @endif
            <a href="{{ route('Pages.Items.create') }}" class="btn btn-primary d-flex align-items-center px-3 shadow-sm">
                <i class="fas fa-plus me-2"></i> إضافة صنف جديد
            </a>
        </div>
    </div>

    <form id="delete-all-form" action="{{ route('Pages.Items.bulkDestroy') }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
        @foreach($items as $item)
            <input type="hidden" name="ids[]" value="{{ $item->id }}">
        @endforeach
    </form>

    <div class="card bg-dark border-secondary mb-4 shadow-sm border-0" style="background-color: #1e1e1e !important;">
        <div class="card-body p-4">
            <form action="{{ route('Pages.Items.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-light fw-bold small">تصفية حسب القسم</label>
                    <select name="category_id" class="form-select bg-dark text-white border-secondary shadow-none custom-select">
                        <option value="">كل الأقسام</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} {{ $cat->status != 'active' ? '(غير نشط)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label text-light fw-bold small">حالة التوفر</label>
                    <select name="status" class="form-select bg-dark text-white border-secondary shadow-none custom-select">
                        <option value="">كل الحالات</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>متوفر</option>
                        <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>غير متوفر</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">بحث</button>
                    <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-dark border-secondary shadow-sm border-0 overflow-hidden" style="background-color: #1e1e1e !important;">
        <div class="table-responsive">
            <x-flash_message />
            <table class="table table-dark table-hover mb-0 align-middle text-end">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th class="px-4 py-3">الصورة</th>
                        <th class="px-4 py-3 text-center">الاسم</th>
                        <th class="px-4 py-3">القسم</th>
                        <th class="px-4 py-3">السعر</th>
                        <th class="px-4 py-3">الحالة</th>
                        <th class="px-4 py-3 text-start">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="border-bottom border-secondary">
                            <td class="px-4 py-3">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/no-image.png') }}"
                                    class="rounded shadow-sm border border-secondary" style="width: 55px; height: 40px; object-fit: cover;">
                            </td>
                            <td class="px-4 fw-bold text-white text-center">{{ $item->item_name }}</td>
                            <td class="px-4">
                                <span class="text-light small">{{ $item->category->name }}</span>
                                @if ($item->category->status != 'active')
                                    <small class="text-danger d-block fw-bold" style="font-size: 0.7rem;">(القسم معطل)</small>
                                @endif
                            </td>
                            <td class="px-4 text-success fw-bold">{{ number_format($item->price, 2) }} <small class="text-muted">ج.م</small></td>
                            <td class="px-4">
                                @if ($item->status == 'available' && $item->category->status == 'active')
                                    <span class="badge rounded-pill bg-success-soft text-success border border-success px-3">متوفر</span>
                                @else
                                    <span class="badge rounded-pill bg-danger-soft text-danger border border-danger px-3">غير متوفر</span>
                                @endif
                            </td>
                            <td class="px-4 text-start">
                                <div class="d-flex justify-content-start gap-2">
                                    <a href="{{ route('Pages.Items.show', $item->id) }}" class="btn-action btn-show" title="مشاهدة">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('Pages.Items.edit', $item->id) }}" class="btn-action btn-edit" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('Pages.Items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('حذف الصنف؟')" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="حذف">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">لا توجد نتائج لعرضها</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    body { background-color: #121212; font-family: 'Cairo', sans-serif; }
    .table-dark { --bs-table-bg: #1e1e1e; --bs-table-hover-bg: #252525; }
    .bg-secondary { background-color: #2d2d2d !important; }

    .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-show { background-color: rgba(255, 193, 7, 0.12); color: #ffc107; }
    .btn-show:hover { background-color: #ffc107; color: #000; transform: translateY(-3px); box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3); }

    .btn-edit { background-color: rgba(13, 202, 240, 0.12); color: #0dcaf0; }
    .btn-edit:hover { background-color: #0dcaf0; color: #fff; transform: translateY(-3px); box-shadow: 0 4px 10px rgba(13, 202, 240, 0.3); }

    .btn-delete { background-color: rgba(220, 53, 69, 0.12); color: #dc3545; }
    .btn-delete:hover { background-color: #dc3545; color: #fff; transform: translateY(-3px); box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3); }

    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }

    .custom-select {
        background-color: #252525 !important;
        border-color: #444 !important;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: none !important; 
        padding-right: 12px !important; 
    }
</style>

<script>
    function confirmDeleteAll() {
        if (confirm('🚨 تنبيه: سيتم حذف جميع الأصناف الموضحة بالجدول حالياً نهائياً. هل أنت متأكد؟')) {
            const form = document.getElementById('delete-all-form');
            if (form) {
                form.submit();
            }
        }
    }
</script>
@endsection