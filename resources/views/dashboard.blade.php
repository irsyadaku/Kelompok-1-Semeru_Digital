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

        {{-- ✅ DINAMIS: Menampilkan hitungan tiket aktif dari Controller --}}
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-400/10 flex items-center justify-center text-amber-400 text-xl"><i class="fas fa-ticket-alt"></i></div>
            <div>
                <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Tiket Aktif</p>
                <h4 class="text-white text-sm font-bold mt-0.5">{{ $tiketAktifCount }} Pendakian</h4>
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

        {{-- ✅ DINAMIS: Menggunakan Loop untuk Riwayat Pemesanan --}}
        <div class="bg-[#0D1B2A] border border-white/5 p-8 rounded-3xl space-y-4">
            <div class="flex justify-between items-center">
                <h3 class="text-white text-xs font-black uppercase tracking-wider">Riwayat Pendakian</h3>
                <span class="text-white/30 text-[10px] font-bold uppercase tracking-wider">Total: {{ $riwayatBooking->count() }}</span>
            </div>
            <hr class="border-white/5">

            <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                @forelse($riwayatBooking as $booking)
                    <div class="flex justify-between items-center bg-white/[0.02] p-4 rounded-xl border border-white/5 hover:border-emerald-400/20 transition duration-200">
                        <div>
                            <h4 class="text-white text-xs font-bold uppercase tracking-tight">#SMR-{{ $booking->id }}</h4>
                            <p class="text-white/40 text-[10px] mt-0.5">Keberangkatan: {{ $booking->tanggal_berangkat }}</p>
                        </div>
                        <div>
                            @if($booking->status === 'sudah_bayar')
                                <span class="bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider">Lunas</span>
                            @elseif($booking->status === 'menunggu_pembayaran')
                                <span class="bg-amber-400/10 text-amber-400 border border-amber-400/20 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider">Pending</span>
                            @else
                                <span class="bg-white/5 text-white/40 border border-white/10 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider">{{ $booking->status }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    {{-- Tampilan Default jika belum pernah booking --}}
                    <div class="py-12 text-center text-white/20 text-xs space-y-2">
                        <i class="fas fa-folder-open text-3xl block text-white/10"></i>
                        <span class="font-bold uppercase tracking-wide block">Belum Ada Catatan Perjalanan</span>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
