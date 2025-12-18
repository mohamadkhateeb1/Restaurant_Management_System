<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Employee;
use App\Models\DineInOrderRestaurant;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب أول موظف وأول طلب لضمان وجود بيانات للربط
        $employee = Employee::first();
        $order = DineInOrderRestaurant::first();

        if ($employee && $order) {
            Invoice::create([
                'invoice_number'    => 'INV-' . date('Ymd') . '-001',
                'dine_in_order_id'  => $order->id,        // ربط بالطلب الداخلي
                'employee_id'       => $employee->id,     // الموظف الذي أصدرها
                'takeaway_order_id' => null,              // القيمة NULL للطلب الداخلي
                'amount_paid'       => $order->total_amount, 
                'payment_status'    => 'paid',            // الحالة من نوع enum
            ]);
        }
    }
}