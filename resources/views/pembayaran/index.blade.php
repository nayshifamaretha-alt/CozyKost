<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('pembayaran.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium mb-4 inline-block shadow-sm hover:opacity-90">
                    + Catat Pembayaran
                </a>

                <table class="w-full mt-4 border-collapse">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Penghuni</th>
                            <th class="py-2">Jumlah Bayar</th>
                            <th class="py-2">Tanggal Bayar</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembayaran as $item)
                            <tr class="border-b">
                                <td class="py-2">{{ $item->tagihan->penghuni->nama }}</td>
                                <td class="py-2">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="py-2">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') }}</td>
                                <td class="py-2">
                                    @php
                                        $badgeColor = match($item->status_verifikasi) {
                                            'diterima' => 'bg-emerald-100 text-emerald-700',
                                            'ditolak' => 'bg-pink-100 text-pink-600',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                                        {{ ucfirst($item->status_verifikasi) }}
                                    </span>
                                </td>
                                <td class="py-2">
                                    <a href="{{ route('pembayaran.edit', $item->id) }}" class="text-blue-600">Verifikasi</a>
                                    <form action="{{ route('pembayaran.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-gray-500">Belum ada pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>