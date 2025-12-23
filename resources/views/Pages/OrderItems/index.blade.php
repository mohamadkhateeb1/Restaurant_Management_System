@extends('layouts.app')

@section('content')
<div class="container py-4 text-end" dir="rtl">
    {{-- تفاصيل الطلب --}}
    @if($orderInfo) 
    <div class="card bg-dark border-info mb-4 shadow-sm">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4 border-start border-secondary">
                    <h5 class="text-info mb-1">
                        <i class="fas fa-file-invoice me-2"></i> رقم الفاتورة: 
                        <span class="text-white">{{ $orderInfo->order_number ?? $orderInfo->id }}</span>
                    </h5>
                    <p class="text-muted mb-0 small">التاريخ: {{ $orderInfo->created_at->format('Y-m-d H:i A') }}</p>
                </div>
                <div class="col-md-4 border-start border-secondary text-center">
                    @if($dine_in_id)
                        <span class="badge bg-success p-2 px-3 fs-6">
                            <i class="fas fa-chair me-1"></i> طاولة رقم: {{ $orderInfo->table->table_number ?? 'N/A' }}
                        </span>
                    @else
                        <span class="badge bg-warning text-dark p-2 px-3 fs-6">
                            <i class="fas fa-motorcycle me-1"></i> طلب سفري (Takeaway)
                        </span>
                    @endif
                </div>
                <div class="col-md-4">
                    <p class="mb-1 text-muted small">الموظف المسئول:</p>
                    <h6 class="text-white mb-0">
                        <i class="fas fa-user-tie me-1 text-info"></i> {{ $orderInfo->employee->name ?? 'غير محدد' }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 text-white m-0">
            <i class="fas fa-list-ul me-2 text-info"></i> تفاصيل أصناف الطلب
        </h2>
        <a href="{{ $dine_in_id ? route('Pages.waiter.index') : '#' }}" class="btn btn-outline-info">
            <i class="fas fa-chevron-right ms-1"></i> العودة للطلبات
        </a>
    </div>

    {{-- جدول الأصناف المضافة --}}
    <div class="card bg-dark border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <x-flash_message />
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th class="px-4 py-3">الصنف</th>
                        <th class="px-4 py-3 text-center">الكمية</th>
                        <th class="px-4 py-3">سعر الوحدة</th>
                        <th class="px-4 py-3">الإجمالي</th>
                        <th class="px-4 py-3 text-start">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="border-bottom border-secondary">
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold text-white">{{ $item->item->item_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 text-center">
                                <span class="badge bg-info bg-opacity-10 text-info border border-info px-3 py-2">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-4 text-muted">{{ number_format($item->price, 2) }} ج.م</td>
                            <td class="px-4 fw-bold text-success">
                                {{ number_format($item->price * $item->quantity, 2) }} ج.م
                            </td>
                            <td class="px-4 text-start">
                                <form  method="POST" onsubmit="return confirm('إزالة الصنف؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">لم يتم إضافة أصناف لهذا الطلب بعد</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($items->count() > 0)
                <tfoot class="bg-darker">
                    <tr>
                        <td colspan="3" class="text-start fw-bold text-white py-3 px-4">إجمالي الفاتورة النهائي:</td>
                        <td colspan="2" class="text-success fw-bold h5 py-3 px-4">
                            {{ number_format($items->sum(fn($i) => $i->price * $i->quantity), 2) }} ج.م
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection