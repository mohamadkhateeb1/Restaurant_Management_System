@extends('layouts.app')

@section('title', 'تعديل الطاولة')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4 text-white">
                    <h2 class="h3 mb-0">
                        <i class="fas fa-edit text-warning me-2"></i> تعديل الطاولة رقم: {{ $table->table_number }}
                    </h2>
                    <a href="{{ route('Pages.Tables.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-right me-2"></i> العودة للقائمة
                    </a>
                </div>

                <div class="card bg-dark border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-header bg-warning py-3">
                        <h5 class="card-title mb-0 text-dark fw-bold">تحديث بيانات الطاولة</h5>
                    </div>

                    <div class="card-body p-4 text-white">
                        <form method="POST" action="{{ route('Pages.Tables.update', $table->id) }}">
                            @csrf
                            @method('PUT') {{-- مهم جداً للتعديل --}}

                            @include('Pages.Tables._form') {{-- استدعاء الفورم المشترك --}}

                            <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top border-secondary">
                                <a href="{{ route('Pages.Tables.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
                                <button type="submit" class="btn btn-warning px-5 fw-bold shadow">تحديث البيانات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection     