@extends('dashboard.widyaiswara.base-widyaiswara')

@section('main')
<!-- Profile Card -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <!-- Profile Header with Gradient -->
    <div class="bg-gradient-to-r from-purple-600 via-purple-400 to-pink-400 p-6">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center">
                    <h1 class="text-lg sm:text-xl font-bold text-white mr-2">{{ $user->name }}</h1>
                    <button onclick="toggleEdit('name')" class="text-white hover:text-gray-300 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                </div>
                <form id="name-form" class="hidden mt-2" method="POST" action="{{ route('dashboard.update') }}">
                    @csrf
                    <div class="flex">
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="flex-1 px-2 py-1 rounded-l text-gray-800">
                        <button type="submit" class="bg-white text-blue-600 px-2 py-1 rounded-r hover:bg-blue-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>
                <p class="text-blue-100 text-sm">{{ $user->jabatan }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="grid grid-cols-1 gap-6 p-6">
        <!-- Left Column -->
        <div class="md:col-span-2">
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
                <!-- Personal Info Card -->
                <div class="bg-white rounded-lg border border-gray-100 p-6 w-full md:w-3/5">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center group relative">
                        <!-- Animated Profile Icon -->
                        <div class="relative mr-3">
                            <!-- Main Icon -->
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" class="group-hover:stroke-[2.3px] transition-all"></path>
                            </svg>
                            <div class="absolute -inset-1.5 rounded-full bg-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                        </div>
                        <span class="relative">
                            Informasi Pribadi
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-400 group-hover:w-full transition-all duration-500 ease-out"></span>
                        </span>
                        <span class="ml-2 px-1.5 py-0.5 text-xs font-medium rounded-full bg-purple-100 text-purple-800 opacity-0 group-hover:opacity-100 translate-x-1 group-hover:translate-x-0 transition-all duration-300">
                            Anda
                        </span>
                    </h2>
                    
                    <!-- Session Messages -->
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Non-editable fields -->
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">NIP</p>
                            <p class="mt-1 text-gray-700">{{ $user->nip }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Jabatan</p>
                            <p class="mt-1 text-gray-700">{{ $user->jabatan }}</p>
                        </div>
                        
                        <div>
                            <div class="flex items-center">
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">No. HP</p>
                                <button onclick="toggleEdit('phone')" class="ml-2 text-gray-400 hover:text-purple-700 focus:outline-none">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1 text-gray-700">{{ $user->no_hp }}</p>
                            <form id="phone-form" class="hidden mt-2" method="POST" action="{{ route('dashboard.update') }}">
                                @csrf
                                <div class="flex">
                                    <input type="tel" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="flex-1 px-2 py-1 rounded-l text-gray-800 text-sm">
                                    <button type="submit" class="bg-blue-100 text-blue-600 px-2 py-1 rounded-r hover:bg-blue-200 text-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                </div>
                                @error('no_hp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </form>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex items-center">
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Password</p>
                                <button onclick="showPasswordModal()" class="ml-2 text-gray-400 hover:text-purple-700 focus:outline-none">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="mt-1 text-gray-700">••••••••</p>
                        </div>
                    </div>
                </div>

                <!-- Masa Kerja Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 transition-all hover:shadow-md px-4 py-2 w-full md:w-2/5">
                    <div class="p-2">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-semibold text-gray-800 flex items-center group relative">
                                <svg class="w-5 h-5 mr-2 text-pink-500 transition-all duration-500 group-hover:text-pink-600 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" class="group-hover:stroke-[2.5px] transition-all"></path>
                                </svg>
                                
                                <span class="relative">
                                    Masa Kerja
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-400 group-hover:w-full transition-all duration-300"></span>
                                </span>
                                <span class="ml-1.5 w-2 h-2 rounded-full bg-purple-400 animate-pulse opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            </h2>
                            {{-- <button type="button" onclick="openModal()" class="text-sm px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                {{ $masakerja ? 'Edit' : 'Hitung' }}
                            </button> --}}
                        </div>
                        
                        @if ($masakerja)
                        <div class="bg-blue-50 rounded-xl p-4 text-center">
                            <p class="text-sm text-blue-600 mb-1">Total Masa Kerja</p>
                            <p class="text-xl font-bold text-blue-700">{{ $masakerja->jumlah_masa_kerja }}</p>
                            <p class="text-xs text-blue-500 mt-1">Diperbarui: {{ $masakerja->updated_at->format('d M Y') }}</p>
                        </div>
                        @else
                        <div class="bg-yellow-50 rounded-xl p-6 text-center border-2 border-dashed border-yellow-200">
                            <svg class="w-8 h-8 mx-auto text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-yellow-700">Data Masa Kerja Belum Tersedia</h3>
                            <p class="mt-1 text-xs text-yellow-600">Silahkan hitung masa kerja Anda untuk menampilkan data</p>
                            {{-- <button type="button" onclick="openModal()" class="mt-4 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                Hitung Sekarang
                            </button> --}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Leave Quota Card -->
            <div class="bg-white rounded-lg border border-gray-100 p-6 mt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center group relative">
                    <!-- Animated Calendar Icon -->
                    <div class="relative mr-3">
                        <!-- Main Icon with Gradient Stroke -->
                        <svg class="w-6 h-6 text-transparent stroke-2" 
                                fill="none" 
                                viewBox="0 0 24 24">
                            <defs>
                                <linearGradient id="calendarGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#8B5CF6" />
                                    <stop offset="100%" stop-color="#C084FC" />
                                </linearGradient>
                            </defs>
                            <path 
                                stroke="url(#calendarGradient)" 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                class="group-hover:stroke-[2.5px] transition-all duration-300"
                            ></path>
                        </svg>
                        
                        <!-- Pulsing Glow Effect -->
                        <div class="absolute inset-0 rounded-full bg-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10 animate-pulse-slow"></div>
                    </div>
                    
                    <!-- Text with Purple Underline Animation -->
                    <span class="relative text-base sm:text-lg md:text-xl block">
                        Kuota Cuti Tahunan
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-fuchsia-400 group-hover:w-full transition-all duration-500 ease-[cubic-bezier(0.65,0,0.35,1)]"></span>
                    </span>
                    <span class="hidden sm:flex ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gradient-to-r from-purple-100 to-fuchsia-100 text-purple-800 opacity-0 group-hover:opacity-100 translate-y-1 group-hover:translate-y-0 transition-all duration-300 items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500 mr-1 animate-pulse"></span>
                        Sisa Kuota
                    </span>
                </h2>
                
                @if($user->kuotaCutiTahunan)
                    <!-- Tampilan normal jika ada kuota -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <p class="text-xs font-medium text-purple-600">Tahun Ini (N)</p>
                            <p class="text-2xl font-bold text-purple-700 mt-1">{{ $user->kuotaCutiTahunan->kuota_n ?? 0 }}</p>
                            <p class="text-xs text-purple-500 mt-1">hari tersedia</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-xs font-medium text-gray-600">Tahun Lalu (N-1)</p>
                            <p class="text-2xl font-bold text-gray-700 mt-1">{{ $user->kuotaCutiTahunan->kuota_n1 ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">sisa cuti</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 text-center">
                            <p class="text-xs font-medium text-gray-600">2 Tahun Lalu (N-2)</p>
                            <p class="text-2xl font-bold text-gray-700 mt-1">{{ $user->kuotaCutiTahunan->kuota_n2 ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-1">sisa cuti</p>
                        </div>
                    </div>
                    
                    {{-- @if(!empty($user->kuotaCutiTahunan->catatan))
                    <div class="mt-4 p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                        <p class="text-sm text-yellow-700">{{ $user->kuotaCutiTahunan->catatan }}</p>
                    </div>
                    @endif --}}
                @else
                    <!-- Tampilan khusus jika belum ada kuota -->
                    <div class="bg-purple-50 rounded-xl p-6 text-center border-2 border-dashed border-purple-200">
                        <div class="inline-flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-md font-medium text-purple-800">Kuota Cuti Belum Diverifikasi</h3>
                        <p class="mt-2 text-xs text-purple-600">
                            Data kuota cuti Anda sedang dalam proses verifikasi oleh admin.
                        </p>
                        <div class="mt-4 bg-white rounded-lg p-3 inline-block">
                            <div class="flex items-center text-sm text-purple-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>Silahkan hubungi Admin</span>
                            </div>
                        </div>
                        @php
                            // Pastikan $admin sudah terdefinisi di controller
                            $whatsappNumber = isset($admin) ? '62' . ltrim(preg_replace('/[^0-9]/', '', $admin->no_hp), '0') : '';
                            $defaultMessage = urlencode("[SIBACO System Notification]\n\nAssalamualaikum Admin,\n\nSaya atas nama:\n  {$user->name}\n  NIP: {$user->nip}\n\nBelum memiliki tim kerja. Mohon bantuan untuk menambahkan saya ke tim kerja.\n\nTerima kasih");
                        @endphp

                        <button onclick="window.open('https://wa.me/{{ $whatsappNumber }}?text={{ $defaultMessage }}', '_blank')" 
                                class="mt-4 px-4 py-2 sm:py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center mx-auto {{ empty($whatsappNumber) ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ empty($whatsappNumber) ? 'disabled title="Nomor admin tidak tersedia"' : '' }}>
                            <svg class="w-6 h-6 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479h.005c5.451 0 9.888-4.434 9.891-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.888-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            Hubungi via WhatsApp
                        </button>

                        @if(empty($whatsappNumber))
                            <p class="mt-2 text-xs text-red-500">Nomor WhatsApp admin tidak tersedia</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-md mx-4">
        <!-- Modal Header -->
        <div class="bg-accent/80 p-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white ml-4">Ubah Password</h3>
                <button onclick="hidePasswordModal()" class="text-white hover:text-gray-200 focus:outline-none transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6">
            <form id="password-form" method="POST" action="{{ route('dashboard.update') }}">
                @csrf
                <div class="space-y-5">
                    <!-- Current Password Field -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password Saat Ini
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="current_password" id="current_password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Password saat ini tidak valid
                            </p>
                        @enderror
                    </div>
                    
                    <!-- New Password Field -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password Baru
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="new_password" id="new_password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition">
                        <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($message == 'The new password must be at least 8 characters.')
                                    Password baru minimal 8 karakter
                                @else
                                    {{ $message }}
                                @endif
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Confirm New Password Field -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password Baru
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-400 transition">
                        @error('new_password_confirmation')
                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Konfirmasi password tidak cocok
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="hidePasswordModal()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-500 rounded-lg shadow-sm text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 transition transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal masa kerja -->
<div id="masaKerjaModal" class="fixed inset-0 bg-gray-900/70 hidden flex items-center justify-center z-50 p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 ease-out">
        <!-- Modal Header -->
        <div class="bg-primary p-4 text-gray-100">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="p-2 rounded-lg bg-white/10 backdrop-blur-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold tracking-tight">
                        Hitung Masa Kerja
                    </h3>
                </div>
                <button onclick="closeModal()" class="p-1 rounded-full hover:bg-white/30 transition-colors focus:outline-none focus:ring-2 focus:ring-white/100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="p-6 space-y-6">
            <!-- Honorer Section -->
            <div class="bg-blue-50 rounded-xl p-3 border border-blue-100 shadow-inner">
                <label class="block text-sm font-semibold text-blue-800 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Masa Honorer (Jika Ada)
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="honoryear" class="block text-xs font-medium text-blue-600 mb-2">Tahun</label>
                        <input type="number" id="honoryear" min="0" value="0" 
                               class="w-full px-4 py-2.5 text-sm border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                    </div>
                    <div>
                        <label for="honormonth" class="block text-xs font-medium text-blue-600 mb-2">Bulan</label>
                        <select id="honormonth" class="w-full px-4 py-2.5 text-sm border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                            @for ($i = 0; $i < 12; $i++)
                                <option value="{{ $i }}">{{ $i }} Bulan</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <p id="honorError" class="text-red-500 text-xs mt-2 hidden flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Nilai tidak boleh negatif
                </p>
            </div>
            <!-- Date Selection -->
            <div class="space-y-3">
                <div>
                    <label for="selectedDate" class="block text-sm font-semibold text-gray-700 mb-2">Mulai Bekerja</label>
                    <div class="relative">
                        <input type="month" id="selectedDate" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-400">
                    </div>
                    <p id="dateError" class="text-red-600 text-xs mt-2 hidden transform transition-all duration-300 ease-out origin-top">
                        <span class="inline-flex items-center px-2 py-1 bg-red-50/80 rounded-lg border border-red-100">
                            <svg class="w-3.5 h-3.5 mr-1.5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Tanggal tidak boleh lebih besar dari tanggal sekarang</span>
                        </span>
                    </p>
                </div>
                <div>
                    <label for="currentDate" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Sekarang</label>
                    <input type="month" id="currentDate" value="{{ date('Y-m') }}" readonly
                           class="w-full px-4 py-2.5 text-sm bg-gray-100 border border-gray-300 rounded-xl">
                </div>
            </div>
            <!-- Result -->
            <div id="resultContainer" class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-5 border border-blue-100 shadow-inner hidden transform transition-all duration-300">
                <div class="flex items-center">
                    <span class="text-sm font-semibold text-blue-800">Total Masa Kerja:</span>
                    <span id="result" class="text-md font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent ml-4"></span>
                </div>
                <div class="mt-2 text-xs text-blue-500 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Termasuk masa honorer yang diinput
                </div>
            </div>
        </div>
        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
            <button type="button" onclick="closeModal()" 
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all">
                Batal
            </button>
            <button type="button" onclick="hitungSelisih()" 
                    class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl hover:from-blue-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-md hover:shadow-blue-200 transition-all">
                Hitung
            </button>
            <button type="submit" id="saveButton" form="masaKerjaForm" hidden
                    class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-500 rounded-xl hover:from-green-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-green-300 shadow-md hover:shadow-green-200 transition-all">
                <span class="flex items-center">
                    <span id="saveText">{{ $masakerja ? 'Update' : 'Simpan' }}</span>
                    <span id="saveLoading" class="hidden ml-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </span>
            </button>
        </div>

        <!-- Form handling for update/create -->
        @if($masakerja)
            <form action="{{ route('widyaiswaramasakerja.update', $masakerja->id) }}" method="POST" id="masaKerjaForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
            </form>
        @else
            <form action="{{ route('widyaiswaramasakerja.store') }}" method="POST" id="masaKerjaForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
            </form>
        @endif
    </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed bottom-4 right-4 flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg animate-bounce">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div id="errorAlert" class="fixed bottom-4 right-4 flex items-center p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg animate-bounce z-50">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    Gagal mengubah password. Silakan cek kembali data Anda.
</div>
@endif

<script>
    function toggleEdit(field) {
        const form = document.getElementById(`${field}-form`);
        form.classList.toggle('hidden');
        
        // Auto focus input when form appears
        if (!form.classList.contains('hidden')) {
            setTimeout(() => {
                const input = form.querySelector('input');
                if (input) input.focus();
            }, 100);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Validasi input honorer
        document.getElementById('honoryear').addEventListener('input', validateHonor);
        // Validasi tanggal
        document.getElementById('selectedDate').addEventListener('change', validateDate);
        // Tambahkan efek loading pada saat submit
        document.getElementById('masaKerjaForm').addEventListener('submit', showLoading);
        
        // Auto-hide success alert after 3 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transition = 'opacity 1s';
                setTimeout(() => {
                    successAlert.remove();
                }, 1000);
            }, 3000);
        }
    });
    
    function openModal() {
        document.getElementById('masaKerjaModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Animation
        const modalContent = document.querySelector('#masaKerjaModal > div');
        modalContent.classList.add('scale-in');
    }
    
    function closeModal() {
        document.getElementById('masaKerjaModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        
        // Reset form
        document.getElementById('resultContainer').classList.add('hidden');
        document.getElementById('saveButton').hidden = true;
    }

    function validateHonor() {
        const honoryear = parseInt(document.getElementById('honoryear').value);
        const errorElement = document.getElementById('honorError');
        
        if (honoryear < 0) {
            errorElement.classList.remove('hidden');
            return false;
        } else {
            errorElement.classList.add('hidden');
            return true;
        }
    }

    function validateDate() {
        const selectedDate = document.getElementById('selectedDate').value;
        const currentDate = document.getElementById('currentDate').value;
        const errorElement = document.getElementById('dateError');
        
        if (selectedDate && selectedDate > currentDate) {
            errorElement.classList.remove('hidden');
            return false;
        } else {
            errorElement.classList.add('hidden');
            return true;
        }
    }

    function showLoading(e) {
        document.getElementById('saveText').classList.add('hidden');
        document.getElementById('saveLoading').classList.remove('hidden');
        // Form submission continues normally
    }

    function hitungSelisih() {
        // Validasi input sebelum melakukan perhitungan
        if (!validateHonor() || !validateDate()) {
            return;
        }

        let selectedDate = document.getElementById('selectedDate').value;
        let currentDate = document.getElementById('currentDate').value;

        let honoryear = parseInt(document.getElementById('honoryear').value) || 0;
        let honormonth = parseInt(document.getElementById('honormonth').value) || 0;
        
        if (!selectedDate || !currentDate) {
            alert('Harap pilih kedua tanggal!');
            return;
        }
        
        let selectedParts = selectedDate.split('-');
        let currentParts = currentDate.split('-');
        
        let selectedYear = parseInt(selectedParts[0]);
        let selectedMonth = parseInt(selectedParts[1]);
        let currentYear = parseInt(currentParts[0]);
        let currentMonth = parseInt(currentParts[1]);
        
        let totalMonths = ((currentYear - selectedYear) * 12 + (currentMonth - selectedMonth)) + (honoryear * 12 + honormonth);
        let years = Math.floor(totalMonths / 12);
        let months = totalMonths % 12;
        
        let resultText = `${years} Tahun, ${months} Bulan`;
        
        // Tampilkan hasil dengan animasi
        const resultContainer = document.getElementById('resultContainer');
        resultContainer.classList.remove('hidden');
        resultContainer.classList.add('animate-fade-in');
        
        document.getElementById('result').innerText = resultText;
        document.getElementById('masaKerjaInput').value = resultText;

        // Tampilkan tombol Simpan setelah hitungan selesai
        document.getElementById('saveButton').hidden = false;
    }
</script>

<script>
    // Toggle edit forms
    function toggleEdit(field) {
        const form = document.getElementById(`${field}-form`);
        form.classList.toggle('hidden');
    }

    // Password modal functions
    function showPasswordModal() {
        document.getElementById('passwordModal').classList.remove('hidden');
    }

    function hidePasswordModal() {
        document.getElementById('passwordModal').classList.add('hidden');
        // Reset form when hiding
        document.getElementById('password-form').reset();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('passwordModal');
        if (event.target === modal) {
            hidePasswordModal();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide success alert after 3 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transition = 'opacity 1s';
                setTimeout(() => {
                    successAlert.remove();
                }, 1000);
            }, 3000);
        }
        
        // Auto-hide error alert after 5 seconds
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                errorAlert.style.transition = 'opacity 1s';
                setTimeout(() => {
                    errorAlert.remove();
                }, 1000);
            }, 5000);
        }
        
        // Function to show password modal
        function showPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
        }
        
        // Function to hide password modal
        function hidePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }
        
        // Make these functions available globally
        window.showPasswordModal = showPasswordModal;
        window.hidePasswordModal = hidePasswordModal;
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .scale-in {
        animation: scaleIn 0.2s ease-out forwards;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce {
        animation: bounce 0.5s ease-in-out 2;
    }
</style>

@endsection