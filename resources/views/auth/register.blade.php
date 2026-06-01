<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl">
        
        <div class="w-full md:w-5/12 glass-panel p-10 md:p-12 hidden md:flex flex-col justify-center text-white relative">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-slate-900 font-bold text-xl shadow-lg">
                        ✈️
                    </div>
                    <span class="font-bold tracking-widest uppercase text-sm leading-tight text-yellow-500">
                        Global Aviation<br><span class="text-white">Academy</span>
                    </span>
                </div>

                <h1 class="text-3xl font-bold leading-tight mb-4">
                    BERGABUNGLAH DENGAN SKUADRON KAMI.
                </h1>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Daftarkan diri Anda dan bersiaplah untuk memulai pendidikan penerbangan kelas dunia.
                </p>
            </div>
        </div>

        <div class="w-full md:w-7/12 form-panel p-8 md:p-12 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-slate-800 mb-6 md:hidden">Daftar Kadet Baru</h2>
            
            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <div class="mb-5">
                    <label for="name" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                    <div class="input-group">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="aviation-input" placeholder="Nama sesuai KTP/Paspor" />
                    </div>
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Email</label>
                    <div class="input-group">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0l-9.75 6.75L2.25 6.75" />
                        </svg>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="aviation-input" placeholder="contoh@aviation.ac.id" />
                    </div>
                    @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Kata Sandi</label>
                        <div class="input-group">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input id="password" type="password" name="password" required class="aviation-input" placeholder="Min. 8 Karakter" />
                        </div>
                        @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Ulangi Sandi</label>
                        <div class="input-group">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="aviation-input" placeholder="Ulangi Sandi" />
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full btn-primary flex items-center justify-center gap-2 py-3.5 rounded-lg font-bold tracking-widest shadow-lg">
                    DAFTARKAN SAYA
                </button>

                <p class="text-center mt-6 text-sm text-slate-600 font-medium">
                    SUDAH PUNYA AKUN? <a href="{{ route('login') }}" class="font-bold text-slate-800 hover:text-yellow-600 hover:underline">MASUK</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>