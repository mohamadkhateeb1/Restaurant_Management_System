<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // ضروري لضبط التاريخ

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'sales');

        // ضبط نطاق التاريخ الافتراضي (أو من الفلترة)
        $from = $request->sales_from ? Carbon::parse($request->sales_from)->startOfDay() : now()->subDays(30)->startOfDay();
        $to = $request->sales_to ? Carbon::parse($request->sales_to)->endOfDay() : now()->endOfDay();

        // --- قسم المبيعات اليومية المجمعة ---
        $salesQuery = Invoice::query()->whereBetween('created_at', [$from, $to]);

        $totalSalesAmount = (clone $salesQuery)->sum('amount_paid');
        $totalOrdersCount = (clone $salesQuery)->count();

        // التجميع الصارم حسب اليوم لضمان ظهور يوم 27 بشكل مستقل
        $dailySalesData = (clone $salesQuery)
            ->select(
                DB::raw('DATE(created_at) as sales_date'),
                DB::raw('SUM(amount_paid) as total_amount'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sales_date', 'desc')
            ->get();

        // بيانات التبويبات الأخرى
        $invoices = Invoice::with(['employee'])->latest()->get();
        $inventoryItems = Inventory::all();
        $inventoryStats = [
            'stock_value' => Inventory::sum(DB::raw('quantity * cost_per_unit')),
            'low_stock_count' => Inventory::whereColumn('quantity', '<=', 'min_quantity')->count()
        ];

        return view('Pages.Reports.index', compact(
            'activeTab', 'totalSalesAmount', 'totalOrdersCount', 
            'dailySalesData', 'invoices', 'inventoryItems', 'inventoryStats'
        ));
    }

    public function show($date)
    {
        // جلب البيانات ليوم محدد حصراً لعرضها في صفحة التفاصيل
        $invoices = Invoice::with(['employee'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        $totalAmount = $invoices->sum('amount_paid');
        $orders_count = $invoices->count(); // تم تصحيح المسمى ليطابق compact

        return view('Pages.Reports.partials.daily_details', compact('invoices', 'date', 'totalAmount', 'orders_count'));
    }
}