@extends('layouts.app')

@section('content')
    <div class="container py-4 text-end" dir="rtl">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 text-white">تفاصيل الصنف البيعي</h2>
            <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                العودة للقائمة <i class="fas fa-arrow-left ms-1"></i>
            </a>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-dark border-secondary shadow-lg h-100 overflow-hidden" style="border-radius: 20px;">
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/no-image.png') }}"
                        class="img-fluid" style="height: 350px; object-fit: cover;">
                </div>
            </div>

            <div class="col-md-8">
                <div class="card bg-dark border-secondary shadow-lg mb-4" style="border-radius: 20px;">
                    <div
                        class="card-header border-secondary bg-secondary text-white fw-bold d-flex justify-content-between py-3">
                        <span><i class="fas fa-info-circle me-2"></i> معلومات المزامنة والرقابة</span>
                        <span class="badge bg-info text-dark">ID: #{{ $item->id }}</span>
                    </div>

                    <div class="card-body p-4">
                        <div
                            class="p-3 mb-4 rounded-4 bg-info bg-opacity-10 border border-info border-opacity-25 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-info fw-bold mb-1"><i class="fas fa-warehouse me-2"></i> الرصيد الحالي
                                    بالمستودع</div>
                                <small class="text-muted">بيانات حقيقية مستمدة من سجلات المخزن</small>
                            </div>
                            <div class="text-start">
                                <span
                                    class="h2 fw-bold mb-0 {{ $item->quantity <= $item->min_quantity ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($item->quantity, 0) }}
                                    <span class="fs-6 fw-normal text-white-50">{{ $item->unit }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="row g-4 text-white">
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">اسم الطبق</label>
                                <span class="fw-bold fs-5">{{ $item->item_name }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">سعر البيع</label>
                                <span class="text-success fw-bold fs-5">{{ number_format($item->price, 0) }} ل.س</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">القسم</label>
                                <span
                                    class="badge bg-primary px-3 py-2 rounded-pill mt-1">{{ $item->category->name }}</span>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small d-block">وقت التحضير</label>
                                <span class="fw-bold"><i class="far fa-clock text-info me-1"></i>
                                    {{ $item->prepare_time ?? '15' }} دقيقة</span>
                            </div>
                        </div>

                        <hr class="border-secondary my-4">

                        <div class="col-12">
                            <label class="text-muted small d-block mb-2">الوصف والمكونات:</label>
                            <p class="text-light-50">{{ $item->description ?: 'لا يوجد وصف متاح.' }}</p>
                        </div>
                    </div>

                    <div class="card-footer border-secondary bg-black bg-opacity-25 d-flex gap-2 p-3">
                        <a href="{{ route('Pages.Items.edit', $item->id) }}"
                            class="btn btn-warning text-dark px-4 fw-bold rounded-pill shadow-sm">
                            <i class="fas fa-edit me-1"></i> تعديل
                        </a>
                        <form action="{{ route('Pages.Items.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('حذف الطبق يزيله من المخزن أيضاً. استمرار؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 rounded-pill">حذف نهائي</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
