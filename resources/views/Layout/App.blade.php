<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mahameru Digital')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        @yield('styles')
    </style>
</head>
<body class="bg-[#1B263B] pt-10">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 w-full h-10 bg-black/20 z-50 flex items-center justify-between px-6 border-b border-white/10 backdrop-blur-sm">
        <a href="/dashboard" class="flex items-center gap-2 group">
            <img src="{{ asset('mountain.png') }}" alt="Logo" class="h-6 w-6 object-contain brightness-0 invert transition-transform group-hover:scale-110">
            <span class="text-white text-xs font-black uppercase tracking-widest italic group-hover:text-emerald-400 transition-colors">Mahameru</span>
        </a>
        <div class="flex items-center gap-4">
            <span class="text-emerald-400 font-black uppercase text-[10px] tracking-widest border-r border-white/10 pr-4 hidden md:block">
                Yang Mulia {{ Auth::user()->username }}
            </span>
            <button onclick="toggleSidebar()" class="group flex items-center focus:outline-none">
                <img src="{{ asset('menus.png') }}" alt="Menu" class="h-6 w-6 object-contain brightness-0 invert transition-transform group-hover:scale-110">
            </button>
        </div>
    </nav>

    {{-- SIDEBAR OVERLAY --}}
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 z-[60] hidden backdrop-blur-sm"></div>

    {{-- SIDEBAR --}}
    <div id="profileSidebar" class="fixed top-0 right-0 h-full w-80 bg-[#1B263B] z-[70] translate-x-full transition-transform duration-300 ease-in-out shadow-2xl border-l border-white/10 flex flex-col">
        {{-- Header Sidebar --}}
        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-black/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-400/10 border-2 border-emerald-400/30 flex items-center justify-center">
                    <i class="fas fa-user text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-emerald-400 text-[9px] font-black uppercase tracking-[0.2em]">{{ ucfirst(Auth::user()->role) }}</p>
                    <p class="text-white font-bold text-sm tracking-tight">Yang Mulia {{ Auth::user()->username }}</p>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="text-white/40 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 custom-scrollbar">
            <p class="text-[10px] font-black text-white/30 uppercase px-4 mt-4 mb-2 tracking-[0.2em]">Menu Utama</p>
            <div class="space-y-1">
                <a href="/dashboard" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('dashboard') ? 'bg-emerald-400 text-[#0D1B2A] font-black' : 'text-white/70 hover:bg-emerald-400 hover:text-[#0D1B2A] font-bold' }} transition-all text-xs uppercase tracking-tighter">
                    <i class="fas fa-th-large text-lg"></i> Dashboard
                </a>
                <a href="/profile" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('profile') ? 'bg-emerald-400 text-[#0D1B2A] font-black' : 'text-white/70 hover:bg-emerald-400 hover:text-[#0D1B2A] font-bold' }} transition-all text-xs uppercase tracking-tighter">
                    <i class="fas fa-id-card text-lg"></i> Lihat Profil
                </a>
                <a href="/pendaftaran" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('pendaftaran') ? 'bg-emerald-400 text-[#0D1B2A] font-black' : 'text-white/70 hover:bg-emerald-400 hover:text-[#0D1B2A] font-bold' }} transition-all text-xs uppercase tracking-tighter">
                    <i class="fas fa-ticket-alt text-lg"></i> Pendaftaran Tiket
                </a>
                <a href="/riwayat" class="flex items-center gap-4 px-4 py-3 rounded-xl {{ request()->is('riwayat') ? 'bg-emerald-400 text-[#0D1B2A] font-black' : 'text-white/70 hover:bg-emerald-400 hover:text-[#0D1B2A] font-bold' }} transition-all text-xs uppercase tracking-tighter">
                    <i class="fas fa-clock-rotate-left text-lg"></i> Riwayat Transaksi
                </a>
            </div>

            <div class="h-px bg-white/5 my-6 mx-4"></div>

            <p class="text-[10px] font-black text-white/30 uppercase px-4 mb-2 tracking-[0.2em]">Jelajahi</p>
            <div class="space-y-1">
                <a href="{{ route('DaftarBerita') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-white/70 hover:bg-white/5 transition-all font-bold text-xs uppercase tracking-tighter">
                    <i class="fas fa-newspaper text-lg opacity-50"></i> Daftar Berita
                </a>
                <a href="{{ route('AlurBooking') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-white/70 hover:bg-white/5 transition-all font-bold text-xs uppercase tracking-tighter">
                    <i class="fas fa-route text-lg opacity-50"></i> Alur Booking
                </a>
                <a href="{{ route('Tips') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl text-white/70 hover:bg-white/5 transition-all font-bold text-xs uppercase tracking-tighter">
                    <i class="fas fa-person-hiking text-lg opacity-50"></i> Tips Mendaki
                </a>
            </div>

            <div class="h-px bg-white/5 my-6 mx-4"></div>

            <div class="px-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-xl text-red-400 hover:bg-red-400/10 transition-all font-bold text-xs uppercase tracking-tighter border border-red-400/20">
                        <i class="fas fa-right-from-bracket text-lg"></i> Keluar
                    </button>
                </form>
            </div>
        </nav>
    </div>

    {{-- HERO HEADER --}}
    <header class="w-full bg-black h-44 flex items-center justify-center overflow-hidden relative border-b-4 border-emerald-400">
        <img src="{{ asset('Gunung Slamet - Gunung Slamet added a new photo_.jpg') }}"
             class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0D1B2A] via-[#0D1B2A]/40 to-transparent"></div>
        <div class="relative z-10 text-center px-4">
            <p class="text-emerald-400 font-black uppercase tracking-[0.3em] text-[10px] mb-2">
                @yield('header-subtitle', 'Mahameru Digital')
            </p>
            <h2 class="text-white text-3xl font-black italic tracking-tighter uppercase drop-shadow-lg">
                {@yield('header-title', 'SELAMAT DATANG')}
            </h2>
            @hasSection('header-desc')
                <p class="text-white/50 font-bold uppercase tracking-widest text-[10px] mt-2">@yield('header-desc')</p>
            @endif
        </div>
    </header>

    {{-- TICKER --}}
    <div class="bg-[#1a1a1a] text-white py-2.5 px-10 border-b border-gray-800">
        <div class="max-w-7xl mx-auto flex items-center gap-4 no-scrollbar">
            <span class="bg-emerald-400 text-[10px] font-black px-2.5 py-1 rounded italic uppercase text-[#0D1B2A] whitespace-nowrap">Info:</span>
            <marquee class="text-xs font-bold tracking-wide">Update Kuota: Jalur Ranupani untuk tanggal 20 Mei tersisa 15 Slot! &nbsp;|&nbsp; Status Gunung Semeru: Waspada Level II</marquee>
        </div>
    </div>

    {{-- QUICK MENU --}}
    <section class="bg-[#1B263B] py-4 px-10 shadow-lg border-b border-white/5">
        <div class="max-w-7xl mx-auto flex gap-3 overflow-x-auto pb-1 no-scrollbar">
            <a href="/dashboard" class="@if(request()->is('dashboard')) bg-emerald-400 text-[#0D1B2A] @else bg-emerald-400/20 text-emerald-400 border border-emerald-400/30 hover:bg-emerald-400 hover:text-[#0D1B2A] @endif px-5 py-2 rounded-full font-black text-[10px] whitespace-nowrap uppercase tracking-tighter transition-all">
                <i class="fas fa-th-large mr-1"></i> Dashboard
            </a>
            <a href="/pendaftaran" class="@if(request()->is('pendaftaran')) bg-emerald-400 text-[#0D1B2A] @else bg-emerald-400/20 text-emerald-400 border border-emerald-400/30 hover:bg-emerald-400 hover:text-[#0D1B2A] @endif px-5 py-2 rounded-full font-black text-[10px] whitespace-nowrap uppercase tracking-tighter transition-all">
                <i class="fas fa-ticket-alt mr-1"></i> Booking Tiket
            </a>
            <a href="/riwayat" class="@if(request()->is('riwayat')) bg-emerald-400 text-[#0D1B2A] @else bg-emerald-400/20 text-emerald-400 border border-emerald-400/30 hover:bg-emerald-400 hover:text-[#0D1B2A] @endif px-5 py-2 rounded-full font-black text-[10px] whitespace-nowrap uppercase tracking-tighter transition-all">
                <i class="fas fa-clock-rotate-left mr-1"></i> Riwayat
            </a>
            <a href="/profile" class="@if(request()->is('profile')) bg-emerald-400 text-[#0D1B2A] @else bg-emerald-400/20 text-emerald-400 border border-emerald-400/30 hover:bg-emerald-400 hover:text-[#0D1B2A] @endif px-5 py-2 rounded-full font-black text-[10px] whitespace-nowrap uppercase tracking-tighter transition-all">
                <i class="fas fa-user mr-1"></i> Profil
            </a>
            <a href="{{ route('DaftarBerita') }}" class="@if(request()->is('berita*')) bg-emerald-400 text-[#0D1B2A] @else bg-emerald-400/20 text-emerald-400 border border-emerald-400/30 hover:bg-emerald-400 hover:text-[#0D1B2A] @endif px-5 py-2 rounded-full font-black text-[10px] whitespace-nowrap uppercase tracking-tighter transition-all">
                <i class="fas fa-newspaper mr-1"></i> Berita
            </a>
        </div>
    </section>

    {{-- KONTEN --}}
    <main class="max-w-7xl mx-auto px-10 py-10">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0D1B2A] py-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('mountain.png') }}" alt="Logo" class="h-5 w-5 object-contain brightness-0 invert opacity-30">
                    <span class="text-white/20 text-[10px] font-black uppercase tracking-widest italic">Mahameru Digital</span>
                </div>
                <div class="flex gap-6">
                    <a href="{{ route('DaftarBerita') }}" class="text-white/20 hover:text-emerald-400 text-[10px] font-bold uppercase transition">Berita</a>
                    <a href="{{ route('AlurBooking') }}" class="text-white/20 hover:text-emerald-400 text-[10px] font-bold uppercase transition">Alur Booking</a>
                    <a href="{{ route('Tips') }}" class="text-white/20 hover:text-emerald-400 text-[10px] font-bold uppercase transition">Tips</a>
                </div>
                <p class="text-white/10 text-[9px] font-black uppercase tracking-[0.2em]">&copy; 2026 SEMERU DIGITAL PORTAL</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('profileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar.classList.contains('translate-x-full')) {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            }
        }
        @yield('scripts')
    </script>
</body>
</html>
