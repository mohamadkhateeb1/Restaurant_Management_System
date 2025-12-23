@extends('layouts.app')

@section('content')
<div class="container py-4 text-end">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-white">تعديل الصنف: <span class="text-info">{{ $item->item_name }}</span></h2>
        <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-secondary">
             العودة للقائمة <i class="fas fa-arrow-left ms-1"></i>
        </a>
    </div>

    <div class="card bg-dark border-secondary shadow-sm">
        <div class="card-body p-4">
            {{-- تأكد من وجود enctype لإرسال الصور --}}
            <form action="{{ route('Pages.Items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') {{-- ضروري جداً في عملية التعديل --}}
                {{-- استدعاء الفورم المشترك --}}
                @include('Pages.Items._form')

                <hr class="border-secondary my-4">

                <div class="d-flex gap-2 justify-content-start">
                    <button type="submit" class="btn btn-info text-white px-4">
                        حفظ التعديلات <i class="fas fa-save ms-1"></i>
                    </button>
                    <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-danger px-4">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* تنسيق إضافي ليتناسب مع الـ Dark Theme */
    .form-control:focus, .form-select:focus {
        background-color: #252525;
        color: white;
        border-color: #0dcaf0;
        box-shadow: none;
    }
</style>
@endsection