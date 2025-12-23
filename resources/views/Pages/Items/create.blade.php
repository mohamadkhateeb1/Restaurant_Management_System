@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white h3">إضافة طبق جديد</h2>
                    <a href="{{ route('Pages.Items.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                    </a>
                </div>

                <form action="{{ route('Pages.Items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('Pages.Items._form')

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                            حفظ البيانات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
