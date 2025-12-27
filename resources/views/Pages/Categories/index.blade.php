@extends('layouts.app')

@section('content')
    <div class="container mt-5" dir="rtl">
        <div class="row align-items-center mb-5">
            <div class="col-md-6 text-right">
                <h1 class="text-white fw-bold mb-1 display-6">إدارة تصنيفات النظام</h1>
                <p class="text-muted fs-5">التحكم في أقسام البيع (المنيو) وأقسام المخزن الإدارية</p>
            </div>
            <div class="col-md-6 text-left mt-4 mt-md-0">
                <div class="d-flex gap-2 justify-content-start justify-content-md-end">

                    @if ($categories->count() > 0)
                        {{-- نموذج الحذف الجماعي المبسط --}}
                        <form action="{{ route('Pages.categories.bulkDestroy') }}" method="POST"
                            onsubmit="return confirm('🚨 تنبيه: مسح كافة الأقسام سيؤدي لإزالة جميع سجلات المخزن والمواد الخام المرتبطة بها. هل أنت متأكد؟')">
                            @csrf
                            @method('DELETE')

                            {{-- وضع كافة المعرفات في حقول مخفية مباشرة --}}
                            @foreach ($categories as $cat)
                                <input type="hidden" name="ids[]" value="{{ $cat->id }}">
                            @endforeach

                            <button type="submit"
                                class="btn btn-outline-danger shadow-sm px-4 rounded-pill transition-all">
                                <i class="fas fa-trash-sweep me-2"></i> مسح كافة الأقسام
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('Pages.categories.create') }}"
                        class="btn btn-primary shadow-sm px-4 rounded-pill transition-all hover-lift">
                        <i class="fas fa-plus-circle me-2"></i> إضافة قسم جديد
                    </a>
                </div>
            </div>
        </div>

        <x-flash_message />

        <div class="card bg-dark border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 text-center">
                    <thead class="bg-secondary bg-opacity-25 text-muted text-uppercase small">
                        <tr>
                            <th class="py-4" style="width: 80px;">#</th>
                            <th class="py-4 text-right pr-5">اسم القسم</th>
                            <th class="py-4">نوع القسم (النطاق)</th>
                            <th class="py-4">حالة النشاط</th>
                            <th class="py-4">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-bottom border-secondary transition-all">
                                <td>
                                    <span class="badge bg-secondary rounded-pill opacity-75">#{{ $loop->iteration }}</span>
                                </td>
                                <td class="text-right pr-5">
                                    <div class="d-flex align-items-center">
                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}"
                                                class="rounded-3 shadow-sm"
                                                style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-folder text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="mr-3 ms-3">
                                            <h6 class="text-white fw-bold mb-0">{{ $category->name }}</h6>
                                            <small
                                                class="text-muted">{{ Str::limit($category->description, 30) ?? 'لا يوجد وصف' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($category->is_menu_category)
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill shadow-sm">قسم
                                            بيع</span>
                                    @else
                                        <span
                                            class="badge bg-info-subtle text-info border border-info px-3 py-2 rounded-pill shadow-sm">مخزني
                                            إداري</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="status-pill {{ $category->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ $category->status == 'active' ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('Pages.categories.show', $category->id) }}"
                                            class="btn btn-icon btn-soft-primary"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('Pages.categories.edit', $category->id) }}"
                                            class="btn btn-icon btn-soft-warning"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('Pages.categories.destroy', $category->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-soft-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-5 text-muted">لا توجد أقسام مضافة حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .status-pill {
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: 0.3s;
            border: none;
        }

        .btn-soft-primary {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .btn-soft-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .btn-soft-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
    </style>
@endsection
