@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        {{-- هيدر الصفحة بتصميم عصري --}}
        <div class="row align-items-center mb-5">
            <div class="col-md-6 text-center text-md-start">
                <h1 class="text-white fw-bold mb-1 display-6">إدارة قائمة الطعام</h1>
                <p class="text-muted fs-5"> الأصناف، الأسعار، وحالات التوفر</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-4 mt-md-0">
                <div class="d-flex gap-2 justify-content-center justify-content-md-end">
                    {{-- زر حذف الكل --}}
                    @if ($categories->count() > 0)
                        <button type="button" class="btn btn-outline-danger shadow-sm px-4 rounded-pill transition-all"
                            onclick="confirmDeleteAll()">
                            <i class="fas fa-trash-sweep me-2"></i> مسح القائمة
                        </button>
                    @endif

                    <a href="{{ route('Pages.categories.create') }}"
                        class="btn btn-primary shadow-sm px-4 rounded-pill transition-all hover-lift">
                        <i class="fas fa-plus-circle me-2"></i> إضافة صنف جديد
                    </a>
                </div>
            </div>
        </div>

        <x-flash_message />

        {{-- فورم حذف الكل المخفي --}}
        <form id="delete-all-form" action="{{ route('Pages.categories.bulkDestroy') }}" method="POST"
            style="display:none;">
            @csrf
            @method('DELETE')
            @foreach ($categories as $category)
                <input type="hidden" name="ids[]" value="{{ $category->id }}">
            @endforeach
        </form>

        {{-- الجدول بتصميم Premium --}}
        <div class="card bg-dark border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 custom-table">
                    <thead class="bg-secondary bg-opacity-25 text-muted text-uppercase small">
                        <tr>
                            <th class="ps-4 py-4" style="width: 80px;">#</th>
                            <th class="py-4">الصنف</th>
                            <th class="py-4 text-center">حالة التوفر</th>
                            <th class="text-center py-4 pe-4">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-bottom border-secondary transition-all">
                                <td class="ps-4">
                                    <span class="badge bg-secondary rounded-pill opacity-75">#{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="img-container me-3 position-relative">
                                            @if ($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}"
                                                    class="rounded-3 shadow-sm"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="fas fa-utensils text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="text-white fw-bold mb-0">{{ $category->name }}</h6>
                                            <small class="text-muted d-block text-truncate"
                                                style="max-width: 150px;">{{ $category->description ?? 'لا يوجد وصف' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="status-pill {{ $category->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                        <span class="status-dot"></span>
                                        {{ $category->status == 'active' ? 'متوفر الآن' : 'غير متوفر' }}
                                    </span>
                                </td>
                                <td class="pe-4">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('Pages.categories.show', $category->id) }}"
                                            class="btn btn-icon btn-soft-primary" title="عرض"><i
                                                class="fas fa-eye"></i></a>
                                        <a href="{{ route('Pages.categories.edit', $category->id) }}"
                                            class="btn btn-icon btn-soft-warning" title="تعديل"><i
                                                class="fas fa-edit"></i></a>

                                        <form action="{{ route('Pages.categories.destroy', $category->id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('هل تريد حذف هذا الصنف نهائياً؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-soft-danger" title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="empty-icon-container mb-4">
                                            <i class="fas fa-utensils fa-4x text-warning opacity-25"></i>
                                            <i class="fas fa-plus fa-1x text-primary position-absolute bottom-0 end-0"></i>
                                        </div>
                                        <h4 class="text-white fw-bold">المنيو ما زال فارغاً!</h4>
                                        <p class="text-muted mb-4">ابدأ بإضافة وجباتك المفضلة لتظهر في هذه القائمة.</p>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03) !important;
            transform: scale(1.002);
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: none;
            transition: 0.3s;
        }

        /* تصميم حالات الأزرار الناعمة */
        .btn-soft-primary {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .btn-soft-primary:hover {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        .btn-soft-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .btn-soft-warning:hover {
            background: #ffc107;
            color: #000;
            box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
        }

        .btn-soft-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .btn-soft-danger:hover {
            background: #dc3545;
            color: #fff;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        /* تصميم شارات الحالة (Status Pills) */
        .status-pill {
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-active .status-dot {
            background: #28a745;
            box-shadow: 0 0 8px #28a745;
        }

        .status-inactive {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .status-inactive .status-dot {
            background: #dc3545;
        }

        /* أيقونة الحالة الفارغة */
        .empty-icon-container {
            position: relative;
            display: inline-block;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
        }
    </style>

    <script>
        // تأكيد حذف الكل
        function confirmDeleteAll() {
            if (confirm('🚨 تنبيه هام: سيتم مسح قائمة الطعام الحالية بالكامل. هل أنت متأكد؟')) {
                document.getElementById('delete-all-form').submit();
            }
        }

        
        document.addEventListener('DOMContentLoaded', function() {//إخفاء رسالة الفلاش تلقائياً بعد ثانيتين
            const flashAlert = document.querySelector('.alert');

            if (flashAlert) {
                setTimeout(function() {
                    flashAlert.style.transition = "opacity 0.6s ease";
                    flashAlert.style.opacity = "0";

                    setTimeout(function() {
                        flashAlert.remove();
                    }, 600);
                }, 2000);
            }
        });
    </script>
@endsection
