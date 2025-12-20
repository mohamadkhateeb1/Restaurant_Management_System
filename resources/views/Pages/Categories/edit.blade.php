@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- زر الرجوع العلوي --}}
            <div class="mb-4">
                <a href="{{ route('Pages.categories.index') }}" class="btn btn-soft-primary rounded-pill px-4 transition-all">
                    <i class="fas fa-arrow-right me-2"></i> العودة للقائمة
                </a>
            </div>

            <div class="card bg-dark text-white border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                {{-- هيدر الكارد --}}
                <div class="card-header bg-secondary text-white border-0 py-3 px-4 d-flex align-items-center">
                    <div class="bg-soft-warning rounded-circle p-2 me-3 d-inline-flex">
                        <i class="fas fa-edit text-warning"></i>
                    </div>
                    <h4 class="mb-0 fw-bold">تعديل بيانات الصنف: {{ $category->name }}</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('Pages.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- تضمين الفورم المشترك --}}
                        @include('Pages.categories._form')

                        <hr class="border-secondary my-4 opacity-25">

                        {{-- أزرار التحكم السفلى --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('Pages.categories.index') }}" class="text-muted text-decoration-none transition-all hover-white">
                                <i class="fas fa-times me-1"></i> إلغاء التعديل
                            </a>
                            
                            <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold text-dark shadow-sm transition-all hover-scale">
                                <i class="fas fa-save me-2"></i> حفظ التغييرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* تنسيقات إضافية للتناسق */
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.2); }
    .bg-soft-primary:hover { background-color: #0d6efd; color: white; }
    
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    
    .transition-all { transition: all 0.3s ease; }
    .hover-scale:hover { transform: scale(1.05); }
    .hover-white:hover { color: white !important; }

    /* تحسين شكل المدخلات داخل الفورم (إذا لم تكن منسقة في الكومبونانت) */
    .form-control:focus {
        background-color: #2b3035 !important;
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25) !important;
        color: white !important;
    }
</style>
@endsection