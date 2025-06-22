<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | CodePersona</title>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="antialiased text-gray-100 bg-gradient-to-b from-gray-800 to-black">

    <!-- Hero Section -->
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-white md:text-5xl">
                Selamat Datang di <span class="text-yellow-300">CodePersona</span> 🚀
            </h1>
            <p class="mt-4 text-lg leading-relaxed text-gray-300">
                Temukan cara belajar pemrograman yang paling cocok untukmu! <br>
                Apakah kamu seorang pembelajar <span class="font-semibold text-white">Visual, Auditori, atau Kinestetik?</span>
                <br><br>
                Mari kita cari tahu bersama! 🎯
            </p>
        </div>

        <!-- Card Login/Register -->
        <div class="w-full max-w-sm p-6 mt-8 bg-gray-900 rounded-lg shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-center text-white">Mulai Cari Tahu Yuk! ✨</h2>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full py-2 mt-4 text-center text-white transition bg-blue-500 rounded-lg hover:bg-blue-600">Dashboard</a>
                @else
                <a href="{{ route('login') }}" class="block w-full py-2 mt-4 font-bold text-center text-white transition bg-yellow-400 rounded-lg hover:bg-yellow-500">Log in</a>
                @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full py-2 mt-4 font-bold text-center text-white transition bg-gray-700 rounded-lg hover:bg-gray-600">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

</body>
</html>
