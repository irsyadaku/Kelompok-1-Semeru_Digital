@extends('Layout.App')

@section('content')
<div class="flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-xl bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl">

        <h1 class="text-2xl font-bold text-white mb-1">Selesaikan Pembayaran</h1>
        <p class="text-slate-400 text-sm mb-8">Lakukan transfer ke rekening di bawah untuk mengamankan slot pendakian.</p>

        <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700 mb-6">
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-400">Kode Booking:</span>
                <span class="text-white font-mono font-bold">#ORD-{{ $booking->id }}</span>
            </div>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-slate-400">Tanggal:</span>
                <span class="text-white font-semibold">{{ $booking->tanggal_pendakian }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-slate-400">Status:</span>
                <span class="text-amber-500 font-bold uppercase text-xs px-2 py-1 bg-amber-500/10 rounded">Menunggu Bayar</span>
            </div>
        </div>

        <div class="space-y-4 mb-8">
            <h2 class="text-emerald-500 font-semibold text-sm uppercase">Transfer Ke:</h2>
            <div class="bg-slate-800 p-4 rounded-xl flex items-center gap-4 border border-emerald-500/30">
                <div class="w-12 h-8 bg-white rounded flex items-center justify-center font-bold text-blue-900">BCA</div>
                <div>
                    <div class="text-white font-bold">1234567890</div>
                    <div class="text-slate-400 text-xs">An. Admin Pendakian Mahameru</div>
                </div>
            </div>
        </div>

        <form action="{{ route('pembayaran.upload', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Upload Bukti Transfer</label>
                <input type="file" name="bukti_pembayaran" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none">
            </div>

            <button type="submit"
                class="w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold py-4 rounded-xl transition-all mt-6">
                KONFIRMASI PEMBAYARAN
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-slate-500 text-sm hover:text-white transition">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
