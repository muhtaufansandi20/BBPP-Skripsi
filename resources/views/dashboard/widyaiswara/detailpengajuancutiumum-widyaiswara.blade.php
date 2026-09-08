@extends('dashboard.widyaiswara.base-widyaiswara')

@section('main')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-4">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-lime-600">
                DETAIL PENGAJUAN CUTI UMUM
            </h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap pengajuan cuti umum</p>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">
        <!-- Gradient Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-lime-700 p-5 text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold">Formulir Pengajuan Cuti Umum</h2>
                    <p class="text-emerald-100 text-sm mt-1">ID: {{ $pengajuan->id }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2 border border-white/20">
                    <p class="text-xs text-emerald-100">Diajukan pada:</p>
                    <p class="font-semibold text-sm sm:text-base">{{ date('d F Y', strtotime($pengajuan->tgl_pengajuan)) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Status Banner -->
        @php
            $overallStatus = 'Menunggu Persetujuan';
            $statusColorClass = 'bg-gradient-to-r from-yellow-50 to-amber-50 border-yellow-200 text-yellow-800';
            $statusIcon = 'fas fa-clock';
            
            if (strtolower($statusKabal) == 'ditolak') {
                $overallStatus = 'Ditolak';
                $statusColorClass = 'bg-gradient-to-r from-red-50 to-rose-50 border-red-200 text-red-800';
                $statusIcon = 'fas fa-times-circle';
            } elseif (strtolower($statusKabal) == 'ditangguhkan') {
                $overallStatus = 'Ditangguhkan';
                $statusColorClass = 'bg-gradient-to-r from-purple-50 to-violet-50 border-purple-200 text-purple-800';
                $statusIcon = 'fas fa-pause-circle';
            } elseif (strtolower($statusKabal) == 'perubahan') {
                $overallStatus = 'Perubahan Diminta';
                $statusColorClass = 'bg-gradient-to-r from-lime-50 to-emerald-50 border-lime-200 text-lime-800';
                $statusIcon = 'fas fa-edit';
            } elseif (strtolower($statusKabal) == 'disetujui') {
                $overallStatus = 'Disetujui';
                $statusColorClass = 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200 text-green-800';
                $statusIcon = 'fas fa-check-circle';
            }
        @endphp
        
        <div class="{{ $statusColorClass }} border-y p-5">
            <div class="flex items-start sm:items-center gap-4">
                <div class="flex-shrink-0 p-2 rounded-full bg-white/80 backdrop-blur-sm">
                    <i class="{{ $statusIcon }} text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Status Pengajuan: <span class="underline">{{ $overallStatus }}</span></h3>
                    <p class="mt-2 text-sm">
                        @if($overallStatus == 'Menunggu Persetujuan')
                            Pengajuan cuti Anda sedang diproses
                        @elseif($overallStatus == 'Disetujui')
                            Pengajuan cuti Anda telah disetujui. Anda dapat mengunduh dokumen cuti sekarang.
                        @elseif($overallStatus == 'Ditolak')
                            Pengajuan cuti Anda ditolak. Silakan periksa catatan untuk detail lebih lanjut.
                        @elseif($overallStatus == 'Ditangguhkan')
                            Pengajuan cuti Anda ditangguhkan. Silakan periksa catatan untuk informasi lebih lanjut.
                        @elseif($overallStatus == 'Perubahan Diminta')
                            Ada permintaan perubahan untuk pengajuan cuti Anda. Silakan periksa catatan untuk detail.
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="p-5 sm:p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Detail Cuti -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-sm transition-shadow">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Detail Cuti</span>
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Cuti</label>
                            <p class="text-gray-800 font-medium">{{ $pengajuan->jenisCuti->nama_cuti }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Periode Cuti</label>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-emerald-100 text-emerald-800 text-sm font-medium px-3 py-1 rounded-lg flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ date('d M Y', strtotime($pengajuan->tgl_mulai)) }}
                                </span>
                                <span class="text-gray-500 mx-1">s/d</span>
                                <span class="bg-emerald-100 text-emerald-800 text-sm font-medium px-3 py-1 rounded-lg flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ date('d M Y', strtotime($pengajuan->tgl_selesai)) }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Lama Cuti</label>
                            <span class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-medium px-4 py-1.5 rounded-lg inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $pengajuan->jumlah_hari }} 
                                @if($pengajuan->jenisCuti->nama_cuti == 'Cuti Besar' || $pengajuan->jenisCuti->nama_cuti == 'Cuti Melahirkan')
                                    bulan
                                @elseif($pengajuan->jenisCuti->nama_cuti == 'Cuti Alasan Penting' || $pengajuan->jenisCuti->nama_cuti == 'Cuti Sakit')
                                    hari kerja
                                @else
                                    hari
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Kontak & Alasan -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-sm transition-shadow">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Informasi Tambahan</span>
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <p class="text-gray-800 font-medium">{{ $pengajuan->no_hp_cuti }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Selama Cuti</label>
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-gray-800">{{ $pengajuan->alamat_saat_cuti }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alasan Cuti</label>
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <p class="text-gray-800">{{ $pengajuan->alasan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Lampiran Section -->
                @if(isset($lampiran))
                <div class="col-span-2 bg-gray-50 rounded-xl p-5 border border-gray-200 hover:shadow-sm transition-shadow">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span>Lampiran</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama Dokumen</label>
                            <p class="text-gray-800">{{ $lampiran->nama_doc }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Diunggah pada</label>
                            <p class="text-gray-800">{{ date('d F Y H:i', strtotime($lampiran->uploaded_at)) }}</p>
                        </div>
                        
                        @if($lampiran->description)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                            <p class="text-gray-800">{{ $lampiran->description }}</p>
                        </div>
                        @endif
                        
                        <div class="md:col-span-2 mt-2">
                            <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-600 to-lime-600 hover:from-emerald-700 hover:to-lime-700 text-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                <span class="text-sm font-medium">Unduh Lampiran</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Status Verifikasi -->
            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Status Verifikasi</span>
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Status Admin -->
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-700">Verifikasi Admin</h3>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($statusAdmin == 'disetujui') bg-green-100 text-green-800
                                @elseif($statusAdmin == 'ditolak') bg-red-100 text-red-800
                                @elseif($statusAdmin == 'ditangguhkan') bg-orange-100 text-orange-800
                                @elseif($statusAdmin == 'perubahan') bg-lime-100 text-lime-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($statusAdmin) }}
                            </span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 text-sm">
                            <p class="text-gray-600 font-medium mb-1">Catatan:</p>
                            <p class="text-gray-800">{{ $catatanAdmin }}</p>
                        </div>
                    </div>
                    
                    <!-- Status Kepala Balai -->
                    <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="font-semibold text-gray-700">Verifikasi Kepala Balai</h3>
                                <p class="text-sm text-gray-500">{{ $kepalaBalaiNama }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                @if($statusKabal == 'disetujui') bg-green-100 text-green-800
                                @elseif($statusKabal == 'ditolak') bg-red-100 text-red-800
                                @elseif($statusKabal == 'ditangguhkan') bg-orange-100 text-orange-800
                                @elseif($statusKabal == 'perubahan') bg-lime-100 text-indigo-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($statusKabal) }}
                            </span>
                        </div>
                        
                        <div class="border-t border-gray-100 pt-3 mt-3">
                            <p class="text-sm text-gray-500">{{ $kepalaBalaiNIP }}</p>
                            <p class="text-sm text-gray-700">{{ $kepalaBalaiJabatan }}</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 text-sm mt-4">
                            <p class="text-gray-600 font-medium mb-1">Catatan:</p>
                            <p class="text-gray-800">{{ $catatanKabal }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col-reverse sm:flex-row justify-between items-center gap-4">
                <a href="{{ route('widyaiswarapengajuancutiumum.index') }}" 
                   class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Daftar</span>
                </a>
                
                <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                    @if($statusKabal == 'disetujui')
                    <a href="{{ route('viewPDFUmum', ['id' => $pengajuan->id]) }}" target="_blank" 
                       class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                        <span class="text-sm font-medium">Unduh Surat Cuti</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>  
    </div>
</div>

<script>
    // Fungsi menentukan satuan cuti
    function updateSatuanCuti() {
        const jenisCutiNama = "{{ $pengajuan->jenisCuti->nama_cuti }}";
        const satuanSpan = $('#satuan_cuti');

        if (jenisCutiNama === 'Cuti Melahirkan' || jenisCutiNama === 'Cuti Besar') {
            satuanSpan.text('bulan');
        } else if (jenisCutiNama === 'Cuti Alasan Penting' || jenisCutiNama === 'Cuti Sakit') {
            satuanSpan.text('hari kerja');
        } else {
            satuanSpan.text('hari'); // Default satuan jika tidak termasuk jenis di atas
        }
    }

    // Panggil saat halaman dimuat untuk set awal
    $(document).ready(function() {
        updateSatuanCuti();
    });
</script>
@endsection