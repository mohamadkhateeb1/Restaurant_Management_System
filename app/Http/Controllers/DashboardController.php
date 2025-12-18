<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRestaurant; // تم الإبقاء عليه ولكن غير مستخدم حالياً لتجنب خطأ DB

class DashboardController extends Controller
{
    public function index()
    {
        // تم إرسال جميع المتغيرات التي تستخدم في القوالب (مثل $employees و $item) كـ مصفوفة فارغة مؤقتاً
        $emptyData = []; 

        return view('Pages.dashboard', [
            'employees' => $emptyData, // لإرضاء القوالب التي تستخدم $employees
            'item' => $emptyData,       // لإرضاء القوالب التي تستخدم $item
            // يمكنك إضافة أي متغير آخر يُحتمل استخدامه في الـ View
        ]);
    }
}