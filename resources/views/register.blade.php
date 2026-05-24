@extends('Layout.Guest')

@section('title', 'Mahameru Digital - Pendaftaran Akun')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="max-w-md mx-auto my-8">
    <div class="bg-[#0D1B2A] rounded-2xl border border-white/5 shadow-2xl p-8 space-y-5">

        {{-- Judul --}}
        <div class="text-center">
            <div class="w-14 h-14 bg-emerald-400/10 border-2 border-emerald-400/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-emerald-400 text-xl"></i>
            </div>
            <h2 class="text-white text-2xl font-black uppercase tracking-tighter italic">
                Registrasi Akun
            </h2>
            <p class="text-white/40 text-[10px] font-bold uppercase tracking-widest mt-1">
                Lengkapi identitas untuk kebutuhan e-ticket
            </p>
        </div>

        {{-- Flash Error --}}
        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 text-[10px] font-bold uppercase p-3 rounded-xl space-y-1">
                @foreach($errors->all() as $error)
                    <p><i class="fas fa-circle-xmark mr-1"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <hr class="border-white/5">

        <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="space-y-1">
                <label class="text-white/60 font-black uppercase text-[9px] tracking-wider block">
                    Nama Lengkap (Sesuai KTP)
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/30 text-xs">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Nama Lengkap Anda"
                           class="w-full bg-[#1B263B] border {{ $errors->has('name') ? 'border-red-400/50' : 'border-white/10' }} rounded-xl py-2.5 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-400 transition">
                </div>
            </div>

            {{-- Email --}}
            <div class="space-y-1">
                <label class="text-white/60 font-black uppercase text-[9px] tracking-wider block">
                    Alamat Email Aktif
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/30 text-xs">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           placeholder="namapendaki@email.com"
                           class="w-full bg-[#1B263B] border {{ $errors->has('email') ? 'border-red-400/50' : 'border-white/10' }} rounded-xl py-2.5 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-400 transition">
                </div>
            </div>

            {{-- Password --}}
            <div class="space-y-1">
                <label class="text-white/60 font-black uppercase text-[9px] tracking-wider block">
                    Kata Sandi Baru
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/30 text-xs">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" required
                           placeholder="Minimal 8 Karakter"
                           class="w-full bg-[#1B263B] border {{ $errors->has('password') ? 'border-red-400/50' : 'border-white/10' }} rounded-xl py-2.5 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-400 transition">
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="space-y-1">
                <label class="text-white/60 font-black uppercase text-[9px] tracking-wider block">
                    Ulangi Kata Sandi
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/30 text-xs">
                        <i class="fas fa-check-double"></i>
                    </span>
                    <input type="password" name="password_confirmation" required
                           placeholder="Konfirmasi Kata Sandi"
                           class="w-full bg-[#1B263B] border border-white/10 rounded-xl py-2.5 pl-10 pr-4 text-xs text-white outline-none focus:border-emerald-400 transition">
                </div>
            </div>

            {{-- Checkbox Syarat --}}
            <div class="flex items-start pt-1">
                <input type="checkbox" id="terms" required class="w-3.5 h-3.5 mt-0.5 accent-emerald-400">
                <label for="terms" class="ml-2 text-white/40 font-bold text-[9px] uppercase leading-tight select-none cursor-pointer">
                    Saya menyatakan data di atas asli dan siap mematuhi aturan TNBITS.
                </label>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-400 text-[#0D1B2A] font-black uppercase text-xs py-3 rounded-xl tracking-wider hover:bg-white transition shadow-lg mt-3">
                <i class="fas fa-user-plus mr-1"></i> Daftar Akun Baru
            </button>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-white/5"></div>
                <span class="flex-shrink mx-4 text-white/20 text-[9px] font-black uppercase tracking-widest">atau</span>
                <div class="flex-grow border-t border-white/5"></div>
            </div>

            {{-- Daftar Google dengan SVG inline --}}
            <a href="{{ route('auth.google') }}"
               class="flex items-center justify-center gap-3 w-full bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-bold py-2.5 rounded-xl text-[10px] tracking-wider shadow">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-4 h-4 flex-shrink-0">
                    <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                    <path fill="#FF3D00" d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                    <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                    <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                </svg>
                Daftar Lewat Google
            </a>
        </form>

        <hr class="border-white/5">

        <div class="text-center">
            <p class="text-white/40 text-[10px] font-bold uppercase">
                Sudah punya akun pendaki?
                <a href="{{ route('login') }}" class="text-emerald-400 font-black hover:underline ml-1">Masuk Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection
