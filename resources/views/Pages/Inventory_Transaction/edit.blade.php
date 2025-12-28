@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-right">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold text-warning mb-0">
                            <i class="fas fa-edit me-1"></i> تعديل الحركة رقم #{{ $transaction->id }}
                        </h5>
                        <small class="text-muted">المادة: {{ $inventory->name }}</small>
                    </div>
                    <div class="card-body border-top p-4">
                        <form action="{{ route('Pages.inventory.transaction.update', [$inventory->id, $transaction->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            @include('Inventory._form_transaction')

                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm">تحديث
                                    البيانات</button>
                                <a href="{{ route('Pages.inventory.show', $inventory->id) }}"
                                    class="btn btn-light px-4 ms-2">رجوع</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
