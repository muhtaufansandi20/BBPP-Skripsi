@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
<div class="max-w-6xl mx-auto p-6 pt-0">

    {{-- Header Judul --}}
    <div class="flex items-center gap-4 mb-6 group">
        <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-green-600 to-emerald-500 shadow-lg
                    group-hover:from-green-700 group-hover:to-emerald-600 transition-all duration-300
                    ring-2 ring-white/20 ring-inset hover:ring-green-400/40 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div class="w-full">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                Detail Pengajuan Cuti
            </h2>
            <div class="relative mt-2">
                <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full w-0
                            group-hover:w-full transition-all duration-500 ease-out"></div>
                <div class="h-0.5 bg-gray-200 rounded-full"></div>
            </div>
        </div>
    </div>

    {{-- Detail Cuti Card --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 border-b border-gray-100 flex items-center justify-between">
            <h5 class="text-base sm:text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="font-semibold uppercase">Detail Cuti</span>
            </h5>
            <span class="text-xs bg-white/20 text-white px-3 py-1 rounded-full backdrop-blur-sm">
                ID: {{ $pengajuan->id }}
            </span>
        </div>

        <div class="p-6 space-y-0 divide-y divide-gray-100">

            {{-- Baris 1: Jenis Cuti & Lama Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5">Jenis Cuti</p>
                    <p class="text-sm font-semibold text-emerald-600">{{ $pengajuan->jenisCuti->nama_cuti ?? '-' }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5">Lama Cuti</p>
                    <div>
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold inline-flex items-center gap-1">
                            <i class="far fa-clock text-[10px]"></i>
                            {{ $pengajuan->jumlah_hari }} 
                            @if(in_array($pengajuan->jenisCuti->nama_cuti ?? '', ['Cuti Besar', 'Cuti Melahirkan']))
                                Bulan
                            @elseif(in_array($pengajuan->jenisCuti->nama_cuti ?? '', ['Cuti Alasan Penting', 'Cuti Sakit']))
                                Hari Kerja
                            @else
                                Hari
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Baris 2: Periode Cuti & Nomor Telepon --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5">Periode Cuti</p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ date('d/m/Y', strtotime($pengajuan->tgl_mulai)) }} s/d {{ date('d/m/Y', strtotime($pengajuan->tgl_selesai)) }}
                    </p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5">Nomor Telepon</p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->no_hp_cuti ?? '-' }}</p>
                </div>
            </div>

            {{-- Baris 3: Alasan Cuti & Alamat Selama Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5">Alasan Cuti</p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pengajuan->alasan ?? '-' }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5">Alamat Selama Cuti</p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pengajuan->alamat_saat_cuti ?? '-' }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Lampiran Dokumen Card (Jika Ada) --}}
    @if(isset($lampiran) || $pengajuan->lampiran)
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 border-b border-gray-100 flex items-center gap-2 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
            </svg>
            <span class="font-semibold uppercase text-sm">Lampiran Dokumen</span>
        </div>
        <div class="p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ $lampiran->nama_doc ?? basename($pengajuan->lampiran ?? 'Dokumen Pendukung') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Lampiran pengajuan cuti</p>
            </div>
            <div class="flex items-center gap-2">
                @php $fileUrl = isset($lampiran) ? Storage::url($lampiran->file_path) : asset('storage/' . $pengajuan->lampiran); @endphp
                <button type="button" onclick="openPreviewPanel()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat
                </button>
                <a href="{{ $fileUrl }}" target="_blank" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Unduh
                </a>
            </div>
        </div>
    </div>
    @endif

    {{-- Status Verifikasi (Timeline Sesuai Referensi Gambar) --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-5 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="text-sm font-semibold text-white uppercase tracking-wide">Status Verifikasi</span>
        </div>

        <div class="p-6">
            @php
                // Ambil status Admin
                $adminModel = $pengajuan->cuStatusUserAdmin ?? null;
                $rawAdmin = $adminModel->status ?? null;
                $adminStatus = $rawAdmin ? strtolower(trim($rawAdmin)) : 'pending';
                $adminCatatan = $adminModel->catatan ?? 'Tidak ada catatan';

                // Ambil status Kepala Bagian (Kabag)
                $kabagModel = optional($adminModel)->cuStatusAdminKatimker ? optional($adminModel)->cuStatusAdminKatimker->cuStatusKatimkerKabag : null;
                $rawKabag = $kabagModel->status ?? null;
                $kabagStatus = $rawKabag ? strtolower(trim($rawKabag)) : 'pending';
                $kabagCatatan = $kabagModel->catatan ?? 'Tidak ada catatan';

                // Ambil status Kepala Balai (Kabal)
                $kabalModel = optional($kabagModel)->cuStatusKabagKabal ?? null;
                $rawKabal = $kabalModel->status ?? null;
                $kabalStatus = $rawKabal ? strtolower(trim($rawKabal)) : 'pending';
                $kabalCatatan = $kabalModel->catatan ?? 'Tidak ada catatan';
            @endphp

            <div class="space-y-0">

                {{-- Step 1: Admin --}}
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        @php
                            if ($adminStatus === 'disetujui') {
                                $s1Bg = 'bg-green-50'; $s1Border = 'border-green-500'; $s1Line = 'bg-green-400';
                                $s1Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                            } elseif ($adminStatus === 'ditolak') {
                                $s1Bg = 'bg-red-50'; $s1Border = 'border-red-500'; $s1Line = 'bg-gray-200';
                                $s1Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                            } else {
                                $s1Bg = 'bg-white'; $s1Border = 'border-slate-300'; $s1Line = 'bg-gray-200';
                                $s1Icon = '<svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><line x1="8" y1="12" x2="16" y2="12"/></svg>';
                            }
                        @endphp
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s1Bg }} {{ $s1Border }}">
                            {!! $s1Icon !!}
                        </div>
                        <div class="w-0.5 flex-1 {{ $s1Line }}" style="min-height:36px;"></div>
                    </div>

                    <div class="flex-1 pl-3 pb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Admin</p>
                                <p class="text-xs text-gray-500 mt-0.5">Administrator</p>
                            </div>
                            @if($adminStatus === 'disetujui')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @elseif($adminStatus === 'ditolak')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Menunggu</span>
                            @endif
                        </div>
                        <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                            <span class="font-medium text-gray-500">Catatan:</span> {{ $adminCatatan }}
                        </div>
                    </div>
                </div>

                {{-- Step 2: Kepala Bagian --}}
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        @php
                            if ($kabagStatus === 'disetujui') {
                                $s2Bg = 'bg-green-50'; $s2Border = 'border-green-500'; $s2Line = 'bg-green-400';
                                $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                            } elseif ($kabagStatus === 'ditolak') {
                                $s2Bg = 'bg-red-50'; $s2Border = 'border-red-500'; $s2Line = 'bg-gray-200';
                                $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                            } else {
                                $s2Bg = 'bg-white'; $s2Border = 'border-slate-300'; $s2Line = 'bg-gray-200';
                                $s2Icon = '<svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><line x1="8" y1="12" x2="16" y2="12"/></svg>';
                            }
                        @endphp
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s2Bg }} {{ $s2Border }}">
                            {!! $s2Icon !!}
                        </div>
                        <div class="w-0.5 flex-1 {{ $s2Line }}" style="min-height:36px;"></div>
                    </div>

                    <div class="flex-1 pl-3 pb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Kepala Bagian</p>
                                <p class="text-xs text-gray-500 mt-0.5">Rosdiana, S. Pi, MM · NIP 197001141999032001</p>
                            </div>
                            @if($kabagStatus === 'disetujui')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @elseif($kabagStatus === 'ditolak')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Menunggu</span>
                            @endif
                        </div>
                        <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                            <span class="font-medium text-gray-500">Catatan:</span> {{ $kabagCatatan }}
                        </div>
                    </div>
                </div>

                {{-- Step 3: Kepala Balai --}}
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        @php
                            if ($kabalStatus === 'disetujui') {
                                $s3Bg = 'bg-green-50'; $s3Border = 'border-green-500';
                                $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                            } elseif ($kabalStatus === 'ditolak') {
                                $s3Bg = 'bg-red-50'; $s3Border = 'border-red-500';
                                $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                            } else {
                                $s3Bg = 'bg-white'; $s3Border = 'border-slate-300';
                                $s3Icon = '<svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><circle cx="12" cy="12" r="9"/><line x1="8" y1="12" x2="16" y2="12"/></svg>';
                            }
                        @endphp
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s3Bg }} {{ $s3Border }}">
                            {!! $s3Icon !!}
                        </div>
                    </div>

                    <div class="flex-1 pl-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">Kepala Balai</p>
                                <p class="text-xs text-gray-500 mt-0.5">Jamaluddin Al Afgani, S.Pd.,MP · NIP 197705012008011010</p>
                            </div>
                            @if($kabalStatus === 'disetujui')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @elseif($kabalStatus === 'ditolak')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Menunggu</span>
                            @endif
                        </div>
                        <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                            <span class="font-medium text-gray-500">Catatan:</span> {{ $kabalCatatan }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Tombol Bawah & Aksi Unduh --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
        <a href="{{ route('katimkerpengajuancutiumum.index') }}" 
            class="w-full sm:w-auto flex items-center justify-center px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-semibold bg-white hover:bg-gray-50 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>

        @if($kabalStatus === 'disetujui')
        <a href="{{ route('viewPDFUmum', ['id' => $pengajuan->id]) }}" target="_blank" 
           class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            <span>Unduh Surat Cuti</span>
        </a>
        @endif
    </div>

</div>

{{-- Preview Panel untuk Lampiran Dokumen --}}
<div id="previewPanel" class="fixed inset-0 z-50 hidden">
    <div class="flex h-full">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePreviewPanel()"></div>
        
        <div class="relative flex flex-col w-full md:w-3/4 lg:w-2/3 h-full bg-white shadow-xl ml-auto transform transition-transform duration-300 ease-in-out translate-x-full" id="panelContent">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold">Preview Dokumen</h3>
                <div class="flex items-center space-x-2">
                    @php $fileUrl = isset($lampiran) ? Storage::url($lampiran->file_path) : (isset($pengajuan->lampiran) ? asset('storage/' . $pengajuan->lampiran) : '#'); @endphp
                    <a href="{{ $fileUrl }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        <i class="fas fa-external-link-alt mr-1"></i> Buka di Tab Baru
                    </a>
                    <button onclick="closePreviewPanel()" class="p-2 rounded-full hover:bg-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex-1 p-4 overflow-auto bg-gray-100">
                @if(isset($lampiran) || isset($pengajuan->lampiran))
                @php
                    $filePath = isset($lampiran) ? $lampiran->file_path : $pengajuan->lampiran;
                    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                @endphp

                <div class="bg-white shadow rounded-lg p-2 h-full">
                    @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                        <div class="flex items-center justify-center h-full">
                            <img src="{{ $fileUrl }}" alt="Preview" class="max-w-full max-h-full object-contain">
                        </div>
                    @elseif(strtolower($fileExtension) == 'pdf')
                        <div class="h-full w-full">
                            <embed src="{{ $fileUrl }}" type="application/pdf" width="100%" height="100%" class="h-full">
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-full">
                            <i class="fas fa-file text-blue-500 text-6xl mb-4"></i>
                            <p class="text-lg font-medium">File {{ strtoupper($fileExtension) }}</p>
                            <p class="text-gray-600 mt-2">File ini tidak dapat ditampilkan secara langsung di browser</p>
                            <a href="{{ $fileUrl }}" download class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <i class="fas fa-download mr-1"></i> Download File
                            </a>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Preview Panel
    function openPreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const panelContent = document.getElementById("panelContent");
        panel.classList.remove("hidden");
        setTimeout(() => { panelContent.classList.remove("translate-x-full"); }, 10);
    }

    function closePreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const panelContent = document.getElementById("panelContent");
        panelContent.classList.add("translate-x-full");
        setTimeout(() => { panel.classList.add("hidden"); }, 300);
    }
</script>
@endsection