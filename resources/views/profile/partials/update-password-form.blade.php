<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">
            Ubah Password
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
        </p>
    </header>

    {{-- Notifikasi sukses --}}
    @if (session('status') === 'password-updated')
        <div class="mb-4 p-4 bg-green-50 border border-green-300 text-green-700 rounded-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium">Password berhasil diubah!</span>
        </div>
    @endif

    <form method="post" action="{{ route('profile.password.update') }}" class="space-y-6" autocomplete="off">
        @csrf
        @method('put')

        {{-- Field tersembunyi untuk mencegah autofill browser --}}
        <input type="text" name="username_fake" style="display:none" tabindex="-1" autocomplete="username">
        <input type="password" name="password_fake" style="display:none" tabindex="-1" autocomplete="current-password">

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
            <div class="relative mt-1">
                <input id="current_password" name="current_password" type="password"
                       autocomplete="current-password"
                       class="block w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" tabindex="-1" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-blue-600 transition" 
                        onclick="const input = document.getElementById('current_password'); const icon = this.querySelector('i'); if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
            <div class="relative mt-1">
                <input id="password" name="password" type="password"
                       autocomplete="new-password"
                       class="block w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" tabindex="-1" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-blue-600 transition" 
                        onclick="const input = document.getElementById('password'); const icon = this.querySelector('i'); if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password', 'updatePassword')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <div class="relative mt-1">
                <input id="password_confirmation" name="password_confirmation" type="password"
                       autocomplete="new-password"
                       class="block w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="button" tabindex="-1" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-blue-600 transition" 
                        onclick="const input = document.getElementById('password_confirmation'); const icon = this.querySelector('i'); if (input.type === 'password') { input.type = 'text'; icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); } else { input.type = 'password'; icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            @error('password_confirmation', 'updatePassword')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Simpan
            </button>
        </div>
    </form>
</section>
