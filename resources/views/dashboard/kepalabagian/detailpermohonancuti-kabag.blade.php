@extends('dashboard.kepalabagian.base-kepalabagian')

@section('content')
<div class="max-w-6xl mx-auto p-6 pt-0">

    <!-- Header -->
    <div class="flex items-center gap-4 mb-6 group">
        <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-green-600 to-emerald-500 shadow-lg
                    group-hover:from-green-700 group-hover:to-emerald-600 transition-all duration-300
                    ring-2 ring-white/20 ring-inset hover:ring-green-400/40 hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <div class="w-full">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                Detail Pengajuan Cuti Tahunan
            </h2>
            <div class="relative mt-2">
                <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full w-0
                            group-hover:w-full transition-all duration-500 ease-out"></div>
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
                <span class="font-semibold uppercase">Biodata Pegawai</span>
            </h5>
        </div>

        <div class="p-6 space-y-0 divide-y divide-gray-100">

            {{-- Nama & NIP --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Nama
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->name }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        NIP
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->nip }}</p>
                </div>
            </div>

            {{-- Jabatan & Masa Kerja --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Jabatan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->jabatan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Masa Kerja
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->masa_kerja }}</p>
                </div>
            </div>

            {{-- No HP --}}
            <div class="py-4 px-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    No HP
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->no_hp }}</p>
            </div>

        </div>
    </div>

    {{-- Detail Pengajuan Cuti --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="font-semibold uppercase">Detail Pengajuan Cuti</span>
            </h5>
        </div>

        <div class="p-6 space-y-0 divide-y divide-gray-100">

            {{-- Tanggal Pengajuan & Tanggal Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Pengajuan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->tgl_pengajuan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $ctstatusadminkatimker->tgl_mulai }}
                        <span class="text-gray-400 mx-1.5">—</span>
                        {{ $ctstatusadminkatimker->tgl_selesai }}
                    </p>
                </div>
            </div>

            {{-- Lama Cuti & No HP Saat Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lama Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->lama_cuti }} hari</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        No HP Saat Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $ctstatusadminkatimker->no_hp_cuti }}</p>
                </div>
            </div>

            {{-- Alasan & Alamat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Alasan Melakukan Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $ctstatusadminkatimker->alasan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Alamat Saat Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $ctstatusadminkatimker->alamat_saat_cuti }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Verifikasi Atasan: Timeline (Admin -> Kabag -> Kabal) --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-5 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="text-sm font-semibold text-white uppercase tracking-wide">Verifikasi Atasan</span>
        </div>

        <div class="p-6">
            @php
                // Status verifikasi Admin
                $adminStatus = $ctstatusadminkatimker->status ?? null; // status di tabel admin/user-admin
                $adminDisetujui = $adminStatus === 'disetujui';
                
                // Status verifikasi Kepala Bagian (Anda)
                $kabagStatus = $checkverifikasi->status ?? null;
                $kabagBlocked = !$adminDisetujui; // Jika admin belum setuju, kabag belum bisa/aktif penuh

                // Status verifikasi Kepala Balai (cek dari relasi jika ada)
                $kabalStatus = optional($ctstatusadminkatimker->ctStatusAdminKabal)->status ?? null;
                $kabalBlocked = !($kabagStatus === 'disetujui');
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
                                $s1Bg = 'bg-yellow-50'; $s1Border = 'border-yellow-400'; $s1Line = 'bg-gray-200';
                                $s1Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92700A" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                            }
                        @endphp
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s1Bg }} {{ $s1Border }}">
                            {!! $s1Icon !!}
                        </div>
                        <div class="w-0.5 flex-1 {{ $s1Line }}" style="min-height:20px;"></div>
                    </div>

                    <div class="flex-1 pl-3 pb-6">
                        <p class="text-sm font-semibold text-gray-800">Administrator</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $adminNama ?? 'Admin Sistem' }}</p>
                        <p class="text-xs text-gray-400">NIP {{ $adminNIP ?? '-' }}</p>
                        @php
                            $s1BadgeText  = $adminStatus ? ucfirst($adminStatus) : 'Menunggu Verifikasi';
                            $s1BadgeClass = match($adminStatus) {
                                'disetujui' => 'bg-green-100 text-green-800',
                                'ditolak'   => 'bg-red-100 text-red-800',
                                default     => 'bg-yellow-100 text-yellow-800',
                            };
                        @endphp
                        <span class="mt-1.5 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $s1BadgeClass }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if($adminStatus === 'disetujui') bg-green-500
                                @elseif($adminStatus === 'ditolak') bg-red-500
                                @else bg-yellow-500 animate-pulse @endif">
                            </span>
                            {{ $s1BadgeText }}
                        </span>
                        @if(!empty($ctstatusadminkatimker->catatan))
                        <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                            <span class="font-medium text-gray-500">Catatan:</span> {{ $ctstatusadminkatimker->catatan }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Step 2: Kepala Bagian Umum (Anda) --}}
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        @php
                            if ($kabagBlocked) {
                                $s2Bg = 'bg-gray-100'; $s2Border = 'border-gray-300'; $s2Line = 'bg-gray-200';
                                $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"><line x1="8" y1="12" x2="16" y2="12"/><circle cx="12" cy="12" r="10"/></svg>';
                            } elseif ($kabagStatus === 'disetujui') {
                                $s2Bg = 'bg-green-50'; $s2Border = 'border-green-500'; $s2Line = 'bg-green-400';
                                $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                            } elseif ($kabagStatus === 'ditolak') {
                                $s2Bg = 'bg-red-50'; $s2Border = 'border-red-500'; $s2Line = 'bg-gray-200';
                                $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                            } else {
                                $s2Bg = 'bg-yellow-50'; $s2Border = 'border-yellow-400'; $s2Line = 'bg-gray-200';
                                $s2Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92700A" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                            }
                        @endphp
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s2Bg }} {{ $s2Border }}">
                            {!! $s2Icon !!}
                        </div>
                        <div class="w-0.5 flex-1 {{ $s2Line }}" style="min-height:20px;"></div>
                    </div>

                    <div class="flex-1 pl-3 pb-6">
                        <p class="text-sm font-semibold {{ $kabagBlocked ? 'text-gray-400' : 'text-gray-800' }}">Kepala Bagian Umum</p>
                        <p class="text-xs {{ $kabagBlocked ? 'text-gray-300' : 'text-gray-500' }} mt-0.5">
                            {{ $kepalaBagianUmum->name ?? 'Belum ditentukan' }}
                        </p>
                        <p class="text-xs {{ $kabagBlocked ? 'text-gray-300' : 'text-gray-400' }}">
                            @if(!empty($kepalaBagianUmum->nip)) NIP {{ $kepalaBagianUmum->nip }} @else - @endif
                        </p>

                        @if(!$kabagBlocked)
                            @php
                                $s2BadgeText  = $kabagStatus ? ucfirst($kabagStatus) : 'Anda Belum Memverifikasi';
                                $s2BadgeClass = match($kabagStatus) {
                                    'disetujui' => 'bg-green-100 text-green-800',
                                    'ditolak'   => 'bg-red-100 text-red-800',
                                    default     => 'bg-yellow-100 text-yellow-800',
                                };
                            @endphp
                            <span class="mt-1.5 inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $s2BadgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if($kabagStatus === 'disetujui') bg-green-500
                                    @elseif($kabagStatus === 'ditolak') bg-red-500
                                    @else bg-yellow-500 animate-pulse @endif">
                                </span>
                                {{ $s2BadgeText }}
                            </span>
                        @else
                            <span class="mt-1.5 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-400">Menunggu Admin</span>
                        @endif

                        @if($checkverifikasi && $checkverifikasi->catatan)
                        <div class="mt-2 bg-gray-50 rounded-lg px-3 py-2 text-xs text-gray-600 border border-gray-100">
                            <span class="font-medium text-gray-500">Catatan:</span>
                            {{ $checkverifikasi->catatan }}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Step 3: Kepala Balai --}}
                <div class="flex gap-0">
                    <div class="flex flex-col items-center" style="width:40px; flex-shrink:0;">
                        @php
                            if ($kabalBlocked) {
                                $s3Bg = 'bg-gray-100'; $s3Border = 'border-gray-300'; $s3Line = 'bg-gray-200';
                                $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2"><line x1="8" y1="12" x2="16" y2="12"/><circle cx="12" cy="12" r="10"/></svg>';
                            } elseif ($kabalStatus === 'disetujui') {
                                $s3Bg = 'bg-green-50'; $s3Border = 'border-green-500'; $s3Line = 'bg-green-400';
                                $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#065F46" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
                            } elseif ($kabalStatus === 'ditolak') {
                                $s3Bg = 'bg-red-50'; $s3Border = 'border-red-500'; $s3Line = 'bg-gray-200';
                                $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#991B1B" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';
                            } else {
                                $s3Bg = 'bg-yellow-50'; $s3Border = 'border-yellow-400'; $s3Line = 'bg-gray-200';
                                $s3Icon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#92700A" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
                            }
                        @endphp
                        <div class="w-9 h-9 rounded-full border-2 flex items-center justify-center z-10 {{ $s3Bg }} {{ $s3Border }}">
                            {!! $s3Icon !!}
                        </div>
                    </div>
                    <div class="flex-1 pl-3 pb-0">
                        <p class="text-sm font-semibold {{ $kabalBlocked ? 'text-gray-400' : 'text-gray-800' }}">Kepala Balai BBPP Batangkaluku</p>
                        <p class="text-xs {{ $kabalBlocked ? 'text-gray-300' : 'text-gray-500' }} mt-0.5">{{ $kepalaBalai->name ?? '-' }}</p>
                        <p class="text-xs {{ $kabalBlocked ? 'text-gray-300' : 'text-gray-400' }}">
                            @if(!empty($kepalaBalai->nip)) NIP {{ $kepalaBalai->nip }} @else - @endif
                        </p>
                        @php
                            $s3BadgeText  = $kabalStatus ? ucfirst($kabalStatus) : ($kabalBlocked ? 'Menunggu Kabag' : 'Menunggu Verifikasi');
                            $s3BadgeClass = match($kabalStatus) {
                                'disetujui' => 'bg-green-100 text-green-800',
                                'ditolak'   => 'bg-red-100 text-red-800',
                                default     => 'bg-yellow-100 text-yellow-800',
                            };
                        @endphp
                        <span class="mt-1.5 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kabalStatus ? $s3BadgeClass : 'bg-gray-100 text-gray-400' }}">
                            @if($kabalStatus)
                                <span class="w-1.5 h-1.5 rounded-full mr-1 @if($kabalStatus === 'disetujui') bg-green-500 @elseif($kabalStatus === 'ditolak') bg-red-500 @else bg-yellow-500 animate-pulse @endif"></span>
                            @endif
                            {{ $s3BadgeText }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Tombol Aksi (Hanya 1 Tombol Verifikasi) --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
        <a href="{{ route('kabagdatapermohonancuti.index') }}"
           class="w-full sm:w-auto flex items-center justify-center px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-semibold bg-white hover:bg-gray-50 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>

        @if(!$checkverifikasi && !$kabagBlocked)
        <button type="button" onclick="openModal()"
                class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-2.5 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Verifikasi Pengajuan
        </button>
        @endif
    </div>

</div>

{{-- Modal Verifikasi Pengajuan Cuti (Card Radio + Opsi Tanda Tangan) --}}
<div id="verifikasiModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        
        {{-- Header Modal --}}
        <div class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white flex items-center gap-3">
            <svg class="w-6 h-6 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <h5 class="text-base sm:text-lg font-bold tracking-wide">
                Verifikasi Pengajuan Cuti
            </h5>
        </div>

        {{-- Form Modal --}}
        <form id="verifikasiForm" method="POST" action="{{ route('ctstatuskatimkerkabag.store') }}" class="p-6">
            @csrf
            <input type="hidden" name="id_ct_status_admin_katimker" value="{{ $ctstatusadminkatimker->id }}">

            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2.5">Status</label>
            
            {{-- Pilihan Status (Card Radio) --}}
            <div class="grid grid-cols-2 gap-3 mb-4">
                <!-- Option Disetujui -->
                <label id="cardDisetujui" class="relative flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/50 cursor-pointer transition-all select-none">
                    <input type="radio" name="status" value="Disetujui" id="radioDisetujui" class="hidden" checked>
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

                <!-- Option Ditolak -->
                <label id="cardDitolak" class="relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none">
                    <input type="radio" name="status" value="Ditolak" id="radioDitolak" class="hidden">
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

            {{-- Container Tanda Tangan (Tampil Jika Disetujui) --}}
            <div id="tandaTanganContainer" class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-200 mb-4 transition-all">
                <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">
                    <span>✍️</span>
                    <span>Tanda Tangan</span>
                </div>
                <p class="text-xs text-gray-700 font-medium mb-3">Bagaimana dokumen cuti ini akan ditandatangani?</p>

                <div class="space-y-2.5">
                    <!-- Option 1: Akan ditempel tanda tangan -->
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
                            <p class="text-[11px] text-emerald-600 font-medium mt-0.5">Tanda tangan otomatis ditempelkan pada dokumen</p>
                        </div>
                    </label>

                    <!-- Option 2: Tidak ditempel tanda tangan -->
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
                            <p class="text-[11px] text-gray-400 mt-0.5">Akan ditandatangani secara langsung / manual</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Container Alasan/Catatan (Tampil Jika Ditolak) --}}
            <div id="catatanContainer" class="hidden mb-4">
                <label class="block text-xs font-bold text-gray-700 mb-1 tracking-wider uppercase">Alasan Penolakan</label>
                <textarea id="catatanInput" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-red-500/30 focus:border-red-400 outline-none text-sm transition-all" rows="3" name="catatan" placeholder="Tuliskan alasan penolakan..."></textarea>
            </div>

            {{-- Tombol Aksi Modal --}}
            <div class="grid grid-cols-2 gap-3 mt-6">
                <button type="button" class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-sm shadow-sm text-center"
                        onclick="toggleModal(false)">
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
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById("verifikasiModal");
        if (modal) modal.style.display = "none";

        // Elements Switch Status
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

        // Elements Switch TTD
        const radioTtdYa       = document.getElementById('radioTtdYa');
        const radioTtdTidak    = document.getElementById('radioTtdTidak');
        const cardTtdYa        = document.getElementById('cardTtdYa');
        const cardTtdTidak     = document.getElementById('cardTtdTidak');
        const dotTtdYa         = document.getElementById('dotTtdYa');
        const dotTtdTidak      = document.getElementById('dotTtdTidak');

        function updateStatusSelection() {
            if (radioDisetujui && radioDisetujui.checked) {
                // Card Disetujui Aktif (Hijau)
                cardDisetujui.className = "relative flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/50 cursor-pointer transition-all select-none";
                dotDisetujui.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center";
                dotDisetujui.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';
                textDisetujui.className = "text-sm font-semibold text-emerald-600";
                badgeDisetujui.className = "w-5 h-5 rounded bg-emerald-500 flex items-center justify-center text-white";

                // Card Ditolak Nonaktif (Abu-abu)
                cardDitolak.className   = "relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                dotDitolak.className    = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
                dotDitolak.innerHTML    = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                textDitolak.className   = "text-sm font-medium text-gray-500";
                badgeDitolak.className  = "text-gray-400";
                badgeDitolak.innerHTML  = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;

                if (tandaTanganContainer) tandaTanganContainer.classList.remove('hidden');
                if (catatanContainer) catatanContainer.classList.add('hidden');
            } else if (radioDitolak && radioDitolak.checked) {
                // Card Disetujui Nonaktif (Abu-abu)
                cardDisetujui.className = "relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                dotDisetujui.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
                dotDisetujui.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                textDisetujui.className = "text-sm font-medium text-gray-500";
                badgeDisetujui.className = "w-5 h-5 rounded bg-gray-200 flex items-center justify-center text-gray-400";

                // Card Ditolak Aktif (Merah)
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

        // Validasi Form & Routing Action Dinamis
        const verifikasiForm = document.getElementById("verifikasiForm");
        if (verifikasiForm) {
            verifikasiForm.addEventListener("submit", function (e) {
                const catatan = document.getElementById("catatanInput");
                let valid = true;

                if (radioDitolak && radioDitolak.checked && catatan && catatan.value.trim() === "") {
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

                // Tentukan route tujuan sesuai keputusan
                if (radioDisetujui && radioDisetujui.checked && radioTtdYa && radioTtdYa.checked) {
                    verifikasiForm.action = '{{ route("ctstatuskatimkerkabag.approve-with-signature") }}';
                } else {
                    verifikasiForm.action = '{{ route("ctstatuskatimkerkabag.store") }}';
                }
            });
        }
    });

    function openModal() {
        const radioDisetujui = document.getElementById('radioDisetujui');
        const radioTtdYa     = document.getElementById('radioTtdYa');
        if (radioDisetujui) {
            radioDisetujui.checked = true;
            radioDisetujui.dispatchEvent(new Event('change'));
        }
        if (radioTtdYa) {
            radioTtdYa.checked = true;
            radioTtdYa.dispatchEvent(new Event('change'));
        }

        const modal = document.getElementById("verifikasiModal");
        if (modal) modal.style.display = "flex";
    }

    function toggleModal(show) {
        const modal = document.getElementById("verifikasiModal");
        if (modal) modal.style.display = show ? "flex" : "none";
    }

    window.onclick = function (e) {
        const modal = document.getElementById("verifikasiModal");
        if (e.target === modal) toggleModal(false);
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') toggleModal(false);
    });
</script>
@endsection