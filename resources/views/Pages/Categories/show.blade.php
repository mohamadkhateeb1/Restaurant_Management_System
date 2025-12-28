@extends('layouts.app')

@section('content')
    <div class="container mt-5" dir="rtl">
        <div class="mb-4">
            <a href="{{ route('Pages.categories.index') }}" class="btn btn-soft-primary rounded-pill px-4 transition-all">
                <i class="fas fa-arrow-right ml-2"></i>@lang('Back to Categories List')
            </a>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card bg-dark text-white border-0 shadow-lg overflow-hidden" style="border-radius: 30px;">
                    <div class="row g-0">
                        <div class="col-md-6 position-relative">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" class="w-100 h-100"
                                    style="object-fit: cover; min-height: 450px;" alt="{{ $category->name }}">
                            @else
                                <div class="bg-secondary h-100 d-flex align-items-center justify-content-center"
                                    style="min-height: 450px;">
                                    <i class="fas fa-warehouse fa-5x text-dark opacity-25"></i>
                                </div>
                            @endif
                            <div class="position-absolute top-0 right-0 m-4 d-flex flex-column gap-2 align-items-end">
                                <span
                                    class="badge rounded-pill {{ $category->status == 'active' ? 'bg-success' : 'bg-danger' }} px-4 py-2 shadow-lg">
                                    {{ $category->status == 'active' ? 'قسم نشط' : 'قسم معطل' }}
                                </span>

                                @if ($category->is_menu_category)
                                    <span class="badge rounded-pill bg-primary px-4 py-2 shadow-lg">
                                        <i class="fas fa-utensils ml-1"></i> قسم تجاري
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-info px-4 py-2 shadow-lg text-dark">
                                        <i class="fas fa-warehouse ml-1"></i> مخزني إداري
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center text-right">
                            <div class="mb-2 text-muted small text-uppercase tracking-widest">تفاصيل القسم النظامي</div>
                            <h1 class="display-5 fw-bold mb-3">{{ $category->name }}</h1>

                            <div class="mb-3">
                                <h6 class="text-white fw-bold mb-2 small text-muted">الدور الإداري للقسم:</h6>
                                <div
                                    class="p-3 rounded bg-secondary bg-opacity-10 border-start border-4 {{ $category->is_menu_category ? 'border-primary' : 'border-info' }}">
                                    <p class="fs-6 mb-0">
                                        @if ($category->is_menu_category)
                                            هذا القسم **مزدوج**؛ ينظم المواد في المخزن ويعرض المنتجات الجاهزة في **قائمة
                                            الطعام**.
                                        @else
                                            هذا القسم **إداري بحت**؛ مخصص لمتابعة المواد الأولية ولا يظهر للزبائن في
                                            المنيو.
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <hr class="border-secondary mb-4 opacity-25">

                            <div class="mb-5">
                                <h6 class="text-white fw-bold mb-3"><i class="fas fa-align-right ml-2 text-primary"></i>
                                    الوصف العام:</h6>
                                <p class="text-light opacity-75 lh-lg fs-5">
                                    {{ $category->description ?? 'لا يوجد وصف مخصص لهذا القسم حتى الآن.' }}
                                </p>
                            </div>

                            <div class="d-flex gap-3 mt-auto pt-4">
                                <a href="{{ route('Pages.categories.edit', $category->id) }}"
                                    class="btn btn-warning btn-lg rounded-pill px-5 flex-grow-1 fw-bold transition-all hover-scale">
                                    <i class="fas fa-edit ml-2"></i> تعديل القسم
                                </a>

                                <form action="{{ route('Pages.categories.destroy', $category->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-soft-danger btn-lg rounded-circle p-3 transition-all hover-scale">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .lh-lg {
            line-height: 1.8 !important;
        }

        @media (max-width: 768px) {
            .card img {
                min-height: 250px !important;
            }

            .p-5 {
                padding: 2rem !important;
            }
        }
    </style>
@endsection
