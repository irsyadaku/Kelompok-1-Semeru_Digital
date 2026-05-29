@extends('Layout.App')

@section('content')
<div class="flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-2xl bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl">

        <h1 class="text-2xl font-bold text-white mb-1">Registrasi Pendakian</h1>
        <p class="text-slate-400 text-sm mb-8">Lengkapi data ketua rombongan dan detail pendakian sesuai KTP.</p>

        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="space-y-4">
                <h2 class="text-emerald-500 font-semibold text-sm uppercase tracking-wider">Informasi Ketua Rombongan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                         <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap Ketua</label>
                         <input type="text" name="nama_ketua" value="{{ old('nama_ketua', auth()->user()?->name ?? '') }}" required
                        class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nomor WhatsApp/HP</label>
                        <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required placeholder="0812xxxxxx"
                            class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-4">
                <h2 class="text-emerald-500 font-semibold text-sm uppercase tracking-wider">Detail Pendakian</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Pendakian</label>
                        <input type="date" name="tanggal_pendakian" value="{{ old('tanggal_pendakian') }}" required
                            class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jumlah Anggota</label>
                        <input type="number" name="jumlah_pendaki" value="{{ old('jumlah_pendaki') }}" min="1" max="10" placeholder="1-10 orang" required
                            class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-4">
                <h2 class="text-emerald-500 font-semibold text-sm uppercase tracking-wider">Kontak Darurat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Kontak</label>
                        <input type="text" name="nama_darurat" value="{{ old('nama_darurat') }}" required placeholder="Nama keluarga/teman"
                            class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nomor HP Darurat</label>
                        <input type="tel" name="hp_darurat" value="{{ old('hp_darurat') }}" required placeholder="0812xxxxxx"
                            class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800">
                <label class="block text-sm font-medium text-slate-300 mb-2">Upload Foto KTP</label>
                <input type="file" name="foto_ktp" accept="image/*" required
                    class="w-full bg-slate-800 border border-slate-700 rounded-xl px-4 py-3 text-white">
                <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG (Maks 2MB)</p>
            </div>

            <div class="flex items-start gap-3 mt-6">
                <input type="checkbox" id="setuju" required class="mt-1 accent-emerald-500">
                <label for="setuju" class="text-xs text-slate-500">
                    Saya menyatakan data yang diisi benar dan bersedia mematuhi aturan pendakian. Saya bertanggung jawab atas keselamatan rombongan saya.
                </label>
            </div>

            <button type="submit"
                class="w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold py-4 rounded-xl transition-all shadow-lg shadow-emerald-500/20 mt-6">
                SIMPAN DAN LANJUTKAN PEMBAYARAN
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="block text-center mt-6 text-slate-500 text-sm hover:text-white transition">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
