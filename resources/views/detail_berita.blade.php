@extends('Layout.Guest')

@section('title', 'Mahameru Digital - Detail Berita')

{{-- Subtitle dinamis, mengambil dari data yang dikirim --}}
@section('header-subtitle')
    {{ $kategori }} • {{ $tanggal }}
@endsection

@section('header-title')
    {{ $slug_judul }}
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8 fade-up delay-1">

    {{-- Tombol Kembali --}}
    <div class="flex items-center justify-between">
        <a href="javascript:history.back()" class="text-white/60 hover:text-emerald-400 text-xs font-black uppercase tracking-widest transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <span class="text-white/30 text-[10px] font-bold uppercase tracking-wider">Oleh: {{ $penulis }}</span>
    </div>

    {{-- Artikel Utama --}}
    <article class="bg-[#0D1B2A] rounded-2xl overflow-hidden border border-white/5 shadow-2xl p-8 space-y-6">

        {{-- Gambar Utama Berita --}}
        <div class="w-full h-[400px] rounded-xl overflow-hidden border border-white/10 shadow-inner">
            <img src="{{ $gambar }}" class="w-full h-full object-cover" alt="Detail Berita">
        </div>

        {{-- Isi Konten Berita --}}
        <div class="text-white/80 leading-relaxed space-y-4 text-sm md:text-base">
            <p class="font-bold text-emerald-400 border-l-4 border-emerald-400 pl-4 italic text-base md:text-lg">
                "{{ $kutipan }}"
            </p>

            {{-- Isi teks berita (Dummy yang disesuaikan dengan konteks) --}}
            <p class="pt-2">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            </p>
            <p>
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
            </p>
            <p>
                Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
            </p>
        </div>

    </article>

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
