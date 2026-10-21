<section>
    <header class="flex items-center gap-3 mb-6">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Ganti Password</h2>
            <p class="text-sm text-gray-500">Gunakan password yang panjang dan sulit ditebak biar akunmu aman.</p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-600 mb-1.5">Password Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-600 mb-1.5">Password Baru</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-600 mb-1.5">Ulangi Password Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-slate-400 focus:ring-2 focus:ring-slate-100 transition">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-gradient-to-r from-slate-800 to-slate-900 text-white font-semibold px-6 py-2.5 rounded-2xl shadow-md hover:shadow-lg transition-all">
                Simpan
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-medium text-green-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>