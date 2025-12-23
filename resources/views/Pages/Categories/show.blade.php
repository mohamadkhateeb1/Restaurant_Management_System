@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- زر الرجوع --}}
    <div class="mb-4">
        <a href="{{ route('Pages.categories.index') }}" class="btn btn-soft-primary rounded-pill px-4 transition-all">
            <i class="fas fa-arrow-right me-2"></i> العودة لقائمة الأصناف
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card bg-dark text-white border-0 shadow-lg overflow-hidden" style="border-radius: 30px;">
                <div class="row g-0">
                    
                    {{-- قسم الصورة (نصف العرض) --}}
                    <div class="col-md-6 position-relative">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 class="w-100 h-100" 
                                 style="object-fit: cover; min-height: 450px;" 
                                 alt="{{ $category->name }}">
                        @else
                            <div class="bg-secondary h-100 d-flex align-items-center justify-content-center" style="min-height: 450px;">
                                <i class="fas fa-utensils fa-5x text-dark opacity-25"></i>
                            </div>
                        @endif
                        
                        {{-- شارة الحالة فوق الصورة --}}
                        <div class="position-absolute top-0 start-0 m-4">
                            <span class="badge rounded-pill {{ $category->status == 'active' ? 'bg-success' : 'bg-danger' }} px-4 py-2 shadow-lg">
                                {{ $category->status == 'active' ? 'صنف نشط' : 'صنف متوقف' }}
                            </span>
                        </div>
                    </div>

                    {{-- قسم التفاصيل (النصف الآخر) --}}
                    <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                        <div class="mb-2 text-muted small text-uppercase tracking-widest">تفاصيل المنتج</div>
                        <h1 class="display-5 fw-bold mb-3">{{ $category->name }}</h1>
                        
                   

                        <hr class="border-secondary mb-4 opacity-25">

                        <div class="mb-5">
                            <h6 class="text-white fw-bold mb-3"><i class="fas fa-align-left me-2 text-primary"></i> الوصف:</h6>
                            <p class="text-light opacity-75 lh-lg fs-5">
                                {{ $category->description ?? 'لا يوجد وصف مخصص لهذا الصنف حتى الآن. يمكنك إضافة وصف لزيادة مبيعات هذا الصنف.' }}
                            </p>
                        </div>

                        {{-- أزرار التحكم السريع --}}
                        <div class="d-flex gap-3 mt-auto pt-4">
                            <a href="{{ route('Pages.categories.edit', $category->id) }}" class="btn btn-warning btn-lg rounded-pill px-5 flex-grow-1 fw-bold transition-all hover-scale">
                                <i class="fas fa-edit me-2"></i> تعديل الصنف
                            </a>
                            <button class="btn btn-soft-danger btn-lg rounded-circle p-3 transition-all hover-scale">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.2); }
    .bg-soft-primary:hover { background-color: #0d6efd; color: white; }
    
    .transition-all { transition: all 0.3s ease; }
    .hover-scale:hover { transform: scale(1.05); }
    
    .lh-lg { line-height: 1.8 !important; }
    
    /* جعل التصميم متجاوب في الجوال */
    @media (max-width: 768px) {
        .card img { min-height: 250px !important; }
        .p-5 { padding: 2rem !important; }
    }
</style>
@endsection