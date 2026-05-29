@extends('Layout.App')

@section('title', 'Mahameru Digital - Profil Pendaki')

@section('content')
<div class="p-6 min-h-screen bg-slate-950 text-slate-100 flex flex-col items-center justify-center">
    <div class="max-w-3xl w-full bg-slate-900/40 backdrop-blur-md border border-white/5 rounded-3xl p-8 shadow-2xl relative overflow-hidden">

        <div class="absolute -top-10 -right-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col sm:flex-row items-center gap-5 border-b border-white/5 pb-6 mb-8">
            <div class="w-20 h-20 bg-emerald-500/10 border-2 border-emerald-500/20 rounded-2xl flex items-center justify-center text-emerald-400 text-3xl shadow-lg shadow-emerald-500/5 shrink-0">
                <i class="fas fa-user-astronaut"></i>
            </div>
            <div class="text-center sm:text-left">
                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    ID PENDRAKI AKTIF
                </span>
                <h2 class="text-white text-2xl font-black uppercase tracking-tight mt-1">{{ $user->name }}</h2>
                <p class="text-white/40 text-xs mt-0.5">Terdaftar sejak: {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs p-4 rounded-xl mb-6 font-bold flex items-center gap-2">
                <i class="fas fa-check-circle text-sm"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <h3 class="text-white font-bold text-xs uppercase tracking-wider mb-4 flex items-center gap-2 text-emerald-400">
                    <i class="fas fa-id-card"></i> Kredensial & Identitas Pendaki
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-white/40 text-[10px] font-black uppercase tracking-wider block">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/30 text-xs"><i class="fas fa-user"></i></span>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-white/[0.02] border border-white/5 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500/40 transition duration-200">
                        </div>
                        @error('name') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-white/40 text-[10px] font-black uppercase tracking-wider block">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/30 text-xs"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-white/[0.02] border border-white/5 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500/40 transition duration-200">
                        </div>
                        @error('email') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-white/40 text-[10px] font-black uppercase tracking-wider block">Nomor HP / WhatsApp</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/30 text-xs"><i class="fas fa-phone"></i></span>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp ?? '') }}" placeholder="Contoh: 08123456789"
                                   class="w-full bg-white/[0.02] border border-white/5 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500/40 transition duration-200">
                        </div>
                        @error('no_hp') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-white/40 text-[10px] font-black uppercase tracking-wider block">NIK KTP (16 Digit)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/30 text-xs"><i class="fas fa-fingerprint"></i></span>
                            <input type="text" name="nik" value="{{ old('nik', $user->nik ?? '') }}" placeholder="Maksimal 16 Angka" max-length="16"
                                   class="w-full bg-white/[0.02] border border-white/5 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500/40 transition duration-200">
                        </div>
                        @error('nik') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <hr class="border-white/5">

            <div>
                <h3 class="text-white font-bold text-xs uppercase tracking-wider mb-4 flex items-center gap-2 text-amber-400">
                    <i class="fas fa-shield-alt"></i> Pembaruan Kata Sandi Akun
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-white/40 text-[10px] font-black uppercase tracking-wider block">Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/30 text-xs"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" placeholder="••••••••"
                                   class="w-full bg-white/[0.02] border border-white/5 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500/40 transition duration-200">
                        </div>
                        @error('password') <span class="text-red-400 text-[11px] block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-white/40 text-[10px] font-black uppercase tracking-wider block">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-white/30 text-xs"><i class="fas fa-lock text-emerald-500/40"></i></span>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                   class="w-full bg-white/[0.02] border border-white/5 rounded-xl pl-10 pr-4 py-3 text-sm text-white focus:outline-none focus:border-emerald-500/40 transition duration-200">
                        </div>
                    </div>
                </div>
                <p class="text-white/20 text-[10px] mt-2"><i class="fas fa-info-circle mr-1"></i> Biarkan kolom password kosong jika Yang Mulia tidak berniat mengganti kata sandi lama.</p>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-500 text-slate-950 font-black uppercase text-xs py-4 rounded-xl tracking-wider hover:bg-white transition duration-300 shadow-xl shadow-emerald-500/5 flex items-center justify-center gap-2">
                    <i class="fas fa-check-double"></i> Simpan Seluruh Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
