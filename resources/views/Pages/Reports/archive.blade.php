@extends('layouts.app')
@section('title', 'أرشيف التقارير المالية')
@section('content')
<div class="container py-5" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-gold fw-bold"><i class="fas fa-history me-2"></i> أرشيف التقارير المحفوظة</h2>
        <a href="{{ route('Pages.reports.index') }}" class="btn btn-outline-light rounded-pill px-4">العودة للتقارير الحية</a>
    </div>

    <div class="card bg-dark border-secondary shadow-lg rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle text-center">
                <thead class="bg-secondary text-gold">
                    <tr>
                        <th class="py-3">العنوان</th>
                        <th>النوع</th>
                        <th>المسؤول</th>
                        <th>القيمة المالية عند الأرشفة</th>
                        <th>التاريخ</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($archivedReports as $report)
                        <tr>
                            <td class="fw-bold">{{ $report->title }}</td>
                            <td>
                                <span class="badge {{ $report->report_type == 'sales' ? 'bg-success' : 'bg-info' }}">
                                    {{ $report->report_type == 'sales' ? 'مبيعات' : 'مخزن' }}
                                </span>
                            </td>
                            <td>{{ $report->employee->name ?? 'النظام' }}</td>
                            <td class="text-gold fw-bold">{{ number_format($report->total_summary, 0) }} ل.س</td>
                            <td>{{ $report->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form action="{{ route('Pages.reports.destroy', $report->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-5 text-muted">لا يوجد سجلات مؤرشفة حالياً</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $archivedReports->links() }}</div>
</div>
@endsection