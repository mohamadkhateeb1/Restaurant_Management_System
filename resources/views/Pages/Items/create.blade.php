@extends('layouts.app')

@section('content')
    <div class="container py-5 text-end" dir="rtl">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="text-white h3 fw-bold mb-1"><i class="fas fa-plus-circle text-primary me-2"></i>إضافة صنف
                            بيع جديد</h2>
                        <p class="text-muted small">هذه العملية ستنشئ سجلاً في المنيو وسجلاً مطابقاً في المستودع آلياً</p>
                    </div>
                    <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-right ml-2"></i> العودة للمنيو
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm mb-4 bg-danger bg-opacity-10 text-danger rounded-3">
                        <ul class="mb-0 small fw-bold">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('Pages.Items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card bg-dark border-secondary shadow-lg p-2" style="border-radius: 20px; overflow: hidden;">
                        @include('Pages.Items._form')
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
                        <button type="submit"
                            class="btn btn-success btn-lg px-5 shadow-sm rounded-pill fw-bold transition-all hover-lift">
                            <i class="fas fa-save ml-2"></i> اعتماد الطبق وتفعيل المخزن
                        </button>
                        <a href="{{ route('Pages.Items.index') }}"
                            class="btn btn-outline-secondary btn-lg px-4 rounded-pill text-white">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
@endsection
