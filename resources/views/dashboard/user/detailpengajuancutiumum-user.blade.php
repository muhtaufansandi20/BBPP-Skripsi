@extends('dashboard.user.base-user')

@section('main')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-emerald-600 to-lime-600">
            Detail Pengajuan Cuti
        </h1>
        <p class="text-sm text-gray-500 mt-1">Informasi lengkap pengajuan cuti umum Anda</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">

        <!-- Gradient Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-lime-600 p-5 text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold">Formulir Pengajuan Cuti Umum</h2>
                    <p class="text-emerald-100 text-sm mt-1">Diajukan pada: {{ date('d F Y', strtotime($pengajuan->tgl_pengajuan)) }}</p>
                </div>
            </div>
        </div>

        <!-- Cancelled Banner -->
        @if($pengajuan->statusCutiUmum && $pengajuan->statusCutiUmum->status == 'dibatalkan')
        <div class="bg-red-50 border-y border-red-200 p-5 flex items-start gap-4">
            <div class="flex-shrink-0 p-2 bg-red-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-800">Pengajuan Cuti Dibatalkan</h3>
                <p class="text-sm text-red-700 mt-1"><span class="font-semibold">Catatan:</span> {{ $catatanPembatalan }}</p>
            </div>
        </div>
        @endif

        <div class="p-5 sm:p-6">

            <!-- Detail Cuti -->
            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 mb-6">
                <h2 class="text-base font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Detail Cuti
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Jenis Cuti</p>
                        <p class="text-gray-800 font-semibold">{{ $pengajuan->jenisCuti->nama_cuti }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Lama Cuti</p>
                        <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 font-semibold px-3 py-1 rounded-full text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $pengajuan->jumlah_hari }}
                            @if(in_array($pengajuan->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                Bulan
                            @elseif(in_array($pengajuan->jenisCuti->nama_cuti, ['Cuti Sakit', 'Cuti Alasan Penting']))
                                Hari Kerja
                            @else
                                Hari
                            @endif
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Periode Cuti</p>
                        <p class="text-gray-800 font-semibold">
                            {{ date('d/m/Y', strtotime($pengajuan->tgl_mulai)) }}
                            <span class="text-gray-400 font-normal mx-1">s/d</span>
                            {{ date('d/m/Y', strtotime($pengajuan->tgl_selesai)) }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Nomor Telepon</p>
                        <p class="text-gray-800">{{ $pengajuan->no_hp_cuti }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Alamat Selama Cuti</p>
                        <p class="text-gray-800">{{ $pengajuan->alamat_saat_cuti }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-medium mb-1">Alasan Cuti</p>
                        <p class="text-gray-800">{{ $pengajuan->alasan }}</p>
                    </div>
                </div>
            </div>

            {{-- Lampiran Dokumen --}}
            @if(isset($lampiran))
            @php
                $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
                $fileUrl = Storage::url($lampiran->file_path);
            @endphp
            <div class="mb-6 rounded-xl border border-gray-200 overflow-hidden">
                <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Lampiran Dokumen</span>
                </div>
                <div class="px-4 py-4 bg-white flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center gap-0.5">
                        @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        @endif
                        <span class="text-[9px] font-bold text-emerald-500 uppercase">{{ $fileExtension }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $lampiran->nama_doc }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Diunggah: {{ $lampiran->uploaded_at }}</p>
                        @if($lampiran->description)
                            <p class="text-xs text-gray-500 truncate mt-0.5">{{ $lampiran->description }}</p>
                        @endif
                    </div>
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <a href="{{ $fileUrl }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Unduh
                        </a>
                        <button type="button" onclick="openPreviewPanel()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-emerald-700 border border-emerald-300 rounded-lg hover:bg-emerald-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat
                        </button>
                        @if($pengajuan->status == 'Pending')
                        <a href="{{ route('userpengajuancutiumum.deleteLampiran', $pengajuan->id) }}"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus lampiran ini?')"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Status Verifikasi: Timeline Stepper -->
            <h2 class="text-base font-semibold text-gray-700 mb-5 pb-2 border-b border-gray-200 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Status Verifikasi
            </h2>

            @php
                $adminDitolak    = $statusAdmin    == 'ditolak';
                $katimkerBlocked = $adminDitolak;
                $kabagBlocked    = $katimkerBlocked || $statusKatimker == 'ditolak';
                $kabalBlocked    = $kabagBlocked    || $statusKabag   == 'ditolak';

                $steps = [
                    [
                        'label'   => 'Admin',
                        'nama'    => $adminNama ?? 'Administrator',
                        'nip'     => $adminNIP  ?? '-',
                        'status'  => $statusAdmin,
                        'catatan' => $catatanAdmin ?? '-',
                        'blocked' => false,
                    ],
                    [
                        'label'   => 'Ketua Tim Kerja',
                        'nama'    => $ketuaNama ?? 'Ketua Tim Kerja',
                        'nip'     => $ketuaNIP  ?? '-',
                        'status'  => $statusKatimker,
                        'catatan' => $catatanKatimker ?? '-',
                        'blocked' => $katimkerBlocked,
                    ],
                    [
                        'label'   => 'Kepala Bagian',
                        'nama'    => $kepalaBagianNama ?? '-',
                        'nip'     => $kepalaBagianNIP  ?? '-',
                        'status'  => $statusKabag,
                        'catatan' => $catatanKabag ?? '-',
                        'blocked' => $kabagBlocked,
                    ],
                    [
                        'label'   => 'Kepala Balai',
                        'nama'    => $kepalaBalaiNama ?? '-',
                        'nip'     => $kepalaBalaiNIP  ?? '-',
                        'status'  => $statusKabal,
                        'catatan' => $catatanKabal ?? '-',
                        'blocked' => $kabalBlocked,
                    ],
                ];
            @endphp

            <div class="space-y-0">
                @foreach($steps as $i => $step)
                @php
                    $isLast = $i === count($steps) - 1;

                    if ($step['blocked']) {
                        $iconBg      = 'bg-gray-100';
                        $iconBorder  = 'border-gray-300';
                        $lineColor   = 'bg-gray-200';
                        $badgeBg     = 'bg-gray-100';
                        $badgeColor  = 'text-gray-400';
                        $badgeText   = '-';
                        $nameColor   = 'text-gray-400';
                        $nipColor    = 'text-gray-300';
                        $iconContent = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"><line x1="8" y1="12" x2="16" y2="12"/><circle cx="12" cy="12" r="10"/></svg>';
                    } elseif ($step['status'] == 'disetujui') {
                        $iconBg      = 'bg-green-50';
                        $iconBorder  = 'border-green-500';
                        $lineColor   = 'bg-green-400';
                        $badgeBg     = 'bg-green-100';
                        $badgeColor  = 'text-green-800';
                        $badgeText   = 'Disetujui';
                        $nameColor   = 'text-gray-800';
                        $nipColor    = 'text-gray-500';
                        $iconContent = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                    } elseif ($step['status'] == 'ditolak') {
                        $iconBg      = 'bg-red-50';
                        $iconBorder  = 'border-red-500';
                        $lineColor   = 'bg-gray-200';
                        $badgeBg     = 'bg-red-100';
                        $badgeColor  = 'text-red-800';
                        $badgeText   = 'Ditolak';
                        $nameColor   = 'text-gray-800';
                        $nipColor    = 'text-gray-500';
                        $iconContent = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                    }   elseif ($step['status'] == 'perubahan') {
                        $iconBg      = 'bg-indigo-50';
                        $iconBorder  = 'border-indigo-400';
                        $lineColor   = 'bg-gray-200';
                        $badgeBg     = 'bg-indigo-100';
                        $badgeColor  = 'text-indigo-800';
                        $badgeText   = 'Perubahan';
                        $nameColor   = 'text-gray-800';
                        $nipColor    = 'text-gray-500';
                        $iconContent = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3730A3" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.5"/></svg>';
                    } else {
                        $iconBg      = 'bg-yellow-50';
                        $iconBorder  = 'border-yellow-400';
                        $lineColor   = 'bg-gray-200';
                        $badgeBg     = 'bg-yellow-100';
                        $badgeColor  = 'text-yellow-800';
                        $badgeText   = 'Menunggu';
                        $nameColor   = 'text-gray-800';
                        $nipColor    = 'text-gray-500';
                        $iconContent = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92700A" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                    }
                @endphp

                <div class="flex gap-0">
                    <!-- Left: icon + line -->
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $iconBg }} {{ $iconBorder }}">
                            {!! $iconContent !!}
                        </div>
                        @if(!$isLast)
                        <div class="w-0.5 flex-1 {{ $lineColor }}" style="min-height:20px;"></div>
                        @endif
                    </div>

                    <!-- Right: content -->
                    <div class="flex-1 pl-3 {{ $isLast ? 'pb-0' : 'pb-6' }}">
                        <div class="flex items-start justify-between gap-3 flex-wrap">
                            <div>
                                <p class="text-sm font-semibold {{ $nameColor }}">{{ $step['label'] }}</p>
                                <p class="text-xs {{ $nipColor }} mt-0.5">
                                    {{ $step['nama'] }}
                                    @if($step['nip'] && $step['nip'] !== '-')
                                        &nbsp;·&nbsp; NIP {{ $step['nip'] }}
                                    @endif
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeBg }} {{ $badgeColor }} flex-shrink-0">
                                {{ $badgeText }}
                            </span>
                        </div>

                        @if(!$step['blocked'])
                        <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                            <span class="font-medium text-gray-500">Catatan:</span>
                            {{ $step['catatan'] }}
                        </div>
                        @endif
                    </div>
                </div>

                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col-reverse sm:flex-row justify-between items-center gap-4">
                <a href="{{ route('userpengajuancutiumum.index') }}"
                   class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg shadow-sm transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Daftar</span>
                </a>

                @if($statusKabal == 'disetujui')
                <a href="{{ route('viewPDFUmum', ['id' => $pengajuan->id]) }}" target="_blank"
                   class="w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-lg shadow-sm transition-all duration-300">
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

<!-- Side Panel Preview Dokumen -->
@if(isset($lampiran))
@php
    $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
    $fileUrl = Storage::url($lampiran->file_path);
@endphp
<div id="previewPanel" class="fixed inset-0 z-50 hidden">
    <div class="flex h-full">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePreviewPanel()"></div>
        <div class="relative flex flex-col w-full md:w-3/4 lg:w-2/3 h-full bg-white shadow-xl ml-auto transform transition-transform duration-300 ease-in-out translate-x-full" id="panelContent">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold">Preview Dokumen</h3>
                <div class="flex items-center space-x-2">
                    <a href="{{ $fileUrl }}" target="_blank"
                       class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Buka di Tab Baru
                    </a>
                    <button onclick="closePreviewPanel()" class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="flex-1 p-4 overflow-auto bg-gray-100">
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
                        <div class="flex flex-col items-center justify-center h-full py-16">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-blue-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="text-lg font-medium text-gray-700">File {{ strtoupper($fileExtension) }}</p>
                            <p class="text-gray-500 text-sm mt-1">File ini tidak dapat ditampilkan secara langsung di browser</p>
                            <a href="{{ $fileUrl }}" download
                               class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download File
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openPreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const panelContent = document.getElementById("panelContent");
        panel.classList.remove("hidden");
        setTimeout(() => panelContent.classList.remove("translate-x-full"), 10);
    }
    function closePreviewPanel() {
        const panelContent = document.getElementById("panelContent");
        panelContent.classList.add("translate-x-full");
        setTimeout(() => document.getElementById("previewPanel").classList.add("hidden"), 300);
    }
    document.addEventListener("keydown", e => { if (e.key === "Escape") closePreviewPanel(); });
</script>
@endif
@endsection