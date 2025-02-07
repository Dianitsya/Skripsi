<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', value => localStorage.setItem('darkMode', value))" :class="{ 'dark': darkMode }">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Include Tailwind CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Include Alpine.js for state management -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

</head>
<body class="antialiased text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-200">
    <div class="flex flex-col items-center justify-center min-h-screen">
        <!-- Login/Register Section -->
        <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <h2 class="mb-6 text-2xl font-bold text-center">Welcome Admin!</h2>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block w-full py-2 mb-4 text-center text-white bg-blue-500 rounded hover:bg-blue-600">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full py-2 mb-4 text-center text-white bg-green-500 rounded hover:bg-green-600">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full py-2 text-center text-white bg-gray-500 rounded hover:bg-gray-600">Register</a>
                    @endif
                @endauth
            @endif
        </div>


    </div>
</body>
</html>
