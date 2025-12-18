<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
       public function boot(): void
    {
        // الفحص اذا كان الادمن سوبر ادمن
        // اذا كان سوبر ادمن بيعطيه كل الصلاحيات بدون فحص
        // Gate::before بيشتغل قبل ما يفحص الصلاحيات
        //  Gate::before(function ($user, $ability) {// قبل ما يفحص الصلاحيات
        //     if ($user->super_admin) { // true, false // 1=> true 
        //         // اذا كان سوبر ادمن رجعلي true يعني عندو كل الصلاحيات
        //         return true;
        //     }
        // });
        // /*
       
        //  */
        // // جلب كل الصلاحيات من ملف الكونفيج
        // // ملف الكونفيج موجود في المسار config/abilities.php
        
        // foreach(config('abilities') as $code => $lable) // اذا كان الصلاحية  موجودة
        //     // code is key
        // {
        //     //  تعريف الصلاحية
        //     Gate::define($code, function ($user) use ($code) { // لارافيل رح تمرر اليوزر او الادمن وحسب مين يلي عامل لوغين
        //         //  فحص اذا اليوزر او الادمن عندو الصلاحية
        //         return $user->hasAbility($code); // اذا عندو الصلاحية رجعلي true
        //         //  false اذا ما عندو الصلاحية
        //         // عملية الفحص المشترك بين اليوزر والادمن ف نخن رح نعمل تريد ونستدعيها في كل مكان
        //     });
        // }
    }
}
