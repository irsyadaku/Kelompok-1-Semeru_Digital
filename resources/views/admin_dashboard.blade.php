@extends('Layout.App')

@section('title', 'Mahameru Digital - Konsol Eksekutif Admin')

@section('content')
<div class="max-w-6xl mx-auto my-8 px-4 space-y-8 fade-up delay-1">

    {{-- Header Utama Konsol Admin --}}
    <div class="bg-[#0D1B2A] border border-red-500/10 p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                Otoritas Pengelola Sistem
            </span>
            <h2 class="text-white text-2xl font-black italic uppercase tracking-tight mt-1.5">
                Singgasana Kontrol <span class="text-emerald-400">Admin</span>
            </h2>
            <p class="text-white/40 text-xs mt-0.5">Panel kendali penuh Pusat Layanan Digital Informasi Jalur Semeru.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-white/5 border border-white/10 hover:bg-red-500/20 hover:text-red-400 text-white/60 font-black px-4 py-2 rounded-xl text-[10px] uppercase tracking-wider transition">
                <i class="fas fa-power-off mr-1.5"></i> Keluar Sistem
            </button>
        </form>
    </div>

    {{-- Metrik Statistik Real-Time --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl space-y-1">
            <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Total User Terdaftar</p>
            <h3 class="text-white text-3xl font-black text-emerald-400">{{ $totalUser }}</h3>
        </div>
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl space-y-1">
            <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Menunggu Pembayaran</p>
            <h3 class="text-white text-3xl font-black text-amber-400">{{ $menunggu }}</h3>
        </div>
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl space-y-1">
            <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Total Booking SIMAKSI</p>
            <h3 class="text-white text-3xl font-black text-sky-400">{{ $totalBooking }}</h3>
        </div>
        <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-2xl space-y-1">
            <p class="text-white/40 text-[9px] font-black uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-white text-xl font-black text-white">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- Tabel Monitoring Dokumen Pembayaran Masuk --}}
    <div class="bg-[#0D1B2A] border border-white/5 rounded-3xl p-8 space-y-4">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-white text-sm font-black uppercase tracking-wider">Validasi Pembayaran Tiket Terbaru</h3>
                <p class="text-white/40 text-xs">Menunggu persetujuan manual untuk penerbitan barcode SIMAKSI</p>
            </div>
        </div>
        <hr class="border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-white/70">
                <thead>
                    <tr class="border-b border-white/5 text-white/40 uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4 font-black">Kode Tiket</th>
                        <th class="py-3 px-4 font-black">Ketua Kelompok</th>
                        <th class="py-3 px-4 font-black">Tgl Berangkat</th>
                        <th class="py-3 px-4 font-black">Status</th>
                        <th class="py-3 px-4 font-black text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($bookingTerbaru as $booking)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="py-4 px-4 font-bold text-emerald-400">#SMR-{{ $booking->id }}</td>
                            <td class="py-4 px-4 font-bold text-white">{{ $booking->user->name ?? 'Pendaki' }}</td>
                            <td class="py-4 px-4">{{ $booking->tanggal_mendaki ?? $booking->tanggal_berangkat }}</td>
                            <td class="py-4 px-4">
                                @if($booking->status === 'sudah_bayar')
                                    <span class="bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Approved</span>
                                @else
                                    <span class="bg-amber-400/10 text-amber-400 border border-amber-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Pending</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 text-right">
                                <a href="#" class="text-emerald-400 hover:underline font-black text-[10px] uppercase">Periksa</a>
                            </td>
                        </tr>
                    @empty
                        {{-- Backup data contoh jika database pendaftaran kosong --}}
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="py-4 px-4 font-bold text-emerald-400">#SMR-280526</td>
                            <td class="py-4 px-4 font-bold text-white">Hanif Ammar</td>
                            <td class="py-4 px-4">28 Mei 2026</td>
                            <td class="py-4 px-4"><span class="bg-amber-400/10 text-amber-400 border border-amber-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Pending</span></td>
                            <td class="py-4 px-4 text-right"><a href="#" class="text-emerald-400 hover:underline font-black text-[10px] uppercase">Periksa</a></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="py-6 text-center text-white/20 italic bg-white/[0.01]">Belum ada data pendaftaran baru lainnya dari database, Yang Mulia.</td>
                        </tr>
                    @endforelse {{-- 🌟 SEKARANG SUDAH FIX MENGGUNAKAN ENDFORELSE --}}
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
