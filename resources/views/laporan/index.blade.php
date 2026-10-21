<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Pendapatan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <p class="font-semibold">Pendapatan 6 Bulan Terakhir</p>
                    <div class="flex gap-2">
                        <button onclick="window.print()" class="bg-gradient-to-r from-slate-800 to-slate-900 text-white px-4 py-2 rounded-full text-sm font-medium">Export PDF</button>
                    </div>
                </div>

                <div class="relative h-72">
                    <canvas id="pendapatanChart"></canvas>
                </div>

                <table class="w-full mt-6 border-collapse">
                    <thead>
                        <tr class="text-left border-b text-sm text-gray-500">
                            <th class="py-2">Bulan</th>
                            <th class="py-2">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item['label'] }}</td>
                                <td class="py-2">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('pendapatanChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [@foreach ($data as $item)'{{ $item['label'] }}',@endforeach],
                datasets: [{
                    label: 'Pendapatan',
                    data: [@foreach ($data as $item){{ $item['total'] }},@endforeach],
                    borderColor: '#334155',
                    backgroundColor: 'rgba(51, 65, 85, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#334155',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
    @endpush
</x-app-layout>