<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl">
        
        <div class="w-full md:w-5/12 glass-panel p-10 md:p-12 flex flex-col justify-center text-white relative">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-10">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 rounded-full shadow-lg object-cover">
                    <span class="font-bold tracking-widest uppercase text-sm leading-tight text-yellow-500">
                        POLITEKNIK PENERBANGAN INDONESIA<br><span class="text-white">CURUG</span>
                    </span>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-4">
                    SELAMAT DATANG DI PANEL KONTROL KARIR IMPIAN ANDA.
                </h1>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Mulailah perjalanan Anda sebagai pilot profesional sekarang.
                </p>
            </div>
        </div>

        <div class="w-full md:w-7/12 form-panel p-10 md:p-14 flex flex-col justify-center">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Email atau Username</label>
                    <div class="input-group">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="aviation-input" placeholder="contoh@aviation.ac.id" />
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Kata Sandi</label>
                    <div class="input-group">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <input id="password" type="password" name="password" required class="aviation-input" placeholder="••••••••" />
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-slate-800 focus:ring-slate-800" {{ old('remember') ? 'checked' : '' }}>
                        <span class="text-sm text-slate-600 font-medium">Ingat Saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm font-bold text-slate-800 hover:text-yellow-600 hover:underline">LUPA KATA SANDI?</a>
                    @endif
                </div>

                <button type="submit" class="w-full btn-primary flex items-center justify-center gap-2 py-3.5 rounded-lg font-bold tracking-widest shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-yellow-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                    MASUK KE KOKPIT
                </button>

                <p class="text-center mt-8 text-sm text-slate-600 font-medium">
                    BELUM PUNYA AKUN? <a href="{{ route('register') }}" class="font-bold text-slate-800 hover:text-yellow-600 hover:underline">DAFTAR</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>