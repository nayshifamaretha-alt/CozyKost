<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <p class="text-gray-500 text-sm font-medium">Total Kamar</p>
            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold mt-3 text-gray-800">{{ $totalKamar }}</p>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <p class="text-gray-500 text-sm font-medium">Kamar Terisi</p>
            <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold mt-3 text-gray-800">{{ $kamarTerisi }}</p>
    </div>
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-md p-6 text-white hover:shadow-lg transition">
        <div class="flex items-center justify-between">
            <p class="text-sm opacity-90 font-medium">Pendapatan Bulan Ini</p>
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" /></svg>
            </div>
        </div>
        <p class="text-3xl font-bold mt-3">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
    </div>
</div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <p class="font-semibold mb-4">Daftar Kamar</p>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b text-sm text-gray-500">
                            <th class="py-2">Properti</th>
                            <th class="py-2">Kamar</th>
                            <th class="py-2">Harga</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarKamar as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->properti->nama_properti }}</td>
                                <td class="py-2">{{ $item->nomor_kamar }}</td>
                                <td class="py-2">Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</td>
                                <td class="py-2">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $item->status == 'terisi' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 text-gray-500">Belum ada data kamar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex flex-col items-center justify-center">
                <p class="font-semibold mb-4 self-start">Okupansi Kamar</p>
                <div class="relative w-40 h-40">
                    <canvas id="okupansiChart"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-slate-700">
                            {{ $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
                <div class="flex gap-4 mt-4 text-sm">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-slate-700 inline-block"></span> Terisi</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-gray-200 inline-block"></span> Kosong</span>
                </div>
            </div>
            </div>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('properti.index') }}" class="bg-white rounded-xl shadow-sm px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Kelola Properti</a>
                <a href="{{ route('kamar.index') }}" class="bg-white rounded-xl shadow-sm px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Kelola Kamar</a>
                <a href="{{ route('penghuni.index') }}" class="bg-white rounded-xl shadow-sm px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Kelola Penghuni</a>
                <a href="{{ route('tagihan.index') }}" class="bg-white rounded-xl shadow-sm px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Kelola Tagihan</a>
                <a href="{{ route('pembayaran.index') }}" class="bg-white rounded-xl shadow-sm px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Verifikasi Pembayaran</a>
                <a href="{{ route('komplain.index') }}" class="bg-white rounded-xl shadow-sm px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100">Kelola Komplain</a>
            </div>

        </div>
    </div>
        @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('okupansiChart');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Terisi', 'Kosong'],
                datasets: [{
                    data: [{{ $kamarTerisi }}, {{ $totalKamar - $kamarTerisi }}],
                    backgroundColor: ['#334155', '#e5e7eb'],
                    borderWidth: 0,
                }]
            },
            options: {
                cutout: '75%',
                plugins: { legend: { display: false } }
            }
        });
    </script>
    @endpush
</x-app-layout>