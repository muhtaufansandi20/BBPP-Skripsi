@extends('dashboard.admin.base-admin')

@section('main')
<div class="p-4 pt-0 min-h-screen bg-gray-50">
    {{-- Header dengan Filter Tahun dan Bulan --}}
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard SIBACO</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan data cuti pegawai BBPP Batangkaluku</p>
        </div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full md:w-auto">
            <!-- Filter Tahun -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <label for="tahunFilter" class="text-sm text-gray-600">Tahun:</label>
                <select id="tahunFilter" class="px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-[#10B981] focus:border-[#10B981] transition-all shadow-xs">
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Tombol Filter dengan Dropdown Dinamis -->
            <div class="relative w-full sm:w-auto">
                <button id="filterButton" class="flex items-center gap-2 px-4 py-2 text-sm border border-gray-200 rounded-lg bg-white hover:bg-gray-50 focus:ring-2 focus:ring-[#10B981] focus:border-[#10B981] transition-all shadow-xs w-full sm:w-auto justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span id="currentFilterLabel" class="text-gray-700">Filter</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <!-- Dropdown Filter Options -->
                <div id="filterDropdown" class="hidden absolute right-0 mt-2 w-68 bg-white rounded-lg shadow-lg z-20 border border-gray-100 transform transition-all duration-200 ease-in-out">
                    <div class="p-4">
                        <div class="flex gap-2 mb-4">
                            <!-- Tab Bulan -->
                            <button type="button" id="tabBulan" class="filter-tab px-3 py-1.5 text-xs rounded-lg border border-gray-200 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-[#10B981] transition-all flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Bulan</span>
                            </button>
                            
                            <!-- Tab Triwulan -->
                            <button type="button" id="tabTriwulan" class="filter-tab px-3 py-1.5 text-xs rounded-lg border border-gray-200 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-[#10B981] transition-all flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                                <span>Triwulan</span>
                            </button>
                            
                            <!-- Tab Rentang -->
                            <button type="button" id="tabRentang" class="filter-tab px-3 py-1.5 text-xs rounded-lg border border-gray-200 bg-white hover:bg-gray-50 focus:ring-2 focus:ring-[#10B981] transition-all flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Rentang</span>
                            </button>
                        </div>
                        
                        <!-- Konten Dinamis -->
                        <div id="filterContent">
                            <!-- Default: Konten Bulan -->
                            <div id="contentBulan" class="filter-content">
                                <label class="block mb-2 text-xs font-medium text-gray-600">Pilih Bulan:</label>
                                <select id="bulanFilter" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-[#10B981] focus:border-[#10B981] transition-all shadow-xs">
                                    <option value="">Semua Bulan</option>
                                    @foreach($availableMonths as $month)
                                        <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                                            {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Konten Triwulan -->
                            <div id="contentTriwulan" class="filter-content hidden">
                                <label class="block mb-2 text-xs font-medium text-gray-600">Pilih Triwulan:</label>
                                <select id="triwulanFilter" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-[#10B981] focus:border-[#10B981] transition-all shadow-xs">
                                    <option value="">Pilih Triwulan</option>
                                    <option value="1" {{ $selectedTriwulan == '1' ? 'selected' : '' }}>Triwulan 1 (Jan-Mar)</option>
                                    <option value="2" {{ $selectedTriwulan == '2' ? 'selected' : '' }}>Triwulan 2 (Apr-Jun)</option>
                                    <option value="3" {{ $selectedTriwulan == '3' ? 'selected' : '' }}>Triwulan 3 (Jul-Sep)</option>
                                    <option value="4" {{ $selectedTriwulan == '4' ? 'selected' : '' }}>Triwulan 4 (Okt-Des)</option>
                                </select>
                            </div>
                            
                            <!-- Konten Rentang Tanggal -->
                            <div id="contentRentang" class="filter-content hidden">
                                <label class="block mb-2 text-xs font-medium text-gray-600">Rentang Tanggal:</label>
                                <div class="space-y-2">
                                    <input type="date" id="startDate" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-[#10B981] focus:border-[#10B981] transition-all shadow-xs" 
                                        value="{{ $startDate ?? '' }}">
                                    <input type="date" id="endDate" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg bg-white focus:ring-2 focus:ring-[#10B981] focus:border-[#10B981] transition-all shadow-xs"
                                        value="{{ $endDate ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between pt-4 mt-4 border-t border-gray-100">
                            <button type="button" id="resetFilter" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-50 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reset</span>
                            </button>
                            
                            <button type="button" id="applyFilter" class="flex items-center gap-2 px-4 py-2 text-sm text-white bg-[#10B981] rounded-lg hover:bg-[#0E9F6E] focus:ring-2 focus:ring-[#A7F3D0] transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Terapkan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-2 gap-3 mb-6 lg:grid-cols-4">
        <!-- Card 1 - Green Theme -->
        <div class="p-3 bg-gradient-to-br from-[#ECFDF5] to-[#D1FAE5]/70 rounded-xl shadow-xs border border-[#A7F3D0] hover:shadow-sm transition-all relative overflow-hidden group">
            <div class="absolute -right-3 -top-3 w-16 h-16 rounded-full bg-[#6EE7B7] opacity-10"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#10B981] to-[#6EE7B7] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex items-center relative z-10">
                <div class="p-1.5 mr-3 rounded-lg bg-white shadow-xs border border-[#A7F3D0]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-6">
                        <defs>
                            <linearGradient id="greenGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#10B981" />
                            <stop offset="100%" stop-color="#6EE7B7" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#greenGradient)" fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6.905 9.97a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72V18a.75.75 0 0 0 1.5 0v-4.19l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd" />
                        <path fill="url(#greenGradient)" d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-600 uppercase tracking-wider">Diajukan</p>
                    <p class="text-lg font-bold text-gray-800">{{ $totalPengajuan }}</p>
                </div>
            </div>
        </div>
        
        <!-- Card 2 - Yellow Theme -->
        <div class="p-3 bg-gradient-to-br from-[#FFFBEB] to-[#FEF3C7]/70 rounded-xl shadow-xs border border-[#FDE68A] hover:shadow-sm transition-all relative overflow-hidden group">
            <div class="absolute -right-3 -top-3 w-16 h-16 rounded-full bg-[#FCD34D] opacity-10"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#F59E0B] to-[#FCD34D] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex items-center relative z-10">
                <div class="p-1.5 mr-3 rounded-lg bg-white shadow-xs border border-[#FDE68A]">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <defs>
                            <linearGradient id="yellowGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#F59E0B"/>
                            <stop offset="100%" stop-color="#FCD34D"/>
                            </linearGradient>
                        </defs>
                        <path fill="url(#yellowGradient)" fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                        <path fill="url(#yellowGradient)" d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-600 uppercase tracking-wider">Disetujui</p>
                    <p class="text-lg font-bold text-gray-800">{{ $pengajuanDisetujui }}</p>
                </div>
            </div>
        </div>
        
        <!-- Card 3 - Blue Theme -->
        <div class="p-3 bg-gradient-to-br from-[#EFF6FF] to-[#DBEAFE]/70 rounded-xl shadow-xs border border-[#BFDBFE] hover:shadow-sm transition-all relative overflow-hidden group">
            <div class="absolute -right-3 -top-3 w-16 h-16 rounded-full bg-[#93C5FD] opacity-10"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#3B82F6] to-[#93C5FD] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex items-center relative z-10">
                <div class="p-1.5 mr-3 rounded-lg bg-white shadow-xs border border-[#BFDBFE]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6">
                        <defs>
                            <linearGradient id="blueGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#3B82F6" />
                            <stop offset="100%" stop-color="#60A5FA" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#blueGradient)" fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                        <path fill="url(#blueGradient)" d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-600 uppercase tracking-wider">Pemohon</p>
                    <p class="text-lg font-bold text-gray-800">{{ $jumlahPegawaiMengajukanCuti }} Orang</p>
                </div>
            </div>
        </div>
        
        <!-- Card 4 - Purple Theme -->
        <div class="p-3 bg-gradient-to-br from-[#F5F3FF] to-[#EDE9FE]/70 rounded-xl shadow-xs border border-[#DDD6FE] hover:shadow-sm transition-all relative overflow-hidden group">
            <div class="absolute -right-3 -top-3 w-16 h-16 rounded-full bg-[#C4B5FD] opacity-10"></div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#8B5CF6] to-[#C4B5FD] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex items-center relative z-10">
                <div class="p-1.5 mr-3 rounded-lg bg-white shadow-xs border border-[#DDD6FE]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-6 h-6">
                        <defs>
                            <linearGradient id="purpleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#8B5CF6"/>
                            <stop offset="100%" stop-color="#C4B5FD"/>
                            </linearGradient>
                        </defs>
                        <path fill="url(#purpleGradient)" d="M346.3 271.8l-60.1-21.9L214 448 32 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l512 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-261.9 0 64.1-176.2zm121.1-.2l-3.3 9.1 67.7 24.6c18.1 6.6 38-4.2 39.6-23.4c6.5-78.5-23.9-155.5-80.8-208.5c2 8 3.2 16.3 3.4 24.8l.2 6c1.8 57-7.3 113.8-26.8 167.4zM462 99.1c-1.1-34.4-22.5-64.8-54.4-77.4c-.9-.4-1.9-.7-2.8-1.1c-33-11.7-69.8-2.4-93.1 23.8l-4 4.5C272.4 88.3 245 134.2 226.8 184l-3.3 9.1L434 269.7l3.3-9.1c18.1-49.8 26.6-102.5 24.9-155.5l-.2-6zM107.2 112.9c-11.1 15.7-2.8 36.8 15.3 43.4l71 25.8 3.3-9.1c19.5-53.6 49.1-103 87.1-145.5l4-4.5c6.2-6.9 13.1-13 20.5-18.2c-79.6 2.5-154.7 42.2-201.2 108z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-medium text-gray-600 uppercase tracking-wider">Sedang Cuti</p>
                    <p class="text-lg font-bold text-gray-800">{{ count($sedangCuti) }} Orang</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-6">
    <!-- Bagian A (2/3 width) -->
        <div class="lg:w-2/3 flex flex-col gap-6">
            <!-- Pengajuan Cuti Disetujui -->
            <div class="rounded-2xl shadow-2xl overflow-hidden border border-gray-200/30">
                <!-- Header with green gradient -->
                <div class="bg-gradient-to-r from-primary/90 to-lime-500 px-6 py-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <h3 class="text-lg font-semibold text-white">
                            <div class="flex items-center">
                                <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <span>{{ $chartTitle }}</span>
                            </div>
                        </h3>
                        <div class="text-sm font-medium text-white/90 bg-white/10 px-4 py-2 rounded-lg backdrop-blur-sm">
                            @if($selectedTriwulan)
                                Triwulan {{ $selectedTriwulan }} 
                            @endif
                            Tahun {{ $selectedYear }}
                            @if($selectedMonth)
                                - {{ DateTime::createFromFormat('!m', $selectedMonth)->format('F') }}
                            @endif
                            @if($startDate && $endDate)
                                ({{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Pure white chart area -->
                <div class="bg-white p-6">
                    <div class="relative" style="height: 300px;">
                        <canvas id="barChart"></canvas>
                    </div>
                    
                    <!-- Green legend badge -->
                    <div class="inline-flex items-center mt-6 px-4 py-2 bg-lime-50 rounded-full border border-lime-200">
                        <span class="w-3 h-3 mr-2 bg-emerald-600 rounded-full"></span>
                        <span class="text-xs font-medium text-emerald-800">Jumlah Pengajuan Disetujui</span>
                    </div>
                </div>
            </div>

            <!-- Permohonan Cuti Dalam Proses -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Permohonan Cuti Dalam Proses
                    </h3>
                    <a href="{{ route('alurverifikasicuti.index') }}" class="text-sm font-medium text-primary hover:text-primary-dark flex items-center">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y sm:divide-y-0 sm:divide-x divide-gray-200 items-center">
                    @foreach([
                        'admin' => ['title' => 'Admin', 'color' => 'text-blue-600', 'bg' => 'bg-blue-50'],
                        'tim_kerja' => ['title' => 'Kepala Tim Kerja', 'color' => 'text-secondary', 'bg' => 'bg-yellow-50'],
                        'kepala_bagian' => ['title' => 'Kepala Bagian', 'color' => 'text-accent', 'bg' => 'bg-orange-50'],
                        'kepala_balai' => ['title' => 'Kepala Balai', 'color' => 'text-primary', 'bg' => 'bg-green-50']
                    ] as $role => $config)
                    <div class="p-2 hover:bg-gray-50 transition-colors">
                        <div class="p-0 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-center">
                                <div class="w-8 h-8 p-2 mr-2 rounded-lg {{ $config['bg'] }} flex items-center justify-center">
                                    <svg class="w-6 h-6 {{ $config['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">{{ $config['title'] }}</p>
                                    <p class="text-lg font-semibold {{ $config['color'] }}">
                                        {{ $statistikCuti[$role]['tahunan'] + $statistikCuti[$role]['umum'] }}
                                        <span class="text-xs font-normal text-gray-400">Permohonan</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-6 py-3 bg-gray-50 text-xs text-gray-500 border-t border-gray-200">
                    <div class="flex justify-between">
                        <span>Terakhir diperbarui: {{ now()->setTimezone('Asia/Makassar')->translatedFormat('d F Y H:i') }}</span>
                        <div class="flex space-x-2">
                            <span class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-1"></span>
                                Tahunan: {{ $statistikCuti['total']['tahunan'] ?? array_sum(array_column($statistikCuti, 'tahunan')) }}
                            </span>
                            <span class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span>
                                Umum: {{ $statistikCuti['total']['umum'] ?? array_sum(array_column($statistikCuti, 'umum')) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian B (1/3 width) -->
        <div class="lg:w-1/3 flex flex-col gap-6">
            <!-- Jenis Cuti -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200/30 overflow-hidden">
                <!-- Header with accent color -->
                <div class="bg-gradient-to-r from-accent/90 to-rose-500  px-6 py-3">
                    <h3 class="text-lg font-semibold text-white">
                        <div class="flex items-center">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <span>Jenis Cuti</span>
                        </div>
                    </h3>
                </div>
                
                <!-- White content area -->
                <div class="p-6">
                    <div class="flex flex-col items-center">
                        <div class="relative w-32 h-32 mb-6">
                            <canvas id="pieChart"></canvas>
                            <div id="emptyPie" class="absolute inset-0 flex items-center justify-center hidden">
                                <div class="w-32 h-32 rounded-full border-2 border-gray-200 flex items-center justify-center">
                                    <span class="text-sm text-gray-400">Tidak ada data</span>
                                </div>
                            </div>
                        </div>
                
                        <div class="w-full grid grid-cols-2 gap-2 text-xs">
                            @foreach($cutiJenisLabels as $index => $label)
                                <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg border border-gray-100 transition-colors">
                                    <div class="flex items-center">
                                        <span class="w-3 h-3 mr-2 rounded-full" 
                                            style="background-color: {{ $chartColors[$index % count($chartColors)] }}"></span>
                                        <span class="font-medium text-gray-700">{{ $label }}</span>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $cutiJenisData[$index] ?? 0 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5 Besar Pengajuan Cuti -->
            <div class="p-4 bg-white rounded-xl shadow-lg border border-gray-200/50">
                <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    5 Besar Pengajuan Cuti
                </h3>
                
                @if($topUsers->isEmpty())
                    <div class="text-center py-6">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Belum ada data pengaju cuti</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($topUsers as $user)
                            <div class="flex items-center justify-between p-2 rounded-lg transition-all 
                                @if($loop->iteration === 1) bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-200 @endif
                                @if($loop->iteration === 2) bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 @endif
                                @if($loop->iteration === 3) bg-gradient-to-r from-amber-700/10 to-amber-800/10 border border-amber-300/30 @endif
                                @if($loop->iteration > 3) bg-gray-50 hover:bg-gray-100 border border-gray-100 @endif">
                                
                                <div class="flex items-center">
                                    <!-- Medal Badge -->
                                    @if($loop->iteration === 1)
                                        <div class="w-6 h-6 mr-2 bg-amber-400 rounded-full flex items-center justify-center shadow-md">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @elseif($loop->iteration === 2)
                                        <div class="w-6 h-6 mr-2 bg-gray-300 rounded-full flex items-center justify-center shadow-md">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @elseif($loop->iteration === 3)
                                        <div class="w-6 h-6 mr-2 bg-amber-600 rounded-full flex items-center justify-center shadow-md">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <span class="w-8 text-lg font-medium text-gray-500 text-center mr-3">{{ $loop->iteration }}.</span>
                                    @endif
                                    
                                    <div>
                                        <p class="font-medium text-xs text-gray-800 @if($loop->iteration <= 3) font-bold @endif">
                                            {{ $user['name'] }}
                                        </p>
                                    </div>
                                </div>
                                
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($loop->iteration === 1) bg-amber-100 text-amber-800 @endif
                                    @if($loop->iteration === 2) bg-gray-100 text-gray-800 @endif
                                    @if($loop->iteration === 3) bg-amber-700/10 text-amber-800 @endif
                                    @if($loop->iteration > 3) bg-gray-100 text-gray-600 @endif">
                                    {{ $user['total'] }} pengajuan
                                </span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 text-xs text-gray-500 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
                        <p class="font-medium text-gray-700">Periode Penilaian:</p>
                        <p>
                            @if($selectedTriwulan)
                                Triwulan {{ $selectedTriwulan }} 
                            @elseif($selectedMonth)
                                {{ Carbon\Carbon::createFromDate($selectedYear, $selectedMonth)->translatedFormat('F Y') }}
                            @elseif($startDate && $endDate)
                                {{ \Carbon\Carbon::parse($startDate)->format('d M') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                            @else
                                Tahun {{ $selectedYear }}
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Daftar Pegawai Sedang Cuti --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="w-6 h-6 mr-4">
                    <defs>
                        <linearGradient id="purpleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#8B5CF6"/>
                        <stop offset="100%" stop-color="#C4B5FD"/>
                        </linearGradient>
                    </defs>
                    <path fill="url(#purpleGradient)" d="M346.3 271.8l-60.1-21.9L214 448 32 448c-17.7 0-32 14.3-32 32s14.3 32 32 32l512 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-261.9 0 64.1-176.2zm121.1-.2l-3.3 9.1 67.7 24.6c18.1 6.6 38-4.2 39.6-23.4c6.5-78.5-23.9-155.5-80.8-208.5c2 8 3.2 16.3 3.4 24.8l.2 6c1.8 57-7.3 113.8-26.8 167.4zM462 99.1c-1.1-34.4-22.5-64.8-54.4-77.4c-.9-.4-1.9-.7-2.8-1.1c-33-11.7-69.8-2.4-93.1 23.8l-4 4.5C272.4 88.3 245 134.2 226.8 184l-3.3 9.1L434 269.7l3.3-9.1c18.1-49.8 26.6-102.5 24.9-155.5l-.2-6zM107.2 112.9c-11.1 15.7-2.8 36.8 15.3 43.4l71 25.8 3.3-9.1c19.5-53.6 49.1-103 87.1-145.5l4-4.5c6.2-6.9 13.1-13 20.5-18.2c-79.6 2.5-154.7 42.2-201.2 108z"/>
                </svg>
                Daftar Pegawai Sedang Cuti (Hari Ini)
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-green-500 to-lime-500 text-white border-b">
                    <tr>
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Pegawai</th>
                        <th class="px-6 py-3 text-left">Jenis Cuti</th>
                        <th class="px-6 py-3 text-left">Sisa Hari</th>
                        <th class="px-6 py-3 text-left">Rentang Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        use Carbon\Carbon;
                        $today = Carbon::today();
                    @endphp

                    {{-- Menggunakan variabel $sedangCuti dari Controller --}}
                    @forelse($sedangCuti as $index => $cuti)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $cuti->user->name ?? '-' }}</div>
                                <div class="text-xs text-gray-500">NIP: {{ $cuti->user->nip ?? '-' }}</div>
                                <div class="text-xs text-gray-500">{{ $cuti->user->jabatan ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @isset($cuti->jenisCuti)
                                    <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-accent rounded-full">
                                        {{ $cuti->jenisCuti->nama_cuti }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-primary rounded-full">
                                        Cuti Tahunan
                                    </span>
                                @endisset
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    if ($today->greaterThan(Carbon::parse($cuti->tgl_selesai))) {
                                        $sisaHari = 0;
                                    } else {
                                        $sisaHari = $today->diffInDays(Carbon::parse($cuti->tgl_selesai)) + 1;
                                    }
                                    
                                    $totalHari = Carbon::parse($cuti->tgl_mulai)->diffInDays(Carbon::parse($cuti->tgl_selesai)) + 1;
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                    {{ $sisaHari }} hari
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ Carbon::parse($cuti->tgl_mulai)->translatedFormat('d M Y') }} - 
                                {{ Carbon::parse($cuti->tgl_selesai)->translatedFormat('d M Y') }}
                                <div class="text-xs text-gray-500">
                                    ({{ $totalHari }} hari)
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p>Tidak ada pegawai yang sedang cuti hari ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 text-sm text-gray-500 border-t border-gray-200">
            <div class="flex justify-between">
                <span>Total pegawai sedang cuti: {{ count($sedangCuti) }} orang</span>
                <span>Periode: {{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data dari controller
    const jumlahCuti = @json($jumlahCuti);
    const labels = @json($labels);
    const jenisLabels = @json($cutiJenisLabels);
    const jenisData = @json($cutiJenisData);
    const chartColors = @json($chartColors);
    const selectedMonth = @json($selectedMonth);
    const selectedTriwulan = @json($selectedTriwulan);
    const startDate = @json($startDate ?? '');
    const endDate = @json($endDate ?? '');
    const chartTitle = @json($chartTitle);
    const xAxisTitle = @json($xAxisTitle);
    const yAxisTitle = @json($yAxisTitle);

    // Bar Chart
    const ctx = document.getElementById('barChart').getContext('2d');
    const maxValue = Math.max(...jumlahCuti);

    const barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: chartTitle,
                data: jumlahCuti,
                backgroundColor: '#10B981',
                borderWidth: 0,
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: { size: 12 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} pengajuan`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: maxValue, // Gunakan max (bukan suggestedMax) untuk kontrol ketat
                    grace: '5%', // Tambahkan grace 5% untuk padding visual
                    grid: {
                        drawBorder: false,
                        color: '#E5E7EB',
                        lineWidth: 1,
                        borderDash: [3, 3]
                    },
                    ticks: {
                        color: '#6B7280',
                        font: { size: 10 },
                        padding: 8,
                        stepSize: 1,
                        precision: 0 // Pastikan hanya integer yang ditampilkan
                    },
                    title: {
                        display: true,
                        text: yAxisTitle,
                        color: '#374151',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        padding: {top: 10, bottom: 10}
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6B7280',
                        font: { size: 10 },
                        maxRotation: 0,
                        minRotation: 0,
                        autoSkip: true,
                        padding: 8
                    },
                    title: {
                        display: true,
                        text: xAxisTitle,
                        color: '#374151',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        padding: {top: 10, bottom: 10}
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Donut Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieChart = new Chart(pieCtx, {
        type: 'doughnut', 
        data: {
            labels: jenisLabels,
            datasets: [{
                label: 'Jenis Cuti',
                data: jenisData,
                backgroundColor: chartColors,
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 8
            }]
        },
        options: {
            cutout: '70%',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: {
                        size: 12
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 10,
                    cornerRadius: 6,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Check if pie chart has data
    document.addEventListener('DOMContentLoaded', function() {
        const pieCtx = document.getElementById('pieChart');
        const hasData = {!! json_encode(array_sum($cutiJenisData) > 0) !!};
        
        if (!hasData) {
            document.getElementById('emptyPie').classList.remove('hidden');
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elemen DOM
    const filterButton = document.getElementById('filterButton');
    const filterDropdown = document.getElementById('filterDropdown');
    const currentFilterLabel = document.getElementById('currentFilterLabel');
    const tabs = document.querySelectorAll('.filter-tab');
    const contents = document.querySelectorAll('.filter-content');
    const tahunFilter = document.getElementById('tahunFilter');
    const bulanFilter = document.getElementById('bulanFilter');
    const triwulanFilter = document.getElementById('triwulanFilter');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const applyFilter = document.getElementById('applyFilter');
    const resetFilter = document.getElementById('resetFilter');

    // Inisialisasi - pastikan dropdown tersembunyi
    filterDropdown.classList.add('hidden');

    // Set tanggal default
    const currentYear = new Date().getFullYear();
    startDateInput.max = endDateInput.max = `${currentYear}-12-31`;
    startDateInput.min = endDateInput.min = `${currentYear}-01-01`;

    // Set nilai input tanggal jika ada di URL
    if ("{{ $startDate ?? '' }}") {
        startDateInput.value = "{{ $startDate }}";
    }
    if ("{{ $endDate ?? '' }}") {
        endDateInput.value = "{{ $endDate }}";
    }

    // Fungsi untuk memformat tanggal
    const formatDate = (dateString) => {
        if (!dateString) return '';
        const options = { day: 'numeric', month: 'short' };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    };

    // Toggle dropdown
    filterButton.addEventListener('click', function(e) {
        e.stopPropagation();
        filterDropdown.classList.toggle('hidden');
    });

    // Tutup dropdown ketika klik di luar
    document.addEventListener('click', function(e) {
        if (!filterDropdown.contains(e.target) && e.target !== filterButton) {
            filterDropdown.classList.add('hidden');
        }
    });

    // Switch tab
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Hapus semua kelas aktif dari semua tab
            tabs.forEach(t => {
                t.classList.remove('border-primary', 'bg-green-50', 'text-primary');
                t.classList.add('border-gray-200', 'hover:border-gray-300');
            });
            
            // Tambahkan kelas aktif ke tab yang diklik
            this.classList.remove('border-gray-200', 'hover:border-gray-300');
            this.classList.add('border-primary', 'bg-green-50', 'text-primary');
            
            // Update active content
            const target = this.id.replace('tab', 'content');
            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(target).classList.remove('hidden');
        });
    });

    // Validasi tanggal
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        if (endDateInput.value && endDateInput.value < this.value) {
            endDateInput.value = this.value;
        }
    });

    endDateInput.addEventListener('change', function() {
        startDateInput.max = this.value;
        if (startDateInput.value && startDateInput.value > this.value) {
            startDateInput.value = this.value;
        }
    });

    // Terapkan filter
    applyFilter.addEventListener('click', function() {
        let url = new URL(window.location.href);
        let params = new URLSearchParams();
        
        params.set('tahun', tahunFilter.value);
        
        // Reset other filters
        params.delete('bulan');
        params.delete('triwulan');
        params.delete('start_date');
        params.delete('end_date');
        
        // Get active tab
        const activeTab = document.querySelector('.filter-tab.border-primary');
        let filterApplied = false;
        
        // Apply filter based on active tab
        if (activeTab && activeTab.id === 'tabBulan' && bulanFilter.value) {
            params.set('bulan', bulanFilter.value);
            currentFilterLabel.textContent = 'Bulan: ' + bulanFilter.options[bulanFilter.selectedIndex].text;
            filterApplied = true;
        } 
        else if (activeTab && activeTab.id === 'tabTriwulan' && triwulanFilter.value) {
            params.set('triwulan', triwulanFilter.value);
            currentFilterLabel.textContent = 'Triwulan: ' + triwulanFilter.options[triwulanFilter.selectedIndex].text;
            filterApplied = true;
        } 
        else if (activeTab && activeTab.id === 'tabRentang' && startDateInput.value && endDateInput.value) {
            params.set('start_date', startDateInput.value);
            params.set('end_date', endDateInput.value);
            currentFilterLabel.textContent = 'Rentang: ' + formatDate(startDateInput.value) + ' - ' + formatDate(endDateInput.value);
            filterApplied = true;
        }
        
        if (!filterApplied) {
            currentFilterLabel.textContent = 'Filter';
        }
        
        window.location.href = url.pathname + '?' + params.toString();
        filterDropdown.classList.add('hidden');
    });

    // Reset filter
    resetFilter.addEventListener('click', function() {
        let url = new URL(window.location.href);
        window.location.href = url.pathname;
    });

    // Set filter label berdasarkan parameter URL saat load
    function setInitialFilterLabel() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('bulan')) {
            const monthValue = urlParams.get('bulan');
            const monthName = bulanFilter.querySelector(`option[value="${monthValue}"]`)?.text || '';
            currentFilterLabel.textContent = 'Bulan: ' + monthName;
        } 
        else if (urlParams.has('triwulan')) {
            const triwulanValue = urlParams.get('triwulan');
            const triwulanName = triwulanFilter.querySelector(`option[value="${triwulanValue}"]`)?.text || '';
            currentFilterLabel.textContent = 'Triwulan: ' + triwulanName;
        } 
        else if (urlParams.has('start_date') && urlParams.has('end_date')) {
            currentFilterLabel.textContent = 'Rentang: ' + 
                formatDate(urlParams.get('start_date')) + ' - ' + 
                formatDate(urlParams.get('end_date'));
        } 
        else {
            currentFilterLabel.textContent = 'Filter';
        }
    }

    // Set tab aktif berdasarkan URL saat load
    function setActiveTabOnLoad() {
        const urlParams = new URLSearchParams(window.location.search);
        let activeTab = document.getElementById('tabBulan'); // Default ke tab Bulan
        
        if (urlParams.has('triwulan')) {
            activeTab = document.getElementById('tabTriwulan');
        } else if (urlParams.has('start_date') && urlParams.has('end_date')) {
            activeTab = document.getElementById('tabRentang');
        }
        
        // Trigger click event pada tab aktif
        if (activeTab) {
            activeTab.click();
        }
    }

    // Panggil fungsi inisialisasi
    setInitialFilterLabel();
    setActiveTabOnLoad();
    
    // Filter tahun
    tahunFilter.addEventListener('change', function() {
        const year = this.value;
        updateUrlWithFilters(year);
    });

    function updateUrlWithFilters(year, additionalParams = {}) {
        let url = new URL(window.location.href);
        let params = new URLSearchParams();
        
        params.set('tahun', year);
        
        // Add existing filters if they exist
        if (selectedMonth) params.set('bulan', selectedMonth);
        if (selectedTriwulan) params.set('triwulan', selectedTriwulan);
        if (startDate) params.set('start_date', startDate);
        if (endDate) params.set('end_date', endDate);
        
        // Add any additional params
        for (const [key, value] of Object.entries(additionalParams)) {
            if (value) params.set(key, value);
        }
        
        window.location.href = url.pathname + '?' + params.toString();
    }
});
</script>
@endsection