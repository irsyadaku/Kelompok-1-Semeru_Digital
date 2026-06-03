@extends('Layout.App')

@section('title', 'Mahameru Digital - Profil Agung Admin')

@section('content')
<div class="max-w-4xl mx-auto my-8 px-4 space-y-8 fade-up delay-1">

    {{-- Tombol Kembali Ke Singgasana --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-xs text-slate-400 hover:text-emerald-400 transition uppercase tracking-widest font-black flex items-center gap-2">
            &larr; Kembali Ke Dashboard
        </a>
        <span class="bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
            Otoritas Level Tinggi
        </span>
    </div>

    {{-- Kartu Utama Profil --}}
    <div class="bg-[#0D1B2A] border border-white/5 rounded-3xl p-8 relative overflow-hidden">
        {{-- Efek Dekoratif Latar Belakang --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-400/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-red-500/[0.02] rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
            {{-- Avatar Simbolis Admin --}}
            <div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-emerald-500/20 to-teal-600/10 border-2 border-emerald-400/30 flex items-center justify-center shadow-xl shadow-black/40 group">
                <i class="fas fa-user-shield text-5xl text-emerald-400 drop-shadow-[0_4px_12px_rgba(52,211,153,0.3)]"></i>
            </div>

            {{-- Informasi Pokok --}}
            <div class="text-center md:text-left space-y-2 flex-1">
                <div class="flex flex-col md:flex-row md:items-center gap-2 justify-center md:justify-start">
                    <h2 class="text-white text-2xl font-black uppercase tracking-tight italic">
                        {{ $admin->name }}
                    </h2>
                    <span class="w-fit mx-auto md:mx-0 bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase tracking-widest">
                        {{ $admin->role ?? 'ADMINISTRATOR' }}
                    </span>
                </div>
                <p class="text-white/50 text-sm font-medium"><i class="fas fa-envelope mr-2 text-slate-500"></i>{{ $admin->email }}</p>
                <p class="text-white/30 text-xs">
                    <i class="fas fa-calendar-alt mr-2 text-slate-600"></i>Auntenfikasi Sistem Sejak:
                    <span class="text-slate-400 font-bold">{{ \Carbon\Carbon::parse($admin->created_at)->translatedFormat('d F Y') }}</span>
                </p>
            </div>
        </div>

        <hr class="border-white/5 my-8">

        {{-- Detail Hak Akses Sistem --}}
        <div class="space-y-4">
            <h3 class="text-white text-xs font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                <i class="fas fa-fingerprint text-emerald-400"></i> Hak Akses Konsol Eksekutif
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-[#122236] p-4 rounded-xl border border-white/5 flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-400 text-sm"></i>
                    <span class="text-white/70 text-xs font-bold">Validasi & Verifikasi SIMAKSI</span>
                </div>
                <div class="bg-[#122236] p-4 rounded-xl border border-white/5 flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-400 text-sm"></i>
                    <span class="text-white/70 text-xs font-bold">Manajemen Kuota Kuasa Pendaki</span>
                </div>
                <div class="bg-[#122236] p-4 rounded-xl border border-white/5 flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-400 text-sm"></i>
                    <span class="text-white/70 text-xs font-bold">Pemantauan Finansial Real-Time</span>
                </div>
                <div class="bg-[#122236] p-4 rounded-xl border border-white/5 flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-400 text-sm"></i>
                    <span class="text-white/70 text-xs font-bold">Otoritas Eksekusi Data Permanen</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Catatan Keamanan --}}
    <div class="bg-amber-500/5 border border-amber-500/10 p-6 rounded-2xl flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-400 text-lg flex-shrink-0">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="space-y-1">
            <h4 class="text-amber-400 text-xs font-black uppercase tracking-wider">Deklarasi Proteksi Keamanan</h4>
            <p class="text-white/40 text-xs leading-relaxed">
                Akun ini memegang kendali penuh atas database Pusat Layanan Digital Pendakian Gunung Semeru. Pastikan untuk selalu melakukan pemutusan sesi (Log Out) apabila singgasana kontrol ditinggalkan demi menjaga integritas data suci.
            </p>
        </div>
    </div>

</div>
@endsection
