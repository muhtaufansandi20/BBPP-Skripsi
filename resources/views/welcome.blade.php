<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>Sibaco - Sistem Cuti Online</title>

        <link rel="icon" type="image/png" sizes="64x64" href="{{ asset('image/logo5.png') }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#10B981',  // Hijau
                            secondary: '#F59E0B', // Kuning
                            accent: '#F97316',    // Orange
                            highlight: '#BFFB78', // Warna highlight
                        },
                        animation: {
                            'bounce-slow': 'bounce 3s infinite',
                            'pulse-slow': 'pulse 4s infinite',
                        }
                    }
                }
            }
        </script>

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                scroll-behavior: smooth;
            }
            
            .bg-hero {
                background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/image/bbpp.jpg');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            
            .feature-card:hover .feature-icon {
                transform: rotateY(180deg) scale(1.1);
            }
            
            .feature-icon {
                transition: transform 0.5s ease;
            }
            html, body {
                overflow-x: hidden;
                max-width: 100%;
                width: 100%;
            }

            .container, .mx-auto {
                max-width: 100%;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            img, svg, video {
                max-width: 100%;
                height: auto;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-50">
        <!-- Navbar -->
        <nav class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo with smoother hover effect -->
                    <div class="flex items-center">
                        <a href="#" class="relative group">
                            <img src="{{ asset('/image/baco.png') }}" alt="Sibaco Logo" 
                                class="w-36 h-auto object-contain transition-all duration-300 group-hover:opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-emerald-500/10 opacity-0 group-hover:opacity-100 rounded-lg transition-opacity duration-500"></div>
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="relative text-gray-700 hover:text-primary transition duration-300 font-medium group">
                            Beranda
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="#features" class="relative text-gray-700 hover:text-primary transition duration-300 font-medium group">
                            Fitur
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="#benefits" class="relative text-gray-700 hover:text-primary transition duration-300 font-medium group">
                            Manfaat
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="#download" class="relative text-gray-700 hover:text-primary transition duration-300 font-medium group">
                            Panduan
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 rounded-lg bg-gradient-to-r from-primary to-emerald-600 text-white hover:from-primary/90 hover:to-emerald-600/90 transition-all duration-300 transform hover:scale-[1.03] shadow-md hover:shadow-lg font-medium flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                    </svg>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-primary to-emerald-600 text-white hover:from-primary/90 hover:to-emerald-600/90 transition-all duration-300 transform hover:scale-[1.03] shadow-md hover:shadow-lg font-medium">
                                    Masuk
                                </a>
                            @endauth
                        @endif
                    </div>
                    
                    <!-- Mobile menu button with animation -->
                    <div class="md:hidden">
                        <button class="outline-none mobile-menu-button p-2 rounded-lg hover:bg-gray-100/50 transition-all duration-300">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Menu with better animation -->
                <div class="hidden mobile-menu">
                    <div class="flex flex-col mt-4 space-y-3 pb-3">
                        <a href="#" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-800 hover:bg-gray-100/50 transition-all duration-300">Beranda</a>
                        <a href="#features" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-800 hover:bg-gray-100/50 transition-all duration-300">Fitur</a>
                        <a href="#benefits" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-800 hover:bg-gray-100/50 transition-all duration-300">Manfaat</a>
                        <a href="#download" class="block px-4 py-3 rounded-lg text-base font-medium text-gray-800 hover:bg-gray-100/50 transition-all duration-300">Panduan</a>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-white bg-gradient-to-r from-primary to-emerald-600 hover:from-primary/90 hover:to-emerald-600/90 transition-all duration-300 text-center">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-base font-medium text-white bg-gradient-to-r from-primary to-emerald-600 hover:from-primary/90 hover:to-emerald-600/90 transition-all duration-300 text-center">
                                    Masuk
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-hero text-white py-16 md:py-24 px-4 md:px-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">Kelola Cuti Pegawai <br> dengan <span class="text-highlight">Mudah</span></h1>
                {{-- <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Sibaco memberikan solusi digital untuk manajemen cuti pegawai yang efisien, transparan, dan terintegrasi.</p> --}}
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto pb-5">Sibaco merupakan sistem pengajuan cuti online BBPP Batangkaluku yang dirancang sebagai solusi digital manajemen cuti</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ Route::has('register') ? route('register') : '#' }}" class="bg-primary px-8 py-4 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 hover:bg-emerald-600 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Mulai Sekarang
                    </a>
                    {{-- <a href="#features" class="bg-secondary px-8 py-3 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 hover:bg-amber-600 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        Pelajari Fitur
                    </a> --}}
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 px-4 md:px-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Fitur <span class="text-primary">Unggulan</span> Sibaco</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Sibaco dilengkapi dengan berbagai fitur canggih untuk memudahkan pengelolaan cuti pegawai.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 feature-card">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-6 mx-auto feature-icon">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Pengajuan Online</h3>
                        <p class="text-gray-600 text-center">pegawai dapat mengajukan cuti secara online kapan saja dan di mana saja melalui sistem yang terintegrasi.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 feature-card">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-6 mx-auto feature-icon">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Persetujuan Multi-Level</h3>
                        <p class="text-gray-600 text-center">Sistem persetujuan bertingkat sesuai struktur organisasi dengan status pengajuan real-time.</p>
                    </div>
                    
                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 feature-card">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-6 mx-auto feature-icon">
                            <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Manajemen Kuota Cuti</h3>
                        <p class="text-gray-600 text-center">Otomatis menghitung sisa hak cuti pegawai berdasarkan kebijakan perusahaan.</p>
                    </div>
                    
                    <!-- Feature 4 - Multi-User Roles -->
                    <div class="bg-white p-8 rounded-xl shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 feature-card">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mb-6 mx-auto feature-icon">
                            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">6 Level Pengguna</h3>
                        <p class="text-gray-600 text-center">Sistem mendukung 6 jenis pengguna: Admin, Pegawai, Widyaiswara, Kepala Tim Kerja, Kepala Bagian, dan Kepala Balai dengan hak akses berbeda.</p>
                    </div>

                    <!-- Feature 5 - Multi-Device Access -->
                    <div class="bg-white p-8 rounded-xl shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 feature-card">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mb-6 mx-auto feature-icon">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Akses Multi-Perangkat</h3>
                        <p class="text-gray-600 text-center">Dapat diakses di semua perangkat termasuk smartphone, tablet, dan komputer dengan tampilan yang responsif.</p>
                    </div>
                    
                    <!-- Feature 6 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg transition duration-300 hover:-translate-y-2 hover:shadow-xl border border-gray-100 feature-card">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-6 mx-auto feature-icon">
                            <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3 text-center">Laporan Lengkap</h3>
                        <p class="text-gray-600 text-center">Generasi laporan cuti pegawai dalam berbagai format (PDF, Excel) dengan data yang komprehensif.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section id="benefits" class="py-16 bg-gray-50 px-4 md:px-16">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Manfaat Menggunakan <span class="text-primary">Sibaco</span></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Tingkatkan efisiensi pengelolaan cuti pegawai dengan solusi digital dari Sibaco.</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="mb-8 flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary text-white shadow-md">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Efisiensi Waktu</h3>
                                <p class="text-gray-600">Proses pengajuan dan persetujuan cuti yang lebih cepat tanpa dokumen fisik.</p>
                            </div>
                        </div>
                        
                        <div class="mb-8 flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-secondary text-white shadow-md">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Transparansi</h3>
                                <p class="text-gray-600">Setiap pegawai dapat memantau status pengajuan cuti mereka secara real-time.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-accent text-white shadow-md">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">Penghematan Biaya</h3>
                                <p class="text-gray-600">Mengurangi biaya administrasi dan penyimpanan dokumen fisik.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="bg-white p-8 rounded-xl shadow-lg transform transition duration-500 hover:scale-102">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Manfaat Sibaco" class="rounded-lg w-full h-auto shadow-md">
                        </div>
                        <div class="absolute -bottom-6 -right-6 bg-primary text-white p-6 rounded-lg shadow-lg hidden lg:block transform transition duration-500 hover:scale-110">
                            <h3 class="text-xl font-bold mb-2">+85%</h3>
                            <p class="text-sm">Peningkatan Efisiensi</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-gradient-to-r from-primary to-emerald-600 text-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Aplikasi Resmi Pengajuan Cuti BBPP Batangkaluku</h2>
                <p class="text-xl mb-8 max-w-3xl mx-auto">SIBACO (Sistem Baatangkaluku Cuti Online) khusus untuk Pegawai BBPP Batangkaluku.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white text-primary px-8 py-3 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 hover:bg-gray-100 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                </svg>
                                Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-white text-primary px-8 py-3 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 hover:bg-gray-100 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Login Pegawai
                            </a>
                        @endauth
                    @endif
                    <a href="https://bbppbatangkaluku2.bppsdmp.pertanian.go.id/" target="_blank" class="border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold transition duration-300 transform hover:scale-105 hover:bg-white hover:bg-opacity-10 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                        </svg>
                        Website BBPP BK
                    </a>
                </div>
                <p class="mt-6 text-sm opacity-80">*Hanya untuk pegawai aktif BBPP Batangkaluku</p>
            </div>
        </section>

        <!-- Download Section -->
        {{-- <section id="download" class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Panduan <span class="text-primary">Penggunaan</span></h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">Download panduan lengkap penggunaan sistem Sibaco untuk administrator dan pegawai.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-emerald-100 mb-6 mx-auto">
                            <svg class="h-10 w-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-center text-gray-800 mb-4">Panduan Administrator</h3>
                        <p class="text-gray-600 text-center mb-6">Petunjuk lengkap untuk mengelola sistem cuti bagi tim HRD dan administrator.</p>
                        <a href="#" class="block w-full bg-primary hover:bg-emerald-600 text-white text-center py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download PDF
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 p-8 rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-1 border border-gray-200">
                        <div class="flex items-center justify-center h-20 w-20 rounded-full bg-amber-100 mb-6 mx-auto">
                            <svg class="h-10 w-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-center text-gray-800 mb-4">Panduan pegawai</h3>
                        <p class="text-gray-600 text-center mb-6">Petunjuk penggunaan sistem untuk mengajukan cuti dan memantau status pengajuan.</p>
                        <a href="#" class="block w-full bg-secondary hover:bg-amber-600 text-white text-center py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
        </section> --}}

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <div class="flex items-center mb-4">
                            <svg class="h-8 w-8 text-primary mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20ZM13 7H11V13H17V11H13V7Z" fill="currentColor"/>
                            </svg>
                            <span class="text-xl font-semibold">Sibaco</span>
                        </div>
                        <p class="text-gray-400">Sistem Cuti Online modern untuk manajemen cuti pegawai yang efisien dan transparan.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Beranda</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-white transition duration-300">Fitur</a></li>
                            <li><a href="#benefits" class="text-gray-400 hover:text-white transition duration-300">Manfaat</a></li>
                            <li><a href="#download" class="text-gray-400 hover:text-white transition duration-300">Panduan</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Kontak</h3>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                +62 852-9993-2327
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                infobbpp@pertanian.go.id
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Jl. Teknologi No. 123, Jakarta
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Sosial Media</h3>
                        <div class="flex space-x-4">
                            <!-- YouTube -->
                            <a href="https://www.youtube.com/@bbppbatangkalukupertanian" target="_blank" class="text-gray-400 hover:text-red-600 transition">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                </svg>
                            </a>
                            
                            <!-- Facebook -->
                            <a href="https://www.facebook.com/bbpp.batangkaluku.pertanian" target="_blank" class="text-gray-400 hover:text-blue-600 transition">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            <!-- Instagram -->
                            <a href="https://www.instagram.com/bbpp.batangkaluku" target="_blank" class="text-gray-400 hover:text-pink-600 transition">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                                </svg>
                            </a>
                            
                            <!-- Twitter/X -->
                            <a href="https://twitter.com/bbpp_bk" target="_blank" class="text-gray-400 hover:text-black transition">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                            
                            <!-- Threads -->
                            <a href="https://www.threads.net/@bbpp.batangkaluku" target="_blank" class="text-gray-400 hover:text-black transition">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 1.5c2.9 0 5.25 2.35 5.25 5.25v12c0 2.9-2.35 5.25-5.25 5.25H6c-2.9 0-5.25-2.35-5.25-5.25v-12C.75 3.85 3.1 1.5 6 1.5h12zm-4.5 7.5c0-1.24 1.01-2.25 2.25-2.25h3c1.24 0 2.25 1.01 2.25 2.25v3c0 1.24-1.01 2.25-2.25 2.25h-3c-1.24 0-2.25-1.01-2.25-2.25v-3z"/>
                                </svg>
                            </a>
                            
                            <!-- TikTok -->
                            <a href="https://www.tiktok.com/@bbpp.batangkaluku" target="_blank" class="text-gray-400 hover:text-black transition">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2023 Sibaco - Sistem Cuti Online. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <script>
            // Mobile menu toggle
            const btn = document.querySelector('.mobile-menu-button');
            const menu = document.querySelector('.mobile-menu');
            
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        </script>
    </body>
</html>