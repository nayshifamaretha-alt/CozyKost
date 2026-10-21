<section class="space-y-6">
    <header class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-2xl bg-red-50 flex items-center justify-center text-red-600 shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Hapus Akun</h2>
            <p class="text-sm text-gray-500">Setelah dihapus, semua data akun ini hilang permanen dan tidak bisa dikembalikan.</p>
        </div>
    </header>

    <button type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-50 text-red-600 font-semibold px-6 py-2.5 rounded-2xl hover:bg-red-100 transition">
        Hapus Akun
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-800">Yakin mau menghapus akun ini?</h2>

            <p class="mt-2 text-sm text-gray-500">
                Semua data akun akan dihapus permanen. Masukkan password untuk mengonfirmasi.
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password" placeholder="Password"
                    class="w-3/4 rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-5 py-2.5 rounded-2xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-2xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>