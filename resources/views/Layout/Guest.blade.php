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
        body {
            font-family: 'Roboto', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }
    </style>

    {{-- STYLE TAMBAHAN --}}
    @stack('styles')

</head>

<body class="bg-[#1B263B] pt-10">

    {{-- NAVBAR --}}
    <nav class="fixed top-0 left-0 w-full h-10 bg-black/20 z-50 flex items-center justify-between px-6 border-b border-white/10 backdrop-blur-sm">

        <a href="/" class="flex items-center gap-2 group">
            <img
                src="{{ asset('mountain.png') }}"
                alt="Logo"
                class="h-6 w-6 object-contain brightness-0 invert transition-transform group-hover:scale-110"
            >

            <span class="text-white text-xs font-black uppercase tracking-widest italic group-hover:text-emerald-400 transition-colors">
                Mahameru
            </span>
        </a>

        <div class="flex items-center gap-4">

            <div class="flex gap-2 text-white font-bold uppercase text-[10px] tracking-widest border-r border-white/10 pr-4">

                <a
                    href="/login"
                    class="{{ request()->is('login') ? 'text-emerald-400' : 'hover:text-emerald-400' }} transition"
                >
                    Masuk
                </a>

                <span class="text-white/30">/</span>

                <a
                    href="/register"
                    class="{{ request()->is('register') ? 'text-emerald-400' : 'text-white/60 hover:text-emerald-400' }} transition"
                >
                    Daftar
                </a>

            </div>

            <button onclick="toggleSidebar()" class="group flex items-center focus:outline-none">
                <img
                    src="{{ asset('menus.png') }}"
                    alt="Menu"
                    class="h-6 w-6 object-contain brightness-0 invert transition-transform group-hover:scale-110"
                >
            </button>

        </div>

    </nav>

    {{-- SIDEBAR OVERLAY --}}
    <div
        id="sidebarOverlay"
        onclick="toggleSidebar()"
        class="fixed inset-0 bg-black/60 z-[60] hidden backdrop-blur-sm"
    ></div>

    {{-- SIDEBAR --}}
    <div
        id="profileSidebar"
        class="fixed top-0 right-0 h-full w-80 bg-[#1B263B] z-[70] translate-x-full transition-transform duration-300 ease-in-out shadow-2xl border-l border-white/10 flex flex-col"
    >

        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-black/20">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-white/5 border-2 border-white/10 flex items-center justify-center">
                    <i class="fas fa-user text-white/30 text-lg"></i>
                </div>

                <div>
                    <p class="text-white/30 text-[9px] font-black uppercase tracking-[0.2em]">
                        Tamu
                    </p>

                    <p class="text-white font-bold text-sm">
                        Halo, Pendaki!
                    </p>
                </div>

            </div>

            <button onclick="toggleSidebar()" class="text-white/40 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>

        </div>

        <nav class="flex-1 overflow-y-auto p-4 custom-scrollbar">

            <div class="mx-4 mt-4 mb-6 p-4 bg-emerald-400/5 border border-emerald-400/20 rounded-xl text-center">

                <p class="text-white/40 text-[9px] font-bold uppercase mb-3">
                    Login untuk akses penuh
                </p>

                <a
                    href="/login"
                    class="block w-full bg-emerald-400 text-[#0D1B2A] font-black py-2 rounded-lg uppercase text-[10px] mb-2 hover:bg-white transition"
                >
                    <i class="fas fa-right-to-bracket mr-1"></i>
                    Masuk
                </a>

                <a
                    href="/register"
                    class="block w-full bg-white/5 border border-white/10 text-white/60 font-black py-2 rounded-lg uppercase text-[10px] hover:bg-white/10 transition"
                >
                    Daftar Akun Baru
                </a>

            </div>

        </nav>

    </div>

    {{-- HERO --}}
    <header class="w-full bg-black h-64 flex items-center justify-center overflow-hidden relative border-b-4 border-emerald-400">

        <img
            src="{{ asset('Gunung Slamet - Gunung Slamet added a new photo_.jpg') }}"
            class="absolute inset-0 w-full h-full object-cover opacity-60"
        >

        <div class="absolute inset-0 bg-gradient-to-t from-[#0D1B2A] via-[#0D1B2A]/30 to-transparent"></div>

        <div class="relative z-10 text-center px-4">

            <p class="text-emerald-400 font-black uppercase tracking-[0.3em] text-[10px] mb-2">
                @yield('header-subtitle', 'Laman Informatif Pendakian Gunung Semeru')
            </p>

            <h2 class="text-white text-4xl font-black italic tracking-tighter uppercase drop-shadow-lg">
                 @yield('header-title', 'MAHAMERU <span class="text-emerald-400">3676 MDPL</span>')
            </h2>

            @hasSection('header-desc')
                <p class="text-white/50 font-bold uppercase tracking-widest text-[10px] mt-2">
                    @yield('header-desc')
                </p>
            @endif

            @hasSection('header-search')
                <div class="max-w-xl relative mt-6 mx-auto">
                    @yield('header-search')
                </div>
            @endif

        </div>

    </header>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-10 py-10">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#0D1B2A] py-12 border-t border-white/5">

        <div class="max-w-7xl mx-auto px-10">

            <div class="border-t border-white/5 pt-6 text-center">
                <p class="text-white/10 text-[9px] font-black uppercase tracking-[0.3em]">
                    &copy; 2026 SEMERU DIGITAL PORTAL
                </p>
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
    </script>

    {{-- SCRIPT TAMBAHAN --}}
    @stack('scripts')

</body>
</html>
