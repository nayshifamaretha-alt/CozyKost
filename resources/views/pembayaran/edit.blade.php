<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6">

                <p class="mb-2"><strong>Penghuni:</strong> {{ $pembayaran->tagihan->penghuni->nama }}</p>
                <p class="mb-2"><strong>Jumlah Bayar:</strong> Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                <p class="mb-4"><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</p>

                <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Status Verifikasi</label>
                        <select name="status_verifikasi" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="menunggu" {{ $pembayaran->status_verifikasi == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diterima" {{ $pembayaran->status_verifikasi == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $pembayaran->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white px-5 py-2.5 rounded-full font-medium shadow-sm hover:opacity-90">Update Status</button>
                    <a href="{{ route('pembayaran.index') }}" class="ml-2 text-gray-600">Batal</a>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>