@extends('Layout.Guest')

@section('title', 'Mahameru Digital - Portal Pendakian Terpadu')

@section('header-subtitle', 'Laman Informatif Bagi Para Pendaki Gunung Semeru')

@section('header-title')
MAHAMERU <span class="text-emerald-400">3676 MDPL</span>
@endsection

@section('header-search')
<div class="relative">
    <input
        type="text"
        placeholder="Cari info jalur, kuota, atau tips..."
        class="w-full py-2.5 px-10 rounded-full text-sm outline-none shadow-inner bg-white text-gray-800"
    />

    <button
        class="absolute right-0 top-0 bottom-0 bg-[#7A7A7A] text-white px-8 rounded-full font-bold uppercase hover:bg-emerald-400 transition shadow-lg"
    >
        Cari
    </button>
</div>
@endsection

@push('styles')
<style>
@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shimmer {
    0% {
        background-position: -400px 0;
    }

    100% {
        background-position: 400px 0;
    }
}

.fade-up {
    animation: fadeUp 0.6s ease forwards;
}

.delay-1 {
    animation-delay: 0.1s;
    opacity: 0;
}

.delay-2 {
    animation-delay: 0.25s;
    opacity: 0;
}

.delay-3 {
    animation-delay: 0.4s;
    opacity: 0;
}

.delay-4 {
    animation-delay: 0.55s;
    opacity: 0;
}

.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}
</style>
@endpush

@section('content')

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10 fade-up delay-1">

    <div class="bg-[#0D1B2A] rounded-xl p-4 border border-white/5 text-center card-hover">
        <p class="text-emerald-400 text-2xl font-black italic">3.676</p>
        <p class="text-white/30 text-[9px] font-black uppercase tracking-widest mt-1">
            MDPL
        </p>
    </div>

    <div class="bg-[#0D1B2A] rounded-xl p-4 border border-white/5 text-center card-hover">
        <p class="text-emerald-400 text-2xl font-black italic">15</p>
        <p class="text-white/30 text-[9px] font-black uppercase tracking-widest mt-1">
            Kuota Tersisa
        </p>
    </div>

    <div class="bg-yellow-400/10 border border-yellow-400/20 rounded-xl p-4 text-center card-hover">
        <p class="text-yellow-400 text-2xl font-black italic">II</p>
        <p class="text-yellow-400/60 text-[9px] font-black uppercase tracking-widest mt-1">
            Level Waspada
        </p>
    </div>

    <div class="bg-[#0D1B2A] rounded-xl p-4 border border-white/5 text-center card-hover">
        <p class="text-emerald-400 text-2xl font-black italic">3</p>
        <p class="text-white/30 text-[9px] font-black uppercase tracking-widest mt-1">
            Jalur Aktif
        </p>
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <div class="md:col-span-2 space-y-6 fade-up delay-2">

        <div class="bg-white rounded-2xl overflow-hidden shadow-2xl border-t-8 border-[#004d3d] card-hover">

            <div class="relative overflow-hidden">

                <img
                    src="{{ asset('OIP.webp') }}"
                    class="w-full h-72 object-cover hover:scale-105 transition-transform duration-700"
                />

                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                <div class="absolute bottom-4 left-4">
                    <span class="bg-emerald-400 text-[#0D1B2A] text-[9px] font-black px-3 py-1 rounded uppercase">
                        Featured
                    </span>
                </div>

            </div>

            <div class="p-7">

                <div class="flex items-center gap-2 mb-3">

                    <span class="text-gray-400 text-[10px] font-black uppercase">
                        12 Mei 2026
                    </span>

                    <span class="text-gray-300">•</span>

                    <span class="text-emerald-600 text-[10px] font-black uppercase">
                        Info Jalur
                    </span>

                </div>

                <h1 class="text-3xl font-black text-gray-900 leading-tight uppercase tracking-tighter">
                    Gagahnya Puncak Mahameru
                </h1>

                <p class="text-gray-500 mt-3 leading-relaxed text-sm italic border-l-4 border-emerald-500 pl-4">
                    "Menaklukkan puncak bukan tentang adu cepat, tapi tentang bagaimana kita pulang dengan selamat."
                </p>

            </div>

        </div>

    </div>

    <aside class="space-y-5 fade-up delay-4">

        <div class="bg-[#0D1B2A] p-5 rounded-2xl border border-white/5 shadow-xl">

            <h3 class="font-black uppercase italic text-white text-xs tracking-tighter mb-3">
                <i class="fas fa-phone text-emerald-400 mr-1"></i>
                Kontak Darurat
            </h3>

            <div class="space-y-2 text-[10px]">

                <div class="flex justify-between">
                    <span class="text-white/40 font-bold uppercase">Basarnas</span>
                    <span class="text-emerald-400 font-black">115</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-white/40 font-bold uppercase">Pos Ranupani</span>
                    <span class="text-emerald-400 font-black">0812-3456-7890</span>
                </div>

            </div>

        </div>

    </aside>

</div>

{{-- SECTION BERITA & TUTORIAL --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">

    {{-- DAFTAR BERITA --}}
    <div class="bg-[#0D1B2A] rounded-2xl border border-white/5 p-6 shadow-2xl fade-up delay-3">

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-white text-xl font-black uppercase tracking-tighter italic">
                <i class="fas fa-newspaper text-emerald-400 mr-2"></i>
                Daftar Berita
            </h2>

            {{-- Disesuaikan rutenya dengan standar URL Laravel agar mengarah ke halaman ini --}}
            <a
                href="{{ url('/berita') }}"
                class="text-emerald-400 text-[10px] font-black uppercase hover:text-white transition"
            >
                Lihat Semua
            </a>
        </div>

        <div class="space-y-4">

            <a href="#" class="block group bg-[#1B263B] rounded-xl p-4 hover:bg-[#24344d] transition">

                <div class="flex gap-4">

                    <img
                        src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=800"
                        class="w-24 h-20 rounded-lg object-cover"
                    >

                    <div class="flex-1">

                        <p class="text-emerald-400 text-[9px] font-black uppercase mb-1">
                            12 Mei 2026
                        </p>

                        <h3 class="text-white font-black uppercase text-xs leading-tight group-hover:text-emerald-400 transition">
                            Jalur Pendakian Ranupani Dibuka Kembali
                        </h3>

                        <p class="text-white/40 text-[10px] mt-2 leading-relaxed">
                            Informasi terbaru mengenai pembukaan jalur pendakian Semeru untuk umum.
                        </p>

                    </div>

                </div>

            </a>

            <a href="#" class="block group bg-[#1B263B] rounded-xl p-4 hover:bg-[#24344d] transition">

                <div class="flex gap-4">

                    <img
                        src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800"
                        class="w-24 h-20 rounded-lg object-cover"
                    >

                    <div class="flex-1">

                        <p class="text-red-400 text-[9px] font-black uppercase mb-1">
                            Cuaca
                        </p>

                        <h3 class="text-white font-black uppercase text-xs leading-tight group-hover:text-emerald-400 transition">
                            Waspada Angin Kencang di Area Kalimati
                        </h3>

                        <p class="text-white/40 text-[10px] mt-2 leading-relaxed">
                            Pendaki diimbau menggunakan perlengkapan yang memadai saat summit attack.
                        </p>

                    </div>

                </div>

            </a>

        </div>

    </div>

    {{-- TUTORIAL PEMBELIAN TIKET --}}
    <div class="bg-[#0D1B2A] rounded-2xl border border-white/5 p-6 shadow-2xl fade-up delay-4">

        <div class="flex items-center justify-between mb-6">

            <h2 class="text-white text-xl font-black uppercase tracking-tighter italic">
                <i class="fas fa-ticket-alt text-emerald-400 mr-2"></i>
                Tutorial Booking
            </h2>

            <span class="text-emerald-400 text-[10px] font-black uppercase">
                4 Langkah
            </span>

        </div>

        <div class="space-y-4">

            <div class="flex gap-4 items-start bg-[#1B263B] rounded-xl p-4">

                <div class="w-8 h-8 rounded-full bg-emerald-400 text-[#0D1B2A] flex items-center justify-center font-black text-sm">
                    1
                </div>

                <div>
                    <h3 class="text-white font-black uppercase text-xs mb-1">
                        Buat Akun
                    </h3>

                    <p class="text-white/40 text-[10px] leading-relaxed">
                        Daftar akun Mahameru Digital menggunakan email aktif.
                    </p>
                </div>

            </div>

            <div class="flex gap-4 items-start bg-[#1B263B] rounded-xl p-4">

                <div class="w-8 h-8 rounded-full bg-emerald-400 text-[#0D1B2A] flex items-center justify-center font-black text-sm">
                    2
                </div>

                <div>
                    <h3 class="text-white font-black uppercase text-xs mb-1">
                        Pilih Jadwal
                    </h3>

                    <p class="text-white/40 text-[10px] leading-relaxed">
                        Tentukan tanggal pendakian dan jumlah anggota tim.
                    </p>
                </div>

            </div>

            <div class="flex gap-4 items-start bg-[#1B263B] rounded-xl p-4">

                <div class="w-8 h-8 rounded-full bg-emerald-400 text-[#0D1B2A] flex items-center justify-center font-black text-sm">
                    3
                </div>

                <div>
                    <h3 class="text-white font-black uppercase text-xs mb-1">
                        Upload Dokumen
                    </h3>

                    <p class="text-white/40 text-[10px] leading-relaxed">
                        Lengkapi identitas dan surat kesehatan pendaki.
                    </p>
                </div>

            </div>

            <div class="flex gap-4 items-start bg-[#1B263B] rounded-xl p-4">

                <div class="w-8 h-8 rounded-full bg-emerald-400 text-[#0D1B2A] flex items-center justify-center font-black text-sm">
                    4
                </div>

                <div>
                    <h3 class="text-white font-black uppercase text-xs mb-1">
                        Bayar Tiket
                    </h3>

                    <p class="text-white/40 text-[10px] leading-relaxed">
                        Lakukan pembayaran dan unduh e-ticket pendakian.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.fade-up').forEach(function(el) {
        el.style.opacity = '0';
    });

    setTimeout(function () {
        document.querySelectorAll('.fade-up').forEach(function(el) {
            el.style.opacity = '';
        });
    }, 50);

});
</script>
@endpush
