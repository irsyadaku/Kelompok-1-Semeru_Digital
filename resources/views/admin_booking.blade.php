@extends('Layout.App')

@section('title', 'Mahameru Digital - Arsip Riwayat Booking')

@section('content')
<div class="max-w-6xl mx-auto my-8 px-4 space-y-8 fade-up delay-1">

    {{-- Header Utama Riwayat --}}
    <div class="bg-[#0D1B2A] border border-emerald-500/10 p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                Arsip Data Kerajaan
            </span>
            <h2 class="text-white text-2xl font-black italic uppercase tracking-tight mt-1.5">
                Daftar Riwayat <span class="text-emerald-400">Booking SIMAKSI</span>
            </h2>
            <p class="text-white/40 text-xs mt-0.5">Seluruh rekam jejak pendaftaran pendakian Gunung Semeru yang tercatat di dalam sistem.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-white/5 border border-white/10 hover:bg-white/10 text-white/80 font-black px-4 py-2 rounded-xl text-[10px] uppercase tracking-wider transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    {{-- Notifikasi Sukses / Error Pengelolaan Data --}}
    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm p-4 rounded-xl font-bold flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm p-4 rounded-xl font-bold flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Utama Log Pendaftaran --}}
    <div class="bg-[#0D1B2A] border border-white/5 rounded-3xl p-8 space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h3 class="text-white text-sm font-black uppercase tracking-wider"><i class="fas fa-history text-emerald-400 mr-2"></i> Log Pendaftaran Keseluruhan</h3>
                <p class="text-white/40 text-xs">Menampilkan data transaksi secara mendalam dan berkala.</p>
            </div>
            <div class="text-white/40 text-[10px] font-bold uppercase tracking-wider bg-white/5 px-3 py-1 rounded-lg border border-white/10">
                Total Data: {{ $bookings->total() }} Record
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
                        <th class="py-3 px-4 font-black text-center">Kuota Anggota</th>
                        <th class="py-3 px-4 font-black text-center">Total Tarif</th>
                        <th class="py-3 px-4 font-black">Status</th>
                        <th class="py-3 px-4 font-black text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="py-4 px-4 font-bold text-emerald-400">#{{ $booking->kode_booking ?? 'SMR-'.$booking->id }}</td>
                            <td class="py-4 px-4 font-bold text-white">{{ $booking->nama_ketua ?? 'Pendaki' }}</td>
                            <td class="py-4 px-4">{{ \Carbon\Carbon::parse($booking->tanggal_pendakian)->translatedFormat('d M Y') }}</td>
                            <td class="py-4 px-4 text-center font-bold text-white">{{ $booking->jumlah_pendaki ?? 0 }} Orang</td>
                            <td class="py-4 px-4 text-center text-sky-400 font-bold">Rp {{ number_format(($booking->jumlah_pendaki ?? 0) * 100000, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                {{-- KONTROL BADGE STATUS --}}
                                @if(in_array(strtolower($booking->status), ['disetujui', 'sudah_bayar']))
                                    <span class="bg-emerald-400/10 text-emerald-400 border border-emerald-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Disetujui</span>
                                @elseif(strtolower($booking->status) === 'ditolak')
                                    <span class="bg-red-500/10 text-red-400 border border-red-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Ditolak</span>
                                @elseif(strtolower($booking->status) === 'menunggu_verifikasi')
                                    <span class="bg-blue-400/10 text-blue-400 border border-blue-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase animate-pulse">Perlu Dicek</span>
                                @elseif(strtolower($booking->status) === 'menunggu_pembayaran')
                                    <span class="bg-amber-400/10 text-amber-400 border border-amber-400/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Pending</span>
                                @else
                                    <span class="bg-slate-500/10 text-slate-400 border border-slate-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">{{ strtoupper($booking->status) }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Mengarah ke halaman detail validasi dokumen --}}
                                    <a href="{{ route('admin.validasi.show', $booking->id) }}" class="bg-white/5 border border-white/10 hover:bg-emerald-500/20 hover:text-emerald-400 text-white/70 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider transition flex items-center gap-1">
                                        <i class="fas fa-search text-[9px]"></i> Detail
                                    </a>

                                    {{-- Tombol Eksekusi Hapus Data Permanen --}}
                                    <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Paduka yakin ingin melenyapkan data booking ini secara permanen dari basis data?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white/40 hover:text-red-400 p-1.5 transition" title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-white/40 italic">
                                <i class="fas fa-folder-open text-2xl block mb-2 text-white/10"></i>
                                Belum ada riwayat pendaftaran yang tersimpan di dalam sistem, Yang Mulia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi Halaman (Pagination Links) --}}
        <div class="mt-4 pt-6 border-t border-white/5">
            {{ $bookings->links() }}
        </div>
    </div>

</div>
@endsection
