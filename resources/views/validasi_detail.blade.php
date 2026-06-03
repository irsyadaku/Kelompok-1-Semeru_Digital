@extends('Layout.App')

@section('title', 'Mahameru Digital - Validasi Dokumen Pendaki')

@section('content')
<div class="max-w-5xl mx-auto my-8 px-4 space-y-6">

    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition font-bold text-xs uppercase tracking-wider mb-2">
        <i class="fas fa-arrow-left"></i> Kembali ke Singgasana
    </a>

   {{-- Header --}}
    <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-2xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div>
            {{-- KOMPONEN BADGE STATUS YANG DINAMIS --}}
            @if(in_array(strtolower($booking->status), ['menunggu_verifikasi', 'pending', 'sudah_bayar']))
                <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest animate-pulse">
                    Menunggu Tinjauan Admin
                </span>
            @elseif(strtolower($booking->status) == 'ditolak')
                <span class="bg-red-500/10 text-red-400 border border-red-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    Pendaftaran Ditolak
                </span>
            @elseif(in_array(strtolower($booking->status), ['disetujui', 'selesai']))
                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    Disetujui & SIMAKSI Aktif
                </span>
            @else
                <span class="bg-slate-500/10 text-slate-400 border border-slate-500/20 px-3 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest">
                    Status: {{ strtoupper($booking->status) }}
                </span>
            @endif

            <h2 class="text-white text-2xl font-black uppercase tracking-tight mt-2">
                Validasi Tiket <span class="text-emerald-400">#{{ $booking->kode_booking ?? 'SMR-'.$booking->id }}</span>
            </h2>
        </div>

        {{-- TOMBOL AKSI KONTROL BERDASARKAN STATUS --}}
        @if(in_array(strtolower($booking->status), ['menunggu_verifikasi', 'pending', 'sudah_bayar']))
            <div class="flex flex-wrap items-center gap-3 relative z-10">

                {{-- FORM PENOLAKAN (REJECT) --}}
                <form action="{{ route('admin.validasi.reject', $booking->id) }}" method="POST" onsubmit="return confirm('Yang Mulia, apakah Anda yakin ingin MENOLAK bukti pembayaran ini? User harus mengunggah ulang.')">
                    @csrf
                    <button type="submit" class="bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 font-black px-5 py-3 rounded-xl text-xs uppercase tracking-wider transition flex items-center gap-2">
                        <i class="fas fa-times-circle"></i> Tolak Pembayaran
                    </button>
                </form>

                {{-- FORM PERSETUJUAN (APPROVE) --}}
                <form action="{{ route('admin.validasi.approve', $booking->id) }}" method="POST" onsubmit="return confirm('Yang Mulia, pastikan dana benar-benar sudah masuk. Terbitkan SIMAKSI sekarang?')">
                    @csrf
                    <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-[#0D1B2A] font-black px-6 py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-emerald-500/20 flex items-center gap-2">
                        <i class="fas fa-check-double"></i> Setujui & Terbitkan SIMAKSI
                    </button>
                </form>

            </div>
        @elseif(strtolower($booking->status) == 'ditolak')
            {{-- TAMPILAN JIKA STATUSNYA DITOLAK --}}
            <div class="bg-red-500/10 border border-red-500/25 text-red-400 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-wider cursor-not-allowed flex items-center gap-2">
                <i class="fas fa-ban"></i> Permintaan Tiket Ditolak
            </div>
        @elseif(in_array(strtolower($booking->status), ['disetujui', 'selesai']))
            {{-- TAMPILAN JIKA STATUSNYA DISETUJUI --}}
            <div class="bg-emerald-500/10 border border-emerald-500/25 text-emerald-400 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-wider cursor-not-allowed flex items-center gap-2">
                <i class="fas fa-lock"></i> Telah Disetujui / Selesai
            </div>
        @endif
    </div>

    {{-- Grid Konten Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Informasi Data Diri --}}
        <div class="md:col-span-1 space-y-6">
            <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-3xl shadow-xl">
                <h3 class="text-white text-sm font-black uppercase tracking-wider mb-4 border-b border-white/5 pb-2">
                    <i class="fas fa-list-alt text-emerald-400 mr-2"></i> Rincian Pendaftaran
                </h3>
                <div class="space-y-4">
                    <div>
                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest block">Ketua Rombongan</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->nama_ketua }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest block">Nomor WhatsApp</span>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->no_hp) }}" target="_blank" class="text-emerald-400 hover:underline font-semibold text-sm inline-flex items-center gap-1">
                            {{ $booking->no_hp }} <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest block">Tanggal Pendakian</span>
                        <span class="text-white font-semibold text-sm">{{ \Carbon\Carbon::parse($booking->tanggal_pendakian)->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-white/[0.02] p-3 rounded-xl border border-white/5">
                        <span class="text-slate-400 text-xs font-bold">Total Anggota</span>
                        <span class="text-white font-black">{{ $booking->jumlah_pendaki }} Orang</span>
                    </div>
                    <div class="flex justify-between items-center bg-emerald-500/5 p-3 rounded-xl border border-emerald-500/10">
                        <span class="text-emerald-500/70 text-xs font-bold">Total Transfer</span>
                        <span class="text-emerald-400 font-black font-mono">Rp {{ number_format($booking->jumlah_pendaki * 100000, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Lampiran Dokumen --}}
        <div class="md:col-span-2 space-y-6">
            <div class="bg-[#0D1B2A] border border-white/5 p-6 rounded-3xl shadow-xl">
                <h3 class="text-white text-sm font-black uppercase tracking-wider mb-4 border-b border-white/5 pb-2">
                    <i class="fas fa-file-invoice-dollar text-amber-400 mr-2"></i> Verifikasi Dokumen & Pembayaran
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    {{-- Bukti Pembayaran --}}
                    <div>
                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest block mb-2">Bukti Transfer Bank</span>
                        @if($booking->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}" target="_blank" class="block group relative rounded-2xl overflow-hidden border border-white/10 aspect-[3/4] bg-slate-900">
                                <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                    <span class="text-white font-bold text-xs uppercase tracking-wider"><i class="fas fa-external-link-alt mr-1"></i> Perbesar</span>
                                </div>
                            </a>
                        @else
                            <div class="flex items-center justify-center aspect-[3/4] bg-slate-900 border border-white/5 rounded-2xl text-slate-600 text-xs font-bold uppercase">Belum Diunggah</div>
                        @endif
                    </div>

                    {{-- Foto Identitas (KTP) --}}
                    <div>
                        <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest block mb-2">Kartu Identitas (KTP)</span>
                        @if($booking->foto_ktp)
                            <a href="{{ asset('storage/' . $booking->foto_ktp) }}" target="_blank" class="block group relative rounded-2xl overflow-hidden border border-white/10 aspect-[3/4] bg-slate-900">
                                <img src="{{ asset('storage/' . $booking->foto_ktp) }}" alt="KTP Pendaki" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                    <span class="text-white font-bold text-xs uppercase tracking-wider"><i class="fas fa-external-link-alt mr-1"></i> Perbesar</span>
                                </div>
                            </a>
                        @else
                            <div class="flex items-center justify-center aspect-[3/4] bg-slate-900 border border-white/5 rounded-2xl text-slate-600 text-xs font-bold uppercase">Belum Diunggah</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
