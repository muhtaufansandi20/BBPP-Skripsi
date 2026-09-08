@extends('dashboard.kepalabalai.base-kepalabalai')

@section('content')
@php
    // Menentukan apakah yang mengajukan adalah Kepala Bagian (berdasarkan kesamaan NIP)
    // Logika ini digunakan untuk menyembunyikan Step 2 (Verifikasi Kabag) jika true
    $isKabagRequest = isset($kepalaBagian) && ($custatuskatimkerkabag->nip === $kepalaBagian->nip);
@endphp

<div class="max-w-6xl mx-auto p-6 pt-0">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6 group">
        <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-green-600 to-emerald-500 shadow-lg ring-2 ring-white/20 ring-inset hover:scale-105 transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <div class="w-full">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Detail Pengajuan Cuti Umum</h2>
            <div class="relative mt-2">
                <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
                <div class="h-0.5 bg-gray-200 rounded-full"></div>
            </div>
        </div>
    </div>

    {{-- Biodata Pegawai --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-6 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="font-semibold uppercase tracking-wide">Biodata Pegawai</span>
            </h5>
        </div>
        <div class="p-6 space-y-0 divide-y divide-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        Nama
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->name ?? '-' }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                        NIP
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->nip ?? '-' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        Jabatan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->jabatan ?? '-' }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Masa Kerja
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->masa_kerja ?? '-' }}</p>
                </div>
            </div>
            <div class="py-4 px-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    No HP
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->no_hp ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Detail Pengajuan Cuti --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 border-b border-gray-100 flex justify-between items-center">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="font-semibold uppercase tracking-wide">Detail Pengajuan Cuti</span>
            </h5>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-xs font-bold bg-[#FEF3C7] text-yellow-700 uppercase tracking-wide border border-yellow-200">
                <i class="fas fa-tag text-[10px]"></i> {{ $custatuskatimkerkabag->nama_cuti }}
            </span>
        </div>
        <div class="p-6 space-y-0 divide-y divide-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Tanggal Pengajuan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->tgl_pengajuan ?? '-' }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Tanggal Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $custatuskatimkerkabag->tgl_mulai ?? '-' }}
                        <span class="text-gray-400 mx-1.5">—</span>
                        {{ $custatuskatimkerkabag->tgl_selesai ?? '-' }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Lama Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->jumlah_hari ?? '0' }} hari</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        No HP Saat Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $custatuskatimkerkabag->no_hp_cuti ?? '-' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                        Alasan Melakukan Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $custatuskatimkerkabag->alasan ?? '-' }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Alamat Saat Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $custatuskatimkerkabag->alamat_saat_cuti ?? '-' }}</p>
                </div>
            </div>
            
            {{-- Bagian Lampiran Dokumen (Jika Ada) --}}
            @if(isset($lampiran))
            <div class="py-6 px-2">
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <h6 class="text-sm font-bold text-gray-700">Lampiran Dokumen</h6>
                    </div>
                    <div class="p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-emerald-50 flex flex-col items-center justify-center border border-emerald-100 text-emerald-500 shrink-0">
                                @php $ext = pathinfo($lampiran->file_path, PATHINFO_EXTENSION); @endphp
                                <span class="text-[10px] font-bold uppercase">{{ $ext }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800 truncate max-w-[200px] sm:max-w-xs">{{ $lampiran->nama_doc }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">Diunggah: {{ $lampiran->uploaded_at }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" 
                               class="flex-1 sm:flex-none px-4 py-2 border border-blue-500 text-blue-600 hover:bg-blue-50 rounded-lg text-xs font-semibold flex items-center justify-center gap-2 transition-colors">
                                Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Alur Verifikasi (Timeline) --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-5 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="text-sm font-semibold text-white uppercase tracking-wide">Alur Verifikasi</span>
        </div>

        <div class="p-6">
            <div class="space-y-0">

                {{-- Step 1: Administrator (Selalu Tampil) --}}
                @php
                    $rawAdmin = $custatuskatimkerkabag->status_admin_katimker ?? 'disetujui';
                    $stAdmin = strtolower(trim($rawAdmin));

                    if ($stAdmin === 'ditolak') {
                        $sAdminBg = 'bg-red-50'; $sAdminBorder = 'border-red-500'; $sAdminLine = 'bg-gray-200';
                        $sAdminIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                        $sAdminBadgeClass = 'bg-red-100 text-red-800'; $sAdminDotClass = 'bg-red-500'; $sAdminBadgeText = 'Ditolak';
                    } elseif ($stAdmin === 'perubahan') {
                        $sAdminBg = 'bg-indigo-50'; $sAdminBorder = 'border-indigo-400'; $sAdminLine = 'bg-gray-200';
                        $sAdminIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3730A3" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>';
                        $sAdminBadgeClass = 'bg-indigo-100 text-indigo-800'; $sAdminDotClass = 'bg-indigo-500'; $sAdminBadgeText = 'Perubahan';
                    } else {
                        $sAdminBg = 'bg-green-50'; $sAdminBorder = 'border-green-500'; $sAdminLine = 'bg-green-400';
                        $sAdminIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                        $sAdminBadgeClass = 'bg-green-100 text-green-800'; $sAdminDotClass = 'bg-green-500'; $sAdminBadgeText = 'Disetujui';
                    }
                @endphp
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $sAdminBg }} {{ $sAdminBorder }}">
                            {!! $sAdminIcon !!}
                        </div>
                        <div class="w-0.5 flex-1 {{ $sAdminLine }}" style="min-height:20px;"></div>
                    </div>
                    <div class="flex-1 pl-3 pb-6">
                        <p class="text-sm font-semibold text-gray-800">Administrator</p>
                        <p class="text-xs text-gray-500 mt-0.5">Admin Sistem</p>
                        <span class="mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sAdminBadgeClass }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $sAdminDotClass }}"></span>
                            {{ $sAdminBadgeText }}
                        </span>
                    </div>
                </div>

                {{-- Step 2: Kepala Bagian Umum (Hanya Tampil Jika Bukan Kabag Yang Mengajukan) --}}
                @if(!$isKabagRequest)
                @php
                    $rawKabag = $custatuskatimkerkabag->status_katimker_kabag ?? 'disetujui';
                    $st2 = strtolower(trim($rawKabag));

                    if ($st2 === 'ditolak') {
                        $s2Bg = 'bg-red-50'; $s2Border = 'border-red-500'; $s2Line = 'bg-gray-200';
                        $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                        $s2BadgeClass = 'bg-red-100 text-red-800'; $s2DotClass = 'bg-red-500'; $s2BadgeText = 'Ditolak';
                    } elseif ($st2 === 'perubahan') {
                        $s2Bg = 'bg-indigo-50'; $s2Border = 'border-indigo-400'; $s2Line = 'bg-gray-200';
                        $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3730A3" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>';
                        $s2BadgeClass = 'bg-indigo-100 text-indigo-800'; $s2DotClass = 'bg-indigo-500'; $s2BadgeText = 'Perubahan';
                    } else {
                        $s2Bg = 'bg-green-50'; $s2Border = 'border-green-500'; $s2Line = 'bg-green-400';
                        $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                        $s2BadgeClass = 'bg-green-100 text-green-800'; $s2DotClass = 'bg-green-500'; $s2BadgeText = 'Disetujui';
                    }
                @endphp
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s2Bg }} {{ $s2Border }}">
                            {!! $s2Icon !!}
                        </div>
                        <div class="w-0.5 flex-1 {{ $s2Line }}" style="min-height:20px;"></div>
                    </div>
                    <div class="flex-1 pl-3 pb-6">
                        <p class="text-sm font-semibold text-gray-800">Kepala Bagian Umum</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $kepalaBagian->name ?? 'Rosdiana, S. Pi, MM' }}</p>
                        <p class="text-xs text-gray-400">
                            NIP {{ $kepalaBagian->nip ?? '197001141999032001' }}
                        </p>
                        @if(!empty($custatuskatimkerkabag->catatan_kabag))
                            <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                                <span class="font-medium text-gray-500">Catatan:</span> {{ $custatuskatimkerkabag->catatan_kabag }}
                            </div>
                        @endif
                        <span class="mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s2BadgeClass }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $s2DotClass }}"></span>
                            {{ $s2BadgeText }}
                        </span>
                    </div>
                </div>
                @endif

                {{-- Step 3: Kepala Balai (Selalu Tampil) --}}
                @php
                    $st3 = strtolower($checkverifikasi->status ?? '');
                    if ($st3 === 'disetujui') {
                        $s3Bg = 'bg-green-50'; $s3Border = 'border-green-500';
                        $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                        $s3BadgeClass = 'bg-green-100 text-green-800'; $s3DotClass = 'bg-green-500'; $s3BadgeText = 'Disetujui';
                    } elseif ($st3 === 'ditolak') {
                        $s3Bg = 'bg-red-50'; $s3Border = 'border-red-500';
                        $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                        $s3BadgeClass = 'bg-red-100 text-red-800'; $s3DotClass = 'bg-red-500'; $s3BadgeText = 'Ditolak';
                    } elseif ($st3 === 'perubahan') {
                        $s3Bg = 'bg-indigo-50'; $s3Border = 'border-indigo-400';
                        $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3730A3" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>';
                        $s3BadgeClass = 'bg-indigo-100 text-indigo-800'; $s3DotClass = 'bg-indigo-500'; $s3BadgeText = 'Perubahan';
                    } else {
                        $s3Bg = 'bg-yellow-50'; $s3Border = 'border-yellow-400';
                        $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92700A" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                        $s3BadgeClass = 'bg-yellow-100 text-yellow-800 font-medium'; $s3DotClass = 'bg-yellow-500 animate-pulse'; $s3BadgeText = 'Anda Belum Memverifikasi';
                    }
                @endphp
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s3Bg }} {{ $s3Border }}">
                            {!! $s3Icon !!}
                        </div>
                    </div>
                    <div class="flex-1 pl-3 pb-0">
                        <p class="text-sm font-semibold text-gray-800">Kepala Balai</p>
                        <p class="text-xs text-gray-600 mt-0.5">{{ $kepalaBalai->name ?? 'Jamaluddin Al Afgani, S.Pd.,MP' }}</p>
                        <p class="text-xs text-gray-400">
                            NIP {{ $kepalaBalai->nip ?? '197705012008011010' }}
                        </p>
                        @if($checkverifikasi && $checkverifikasi->catatan)
                            <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                                <span class="font-medium text-gray-500">Catatan:</span> {{ $checkverifikasi->catatan }}
                            </div>
                        @endif
                        <span class="mt-1.5 inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full text-xs {{ $s3BadgeClass }}">
                            <span class="w-2 h-2 rounded-full {{ $s3DotClass }}"></span>
                            {{ $s3BadgeText }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
        <a href="{{ url()->previous() }}"
           class="w-full sm:w-auto flex items-center justify-center px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-semibold bg-white hover:bg-gray-50 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>

        @if(!$checkverifikasi)
        <button type="button"
                data-id="{{ $custatuskatimkerkabag->id }}"
                data-is-kabag="{{ $isKabagRequest ? '1' : '0' }}"
                onclick="openVerifikasiModal(this)"
                class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Verifikasi Pengajuan
        </button>
        @endif
    </div>

</div>

{{-- Modal Verifikasi Pengajuan Cuti --}}
<div id="verifikasiModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        <div class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white flex items-center gap-3">
            <svg class="w-6 h-6 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <h5 class="text-base sm:text-lg font-bold tracking-wide">
                Verifikasi Pengajuan Cuti
            </h5>
        </div>

        <form id="verifikasiForm" method="POST" action="" class="p-6">
            @csrf
            
            {{-- PERBAIKAN: name diubah sesuai controller Cuti Umum --}}
            <input type="hidden" name="cu_status_katimker_kabag_id" id="dynamic_id_cuti" value="">

            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2.5">Status</label>
            
            <div class="grid grid-cols-2 gap-3 mb-4">
                <label id="cardDisetujui" class="relative flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/50 cursor-pointer transition-all select-none">
                    <input type="radio" name="status" value="disetujui" id="radioDisetujui" class="hidden" checked>
                    <div class="flex items-center gap-2.5">
                        <div id="dotDisetujui" class="w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                        </div>
                        <span id="textDisetujui" class="text-sm font-semibold text-emerald-600">Disetujui</span>
                    </div>
                    <div id="badgeDisetujui" class="w-5 h-5 rounded bg-emerald-500 flex items-center justify-center text-white">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </label>

                <label id="cardDitolak" class="relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none">
                    <input type="radio" name="status" value="ditolak" id="radioDitolak" class="hidden">
                    <div class="flex items-center gap-2.5">
                        <div id="dotDitolak" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                        </div>
                        <span id="textDitolak" class="text-sm font-medium text-gray-500">Ditolak</span>
                    </div>
                    <div id="badgeDitolak" class="text-gray-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </label>
            </div>

            <div id="tandaTanganContainer" class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-200 mb-4 transition-all">
                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">
                    <span>✍️</span>
                    <span>Tanda Tangan</span>
                </div>
                <p class="text-xs text-gray-700 font-medium mb-3">Bagaimana dokumen cuti ini akan ditandatangani?</p>

                <div class="space-y-2.5">
                    <label id="cardTtdYa" class="flex items-center gap-3 p-3 rounded-xl border-2 border-emerald-500 bg-white cursor-pointer transition-all select-none shadow-sm">
                        <input type="radio" name="tempel_ttd" value="ya" id="radioTtdYa" class="hidden" checked>
                        <div id="dotTtdYa" class="w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center shrink-0">
                            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                        </div>
                        <div class="shrink-0 text-gray-700">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm font-bold text-gray-800">Akan ditempel tanda tangan</p>
                            <p class="text-[11px] text-emerald-600 font-medium mt-0.5">Tanda tangan otomatis ditempelkan</p>
                        </div>
                    </label>

                    <label id="cardTtdTidak" class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none">
                        <input type="radio" name="tempel_ttd" value="tidak" id="radioTtdTidak" class="hidden">
                        <div id="dotTtdTidak" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0">
                            <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                        </div>
                        <div class="shrink-0 text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700">Tidak ditempel tanda tangan</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">Akan ditandatangani manual</p>
                        </div>
                    </label>
                </div>
            </div>

            <div id="catatanContainer" class="hidden mb-4">
                <label class="block text-xs font-bold text-gray-700 mb-1 tracking-wider uppercase">Alasan Penolakan</label>
                <textarea id="catatanInput" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-red-500/30 focus:border-red-400 outline-none text-sm transition-all" rows="3" name="catatan" placeholder="Tuliskan alasan penolakan..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-6">
                <button type="button" class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-sm shadow-sm text-center"
                        onclick="toggleVerifikasiModal(false)">
                    Batalkan
                </button>
                <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-sm text-center">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
         class="fixed bottom-10 right-10 bg-emerald-600 text-white px-6 py-3 rounded-2xl shadow-2xl z-[100] border border-white/20 flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
@endif

<script>
    let currentIsKabag = false;
    let currentCutiId = null;

    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("verifikasiModal");
        if (modal) modal.style.display = "none";

        const radioDisetujui       = document.getElementById('radioDisetujui');
        const radioDitolak         = document.getElementById('radioDitolak');
        const cardDisetujui        = document.getElementById('cardDisetujui');
        const cardDitolak          = document.getElementById('cardDitolak');
        const dotDisetujui         = document.getElementById('dotDisetujui');
        const dotDitolak           = document.getElementById('dotDitolak');
        const textDisetujui        = document.getElementById('textDisetujui');
        const textDitolak          = document.getElementById('textDitolak');
        const badgeDisetujui       = document.getElementById('badgeDisetujui');
        const badgeDitolak         = document.getElementById('badgeDitolak');
        const tandaTanganContainer = document.getElementById('tandaTanganContainer');
        const catatanContainer     = document.getElementById('catatanContainer');

        const radioTtdYa           = document.getElementById('radioTtdYa');
        const radioTtdTidak        = document.getElementById('radioTtdTidak');
        const cardTtdYa            = document.getElementById('cardTtdYa');
        const cardTtdTidak         = document.getElementById('cardTtdTidak');
        const dotTtdYa             = document.getElementById('dotTtdYa');
        const dotTtdTidak          = document.getElementById('dotTtdTidak');

        function updateStatusSelection() {
            if (radioDisetujui.checked) {
                cardDisetujui.className = "relative flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/50 cursor-pointer transition-all select-none";
                dotDisetujui.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center";
                dotDisetujui.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';
                textDisetujui.className = "text-sm font-semibold text-emerald-600";
                badgeDisetujui.className = "w-5 h-5 rounded bg-emerald-500 flex items-center justify-center text-white";

                cardDitolak.className   = "relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                dotDitolak.className    = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
                dotDitolak.innerHTML    = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                textDitolak.className   = "text-sm font-medium text-gray-500";
                badgeDitolak.className  = "text-gray-400";
                badgeDitolak.innerHTML  = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;

                if (tandaTanganContainer) tandaTanganContainer.classList.remove('hidden');
                if (catatanContainer) catatanContainer.classList.add('hidden');
            } else if (radioDitolak.checked) {
                cardDisetujui.className = "relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                dotDisetujui.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
                dotDisetujui.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                textDisetujui.className = "text-sm font-medium text-gray-500";
                badgeDisetujui.className = "w-5 h-5 rounded bg-gray-200 flex items-center justify-center text-gray-400";

                cardDitolak.className   = "relative flex items-center justify-between p-3.5 rounded-xl border-2 border-red-500 bg-red-50/50 cursor-pointer transition-all select-none";
                dotDitolak.className    = "w-5 h-5 rounded-full border-2 border-red-500 flex items-center justify-center";
                dotDitolak.innerHTML    = '<div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>';
                textDitolak.className   = "text-sm font-semibold text-red-600";
                badgeDitolak.className  = "w-5 h-5 rounded bg-red-500 flex items-center justify-center text-white";
                badgeDitolak.innerHTML  = `<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>`;

                if (tandaTanganContainer) tandaTanganContainer.classList.add('hidden');
                if (catatanContainer) catatanContainer.classList.remove('hidden');
            }
        }

        function updateTtdSelection() {
            if (radioTtdYa.checked) {
                cardTtdYa.className = "flex items-center gap-3 p-3 rounded-xl border-2 border-emerald-500 bg-white cursor-pointer transition-all select-none shadow-sm";
                dotTtdYa.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center shrink-0";
                dotTtdYa.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';

                cardTtdTidak.className = "flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                dotTtdTidak.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0";
                dotTtdTidak.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
            } else if (radioTtdTidak.checked) {
                cardTtdYa.className = "flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                dotTtdYa.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0";
                dotTtdYa.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';

                cardTtdTidak.className = "flex items-center gap-3 p-3 rounded-xl border-2 border-emerald-500 bg-white cursor-pointer transition-all select-none shadow-sm";
                dotTtdTidak.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center shrink-0";
                dotTtdTidak.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';
            }
        }

        if (radioDisetujui) radioDisetujui.addEventListener('change', updateStatusSelection);
        if (radioDitolak)   radioDitolak.addEventListener('change', updateStatusSelection);
        if (radioTtdYa)     radioTtdYa.addEventListener('change', updateTtdSelection);
        if (radioTtdTidak)  radioTtdTidak.addEventListener('change', updateTtdSelection);

        const verifikasiForm = document.getElementById("verifikasiForm");
        if (verifikasiForm) {
            verifikasiForm.addEventListener("submit", function (e) {
                const catatan = document.getElementById("catatanInput");
                const dynamicIdInput = document.getElementById("dynamic_id_cuti");
                let valid = true;

                if (radioDitolak.checked && catatan && catatan.value.trim() === "") {
                    valid = false;
                    catatan.classList.add("border-red-500");
                    catatan.focus();
                } else if (catatan) {
                    catatan.classList.remove("border-red-500");
                }

                if (!valid) {
                    e.preventDefault();
                    return;
                }

                // PERBAIKAN DI SINI
                // Memastikan nama field sesuai dengan kolom yang ada di database Cuti Umum
                dynamicIdInput.name = 'cu_status_katimker_kabag_id';
                dynamicIdInput.value = currentCutiId;

                // Logika Submit URL
                if (radioDisetujui.checked && radioTtdYa.checked) {
                    verifikasiForm.action = '{{ route("kabalverivikasicutiumum.approve-with-signature") }}';
                } else {
                    verifikasiForm.action = '{{ route("kabalaiverifikasicutiumum.store") }}';
                }
            });
        }
    });

    function openVerifikasiModal(btn) {
        currentCutiId = btn.getAttribute('data-id');
        currentIsKabag = btn.getAttribute('data-is-kabag') === '1';

        document.getElementById('radioDisetujui').checked = true;
        document.getElementById('radioTtdYa').checked = true;
        document.getElementById('radioDisetujui').dispatchEvent(new Event('change'));
        document.getElementById('radioTtdYa').dispatchEvent(new Event('change'));

        const modal = document.getElementById('verifikasiModal');
        modal.style.display = 'flex';
    }

    function toggleVerifikasiModal(show) {
        const modal = document.getElementById('verifikasiModal');
        modal.style.display = show ? 'flex' : 'none';
    }

    window.onclick = function (e) {
        const modal = document.getElementById('verifikasiModal');
        if (e.target === modal) toggleVerifikasiModal(false);
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') toggleVerifikasiModal(false);
    });
</script>
@endsection