<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>غير مصرح بالدخول - 403</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-900 text-white h-screen flex items-center justify-center overflow-hidden">

    <div class="text-center p-8 max-w-lg w-full">
        <div class="relative mb-8">
            <div class="text-9xl font-bold text-gray-800 opacity-20">403</div>
            <div class="absolute inset-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-red-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold mb-4">يا حبيب، مكانك مو هون!</h1>
        <p class="text-gray-400 mb-8 leading-relaxed">
            يبدو أنك تحاول الدخول إلى منطقة غير مصرح لك بها بناءً على دورك الوظيفي. 
            <br>
            <span class="text-red-400 font-bold">الدور المختار لا يتطابق مع صلاحياتك الحقيقية.</span>
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url()->previous() }}" class="px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg transition duration-300 font-bold">
                رجوع للخلف
            </a>
            <a href="{{ route('login') }}" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg transition duration-300 font-bold shadow-lg shadow-red-900/50">
                العودة لتسجيل الدخول
            </a>
        </div>

        <p class="mt-12 text-sm text-gray-500 italic">
            إذا كنت تعتقد أن هذا خطأ، يرجى مراجعة مدير النظام.
        </p>
    </div>

</body>
</html>