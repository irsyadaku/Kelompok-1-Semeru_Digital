@extends('Layout.App')

@section('content')
<div class="flex items-center justify-center p-6 min-h-screen bg-slate-950">
    <div class="w-full max-w-xl bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl relative overflow-hidden">

        <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Selesaikan Pembayaran</h1>
            <p class="text-slate-400 text-sm">Pilih metode pembayaran di bawah dan unggah bukti transfer untuk verifikasi cepat.</p>
        </div>

        <div class="bg-slate-950/60 p-5 rounded-2xl border border-slate-800/80 mb-6 backdrop-blur-xl">
            <div class="grid grid-cols-2 gap-y-3 text-sm">
                <span class="text-slate-400">Kode Booking</span>
                <span class="text-emerald-400 font-mono font-bold text-right">#{{ $booking->kode_booking ?? 'SMR-'.$booking->id }}</span>

                <span class="text-slate-400">Tanggal Pendakian</span>
                <span class="text-white font-semibold text-right">{{ \Carbon\Carbon::parse($booking->tanggal_pendakian)->translatedFormat('d F Y') }}</span>

                <span class="text-slate-400">Jumlah Pendaki</span>
                <span class="text-white font-semibold text-right">{{ $booking->jumlah_pendaki }} Orang</span>

                <div class="col-span-2 border-t border-slate-800/80 my-1"></div>

                <span class="text-slate-400 flex items-center">Status</span>
                <div class="text-right">
                    <span class="text-amber-400 font-bold uppercase text-[10px] tracking-wider px-2.5 py-1 bg-amber-400/10 border border-amber-400/20 rounded-full">
                        Menunggu Pembayaran
                    </span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-300 mb-3">Pilih Metode Pembayaran</label>
            <div class="grid grid-cols-3 gap-3">
                <button type="button" onclick="switchPayment('bca')" id="tab-bca"
                    class="payment-tab flex flex-col items-center justify-center p-4 bg-slate-950 border-2 border-emerald-500 rounded-2xl text-white transition-all duration-200">
                    <span class="font-black text-blue-400 text-base tracking-wider">BCA</span>
                    <span class="text-[10px] text-slate-400 mt-1">Transfer Bank</span>
                </button>

                <button type="button" onclick="switchPayment('qris')" id="tab-qris"
                    class="payment-tab flex flex-col items-center justify-center p-4 bg-slate-950 border border-slate-800 rounded-2xl text-slate-400 hover:text-white hover:border-slate-700 transition-all duration-200">
                    <span class="font-extrabold text-red-400 text-base tracking-tight">QRIS</span>
                    <span class="text-[10px] text-slate-400 mt-1">E-Wallet / Bank</span>
                </button>

                <button type="button" onclick="switchPayment('dana')" id="tab-dana"
                    class="payment-tab flex flex-col items-center justify-center p-4 bg-slate-950 border border-slate-800 rounded-2xl text-slate-400 hover:text-white hover:border-slate-700 transition-all duration-200">
                    <span class="font-black text-sky-400 text-base tracking-wide">DANA</span>
                    <span class="text-[10px] text-slate-400 mt-1">Dompet Digital</span>
                </button>
            </div>
        </div>

        <div class="mb-8">
            <div id="content-bca" class="payment-content space-y-3 animate-fadeIn">
                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-0.5">Nomor Rekening BCA</div>
                        <div class="text-white font-mono text-lg font-bold tracking-widest" id="rek-bca">1234567890</div>
                        <div class="text-slate-400 text-xs mt-0.5">An. Admin Pendakian Mahameru</div>
                    </div>
                    <button type="button" onclick="copyToClipboard('1234567890', this)" class="text-xs bg-slate-800 hover:bg-slate-700 text-emerald-400 px-3 py-1.5 rounded-xl transition">
                        Salin
                    </button>
                </div>
            </div>

            <div id="content-qris" class="payment-content space-y-3 hidden animate-fadeIn">
    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 flex flex-col items-center justify-center text-center">
        <div class="text-xs text-slate-500 uppercase tracking-wider mb-3">Scan Kode QRIS di Bawah Ini</div>

        <div class="bg-white p-3 rounded-xl mb-3 shadow-lg group relative">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://images.unsplash.com/photo-1540573133985-87b6da6d54a9"
                 alt="QRIS Mockup"
                 class="w-44 h-44 rounded-lg transition-transform group-hover:scale-105 duration-200">
        </div>

        <div class="text-amber-400 font-medium text-xs mb-2">
        </div>

        <div class="text-slate-400 text-xs max-w-xs">
            Bisa di-scan menggunakan kamera HP, GoPay, OVO, atau Dana untuk memunculkan kejutan.
        </div>
    </div>
</div>

            <div id="content-dana" class="payment-content space-y-3 hidden animate-fadeIn">
                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 flex items-center justify-between">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-wider mb-0.5">Nomor Akun DANA</div>
                        <div class="text-white font-mono text-lg font-bold tracking-widest" id="num-dana">081234567890</div>
                        <div class="text-slate-400 text-xs mt-0.5">An. Admin Pendakian Mahameru</div>
                    </div>
                    <button type="button" onclick="copyToClipboard('081234567890', this)" class="text-xs bg-slate-800 hover:bg-slate-700 text-emerald-400 px-3 py-1.5 rounded-xl transition">
                        Salin
                    </button>
                </div>
            </div>
        </div>

        <form action="{{ route('pembayaran.upload', $booking->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-3">Unggah Bukti Transfer</label>

                <div class="relative group border-2 border-dashed border-slate-800 hover:border-emerald-500/50 bg-slate-950/40 rounded-2xl p-6 text-center transition-all cursor-pointer">
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" required onchange="updateFileName(this)"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                    <div class="space-y-2" id="upload-placeholder">
                        <svg class="mx-auto h-8 w-8 text-slate-500 group-hover:text-emerald-400 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="text-xs text-slate-400">
                            <span class="text-emerald-400 font-semibold">Klik untuk upload</span> atau drag file ke sini
                        </div>
                        <p class="text-[10px] text-slate-500">PNG, JPG, JPEG (Maks. 2MB)</p>
                    </div>

                    <div class="hidden text-sm text-emerald-400 font-medium" id="file-name-display">
                        </div>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-emerald-500 hover:bg-emerald-600 active:scale-[0.99] text-slate-950 font-extrabold py-4 rounded-2xl transition-all shadow-lg shadow-emerald-500/10 tracking-wider">
                KONFIRMASI PEMBAYARAN
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-500 text-sm hover:text-white transition group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-0.5 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script>
    // 1. Fungsi Ganti Metode Pembayaran (Tabs)
    function switchPayment(method) {
        // Sembunyikan semua konten instruksi
        document.querySelectorAll('.payment-content').forEach(el => el.classList.add('hidden'));

        // Hapus styling aktif di semua tombol tab
        document.querySelectorAll('.payment-tab').forEach(el => {
            el.classList.remove('border-emerald-500', 'text-white');
            el.classList.add('border-slate-800', 'text-slate-400');
        });

        // Tampilkan konten yang dipilih
        document.getElementById(`content-${method}`).classList.remove('hidden');

        // Tambah styling aktif pada tab yang diklik
        const activeTab = document.getElementById(`tab-${method}`);
        activeTab.classList.remove('border-slate-800', 'text-slate-400');
        activeTab.classList.add('border-emerald-500', 'text-white');
    }

    // 2. Fungsi Salin ke Clipboard (Rekening / No HP)
    function copyToClipboard(text, button) {
        navigator.clipboard.writeText(text).then(() => {
            const originalText = button.innerText;
            button.innerText = 'Tersalin!';
            button.classList.remove('text-emerald-400', 'bg-slate-800');
            button.classList.add('text-slate-950', 'bg-emerald-400');

            setTimeout(() => {
                button.innerText = originalText;
                button.classList.remove('text-slate-950', 'bg-emerald-400');
                button.classList.add('text-emerald-400', 'bg-slate-800');
            }, 2000);
        });
    }

    // 3. Menampilkan Nama File Setelah Dipilih
    function updateFileName(input) {
        const placeholder = document.getElementById('upload-placeholder');
        const display = document.getElementById('file-name-display');

        if (input.files && input.files.length > 0) {
            placeholder.classList.add('hidden');
            display.classList.remove('hidden');
            display.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>${input.files[0].name}</span>
                </div>
                <span class="text-[10px] text-slate-500 block mt-1">(Klik untuk mengganti file)</span>
            `;
        }
    }
</script>

<style>
    /* Animasi Fade In Sederhana */
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
