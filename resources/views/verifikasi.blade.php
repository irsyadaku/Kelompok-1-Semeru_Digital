@extends('Layout.App') @section('content')
<div class="p-8 min-h-screen bg-slate-950">
    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-white tracking-tight mb-1">Verifikasi Pembayaran</h1>
                <p class="text-slate-400 text-sm">Cek bukti transfer dan konfirmasi slot pendakian Mahameru.</p>
            </div>
            <div class="bg-amber-500/10 text-amber-500 border border-amber-500/20 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </span>
                {{ $bookings->total() }} Menunggu Verifikasi
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500 text-emerald-400 px-6 py-4 rounded-xl mb-6 font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-400 px-6 py-4 rounded-xl mb-6 font-medium">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-300">
                    <thead class="bg-slate-950/50 text-slate-400 font-semibold border-b border-slate-800">
                        <tr>
                            <th scope="col" class="px-6 py-5">KODE</th>
                            <th scope="col" class="px-6 py-5">KETUA KELOMPOK</th>
                            <th scope="col" class="px-6 py-5">TANGGAL PENDAKIAN</th>
                            <th scope="col" class="px-6 py-5 text-center">BUKTI TRANSFER</th>
                            <th scope="col" class="px-6 py-5 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @forelse ($bookings as $booking)
                            <tr class="hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-5 font-mono font-bold text-white">
                                    {{ $booking->kode_booking ?? 'SMR-'.$booking->id }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-bold text-white">{{ $booking->nama_ketua }}</div>
                                    <div class="text-xs text-slate-500">{{ $booking->jumlah_pendaki }} Orang | HP: {{ $booking->no_hp }}</div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="font-medium text-emerald-400">{{ \Carbon\Carbon::parse($booking->tanggal_pendakian)->translatedFormat('d F Y') }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}" target="_blank"
                                       class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-blue-400 px-4 py-2 rounded-xl transition text-xs font-bold border border-slate-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat Struk
                                    </a>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.terima', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menerima pembayaran ini?')">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500/10 hover:bg-emerald-500 text-emerald-500 hover:text-slate-900 border border-emerald-500/50 p-2 rounded-lg transition" title="Terima Pembayaran">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.tolak', $booking->id) }}" method="POST" onsubmit="return confirm('Tolak pembayaran dan minta user upload ulang?')">
                                            @csrf
                                            <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-slate-900 border border-red-500/50 p-2 rounded-lg transition" title="Tolak Pembayaran">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Hore! Belum ada antrean verifikasi pembayaran saat ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="border-t border-slate-800 p-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
