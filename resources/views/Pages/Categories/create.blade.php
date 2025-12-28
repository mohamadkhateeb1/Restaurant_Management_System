@extends('layouts.app')

@section('content')
<div class="container mt-5" dir="rtl">
    <div class="card bg-dark text-white border-0 shadow-lg" style="border-radius: 20px;">
        <div class="card-header bg-primary text-white p-4" style="border-radius: 20px 20px 0 0;">
            <h4 class="mb-0 fw-bold"><i class="fas fa-plus-circle me-2"></i> إضافة قسم جديد للنظام</h4>
        </div>
        
        <div class="card-body p-4">
            <form method="POST" action="{{ route('Pages.categories.store') }}" enctype="multipart/form-data">
                @csrf
                
                @include('Pages.Categories._form')

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">
                        <i class="fas fa-save me-1"></i> حفظ القسم الجديد
                    </button>
                    <a href="{{ route('Pages.categories.index') }}" class="btn btn-outline-light px-4 rounded-pill">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection