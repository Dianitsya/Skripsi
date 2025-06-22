@extends('layouts.app')

@section('content')
<div class="container p-4 mx-auto">
    <!-- Statistik Pengguna -->
    <div class="mb-6">
        <h3 class="mb-3 text-lg font-bold text-gray-800 dark:text-white">Statistik Pengguna</h3>
        <div class="overflow-x-auto rounded-md shadow-sm">
            <table class="w-full text-xs text-center border border-gray-300 dark:border-gray-600 dark:text-gray-300">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-2 border">Total Pengguna</th>
                        <th class="px-4 py-2 border">Total Admin</th>
                        <th class="px-4 py-2 border">Total Pengguna Reguler</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-4 py-2 font-semibold text-gray-900 border dark:text-white">{{ $totalUsers ?? 0 }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-900 border dark:text-white">{{ $totalAdmins ?? 0 }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-900 border dark:text-white">{{ $totalReguler ?? 0 }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart: Distribusi Gaya Belajar berdasarkan Minat -->
    @if (!empty($learningStyleDistribution))
    <div class="w-full max-w-3xl p-4 mx-auto bg-white rounded-md shadow-sm dark:bg-gray-900">
        <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Distribusi Gaya Belajar berdasarkan Minat</h3>

        <div class="relative w-full h-64">
            <canvas id="learningStyleDistributionChart" class="w-full h-full"></canvas>
        </div>

        @php
            $explanationTexts = [];

            foreach ($learningStyleDistribution as $minat => $styles) {
                $stylesArray = is_array($styles) ? $styles : $styles->toArray();
                arsort($stylesArray);
                $dominantStyle = array_key_first($stylesArray);
                $explanationTexts[] = "Maka rata-rata dari <strong>{$minat}</strong> gaya belajar mereka adalah <strong>{$dominantStyle}</strong>.";
            }
        @endphp

        <div class="px-2 mt-4 text-sm text-gray-700 dark:text-gray-300">
            @foreach ($explanationTexts as $text)
                <p class="mb-1">{!! $text !!}</p>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const learningStyleDistribution = @json($learningStyleDistribution);

    const minatLabels = Object.keys(learningStyleDistribution);
    const dominantStyles = [...new Set(Object.values(learningStyleDistribution).flatMap(styleObj => Object.keys(styleObj)))];

    const datasets = dominantStyles.map(style => ({
        label: style,
        data: minatLabels.map(minat => learningStyleDistribution[minat][style] || 0),
        backgroundColor: getRandomColor(),
    }));

    const config = {
        type: 'bar',
        data: {
            labels: minatLabels,
            datasets: datasets,
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Gaya Belajar berdasarkan Minat',
                    font: { size: 14 }
                },
                legend: {
                    position: 'bottom'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                },
            },
        },
    };

    const ctx = document.getElementById('learningStyleDistributionChart').getContext('2d');
    new Chart(ctx, config);

    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color + 'CC';
    }
</script>
@endsection
