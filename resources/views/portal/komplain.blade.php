<x-app-layout>
<div class="p-10">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center text-white shadow-md">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">Komplain Saya</h3>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded-2xl bg-green-50 border border-green-200 text-green-700 px-5 py-3 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl p-6 bg-white shadow-md border border-gray-100 mb-8">
        <h5 class="text-lg font-bold text-gray-800 mb-4">Ajukan Komplain Baru</h5>
        <form action="{{ route('portal.komplain.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Deskripsi Masalah</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition placeholder-gray-400"
                    placeholder="Ceritakan masalah yang kamu alami..." required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1.5">Prioritas</label>
                <div class="relative">
                    <select name="prioritas"
                        class="w-full appearance-none rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition pr-10">
                        <option value="rendah">🟢 Rendah</option>
                        <option value="sedang" selected>🟡 Sedang</option>
                        <option value="tinggi">🔴 Tinggi</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </div>

            <button type="submit"
                class="bg-gradient-to-r from-slate-800 to-slate-900 text-white font-semibold px-6 py-2.5 rounded-2xl shadow-md hover:shadow-lg transition-all">
                Kirim Komplain
            </button>
        </form>
    </div>

    <h5 class="text-lg font-bold text-gray-800 mb-4">Riwayat Komplain</h5>
    <div class="space-y-3">
        @forelse($komplains as $komplain)
            @php
                $prioritasColor = match($komplain->prioritas) {
                    'tinggi' => 'bg-red-100 text-red-600',
                    'rendah' => 'bg-green-100 text-green-600',
                    default => 'bg-yellow-100 text-yellow-700',
                };
            @endphp
            <div class="rounded-2xl p-5 bg-white shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex justify-between items-start gap-4">
                    <p class="text-gray-800 leading-relaxed">{{ $komplain->deskripsi }}</p>
                    <span class="shrink-0 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                        {{ ucfirst($komplain->status) }}
                    </span>
                </div>
                <div class="flex items-center gap-2 mt-3">
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $prioritasColor }}">
                        {{ ucfirst($komplain->prioritas) }}
                    </span>
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($komplain->created_at)->format('d M Y') }}</span>
                </div>
            </div>
        @empty
            <div class="rounded-2xl p-8 bg-white shadow-sm border border-gray-100 text-center">
                <p class="text-gray-400">Belum ada komplain yang diajukan</p>
            </div>
        @endforelse
    </div>
</div>
</x-app-layout>