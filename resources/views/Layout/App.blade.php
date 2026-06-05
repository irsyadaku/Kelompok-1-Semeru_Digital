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
    </style>
    @stack('styles')
</head>

<body class="bg-[#1B263B] pt-10">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 w-full h-10 bg-black/20 z-50 flex items-center justify-between px-6 border-b border-white/10 backdrop-blur-sm">
        {{-- Logo Cerdas: Deteksi Rute Dashboard Sesuai Role --}}
        <a href="{{ (Auth::check() && Auth::user()->role === 'admin') ? route('admin.dashboard') : '/dashboard' }}" class="flex items-center gap-2 group">
            <img src="{{ asset('mountain.png') }}" alt="Logo" class="h-6 w-6 object-contain brightness-0 invert transition-transform group-hover:scale-110">
            <span class="text-white text-xs font-black uppercase tracking-widest italic group-hover:text-emerald-400 transition-colors">Mahameru</span>
        </a>

        <div class="flex items-center gap-4">
            <span class="text-emerald-400 font-black uppercase text-[10px] tracking-widest border-r border-white/10 pr-4 hidden md:block">
                Yang Mulia {{ Auth::user()->username ?? 'User' }}
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
        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-black/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-400/10 border-2 border-emerald-400/30 flex items-center justify-center">
                    <i class="fas fa-user text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-emerald-400 text-[9px] font-black uppercase tracking-[0.2em]">{{ ucfirst(Auth::user()->role ?? 'User') }}</p>
                    <p class="text-white font-bold text-sm">Yang Mulia {{ Auth::user()->username ?? 'User' }}</p>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="text-white/40 hover:text-white transition"><i class="fas fa-times text-xl"></i></button>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 custom-scrollbar space-y-6">
            <div class="px-2 space-y-1">
                <p class="text-white/20 text-[9px] font-black uppercase tracking-widest px-3 mb-2">Menu Utama</p>

                {{-- LOGIKA MENU BERDASARKAN ROLE --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    {{-- MENU KHUSUS ADMIN --}}
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-th-large text-emerald-400 w-5"></i> Singgasana Admin
                    </a>
                  <a href="{{ route('admin.metode_pembayaran') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
    <i class="fas fa-wallet text-emerald-400 w-5"></i> Metode Pembayaran
</a>
                    <a href="{{ route('admin.booking') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
     <i class="fas fa-file-alt text-emerald-400 w-5"></i> Daftar Riwayat
</a>
                   <a href="{{ route('admin.verifikasi') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
    <i class="fas fa-check-double text-emerald-400 w-5"></i> Validasi Tiket
</a>
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-user-shield text-emerald-400 w-5"></i> Lihat Profil Admin
                    </a>
                @else
                    {{-- MENU KHUSUS PENDAKI --}}
                    <a href="/dashboard" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-th-large text-emerald-400 w-5"></i> Dashboard
                    </a>
                    <a href="{{ route('booking.index') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-ticket-alt text-emerald-400 w-5"></i> Booking Tiket
                    </a>
                    <a href="{{ route('riwayat.transaksi') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-clock-rotate-left text-emerald-400 w-5"></i> Riwayat Transaksi
                    </a>
                    <a href="{{ route('profile.index') }}" class="flex items-center gap-3 text-white/70 hover:text-white hover:bg-white/5 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-id-card text-emerald-400 w-5"></i> Lihat Profil
                    </a>
                @endif
            </div>

            <div class="mx-4 p-4 border-t border-white/5">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 text-red-400 hover:bg-red-400/10 px-3 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition">
                        <i class="fas fa-right-from-bracket w-5"></i> Keluar
                    </button>
                </form>
            </div>
        </nav>
    </div>

    {{-- HERO --}}
    <header class="w-full bg-black h-44 flex items-center justify-center overflow-hidden relative border-b-4 border-emerald-400">
        <img src="{{ asset('Gunung Slamet - Gunung Slamet added a new photo_.jpg') }}" class="absolute inset-0 w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-t from-[#0D1B2A] via-[#0D1B2A]/40 to-transparent"></div>
        <div class="relative z-10 text-center px-4">
            <p class="text-emerald-400 font-black uppercase tracking-[0.3em] text-[10px] mb-2">@yield('header-subtitle', 'Mahameru Digital Portal')</p>
            <h2 class="text-white text-3xl font-black italic tracking-tighter uppercase drop-shadow-lg">@yield('header-title', 'DASHBOARD')</h2>
        </div>
    </header>

    {{-- TICKER --}}
    <div class="bg-[#1a1a1a] text-white py-2.5 px-10 border-b border-gray-800">
        <div class="max-w-7xl mx-auto flex items-center gap-4 no-scrollbar">
            <span class="bg-emerald-400 text-[10px] font-black px-2.5 py-1 rounded italic uppercase text-[#0D1B2A] whitespace-nowrap">Info:</span>
            <marquee class="text-xs font-bold tracking-wide">Status Kuota: Masih Tersedia &nbsp;|&nbsp; Harap cek riwayat transaksi Anda secara berkala.</marquee>
        </div>
    </div>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-10 py-10">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0D1B2A] py-12 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-10 text-center">
            <p class="text-white/10 text-[9px] font-black uppercase tracking-[0.3em]">&copy; 2026 SEMERU DIGITAL PORTAL</p>
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
    </script>
    @stack('scripts')
</body>
</html>
