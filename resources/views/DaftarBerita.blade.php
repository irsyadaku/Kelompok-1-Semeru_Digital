@extends('Layout.Guest')

@section('title', 'Daftar Berita - Mahameru Digital')

@section('header-subtitle', 'Informasi & Update Pendakian')

@section('header-title')
DAFTAR <span class="text-emerald-400">BERITA</span>
@endsection

@section('header-search')
<div class="relative">
    <input
        type="text"
        placeholder="Cari berita pendakian..."
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

.fade-up {
    animation: fadeUp 0.6s ease forwards;
}

.delay-1 {
    animation-delay: 0.1s;
    opacity: 0;
}

.delay-2 {
    animation-delay: 0.2s;
    opacity: 0;
}

.delay-3 {
    animation-delay: 0.3s;
    opacity: 0;
}

.card-hover {
    transition: 0.3s;
}

.card-hover:hover {
    transform: translateY(-5px);
}

</style>
@endpush

@section('content')

{{-- HEADING --}}
<div class="mb-10 fade-up delay-1">

    <h1 class="text-4xl font-black text-white uppercase tracking-tighter mb-3">
        Update Berita Pendakian
    </h1>

    <p class="text-white/50 uppercase text-xs tracking-widest">
        Informasi terbaru Gunung Semeru & jalur pendakian
    </p>

</div>

{{-- GRID BERITA --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- BERITA 1 --}}
    <div class="bg-[#0D1B2A] rounded-2xl overflow-hidden border border-white/5 shadow-xl card-hover fade-up delay-1">

        <div class="relative h-52 overflow-hidden">

            <img
                src="https://images.unsplash.com/photo-1501555088652-021faa106b9b?auto=format&fit=crop&w=1000&q=80"
                class="w-full h-full object-cover hover:scale-110 transition duration-700"
            >

            <div class="absolute top-3 left-3">
                <span class="bg-emerald-400 text-[#0D1B2A] text-[9px] px-3 py-1 rounded-full font-black uppercase">
                    Info Jalur
                </span>
            </div>

        </div>

        <div class="p-5">

            <p class="text-white/30 text-[10px] uppercase font-black mb-2">
                20 Mei 2026
            </p>

            <h2 class="text-white text-lg font-black uppercase leading-tight mb-3">
                Jalur Ranupani Dibuka Kembali
            </h2>

            <p class="text-white/50 text-sm leading-relaxed mb-5">
                Pendakian Gunung Semeru jalur Ranupani resmi dibuka dengan kuota terbatas.
            </p>

            <a
                href="{{ url('/berita/detail/1') }}"
                class="inline-flex items-center gap-2 text-emerald-400 font-black uppercase text-xs hover:text-white transition"
            >
                Baca Selengkapnya
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </div>

    {{-- BERITA 2 --}}
    <div class="bg-[#0D1B2A] rounded-2xl overflow-hidden border border-white/5 shadow-xl card-hover fade-up delay-2">

        <div class="relative h-52 overflow-hidden">

            <img
                src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1000&q=80"
                class="w-full h-full object-cover hover:scale-110 transition duration-700"
            >

            <div class="absolute top-3 left-3">
                <span class="bg-red-500 text-white text-[9px] px-3 py-1 rounded-full font-black uppercase">
                    Cuaca
                </span>
            </div>

        </div>

        <div class="p-5">

            <p class="text-white/30 text-[10px] uppercase font-black mb-2">
                18 Mei 2026
            </p>

            <h2 class="text-white text-lg font-black uppercase leading-tight mb-3">
                Waspada Kabut Tebal di Arcopodo
            </h2>

            <p class="text-white/50 text-sm leading-relaxed mb-5">
                Pendaki diminta berhati-hati karena cuaca ekstrem dan kabut tebal.
            </p>

            <a
                href="{{ url('/berita/detail/2') }}"
                class="inline-flex items-center gap-2 text-emerald-400 font-black uppercase text-xs hover:text-white transition"
            >
                Baca Selengkapnya
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </div>

    {{-- BERITA 3 --}}
    <div class="bg-[#0D1B2A] rounded-2xl overflow-hidden border border-white/5 shadow-xl card-hover fade-up delay-3">

        <div class="relative h-52 overflow-hidden">

            <img
                src="https://images.unsplash.com/photo-1522163182402-834f871fd851?auto=format&fit=crop&w=1000&q=80"
                class="w-full h-full object-cover hover:scale-110 transition duration-700"
            >

            <div class="absolute top-3 left-3">
                <span class="bg-yellow-400 text-[#0D1B2A] text-[9px] px-3 py-1 rounded-full font-black uppercase">
                    Tips
                </span>
            </div>

        </div>

        <div class="p-5">

            <p class="text-white/30 text-[10px] uppercase font-black mb-2">
                15 Mei 2026
            </p>

            <h2 class="text-white text-lg font-black uppercase leading-tight mb-3">
                Persiapan Fisik Sebelum Mendaki
            </h2>

            <p class="text-white/50 text-sm leading-relaxed mb-5">
                Berikut beberapa latihan penting sebelum melakukan summit ke Mahameru.
            </p>

            <a
                href="{{ url('/berita/detail/3') }}"
                class="inline-flex items-center gap-2 text-emerald-400 font-black uppercase text-xs hover:text-white transition"
            >
                Baca Selengkapnya
                <i class="fas fa-arrow-right"></i>
            </a>

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
