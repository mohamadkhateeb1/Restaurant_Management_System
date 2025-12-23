@extends('layouts.app')

@section('content')
    <div class="container py-4 text-end">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 text-white">تفاصيل الصنف: <span class="text-info">{{ $item->item_name }}</span></h2>
            <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-secondary">
                العودة للقائمة <i class="fas fa-arrow-left ms-1"></i>
            </a>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-dark border-secondary shadow-sm h-100">
                    <div class="card-body text-center d-flex align-items-center justify-content-center">
                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/no-image.png') }}"
                            class="img-fluid rounded shadow" style="max-height: 300px; object-fit: cover;"
                            alt="{{ $item->item_name }}">
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card bg-dark border-secondary shadow-sm">
                    <div class="card-header border-secondary bg-secondary text-white fw-bold">
                        معلومات الطبق الأساسية
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3 text-muted">اسم الصنف:</div>
                            <div class="col-sm-9 text-white fw-bold">{{ $item->item_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 text-muted">القسم التابع له:</div>
                            <div class="col-sm-9">
                                <span class="badge bg-primary px-3">{{ $item->category->name }}</span>
                                @if ($item->category->status != 'active')
                                    <small class="text-danger ms-2 fw-bold">(القسم غير نشط حالياً)</small>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 text-muted">السعر:</div>
                            <div class="col-sm-9 text-success fw-bold h5">{{ number_format($item->price, 2) }} ج.م</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 text-muted">وقت التحضير:</div>
                            <div class="col-sm-9 text-white">{{ $item->prepare_time ?? 'غير محدد' }} دقيقة</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3 text-muted">حالة التوفر:</div>
                            <div class="col-sm-9">
                                @if ($item->status == 'available' && $item->category->status == 'active')
                                    <span class="badge bg-success">متوفر للطلب</span>
                                @else
                                    <span class="badge bg-danger">غير متوفر حالياً</span>
                                @endif
                            </div>
                        </div>

                        <hr class="border-secondary">

                        <div class="row">
                            <div class="col-12 text-muted mb-2">وصف الطبق:</div>
                            <div class="col-12 text-light" style="line-height: 1.8;">
                                {{ $item->description ?: 'لا يوجد وصف متاح لهذا الصنف.' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-secondary d-flex gap-2">
                        <a href="{{ route('Pages.Items.edit', $item->id) }}" class="btn btn-info text-white px-4">
                            <i class="fas fa-edit me-1"></i> تعديل البيانات
                        </a>
                        <form action="{{ route('Pages.Items.destroy', $item->id) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4">
                                <i class="fas fa-trash-alt me-1"></i> حذف الصنف
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
