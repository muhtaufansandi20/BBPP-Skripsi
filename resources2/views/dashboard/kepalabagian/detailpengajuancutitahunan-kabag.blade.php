@extends('dashboard.kepalabagian.base-kepalabagian')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Page -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-emerald-600">
            Detail Pengajuan Cuti
        </h1>
        <p class="text-sm text-gray-500 mt-1">Informasi lengkap pengajuan cuti tahunan Anda</p>
    </div>

    <!-- Main Card Wrapper -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <!-- Green Banner -->
        <div class="bg-emerald-600 p-6 text-white">
            <h2 class="text-xl font-bold">Formulir Pengajuan Cuti</h2>
            <p class="text-emerald-100 text-sm mt-1">Diajukan pada: {{ date('d F Y', strtotime($pengajuancutitahunan->tgl_pengajuan)) }}</p>
        </div>
        
        <div class="p-6">
            <!-- Box Detail Cuti -->
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 mb-8">
                <h3 class="text-md font-bold text-gray-700 mb-5 flex items-center gap-2">
                    <i class="far fa-calendar-check text-emerald-500 text-lg"></i> Detail Cuti
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                    <!-- Column 1 -->
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Periode Cuti</p>
                            <p class="font-bold text-gray-800 text-sm">
                                {{ date('d/m/Y', strtotime($pengajuancutitahunan->tgl_mulai)) }} 
                                <span class="text-gray-400 font-normal mx-1">s/d</span> 
                                {{ date('d/m/Y', strtotime($pengajuancutitahunan->tgl_selesai)) }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Nomor Telepon</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $pengajuancutitahunan->no_hp_cuti }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Alasan Cuti</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $pengajuancutitahunan->alasan }}</p>
                        </div>
                    </div>
                    
                    <!-- Column 2 -->
                    <div class="space-y-5">
                        <div>
                            <p class="text-sm text-gray-500 mb-2">Lama Cuti</p>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                <i class="far fa-clock"></i> {{ $pengajuancutitahunan->lama_cuti }} Hari Kerja
                            </span>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Alamat Selama Cuti</p>
                            <p class="font-medium text-gray-800 text-sm">{{ $pengajuancutitahunan->alamat_saat_cuti }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Verifikasi Timeline -->
            <div>
                <h3 class="text-md font-bold text-gray-700 mb-6 flex items-center gap-2">
                    <i class="fas fa-shield-check text-emerald-500 text-lg"></i> Status Verifikasi
                </h3>

                @php
                    // Helper untuk menentukan gaya CSS berdasarkan status
                    function getStatusStyle($status) {
                        $status = strtolower($status ?? '');
                        if ($status == 'disetujui') {
                            return ['border' => 'border-emerald-500', 'text' => 'text-emerald-500', 'bg_badge' => 'bg-emerald-100', 'text_badge' => 'text-emerald-700', 'icon' => 'fas fa-check', 'label' => 'Disetujui', 'line' => 'bg-emerald-500'];
                        } elseif ($status == 'ditolak') {
                            return ['border' => 'border-red-500', 'text' => 'text-red-500', 'bg_badge' => 'bg-red-100', 'text_badge' => 'text-red-700', 'icon' => 'fas fa-times', 'label' => 'Ditolak', 'line' => 'bg-gray-200'];
                        } elseif ($status == 'perubahan') {
                            return ['border' => 'border-blue-500', 'text' => 'text-blue-500', 'bg_badge' => 'bg-blue-100', 'text_badge' => 'text-blue-700', 'icon' => 'fas fa-edit', 'label' => 'Perubahan', 'line' => 'bg-gray-200'];
                        } else {
                            return ['border' => 'border-yellow-400', 'text' => 'text-yellow-500', 'bg_badge' => 'bg-yellow-50', 'text_badge' => 'text-yellow-600', 'icon' => 'far fa-clock', 'label' => 'Menunggu', 'line' => 'bg-gray-200'];
                        }
                    }

                    $adminStyle = getStatusStyle($statusAdmin);
                    $kabalStyle = getStatusStyle($statusKabal);
                @endphp

                <div class="space-y-0 pl-2">
                    <!-- Step 1: Admin -->
                    <div class="flex gap-4 relative">
                        <!-- Vertical Line (Dynamic color based on Admin Status) -->
                        <div class="absolute left-4 top-8 bottom-[-16px] w-[2px] {{ $adminStyle['line'] }}"></div>
                        
                        <!-- Timeline Icon -->
                        <div class="relative z-10 flex-shrink-0 w-8 h-8 rounded-full border-2 bg-white flex items-center justify-center {{ $adminStyle['border'] }} {{ $adminStyle['text'] }}">
                            <i class="{{ $adminStyle['icon'] }} text-xs"></i>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 pb-8">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Admin</h4>
                                    <p class="text-xs text-gray-400 mt-0.5">Administrator</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold {{ $adminStyle['bg_badge'] }} {{ $adminStyle['text_badge'] }}">
                                    {{ $adminStyle['label'] }}
                                </span>
                            </div>
                            <div class="bg-gray-50/80 rounded-lg p-3 text-xs text-gray-500 mt-2">
                                Catatan: {{ empty($catatanAdmin) ? 'Tidak ada catatan' : $catatanAdmin }}
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Kepala Balai -->
                    <div class="flex gap-4 relative">
                        <!-- Timeline Icon -->
                        <div class="relative z-10 flex-shrink-0 w-8 h-8 rounded-full border-2 bg-white flex items-center justify-center {{ $kabalStyle['border'] }} {{ $kabalStyle['text'] }}">
                            <i class="{{ $kabalStyle['icon'] }} text-xs"></i>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Kepala Balai</h4>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $kepalaBalaiNama ?? 'Nama Kepala Balai' }} - NIP {{ $kepalaBalaiNIP ?? '-' }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold {{ $kabalStyle['bg_badge'] }} {{ $kabalStyle['text_badge'] }}">
                                    {{ $kabalStyle['label'] }}
                                </span>
                            </div>
                            <div class="bg-gray-50/80 rounded-lg p-3 text-xs text-gray-500 mt-2">
                                Catatan: {{ empty($catatanKabal) ? 'Tidak ada catatan' : $catatanKabal }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <a href="{{ route('kabagpengajuancutitahunan.index') }}" 
                   class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-[#475569] hover:bg-[#334155] text-white text-sm font-medium rounded-lg transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Daftar</span>
                </a>
                
                <!-- Action Tools (Download) -->
                <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                    @if(isset($statusKabal) && $statusKabal == 'disetujui')
                        <a href="{{ route('viewPDF', ['id' => $pengajuancutitahunan->id]) }}" target="_blank" 
                           class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-file-pdf"></i>
                            <span>Unduh Surat Cuti</span>
                        </a>
                    @endif
                </div>
            </div>

        </div> 
    </div>
</div>
@endsection