@extends('layouts.app')

@section('content')
<div class="max-w-4xl p-6 mx-auto mt-10 bg-white rounded-lg shadow-md">
    <h2 class="mb-6 text-2xl font-bold text-center">📊 Hasil Kuisioner</h2>

    <!-- 🔹 Hasil Minat Belajar Pemrograman -->
    <div class="p-4 mb-6 bg-gray-100 rounded-lg">
        <h3 class="text-lg font-bold text-gray-700">Minat Belajar Pemrograman</h3>
        <p class="mt-2 text-gray-600">
            <strong>Skor:</strong> {{ $minatResult->skor }} <br>
            <strong>Kategori:</strong> {{ $minatResult->minat }}
        </p>
    </div>

    <!-- 🔹 Hasil Gaya Belajar -->
    <div class="p-4 mb-6 bg-gray-100 rounded-lg">
        <h3 class="text-lg font-bold text-gray-700">Gaya Belajar</h3>
        <ul class="mt-2 text-gray-600">
            <li><strong>Visual:</strong> {{ $learningResult->visual_score }}</li>
            <li><strong>Auditori:</strong> {{ $learningResult->auditory_score }}</li>
            <li><strong>Kinestetik:</strong> {{ $learningResult->kinesthetic_score }}</li>
            <li class="mt-2"><strong>Dominan:</strong> 🎯 {{ $learningResult->dominant_style }}</li>
        </ul>
    </div>

    @php
        // Tentukan route dashboard sesuai dengan kategori minat
        if (strpos($minatResult->minat, 'Rendah') !== false) {
            $dashboardRoute = route('dashboard.beginner');
        } elseif (strpos($minatResult->minat, 'Sedang') !== false) {
            $dashboardRoute = route('dashboard.intermediate');
        } elseif (strpos($minatResult->minat, 'Tinggi') !== false) {
            $dashboardRoute = route('dashboard.advanced');
        } else {
            $dashboardRoute = route('dashboard');
        }
    @endphp

    <!-- 🔹 Tombol Menuju Dashboard (Menyesuaikan Minat) -->
<div class="mt-6 text-center">
    @if(str_contains($minatResult->minat, 'Tinggi'))
        <a href="{{ route('dashboard.advanced') }}" class="px-6 py-2 text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700">
            🚀 Lanjut ke Dashboard
        </a>
    @elseif(str_contains($minatResult->minat, 'Sedang'))
        <a href="{{ route('dashboard.intermediate') }}" class="px-6 py-2 text-white bg-yellow-600 rounded-lg shadow-md hover:bg-yellow-700">
            🚀 Lanjut ke Dashboard
        </a>
    @else
        <a href="{{ route('dashboard.beginner') }}" class="px-6 py-2 text-white bg-red-600 rounded-lg shadow-md hover:bg-red-700">
            🚀 Lanjut ke Dashboard
        </a>
    @endif
</div>

</div>
@endsection
