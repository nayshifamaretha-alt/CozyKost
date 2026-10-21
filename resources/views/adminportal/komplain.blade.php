<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tindak Lanjut Komplain</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-xl mb-4">{{ session('success') }}</div>
            @endif
            <p class="text-gray-500 text-sm mb-6">Total {{ $komplain->count() }} komplain</p>
            <div class="space-y-3">
                @forelse ($komplain as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-semibold shrink-0">
                                    {{ strtoupper(substr($item->penghuni->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item->penghuni->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->kategori }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item->status == 'selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        @if ($item->status != 'selesai')
                            <form action="{{ route('adminportal.komplain.selesai', $item->id) }}" method="POST" class="mt-4 pt-4 border-t border-gray-100">
                                @csrf
                                <button type="submit" class="text-sm text-slate-700 font-medium bg-slate-100 px-4 py-2 rounded-lg hover:bg-slate-200">Tandai Selesai</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center text-gray-500">Belum ada komplain.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>