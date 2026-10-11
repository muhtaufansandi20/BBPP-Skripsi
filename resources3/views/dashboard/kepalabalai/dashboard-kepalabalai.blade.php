@extends('dashboard.kepalabalai.base-kepalabalai')

@section('content')

<!-- Profile Card -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <!-- Profile Header with Gradient -->
    {{-- <div class="bg-gradient-to-r from-emerald-600 to-emerald-400 p-6"> --}}
    <div class="bg-gradient-to-l from-lime-400 to-green-500 p-6">
    {{-- <div class="bg-gradient-to-r from-teal-600 to-emerald-600 p-6"> --}}
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="h-16 w-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center">
                    <h1 class="text-lg sm:text-xl font-bold text-white mr-2">{{ $user->name }}</h1>
                    <button onclick="toggleEdit('name')" class="text-white hover:text-emerald-200 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                </div>
                <form id="name-form" class="hidden mt-2" method="POST" action="{{ route('dashboard.update') }}">
                    @csrf
                    <div class="flex">
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="flex-1 px-2 py-1 rounded-l text-gray-800">
                        <button type="submit" class="bg-white text-emerald-600 px-2 py-1 rounded-r hover:bg-emerald-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </form>
                <p class="text-emerald-100 text-sm">{{ $user->jabatan }}</p>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="grid grid-cols-1 gap-6 p-6">
        <!-- Left Column -->
        <div class="md:col-span-2">
            <div class="flex flex-col md:flex-row md:space-x-6 space-y-6 md:space-y-0">
                <!-- Personal Info Card -->
                <div class="bg-white rounded-lg border border-gray-100 p-6 w-full md:w-full">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center group relative">
                        <!-- Animated Profile Icon -->
                        <div class="relative mr-3">
                            <!-- Main Icon -->
                            <svg class="w-6 h-6 text-gray-500 group-hover:text-emerald-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" class="group-hover:stroke-[2.3px] transition-all"></path>
                            </svg>
                            <div class="absolute -inset-1.5 rounded-full bg-indigo-100 opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                        </div>
                        <span class="relative">
                            Informasi Pribadi
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-gradient-to-r from-green-400 to-emerald-500 group-hover:w-full transition-all duration-500 ease-out"></span>
                        </span>
                        <span class="ml-2 px-1.5 py-0.5 text-xs font-medium rounded-full bg-green-100 text-green-800 opacity-0 group-hover:opacity-100 translate-x-1 group-hover:translate-x-0 transition-all duration-300">
                            Anda
                        </span>
                    </h2>
                    
                    <!-- Session Messages -->
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded-lg border border-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg border border-red-200">
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
                                <button onclick="toggleEdit('phone')" class="ml-2 text-gray-400 hover:text-emerald-500 focus:outline-none">
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
                                    <button type="submit" class="bg-emerald-100 text-emerald-600 px-2 py-1 rounded-r hover:bg-emerald-200 text-sm">
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

                    <div>
                        <div class="flex items-center">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Password</p>
                            <button onclick="showPasswordModal()" class="ml-2 text-gray-400 hover:text-primary focus:outline-none">
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
                {{-- <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 transition-all hover:shadow-md px-4 py-2 w-full md:w-2/5">
                    <div class="p-2">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-sm font-semibold text-gray-800 flex items-center group">
                                <svg class="w-5 h-5 mr-2 text-emerald-500 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="relative">
                                    Masa Kerja
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-400 group-hover:w-full transition-all duration-300"></span>
                                </span>
                            </h2>
                            <button type="button" onclick="openModal()" class="text-sm px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                {{ $masakerja ? 'Edit' : 'Hitung' }}
                            </button>
                        </div>
                        
                        @if ($masakerja)
                        <div class="bg-emerald-50 rounded-xl p-4 text-center border border-emerald-100">
                            <p class="text-sm text-emerald-600 mb-1">Total Masa Kerja</p>
                            <p class="text-xl font-bold text-emerald-700">{{ $masakerja->jumlah_masa_kerja }}</p>
                            <p class="text-xs text-emerald-500 mt-1">Diperbarui: {{ $masakerja->updated_at->format('d M Y') }}</p>
                        </div>
                        @else
                        <div class="bg-amber-50 rounded-xl p-6 text-center border-2 border-dashed border-amber-200">
                            <svg class="w-8 h-8 mx-auto text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-amber-700">Data Masa Kerja Belum Tersedia</h3>
                            <p class="mt-1 text-xs text-amber-600">Silahkan hitung masa kerja Anda untuk menampilkan data</p>
                            <button type="button" onclick="openModal()" class="mt-4 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                                Hitung Sekarang
                            </button>
                        </div>
                        @endif
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-md mx-4">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-accent/90 to-accent/80 p-4">
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
                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg shadow-sm text-sm font-medium text-white hover:from-green-600 hover:to-emerald-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-400 transition transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for calculating masa kerja -->
<div id="masaKerjaModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-primary to-primary/70 p-5 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Hitung Masa Kerja
                </h3>
                <button onclick="closeModal()" class="text-white hover:text-emerald-200 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 space-y-4">
            <!-- Honorer Section -->
            <div class="bg-emerald-50 rounded-lg p-4 border border-emerald-100">
                <label class="block text-sm font-medium text-emerald-700 mb-2">Masa Honorer (Jika Ada)</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="honoryear" class="block text-xs text-emerald-600 mb-1">Tahun</label>
                        <input type="number" id="honoryear" min="0" value="0" 
                               class="w-full px-3 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-300 focus:border-emerald-400">
                    </div>
                    <div>
                        <label for="honormonth" class="block text-xs text-emerald-600 mb-1">Bulan</label>
                        <select id="honormonth" class="w-full px-3 py-2 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-300 focus:border-emerald-400">
                            @for ($i = 0; $i < 12; $i++)
                                <option value="{{ $i }}">{{ $i }} Bulan</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <p id="honorError" class="text-red-500 text-xs mt-2 hidden">Nilai tidak boleh negatif</p>
            </div>

            <!-- Date Selection -->
            <div class="space-y-4">
                <div>
                    <label for="selectedDate" class="block text-sm font-medium text-gray-700 mb-1">Mulai Bekerja</label>
                    <input type="month" id="selectedDate" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-300 focus:border-emerald-400">
                    <p id="dateError" class="text-red-500 text-xs mt-1 hidden">Tanggal tidak boleh lebih besar dari tanggal sekarang</p>
                </div>

                <div>
                    <label for="currentDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Sekarang</label>
                    <input type="month" id="currentDate" value="{{ date('Y-m') }}" readonly
                           class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                </div>
            </div>

            <!-- Result -->
            <div id="resultContainer" class="bg-gray-50 rounded-lg p-4 border border-gray-200 hidden">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Total Masa Kerja:</span>
                    <span id="result" class="text-lg font-bold text-emerald-600"></span>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Termasuk masa honorer yang diinput
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
            <button type="button" onclick="closeModal()" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                Batal
            </button>
            <button type="button" onclick="hitungSelisih()" 
                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
                Hitung
            </button>
            <button type="submit" id="saveButton" form="masaKerjaForm" hidden
                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300">
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
            <form action="{{ route('kepalabalaimasakerja.update', $masakerja->id) }}" method="POST" id="masaKerjaForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
            </form>
        @else
            <form action="{{ route('kepalabalaimasakerja.store') }}" method="POST" id="masaKerjaForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
            </form>
        @endif
    </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed bottom-4 right-4 flex items-center p-4 mb-4 text-sm text-emerald-700 bg-emerald-100 rounded-lg animate-bounce">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    {{ session('success') }}
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
        
        document.getElementById('result').innerText = "Selisih : " + resultText;
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