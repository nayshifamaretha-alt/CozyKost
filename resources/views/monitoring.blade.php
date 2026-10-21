<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Monitoring Kos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <form method="GET" class="mb-6">
                <select name="properti_id" onchange="this.form.submit()"
                    class="rounded-2xl border-gray-200 bg-white shadow-sm focus:border-slate-400 focus:ring-2 focus:ring-slate-100">
                    <option value="">Semua Properti</option>
                    @foreach ($properti as $p)
                        <option value="{{ $p->id }}" {{ request('properti_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_properti }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b bg-gray-50 text-sm text-gray-500">
                            <th class="py-3 px-5">Properti</th>
                            <th class="py-3 px-5">No. Kamar</th>
                            <th class="py-3 px-5">Nama Penghuni</th>
                            <th class="py-3 px-5">No. HP</th>
                            <th class="py-3 px-5">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kamar as $item)
                            @php
                                $penghuniAktif = $item->penghuni->firstWhere('status', 'aktif');
                            @endphp
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-5 text-gray-700">{{ $item->properti->nama_properti }}</td>
                                <td class="py-3 px-5 font-medium text-gray-800">{{ $item->nomor_kamar }}</td>
                                <td class="py-3 px-5 text-gray-700">{{ $penghuniAktif->nama ?? '-' }}</td>
                                <td class="py-3 px-5 text-gray-500">{{ $penghuniAktif->no_hp ?? '-' }}</td>
                                <td class="py-3 px-5">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'terisi' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada data kamar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>