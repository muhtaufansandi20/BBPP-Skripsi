<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sibaco | Pegawai</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('image/logo5.png') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981',
                        secondary: '#F59E0B',
                        accent: '#F97316',
                        highlight: '#BFFB78',
                    },
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s infinite',
                    }
                }
            }
        }
    </script>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .mobile-menu-button {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-menu-button {
                display: block;
            }

            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                bottom: 0;
                z-index: 50;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                display: none;
            }

            .overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Mobile menu button -->
    <button class="mobile-menu-button fixed top-4 left-4 z-30 p-2 rounded-md bg-white shadow-md md:hidden">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <!-- Overlay for mobile menu -->
    <div class="overlay"></div>

    <!-- Layout Container -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-64 bg-white border-r border-gray-100 flex flex-col select-none z-50">
            <!-- 1. Header Logo & Role -->
            <div class="px-6 pt-6 pb-2 flex flex-col items-center text-center">
                <div class="flex items-center justify-center">
                    <img src="{{ asset('/image/baco.png') }}" alt="Sibaco Logo" class="w-36 h-auto object-contain">
                </div>

                <div class="mt-3 flex flex-col items-center w-full">
                    <span class="text-xs font-semibold text-gray-700">Pegawai</span>
                    <div class="w-24 h-0.5 mt-1.5 rounded-full bg-gradient-to-r from-teal-400 via-emerald-400 to-amber-300"></div>
                </div>
            </div>

            <!-- 2. Menu Navigasi -->
            <nav class="flex-1 px-4 space-y-5 overflow-y-auto mt-3">
                <!-- Dashboard Button -->
                <div>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-3 py-2.5 rounded-2xl {{ request()->routeIs('dashboard*') ? 'bg-gradient-to-r from-[#00c58e] to-[#6fc43a] text-white font-semibold shadow-md shadow-emerald-500/20' : 'text-gray-600 hover:bg-gray-50' }} transition-all">
                        <div class="w-7 h-7 rounded-full {{ request()->routeIs('dashboard*') ? 'bg-white/20 text-white' : 'bg-[#e6fcf5] text-[#00c58e]' }} flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-globe text-sm"></i>
                        </div>
                        <span class="text-sm font-medium tracking-wide">Dashboard</span>
                    </a>
                </div>

                <!-- Section Pengajuan -->
                <div>
                    <div class="flex items-center space-x-2 mb-2.5 px-2">
                        <span class="text-[11px] font-bold tracking-wider text-emerald-600 uppercase">PENGAJUAN</span>
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </div>

                    <div class="space-y-1.5">
                        <!-- Cuti Tahunan -->
                        <a href="{{ route('userpengajuancutitahunan.index') }}"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-2xl {{ request()->routeIs('userpengajuancutitahunan*') ? 'bg-gradient-to-r from-[#00c58e] to-[#6fc43a] text-white font-semibold shadow-md shadow-emerald-500/20' : 'text-gray-600 hover:bg-gray-50' }} transition-all">
                            <div class="w-7 h-7 rounded-lg {{ request()->routeIs('userpengajuancutitahunan*') ? 'bg-white/20 text-white' : 'bg-[#e6fcf5] text-[#00c58e]' }} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-alt text-xs"></i>
                            </div>
                            <span class="text-sm font-medium">Cuti Tahunan</span>
                        </a>

                        <!-- Cuti Khusus -->
                        <a href="{{ route('userpengajuancutiumum.index') }}"
                            class="flex items-center space-x-3 px-3 py-2.5 rounded-2xl {{ request()->routeIs('userpengajuancutiumum*') ? 'bg-gradient-to-r from-[#00c58e] to-[#6fc43a] text-white font-semibold shadow-md shadow-emerald-500/20' : 'text-gray-600 hover:bg-gray-50' }} transition-all">
                            <div class="w-7 h-7 rounded-lg {{ request()->routeIs('userpengajuancutiumum*') ? 'bg-white/20 text-white' : 'bg-[#e6fcf5] text-[#00c58e]' }} flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-calendar-plus text-xs"></i>
                            </div>
                            <span class="text-sm font-medium">Cuti Umum</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- 3. Profil & Tombol Logout -->
            <div class="p-4 border-t border-gray-100 mt-auto">
                <div class="flex items-center space-x-3 mb-4 px-1">
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-full p-[2px] bg-gradient-to-tr from-amber-400 via-lime-400 to-emerald-400 flex items-center justify-center">
                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center font-bold text-gray-800 text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate" title="{{ Auth::user()->name }}">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-[10px] text-gray-400 truncate mt-0.5">
                            {{ Auth::user()->jabatan ?? 'Penelaah Teknis Kebijakan' }}
                        </p>
                    </div>
                </div>

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-2.5 px-4 rounded-xl text-white font-medium flex items-center justify-center space-x-2 transition-all bg-gradient-to-r from-[#ff3b5c] to-[#f82b4a] hover:opacity-95 active:scale-95 shadow-md shadow-red-500/20 text-sm">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden main-content">
            <main class="flex-1 overflow-y-auto px-4 sm:px-6 pb-6 bg-gray-50">
                <div class="flex flex-row items-center justify-between sm:justify-start gap-3 py-2 my-4 px-4 sm:px-6 border-b border-gray-200/50">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent ml-2 sm:ml-0">
                        @yield('title', 'Overview')
                    </h2>
                    <p id="tanggal-sekarang" class="text-sm font-medium text-yellow-800 px-3 py-1 rounded-full bg-yellow-100/70 border border-yellow-300/50">
                    </p>
                </div>
                <div class="px-2 sm:px-4 pt-2">
                    @yield('main')
                </div>
            </main>
        </div>
        @stack('scripts')
    </div>

    <script>
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        });

        document.querySelector('.overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.overlay').classList.remove('active');
        });

        const today = new Date();
        const fullDate = `${today.toLocaleDateString('id-ID', { weekday: 'long' })}, ${today.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}`;
        const tanggalEl = document.getElementById('tanggal-sekarang');
        if (tanggalEl) tanggalEl.textContent = fullDate;
    </script>
</body>

</html>