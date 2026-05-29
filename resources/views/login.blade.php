@extends('Layout.Guest')

@section('title', 'Mahameru Digital - Masuk Akun')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-[#0D1B2A] rounded-2xl border border-white/5 shadow-2xl p-8 space-y-6">

        {{-- Judul --}}
        <div class="text-center">
            <div class="w-14 h-14 bg-emerald-400/10 border-2 border-emerald-400/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-mountain text-emerald-400 text-xl"></i>
            </div>
            <h2 class="text-white text-2xl font-black uppercase tracking-tighter italic">
                Masuk Pendaki
            </h2>
            <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest mt-1">
                Gunakan akun Mahameru Digital Anda
            </p>
        </div>

        {{-- Flash Error --}}
        @if(session('loginError'))
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-[10px] font-bold uppercase p-3 rounded-xl text-center">
                <i class="fas fa-triangle-exclamation mr-1"></i> {{ session('loginError') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-[10px] font-bold uppercase p-3 rounded-xl text-center">
                <i class="fas fa-circle-check mr-1"></i> {{ session('success') }}
            </div>
        @endif

        <hr class="border-white/5">

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-1.5">
                <label class="text-white/60 font-black uppercase text-[9px] tracking-wider block">Alamat Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/30 text-xs">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="contoh@email.com"
                           class="w-full bg-[#1B263B] border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-400 transition">
                </div>
                @error('email') <p class="text-red-400 text-[9px] font-bold uppercase">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5">
                <div class="flex justify-between items-center">
                    <label class="text-white/60 font-black uppercase text-[9px] tracking-wider">Kata Sandi</label>
                    <a href="#" class="text-emerald-400 font-bold uppercase text-[9px] hover:underline">Lupa Sandi?</a>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/30 text-xs">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="w-full bg-[#1B263B] border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-400 transition">
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" class="w-3.5 h-3.5 accent-emerald-400">
                <label for="remember" class="ml-2 text-white/40 font-bold text-[10px] uppercase select-none cursor-pointer">
                    Ingat Sesi Saya
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-400 text-[#0D1B2A] font-black uppercase text-xs py-3 rounded-xl tracking-wider hover:bg-white transition shadow-lg">
                <i class="fas fa-right-to-bracket mr-1"></i> Masuk Sekarang
            </button>

            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-white/5"></div>
                <span class="flex-shrink mx-4 text-white/20 text-[9px] font-black uppercase tracking-widest">atau</span>
                <div class="flex-grow border-t border-white/5"></div>
            </div>

            {{-- 🎨 PERBAIKAN ELEGAN: Tombol Google diubah menjadi tema gelap transparan agar mewah --}}
           <a href="{{ url('/auth/google') }}" class="flex items-center justify-center gap-3 w-full bg-white/5 border border-white/10 text-white hover:bg-white/10 hover:border-white/20 transition font-bold py-2.5 rounded-xl text-[10px] tracking-wider shadow">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-4 h-4 flex-shrink-0">
        <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
        <path fill="#FF3D00" d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
        <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
        <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
    </svg>
    Masuk Lewat Google
</a>
        </form>

        <hr class="border-white/5">

        <div class="text-center">
            <p class="text-white/40 text-[10px] font-bold uppercase">
                Belum terdaftar sebagai pendaki?
                <a href="{{ route('register') }}" class="text-emerald-400 font-black hover:underline ml-1">Daftar Di Sini</a>
            </p>
        </div>
    </div>
</div>
@endsection
