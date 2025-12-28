@extends('layouts.app')

@section('content')
    <div class="container py-4 text-end" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h4 text-white">تعديل الصنف: <span class="text-info">{{ $item->item_name }}</span></h2>
                <small class="text-muted">ملاحظة: تعديل الكميات هنا سيحدث بيانات المخزن فوراً</small>
            </div>
            <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                العودة للقائمة <i class="fas fa-arrow-left ms-1"></i>
            </a>
        </div>

        <div class="card bg-dark border-secondary shadow-lg" style="border-radius: 20px;">
            <div class="card-body p-4">
                <form action="{{ route('Pages.Items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('Pages.Items._form')

                    <hr class="border-secondary my-4">

                    <div class="d-flex gap-2 justify-content-start">
                        <button type="submit" class="btn btn-info text-white px-5 rounded-pill fw-bold shadow">
                            حفظ التغييرات المزامنة <i class="fas fa-sync-alt ms-1"></i>
                        </button>
                        <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-danger px-4 rounded-pill">إهمال
                            التعديلات</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
