<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sibaco | Admin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('image/logo5.png') }}">

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#10B981', // Hijau
                        secondary: '#F59E0B', // Kuning
                        accent: '#F97316', // Orange
                    },
                    animation: {
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s infinite',
                    }
                }
            }
        }
    </script>

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

    <!-- Flatpickr (Date Picker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- XLSX Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .active-nav {
            background: linear-gradient(90deg, #10B981 0%, #84CC16 100%) !important;
            color: white !important;
            font-weight: 600;
            border-left: 3px solid white;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        .active-nav div {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }

        .active-nav .text-gray-700 {
            color: white !important;
        }

        .nav-item:hover {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.05) 0%, rgba(16, 185, 129, 0.02) 100%);
            transform: translateX(4px);
            transition: all 0.3s ease;
        }

        .logout-btn {
            background: linear-gradient(135deg, #10B981 0%, #0D9488 100%);
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);
        }

        @keyframes pulse-slow {

            0%,
            100% {
                transform: translateY(-50%) scale(1);
                opacity: 1;
            }

            50% {
                transform: translateY(-50%) scale(1.2);
                opacity: 0.8;
            }
        }

        /* Mobile menu styles */
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
                width: 280px;
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

            .nav-item {
                padding: 0.75rem 1rem;
            }

            .logo-container {
                padding: 1rem;
            }

            .profile-section {
                padding: 0.75rem;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) translateX(10px) rotate(180deg);
            }

            100% {
                transform: translateY(0) translateX(0) rotate(360deg);
            }
        }

        .animate-float {
            animation: float linear infinite;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Mobile menu button -->
    <button class="mobile-menu-button fixed top-4 left-4 z-30 p-2 rounded-md bg-white shadow-md md:hidden">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <!-- Overlay for mobile menu -->
    <div class="overlay"></div>

    <!-- Layout Container -->
    <div class="flex h-screen">
        <!-- Sidebar dengan gradient -->
        <aside
            class="sidebar w-64 bg-gradient-to-b from-white to-gray-50 border-r border-gray-200/50 flex flex-col shadow-lg">
            <!-- Logo Header with Animated Gradient -->
            <div
                class="logo-container relative px-6 py-4 bg-gradient-to-r from-white to-gray-50 border-b border-gray-100 flex justify-center items-center shadow-sm overflow-hidden">
                <!-- Particle Background -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="particles absolute inset-0">
                        <!-- Green Particles -->
                        <div class="absolute w-2 h-2 rounded-full bg-primary opacity-50 animate-float"
                            style="top:20%; left:15%; animation-delay:0s; animation-duration:15s"></div>
                        <div class="absolute w-3 h-3 rounded-full bg-primary opacity-45 animate-float"
                            style="top:70%; left:80%; animation-delay:2s; animation-duration:20s"></div>
                    </div>
                </div>

                <!-- Logo Content -->
                <div
                    class="group flex items-center space-x-3 hover:scale-[1.02] transition-all duration-300 relative z-10">
                    <div class="relative">
                        <img src="{{ asset('/image/baco.png') }}" alt="Sibaco Logo"
                            class="w-32 h-auto object-contain transition-all duration-300">
                        <div
                            class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-20 rounded-lg transition-opacity duration-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu Navigasi -->
            <nav class="flex-1 px-4 overflow-y-auto pt-4">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                    class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('dashboard*') ? 'active-nav' : '' }}">
                    <div
                        class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/10 to-primary/5 text-primary flex items-center justify-center group-hover:from-primary/20 group-hover:to-primary/10 transition-all">
                        <i class="fas fa-tachometer-alt text-sm"></i>
                    </div>
                    <span class="text-sm">Dashboard</span>
                    <div
                        class="ml-auto w-2 h-2 rounded-full bg-primary opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                </a>

                <!-- Manajemen Pengguna -->
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200/60"></div>
                        </div>
                        <div class="relative flex justify-left ml-2">
                            <span class="px-3 text-xs font-semibold bg-white text-gray-500 uppercase tracking-wider">
                                <span class="text-grey-900">Manajemen Pengguna</span>
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('admindatapengguna.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('admindatapengguna*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-user-friends text-sm"></i>
                        </div>
                        <span class="text-md sm:text-sm">Daftar Pengguna</span>
                    </a>

                    <a href="{{ route('adminmasakerja.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminmasakerja*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-business-time text-sm"></i>
                        </div>
                        <span class="text-md sm:text-sm">Masa Kerja</span>
                    </a>
                </div>

                <!-- Manajemen Tim -->
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200/50"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span
                                class="px-3 text-xs font-semibold bg-white text-gray-500 uppercase tracking-wider ml-2">
                                <span class="text-grey-900">Manajemen Tim</span>
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('admintimkerja.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('admintimkerja*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-user-tie text-sm"></i>
                        </div>
                        <span class="text-sm">Tim Kerja</span>
                    </a>

                    <a href="{{ route('adminanggotatim.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminanggotatim*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-user-plus text-sm"></i>
                        </div>
                        <span class="text-sm">Anggota Tim</span>
                    </a>
                </div>

                <!-- Manajemen Cuti -->
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200/50"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span
                                class="px-3 text-xs font-semibold bg-white text-gray-500 uppercase tracking-wider ml-2">
                                <span class="text-grey-900">Manajemen Cuti</span>
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('adminkalendercuti.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminkalendercuti*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-calendar-day text-sm"></i>
                        </div>
                        <span class="text-sm">Hari Libur</span>
                    </a>

                    {{-- <a href="{{ route('admindatajeniscuti.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('admindatajeniscuti*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-list-alt text-sm"></i>
                        </div>
                        <span class="text-sm">Jenis Cuti</span>
                    </a> --}}

                    <a href="{{ route('alurverifikasicuti.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('alurverifikasicuti.index') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-sitemap text-sm"></i>
                        </div>
                        <span class="text-sm">Alur Verifikasi</span>
                    </a>

                    <a href="{{ route('admindatakuotacutitahunan.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('admindatakuotacutitahunan*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-clipboard-list text-sm"></i>
                        </div>
                        <span class="text-sm">Kuota Cuti</span>
                    </a>

                    <a href="{{ route('adminpengajuancutitahunan.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminpengajuancutitahunan*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-calendar-alt text-sm"></i>
                        </div>
                        <span class="text-sm">Cuti Tahunan</span>
                    </a>

                    <a href="{{ route('adminpengajuancutiumum.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminpengajuancutiumum*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-calendar-plus text-sm"></i>
                        </div>
                        <span class="text-sm">Cuti Umum</span>
                    </a>

                    <a href="{{ route('adminperubahancuti.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminperubahancuti*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-exchange-alt text-sm"></i>
                        </div>
                        <span class="text-sm">Perubahan Cuti</span>
                    </a>

                    <a href="{{ route('adminriwayatcuti.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminriwayatcuti*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-history text-sm"></i>
                        </div>
                        <span class="text-sm">Riwayat Cuti</span>
                    </a>
                </div>

                <!-- Dokumen & Administrasi -->
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200/50"></div>
                        </div>
                        <div class="relative flex justify-left">
                            <span
                                class="px-3 text-xs font-semibold bg-white text-gray-500 uppercase tracking-wider ml-2">
                                <span class="text-grey-900">Dokumen</span>
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('adminpenomoransuratcuti.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminpenomoransuratcuti*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-file-signature text-sm"></i>
                        </div>
                        <span class="text-sm">Arsip Surat Cuti</span>
                    </a>

                    <a href="{{ route('adminkelolatandatangan.index') }}"
                        class="nav-item px-4 py-2 rounded-xl flex items-center space-x-3 text-gray-700 group {{ request()->routeIs('adminkelolatandatangan*') ? 'active-nav' : '' }}">
                        <div
                            class="w-6 h-6 rounded-lg bg-gradient-to-br from-primary/20 to-primary/10 text-primary flex items-center justify-center group-hover:from-primary/30 group-hover:to-primary/20 transition-all">
                            <i class="fas fa-signature text-sm"></i>
                        </div>
                        <span class="text-sm">Tanda Tangan</span>
                    </a>
                </div>
            </nav>

            <!-- User Profile & Logout -->
            <div class="profile-section p-4 border-t border-gray-200/50 mt-auto">
                <div
                    class="flex items-center space-x-3 mb-4 px-2 py-3 rounded-xl bg-gradient-to-r from-gray-50 to-white group">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-accent p-0.5">
                            <div
                                class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                                <span class="text-lg font-semibold text-gray-700 uppercase">
                                    {{ substr(Auth::user()->name, 0, 1) ?? 'U' }}
                                </span>
                            </div>
                        </div>
                        <span
                            class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-green-500 border-2 border-white"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full py-3 px-4 rounded-xl text-white font-medium flex items-center justify-center space-x-2 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl bg-gradient-to-r from-red-500 to-red-400 hover:from-red-600 hover:to-red-500 active:scale-95 active:shadow-inner">
                        <i class="fas fa-sign-out-alt transform group-hover:rotate-180 transition-transform"></i>
                        <span class="text-sm tracking-wide">Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden main-content">
            <main class="flex-1 overflow-y-auto px-4 sm:px-6 pb-6 bg-gray-50">
                <div
                    class="flex flex-row items-center justify-between sm:justify-start gap-3 py-2 my-4 px-4 sm:px-6 border-b border-gray-200/50">
                    <h2
                        class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary to-accent ml-2 sm:ml-0">
                        @yield('title', 'Overview')
                    </h2>
                    <p id="tanggal-sekarang"
                        class="text-sm font-medium text-primary px-3 py-1 rounded-full bg-green-100/70 border border-green-300/50">
                    </p>
                </div>
                <div class="px-2 sm:px-4 pt-0">
                    @yield('main')
                </div>
            </main>
        </div>
        @yield('scripts')
    </div>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.overlay').classList.toggle('active');
        });

        document.querySelector('.overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.overlay').classList.remove('active');
        });

        // Ambil tanggal saat ini
        const today = new Date();
        const dayOptions = {
            weekday: 'long'
        };
        const dayName = today.toLocaleDateString('id-ID', dayOptions);
        const dateOptions = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        const formattedDate = today.toLocaleDateString('id-ID', dateOptions);
        const fullDate = `${dayName}, ${formattedDate}`;
        document.getElementById('tanggal-sekarang').textContent = fullDate;
        const currentYear = today.getFullYear();
        document.getElementById('tahun-cuti').textContent = currentYear;
    </script>
</body>

</html>
