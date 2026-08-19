<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full max-w-5xl rounded-3xl overflow-hidden shadow-2xl spatial-workspace-window bg-white/40 backdrop-blur-2xl border border-white/60">
        
        {{-- Left Hero Glass Panel --}}
        <div class="w-full md:w-5/12 p-8 md:p-12 flex flex-col justify-between text-white relative bg-gradient-to-br from-slate-900/90 via-blue-950/85 to-indigo-950/90 backdrop-blur-xl border-r border-white/20">
            <div class="relative z-10">
                <div class="flex items-center gap-3.5 mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PPI Curug" class="w-14 h-14 rounded-2xl p-1 bg-white/10 backdrop-blur-md border border-white/30 shadow-lg object-contain">
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-white/10 text-[9px] font-extrabold tracking-widest uppercase text-amber-400 border border-white/10">
                            PPI CURUG
                        </div>
                        <h2 class="text-xs font-black tracking-wider uppercase text-white mt-1">Sistem Pengasuhan</h2>
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-bold uppercase tracking-widest mb-4 backdrop-blur-md">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Sistem Kokpit Aktif</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold leading-tight text-white mb-3 font-serif">
                    Selamat Datang di Panel Manajemen Pengasuhan Taruna.
                </h1>
                <p class="text-sky-100/75 text-xs leading-relaxed">
                    Akses terpadu log pergerakan pos jaga, presensi apel, raport poin, perizinan, dan fasilitas barak terintegrasi.
                </p>
            </div>

            <div class="relative z-10 pt-6 border-t border-white/15 text-[11px] text-sky-200/60 flex items-center justify-between">
                <span>&copy; {{ date('Y') }} PPI Curug</span>
                <span>Spatial UI 2.0</span>
            </div>

            {{-- Ambient glow --}}
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>

        {{-- Right Form Glass Panel --}}
        <div class="w-full md:w-7/12 p-8 md:p-14 flex flex-col justify-center bg-white/70 backdrop-blur-xl">
            <div class="mb-6">
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun Anda</h2>
                <p class="text-xs text-slate-500 mt-1">Silakan masukkan kredensial akun terdaftar Anda untuk melanjutkan.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-[10px] font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Email atau Username</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-white/80 focus:bg-white border border-slate-200 focus:border-indigo-500 text-xs font-semibold text-slate-900 outline-none transition shadow-sm"
                               placeholder="NPM / Email PPI Curug" />
                    </div>
                    @error('email') <span class="text-rose-600 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-[10px] font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input id="password" type="password" name="password" required
                               class="w-full pl-9 pr-3.5 py-2.5 rounded-xl bg-white/80 focus:bg-white border border-slate-200 focus:border-indigo-500 text-xs font-semibold text-slate-900 outline-none transition shadow-sm"
                               placeholder="••••••••" />
                    </div>
                    @error('password') <span class="text-rose-600 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between mb-6 text-xs">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500" {{ old('remember') ? 'checked' : '' }}>
                        <span class="text-slate-600 font-semibold">Ingat Saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline">Lupa Kata Sandi?</a>
                    @endif
                </div>

                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white font-extrabold text-xs tracking-widest uppercase shadow-xl transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket text-amber-400"></i>
                    <span>Masuk ke Kokpit</span>
                </button>

                <p class="text-center mt-6 text-xs text-slate-500 font-medium">
                    Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline">Daftar Sekarang</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>