@extends('dashboard.admin.base-admin')

@section('main')
<div class="container mx-auto px-4 pt-0 py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 pt-4">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-xl font-semibold text-gray-800 mb-2">Kelola Tanda Tangan Digital</h1>
            <p class="text-gray-600 text-sm">Kelola tanda tangan digital untuk kepala bagian dan kepala balai</p>
        </div>
        
        <!-- Signature Management Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- Kepala Bagian Section -->
            <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-md md:text-xl font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Kepala Bagian
                    </h2>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">Required</span>
                </div>
                
                @php
                    $kepalaBagian = \App\Models\User::where('role', 'kepalabagian')->first();
                    $ttdKepalaBagian = \App\Models\TandaTangan::where('role', 'kepalabagian')->first();
                @endphp

                @if($kepalaBagian)
                <div class="space-y-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-medium">
                                {{ substr($kepalaBagian->name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $kepalaBagian->name }}</p>
                            <p class="text-sm text-gray-500">NIP: {{ $kepalaBagian->nip }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Tanda Tangan Saat Ini</h3>
                        <div id="preview-kabag" class="relative border-2 border-dashed border-gray-200 rounded-lg p-4 bg-white h-40 flex items-center justify-center bg-grid-pattern">
                            @if($ttdKepalaBagian && $ttdKepalaBagian->gambar_ttd_path)
                                <img src="{{ asset('storage/' . $ttdKepalaBagian->gambar_ttd_path) }}" alt="Tanda Tangan Kepala Bagian" class="max-h-full max-w-full object-contain">
                                <div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-0 hover:bg-opacity-30 transition-all opacity-0 hover:opacity-100">
                                    <a href="{{ asset('storage/' . $ttdKepalaBagian->gambar_ttd_path) }}" target="_blank" class="p-2 bg-white rounded-full shadow-md text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10V7M10 10H7M10 10h3m0 0v3"></path>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-1 text-sm text-gray-500 italic">Belum ada tanda tangan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <form id="form-kabag" action="{{ route('adminkelolatandatangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" value="kepalabagian">
                    
                    <div>
                        <label for="ttd_kabag" class="block text-sm font-medium text-gray-700 mb-2">Upload Tanda Tangan Baru</label>
                        <div class="relative">
                            <input type="file" id="ttd_kabag" name="gambar_ttd" accept="image/png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-blue-500 transition">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700" id="file-name-kabag">Pilih file PNG</span>
                                </div>
                                <span class="text-sm text-gray-500">Max 2MB</span>
                            </div>
                        </div>
                        
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <h4 class="text-xs font-medium text-gray-700 mb-2">Persyaratan file tanda tangan:</h4>
                            <ul class="text-xs text-gray-600 space-y-1">
                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 h-3 w-3 text-green-500 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Format PNG dengan latar belakang transparan
                                </li>
                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 h-3 w-3 text-green-500 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ukuran file maksimal 2MB
                                </li>
                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 h-3 w-3 text-green-500 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Resolusi minimal 300DPI untuk kejelasan
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Simpan Tanda Tangan
                    </button>
                </form>
                @else
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200 flex items-start">
                    <svg class="flex-shrink-0 h-5 w-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Belum ada pengguna dengan role Kepala Bagian</h3>
                        <p class="text-sm text-yellow-700 mt-1">Silakan tambahkan pengguna dengan role Kepala Bagian terlebih dahulu</p>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Kepala Balai Section -->
            <div class="bg-gradient-to-br from-gray-50 to-white p-6 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-md md:text-xl font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kepala Balai
                    </h2>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Required</span>
                </div>
                
                @php
                    $kepalaBalai = \App\Models\User::where('role', 'kepalabalai')->first();
                    $ttdKepalaBalai = \App\Models\TandaTangan::where('role', 'kepalabalai')->first();
                @endphp

                @if($kepalaBalai)
                <div class="space-y-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-medium">
                                {{ substr($kepalaBalai->name, 0, 1) }}
                            </div>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $kepalaBalai->name }}</p>
                            <p class="text-sm text-gray-500">NIP: {{ $kepalaBalai->nip }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Tanda Tangan Saat Ini</h3>
                        <div id="preview-kabalai" class="relative border-2 border-dashed border-gray-200 rounded-lg p-4 bg-white h-40 flex items-center justify-center bg-grid-pattern">
                            @if($ttdKepalaBalai && $ttdKepalaBalai->gambar_ttd_path)
                                <img src="{{ asset('storage/' . $ttdKepalaBalai->gambar_ttd_path) }}" alt="Tanda Tangan Kepala Balai" class="max-h-full max-w-full object-contain">
                                <div class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-0 hover:bg-opacity-30 transition-all opacity-0 hover:opacity-100">
                                    <a href="{{ asset('storage/' . $ttdKepalaBalai->gambar_ttd_path) }}" target="_blank" class="p-2 bg-white rounded-full shadow-md text-blue-600 hover:text-blue-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10V7M10 10H7M10 10h3m0 0v3"></path>
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-1 text-sm text-gray-500 italic">Belum ada tanda tangan</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <form id="form-kabalai" action="{{ route('adminkelolatandatangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" value="kepalabalai">
                    
                    <div>
                        <label for="ttd_kabalai" class="block text-sm font-medium text-gray-700 mb-2">Upload Tanda Tangan Baru</label>
                        <div class="relative">
                            <input type="file" id="ttd_kabalai" name="gambar_ttd" accept="image/png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-lg shadow-sm cursor-pointer hover:border-blue-500 transition">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700" id="file-name-kabalai">Pilih file PNG</span>
                                </div>
                                <span class="text-sm text-gray-500">Max 2MB</span>
                            </div>
                        </div>
                        
                        <div class="mt-3 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <h4 class="text-xs font-medium text-gray-700 mb-2">Persyaratan file tanda tangan:</h4>
                            <ul class="text-xs text-gray-600 space-y-1">
                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 h-3 w-3 text-green-500 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Format PNG dengan latar belakang transparan
                                </li>
                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 h-3 w-3 text-green-500 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ukuran file maksimal 2MB
                                </li>
                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 h-3 w-3 text-green-500 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Resolusi minimal 300DPI untuk kejelasan
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Simpan Tanda Tangan
                    </button>
                </form>
                @else
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200 flex items-start">
                    <svg class="flex-shrink-0 h-5 w-5 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Belum ada pengguna dengan role Kepala Balai</h3>
                        <p class="text-sm text-yellow-700 mt-1">Silakan tambahkan pengguna dengan role Kepala Balai terlebih dahulu</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Guide Section -->
        <div class="mt-10 p-6 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
            <div class="flex items-start">
                <div class="flex-shrink-0 p-2 rounded-lg bg-blue-100 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-md md:text-lg font-semibold text-blue-800 mb-3">Panduan Membuat Tanda Tangan Digital</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-blue-100 shadow-sm">
                            <h3 class="text-sm font-medium text-blue-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Langkah Persiapan
                            </h3>
                            <ol class="text-sm text-gray-700 space-y-2 pl-2">
                                <li class="flex items-start">
                                    <span class="flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2">1</span>
                                    Tulis tanda tangan di kertas putih polos dengan tinta hitam
                                </li>
                                <li class="flex items-start">
                                    <span class="flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2">2</span>
                                    Pindai atau foto dengan kamera resolusi tinggi (min. 300DPI)
                                </li>
                                <li class="flex items-start">
                                    <span class="flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2">3</span>
                                    Pastikan latar belakang bersih dan kontras tinggi
                                </li>
                            </ol>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg border border-blue-100 shadow-sm">
                            <h3 class="text-sm font-medium text-blue-700 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengeditan Digital
                            </h3>
                            <ol class="text-sm text-gray-700 space-y-2 pl-2">
                                <li class="flex items-start">
                                    <span class="flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2">4</span>
                                    Gunakan aplikasi (Photoshop, GIMP, atau PowerPoint) untuk menghapus latar belakang
                                </li>
                                <li class="flex items-start">
                                    <span class="flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2">5</span>
                                    Sesuaikan kontras untuk kejelasan tanda tangan
                                </li>
                                <li class="flex items-start">
                                    <span class="flex items-center justify-center w-5 h-5 bg-blue-100 text-blue-600 rounded-full text-xs font-medium mr-2">6</span>
                                    Simpan dalam format PNG dengan latar belakang transparan
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Status Messages -->
        @if(session('success'))
        <div class="mt-8 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start">
            <svg class="flex-shrink-0 h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-green-700">
                {{ session('success') }}
            </div>
        </div>
        @endif
        
        @if($errors->any())
        <div class="mt-8 p-4 rounded-lg bg-red-50 border border-red-200 flex items-start">
            <svg class="flex-shrink-0 h-5 w-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-red-800">Ada kesalahan dalam pengisian form</h3>
                <ul class="mt-2 text-sm text-red-700 space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="flex items-start">
                        <svg class="flex-shrink-0 h-4 w-4 mt-0.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $error }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.bg-grid-pattern {
    background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px), 
                      linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px);
    background-size: 20px 20px;
}
</style>

<script>
// Enhanced file name display and preview for both forms
document.getElementById('ttd_kabag').addEventListener('change', function(e) {
    // Update file name display
    const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file PNG';
    document.getElementById('file-name-kabag').textContent = fileName;
    
    // Generate and show preview
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const previewContainer = document.getElementById('preview-kabag');
            // Clear previous preview content
            previewContainer.innerHTML = '';
            // Create and add image to preview
            const img = document.createElement('img');
            img.src = event.target.result;
            img.alt = 'Preview Tanda Tangan Kepala Bagian';
            img.className = 'max-h-full max-w-full object-contain';
            previewContainer.appendChild(img);
            
            // Add zoom functionality
            const overlay = document.createElement('div');
            overlay.className = 'absolute inset-0 flex items-center justify-center bg-white bg-opacity-0 hover:bg-opacity-30 transition-all opacity-0 hover:opacity-100';
            const zoomLink = document.createElement('a');
            zoomLink.href = event.target.result;
            zoomLink.target = '_blank';
            zoomLink.className = 'p-2 bg-white rounded-full shadow-md text-blue-600 hover:text-blue-800';
            zoomLink.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10V7M10 10H7M10 10h3m0 0v3"></path></svg>';
            overlay.appendChild(zoomLink);
            previewContainer.appendChild(overlay);
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('ttd_kabalai').addEventListener('change', function(e) {
    // Update file name display
    const fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file PNG';
    document.getElementById('file-name-kabalai').textContent = fileName;
    
    // Generate and show preview
    if (e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(event) {
            const previewContainer = document.getElementById('preview-kabalai');
            // Clear previous preview content
            previewContainer.innerHTML = '';
            // Create and add image to preview
            const img = document.createElement('img');
            img.src = event.target.result;
            img.alt = 'Preview Tanda Tangan Kepala Balai';
            img.className = 'max-h-full max-w-full object-contain';
            previewContainer.appendChild(img);
            
            // Add zoom functionality
            const overlay = document.createElement('div');
            overlay.className = 'absolute inset-0 flex items-center justify-center bg-white bg-opacity-0 hover:bg-opacity-30 transition-all opacity-0 hover:opacity-100';
            const zoomLink = document.createElement('a');
            zoomLink.href = event.target.result;
            zoomLink.target = '_blank';
            zoomLink.className = 'p-2 bg-white rounded-full shadow-md text-blue-600 hover:text-blue-800';
            zoomLink.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 10V7M10 10H7M10 10h3m0 0v3"></path></svg>';
            overlay.appendChild(zoomLink);
            previewContainer.appendChild(overlay);
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>

@endsection