@extends('Layout.App')

@section('content')
<div class="p-6 min-h-screen bg-slate-950 text-slate-100">
    <div class="max-w-4xl mx-auto">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Riwayat Transaksi</h1>
            <p class="text-slate-400 text-sm">Pantau status pembayaran dan pendaftaran slot pendakian Mahameru Anda.</p>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm p-4 rounded-xl mb-6 font-bold flex items-center gap-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm p-4 rounded-xl mb-6 font-bold flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse ($transaksi as $item)
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl relative overflow-hidden transition-all hover:border-slate-700">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800/60 pb-4 mb-4">
                        <div>
                            <span class="text-xs text-slate-500 uppercase tracking-wider block mb-0.5">Kode Booking</span>
                            <span class="text-white font-mono font-bold text-lg">#{{ $item->kode_booking ?? 'SMR-'.$item->id }}</span>
                        </div>

                        <div>
                            @if ($item->status == 'menunggu_pembayaran')
                                <span class="inline-flex items-center text-amber-400 font-bold uppercase text-[11px] tracking-wider px-3 py-1.5 bg-amber-400/10 border border-amber-400/20 rounded-full">
                                    Menunggu Pembayaran
                                </span>
                            @elseif ($item->status == 'menunggu_verifikasi')
                                <span class="inline-flex items-center text-blue-400 font-bold uppercase text-[11px] tracking-wider px-3 py-1.5 bg-blue-400/10 border border-blue-400/20 rounded-full">
                                    Menunggu Verifikasi
                                </span>
                            @elseif ($item->status == 'sudah_bayar')
                                <span class="inline-flex items-center text-emerald-400 font-bold uppercase text-[11px] tracking-wider px-3 py-1.5 bg-emerald-400/10 border border-emerald-400/20 rounded-full">
                                    Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center text-red-400 font-bold uppercase text-[11px] tracking-wider px-3 py-1.5 bg-red-400/10 border border-red-400/20 rounded-full">
                                    Gagal / Dibatalkan
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm mb-4">
                        <div>
                            <span class="text-slate-500 block text-xs">Ketua Kelompok</span>
                            <span class="text-slate-200 font-semibold mt-0.5 block">{{ $item->nama_ketua }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Tanggal Pendakian</span>
                            <span class="text-slate-200 font-semibold mt-0.5 block">
                                {{ \Carbon\Carbon::parse($item->tanggal_pendakian)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Jumlah Anggota</span>
                            <span class="text-slate-200 font-semibold mt-0.5 block">{{ $item->jumlah_pendaki }} Orang</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-xs">Total Pembayaran</span>
                            <span class="text-emerald-400 font-bold mt-0.5 block font-mono">
                                Rp {{ number_format($item->jumlah_pendaki * 100000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2 border-t border-slate-800/40">
                        @if ($item->status == 'menunggu_pembayaran')
                            <div class="flex items-center gap-3">
                                <form action="{{ route('booking.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini? Data yang dihapus tidak bisa dikembalikan.')" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500/20 font-extrabold text-xs px-5 py-2.5 rounded-xl transition uppercase tracking-wide flex items-center gap-2">
                                        <i class="fas fa-trash-alt"></i> Batalkan
                                    </button>
                                </form>

                                <a href="{{ url('/pembayaran/' . $item->id) }}"
                                   class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xs px-5 py-2.5 rounded-xl transition shadow-lg shadow-amber-500/10 uppercase tracking-wide flex items-center gap-2">
                                    <i class="fas fa-wallet"></i> Bayar Sekarang
                                </a>
                            </div>
                        @elseif ($item->status == 'menunggu_verifikasi')
                            <button disabled class="bg-slate-800 text-slate-500 cursor-not-allowed text-xs px-5 py-2.5 rounded-xl border border-slate-700/50 uppercase font-bold tracking-wide">
                                Sedang Diulas Admin
                            </button>
                        @elseif ($item->status == 'sudah_bayar')
                            <button onclick="alert('Fitur download e-tiket akan segera hadir!')"
                                    class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold text-xs px-5 py-2.5 rounded-xl transition shadow-lg shadow-emerald-500/10 uppercase tracking-wide flex items-center gap-2">
                                <i class="fas fa-print"></i> Cetak E-Tiket
                            </button>
                        @endif
                    </div>

                </div>
            @empty
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center shadow-xl">
                    <i class="fas fa-box-open text-6xl text-slate-700 mx-auto mb-4 opacity-40 block"></i>
                    <h3 class="text-lg font-bold text-white mb-1">Belum Ada Transaksi</h3>
                    <p class="text-slate-500 text-sm mb-6">Anda belum pernah melakukan pendaftaran atau booking tiket pendakian.</p>
                    <a href="{{ route('booking.index') }}" class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs px-6 py-3 rounded-xl transition shadow-lg shadow-emerald-500/10 uppercase tracking-wide">
                        Mulai Booking Tiket
                    </a>
                </div>
            @endforelse
        </div>

        @if ($transaksi->hasPages())
            <div class="mt-6 mt-pagination">
                {{ $transaksi->links() }}
            </div>
        @endif

    </div>
</div>

<style>
    .mt-pagination nav svg { width: 1.5rem; height: 1.5rem; display: inline; }
    .mt-pagination nav span, .mt-pagination nav a { background-color: #0f172a !important; border-color: #1e293b !important; color: #94a3b8 !important; }
    .mt-pagination nav .shadow-sm { box-shadow: none !important; }
</style>
@endsection
