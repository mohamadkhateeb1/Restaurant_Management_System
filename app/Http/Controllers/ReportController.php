<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Report;
use Carbon\Carbon; // ضروري لضبط التاريخ

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Report::class);
        $activeTab = $request->query('tab', 'sales');

        $from = $request->sales_from ? Carbon::parse($request->sales_from)->startOfDay() : now()->subDays(30)->startOfDay();

        $to = $request->sales_to ? Carbon::parse($request->sales_to)->endOfDay() : now()->endOfDay();

        $salesQuery = Invoice::query()->whereBetween('created_at', [$from, $to]);

        $totalSalesAmount = (clone $salesQuery)->sum('amount_paid');

        $totalOrdersCount = (clone $salesQuery)->count();

        $dailySalesData = (clone $salesQuery)
            ->select(
                DB::raw('DATE(created_at) as sales_date'),
                DB::raw('SUM(amount_paid) as total_amount'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sales_date', 'desc')
            ->get();
        $invoices = Invoice::with(['employee'])->latest()->get();
        $inventoryItems = Inventory::all();
        $inventoryStats = [
            'stock_value' => Inventory::sum(DB::raw('quantity * cost_per_unit')),
            'low_stock_count' => Inventory::whereColumn('quantity', '<=', 'min_quantity')->count()
        ];
        return view('Pages.Reports.index', compact(
            'activeTab',
            'totalSalesAmount',
            'totalOrdersCount',
            'dailySalesData',
            'invoices',
            'inventoryItems',
            'inventoryStats'
        ));
    }
    public function show($date)
    {

        $invoices = Invoice::with(['employee'])
            ->whereDate('created_at', $date)
            ->latest()
            ->get();
        $totalAmount = $invoices->sum('amount_paid');
        $orders_count = $invoices->count();
        return view('Pages.Reports.partials.daily_details', compact('invoices', 'date', 'totalAmount', 'orders_count'));
    }
}
