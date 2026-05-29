@extends('Layout.App')

@section('title', 'Mahameru Digital - Panel Pendaki')

@section('content')
<div class="max-w-6xl mx-auto my-8 px-4 space-y-8 fade-up delay-1">

    {{-- Ucapan Selamat Datang Agung --}}
    <div class="bg-gradient-to-r from-[#0D1B2A] to-[#1B263B] border border-white/5 p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-400/5 rounded-full blur-3xl pointer-events-none"></div>
        <div>
            <span class="bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                Sesi Pendaki Aktif
            </span>
            <h2 class="text-white text-2xl font-black italic uppercase tracking-tight mt-1.5">
                Selamat Datang Kembali, <span class="text-emerald-400">{{ Auth::user()->name }}</span>
            </h2>
            <p class="text-white/40 text-xs mt-0.5">Persiapkan fisik dan administrasi Anda sebelum menaklukkan Atap Pulau Jawa.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 font-black px-4 py-2 rounded-xl text-[10px] uppercase tracking-wider transition">
                <i class="fas fa-sign-out-alt mr-1.5"></i> Keluar Sesi
            </button>
        </form>
    </div>

    {{-- Baris Info Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-400/10 flex items-center justify-center text-emerald-400 text-xl"><i class="fas fa-id-card"></i></div>
            <div>
                <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Status Identitas</p>
                <h4 class="text-white text-sm font-bold mt-0.5">Terverifikasi</h4>
            </div>
        </div>

        {{-- DINAMIS: Menampilkan hitungan tiket aktif dari Controller --}}
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-400/10 flex items-center justify-center text-amber-400 text-xl"><i class="fas fa-ticket-alt"></i></div>
            <div>
                <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Tiket Aktif</p>
                <h4 class="text-white text-sm font-bold mt-0.5">{{ $tiketAktifCount ?? 0 }} Pendakian</h4>
            </div>
        </div>

        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-sky-400/10 flex items-center justify-center text-sky-400 text-xl"><i class="fas fa-cloud-sun"></i></div>
            <div>
                <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Cuaca Ranupani</p>
                <h4 class="text-white text-sm font-bold mt-0.5">Cerah (14°C)</h4>
            </div>
        </div>
    </div>

    {{-- Fitur Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-[#0D1B2A] border border-emerald-400/20 p-8 rounded-3xl space-y-4 flex flex-col justify-between">
            <div class="space-y-2">
                <h3 class="text-white text-xl font-black uppercase tracking-tight italic">Registrasi SIMAKSI Online</h3>
                <p class="text-white/50 text-xs leading-relaxed">Urus perizinan, kuota rombongan, dan pembayaran e-ticket Gunung Semeru secara aman di bawah perlindungan sistem digital.</p>
            </div>
            <a href="{{ route('booking.index') }}" class="w-full text-center bg-emerald-400 text-[#0D1B2A] font-black uppercase text-xs py-3.5 rounded-xl tracking-wider hover:bg-white transition block mt-4">
                <i class="fas fa-mountain mr-1.5"></i> Booking Tiket Sekarang
            </a>
        </div>

        {{-- ✅ TAMPILAN RIWAYAT SESUAI GAMBAR REFERENSI --}}
        <div class="bg-[#0B1521] border border-white/5 p-8 rounded-3xl flex flex-col">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-white text-sm font-black uppercase tracking-widest">Riwayat Pendakian</h3>
                <span class="text-slate-500 text-[10px] font-bold uppercase tracking-wider">Total: {{ $riwayatBooking->count() }}</span>
            </div>

            <div class="space-y-4 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                @forelse($riwayatBooking as $booking)
                    <a href="{{ route('riwayat.transaksi') }}" class="flex justify-between items-center bg-[#121E2D] p-5 rounded-2xl border border-white/5 hover:border-slate-600/50 transition duration-300 group block">
                        <div>
                            <h4 class="text-white text-base font-extrabold uppercase tracking-tight mb-1 group-hover:text-emerald-400 transition-colors">#SMR-{{ $booking->id }}</h4>
                            <p class="text-slate-400 text-xs">Keberangkatan: <span class="text-slate-300">{{ $booking->tanggal_berangkat ?? '-' }}</span></p>
                        </div>
                        <div>
                            @if($booking->status === 'sudah_bayar')
                                <span class="text-emerald-400 border border-emerald-400/30 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest">Lunas</span>
                            @elseif($booking->status === 'menunggu_pembayaran')
                                <span class="text-amber-400 border border-amber-400/40 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest">Pending</span>
                            @elseif($booking->status === 'menunggu_verifikasi')
                                <span class="text-slate-300 border border-slate-600 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest">Menunggu_Verifikasi</span>
                            @else
                                <span class="text-slate-400 border border-white/10 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-widest">{{ $booking->status }}</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="py-12 text-center text-white/20 text-xs space-y-2">
                        <i class="fas fa-folder-open text-3xl block text-white/10"></i>
                        <span class="font-bold uppercase tracking-wide block">Belum Ada Catatan Perjalanan</span>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('riwayat.transaksi') }}" class="mt-auto pt-6 text-center text-xs text-slate-400 hover:text-white transition uppercase tracking-widest font-bold">
                Lihat Semua Riwayat Transaksi &rarr;
            </a>
        </div>
    </div>

</div>

<style>
    /* Styling agar scrollbar di area riwayat terlihat lebih rapi di mode gelap */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #334155; }
</style>
@endsection
