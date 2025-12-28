@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-right">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold text-primary mb-0">
                            <i class="fas fa-exchange-alt me-1"></i> تسجيل حركة مخزون للمادة: {{ $item->name }}
                        </h5>
                    </div>
                    <div class="card-body border-top p-4">
                        <form action="{{ route('Pages.inventory.transactions.store', $item->id) }}" method="POST">
                            @csrf
                            @include('Pages.Inventory_Transaction._form')

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">حفظ الحركة</button>
                                <a href="{{ route('Pages.inventory.show', $item->id) }}"
                                    class="btn btn-light px-4 ms-2">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
