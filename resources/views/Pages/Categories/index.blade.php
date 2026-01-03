@extends('layouts.app')

@section('title', __('إدارة الأقسام'))

@section('content')
    <div class="container mt-4 mt-md-5" dir="rtl">
        {{-- Header Section --}}
        <div class="row align-items-center mb-4 mb-md-5">
            <div class="col-md-6 text-right">
                <h1 class="text-white fw-bold mb-1 display-6">@lang('Categories Management')</h1>
                <p class="text-muted fs-6 fs-md-5">@lang('Manage the system categories (menu) and inventory categories')</p>
            </div>
            <div class="col-md-6 text-left mt-3 mt-md-0">
                {{-- أضفنا justify-content-md-end و flex-nowrap للأجهزة المتوسطة --}}
                <div
                    class="d-flex gap-2 justify-content-start justify-content-md-end align-items-center flex-wrap flex-md-nowrap">
                    @can('delete', App\Models\CategoriesRestaurant::class)
                        @if ($categories->count() > 0)
                            <form action="{{ route('Pages.categories.bulkDestroy') }}" method="POST" class="m-0 p-0"
                                {{-- منع الفورم من أخذ مساحة إضافية --}}
                                onsubmit="return confirm('🚨 تنبيه: مسح كافة الأقسام سيؤدي لإزالة جميع سجلات المخزن والمواد الخام المرتبطة بها. هل أنت متأكد؟')">
                                @csrf
                                @method('DELETE')
                                @foreach ($categories as $cat)
                                    <input type="hidden" name="ids[]" value="{{ $cat->id }}">
                                @endforeach
                                {{-- استخدام w-auto لضمان عدم التمدد --}}
                                <button type="submit"
                                    class="btn btn-outline-danger shadow-sm px-4 rounded-pill transition-all w-auto text-nowrap">
                                    <i class="fas fa-trash-sweep me-2"></i> @lang('Delete All')
                                </button>
                            </form>
                        @endif
                    @endcan
                    @can('create', App\Models\CategoriesRestaurant::class)
                        <a href="{{ route('Pages.categories.create') }}"
                            class="btn btn-primary shadow-sm px-4 rounded-pill transition-all hover-lift w-auto text-nowrap">
                            <i class="fas fa-plus-circle me-2"></i> @lang('Add New')
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <x-flash_message />

        {{-- Table Card --}}
        <div class="card bg-dark border-0 shadow-lg overflow-hidden" style="border-radius: 25px;">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 text-center text-nowrap">
                    <thead class="bg-secondary bg-opacity-25 text-muted text-uppercase small">
                        <tr>
                            <th class="py-4 px-3" style="width: 80px;">#</th>
                            <th class="py-4 text-right pr-5">@lang('Name')</th>
                            <th class="py-4">@lang('Category Type')</th>
                            <th class="py-4">@lang('Status')</th>
                            <th class="py-4">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="border-bottom border-secondary transition-all">
                                <td class="px-3">
                                    <span class="badge bg-secondary rounded-pill opacity-75">#{{ $loop->iteration }}</span>
                                </td>
                                <td class="text-right pr-5">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3 ms-3">
                                            <h6 class="text-white fw-bold mb-0">{{ $category->name }}</h6>
                                            <small
                                                class="text-muted d-block">{{ Str::limit($category->description, 30) ?? 'لا يوجد وصف' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($category->is_menu_category)
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-pill shadow-sm small">
                                            @lang('قسم بيع')
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-info-subtle text-info border border-info px-3 py-2 rounded-pill shadow-sm small">
                                            @lang('مخزني إداري')
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="status-pill {{ $category->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ $category->status == 'active' ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>
                                <td class="px-3">
                                    <div class="d-flex justify-content-center gap-2 flex-nowrap">
                                        @can('view', App\Models\CategoriesRestaurant::class)
                                            <a href="{{ route('Pages.categories.show', $category->id) }}"
                                                class="btn btn-icon btn-soft-primary"><i class="fas fa-eye"></i></a>
                                        @endcan
                                        @can('update', App\Models\CategoriesRestaurant::class)
                                            <a href="{{ route('Pages.categories.edit', $category->id) }}"
                                                class="btn btn-icon btn-soft-warning"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('delete', App\Models\CategoriesRestaurant::class)
                                            <form action="{{ route('Pages.categories.destroy', $category->id) }}"
                                                method="POST" class="d-inline m-0 p-0"
                                                onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-soft-danger"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
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
 .btn-icon {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: 0.3s;
            border: none;
            flex-shrink: 0;
        }

 .w-auto {
            width: auto !important;
        }

        .text-nowrap {
            white-space: nowrap !important;
        }

        .status-pill {
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            display: inline-block;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
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

        @media (max-width: 768px) {
            .display-6 {
                font-size: calc(1.3rem + 0.6vw);
            }

            .fs-5 {
                font-size: 0.9rem !important;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .table-responsive {
                border-radius: 25px;
            }

   .btn-icon {
                width: 34px !important;
                height: 34px !important;
                min-width: 34px !important;
            }

            .status-pill {
                padding: 4px 12px;
                font-size: 0.75rem;
            }
        }

        .hover-lift:hover {
            transform: translateY(-3px);
        }
    </style>
@endsection
