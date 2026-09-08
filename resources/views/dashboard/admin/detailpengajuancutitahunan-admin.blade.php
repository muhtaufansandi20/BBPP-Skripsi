@extends('dashboard.admin.base-admin')

@section('main')

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

    {{-- Biodata Pegawai Card --}}
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
            {{-- Baris 1: Nama & NIP --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Nama
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->user->name }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        NIP
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->user->nip }}</p>
                </div>
            </div>

            {{-- Baris 2: Jabatan & Masa Kerja --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Jabatan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->user->jabatan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Masa Kerja
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->masa_kerja }}</p>
                </div>
            </div>

            {{-- Baris 3: No HP --}}
            <div class="py-4 px-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    No HP
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $pengajuan->user->no_hp }}</p>
            </div>
        </div>
    </div>

    {{-- Detail Pengajuan Cuti Card --}}
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
            {{-- Baris 1: Tanggal Pengajuan & Tanggal Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Pengajuan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->tgl_pengajuan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ $pengajuan->tgl_mulai }}
                        <span class="text-gray-400 mx-1.5">—</span>
                        {{ $pengajuan->tgl_selesai }}
                    </p>
                </div>
            </div>

            {{-- Baris 2: Lama Cuti & No HP Saat Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lama Cuti
                    </p>
                    <form id="editLamaCutiForm" method="POST" action="{{ route('adminpengajuancutitahunan.update', $pengajuan->id) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')

                        <p id="lamaCutiText" class="text-sm font-medium text-gray-800">{{ $pengajuan->lama_cuti }} hari</p>

                        <input type="number" id="lamaCutiInput" name="lama_cuti" value="{{ $pengajuan->lama_cuti }}" min="1"
                               class="hidden w-20 px-2.5 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/50 focus:outline-none">
                        <span id="satuanCuti" class="hidden text-gray-600 text-sm">hari</span>

                        <button type="button" id="editButton"
                                class="px-2 py-0.5 text-xs text-emerald-700 border border-emerald-300 rounded-md hover:bg-emerald-50 transition-colors">
                            Edit
                        </button>
                        <button type="submit" id="saveButton"
                                class="hidden px-2 py-0.5 text-xs text-white bg-emerald-600 rounded-md hover:bg-emerald-700 transition-colors">
                            Simpan
                        </button>
                        <button type="button" id="cancelButton"
                                class="hidden px-2 py-0.5 text-xs text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors">
                            Batal
                        </button>
                    </form>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        No HP Saat Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuan->no_hp_cuti }}</p>
                </div>
            </div>

            {{-- Baris 3: Alasan & Alamat Saat Cuti --}}
            <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Alasan Melakukan Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pengajuan->alasan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Alamat Saat Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pengajuan->alamat_saat_cuti }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kuota Cuti --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-6 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="font-semibold uppercase">Kuota Cuti Jika Disetujui</span>
            </h5>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                {{-- Tahun Ini (N) --}}
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">Tahun Ini</span>
                        <span class="text-xs px-2 py-0.5 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-full font-medium">(N)</span>
                    </div>
                    <div class="flex items-end gap-1.5 mt-1">
                        <span class="text-2xl font-bold text-emerald-700">{{ $kuotaCuti->kuota_n }}</span>
                        <span class="text-sm text-emerald-600 mb-0.5">hari</span>
                    </div>
                    <div class="mt-3 h-1.5 bg-emerald-200 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(($kuotaCuti->kuota_n / 12) * 100, 100) }}%"></div>
                    </div>
                </div>

                {{-- Tahun Lalu (N-1) --}}
                <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-green-800 uppercase tracking-wider">Tahun Lalu</span>
                        <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 border border-green-200 rounded-full font-medium">(N-1)</span>
                    </div>
                    <div class="flex items-end gap-1.5 mt-1">
                        <span class="text-2xl font-bold text-green-700">{{ $kuotaCuti->kuota_n1 }}</span>
                        <span class="text-sm text-green-600 mb-0.5">hari</span>
                    </div>
                    <div class="mt-3 h-1.5 bg-green-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: {{ min(($kuotaCuti->kuota_n1 / 3) * 100, 100) }}%"></div>
                    </div>
                </div>

                {{-- 2 Tahun Lalu (N-2) --}}
                <div class="rounded-xl border border-teal-200 bg-teal-50 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-teal-800 uppercase tracking-wider">2 Tahun Lalu</span>
                        <span class="text-xs px-2 py-0.5 bg-teal-100 text-teal-700 border border-teal-200 rounded-full font-medium">(N-2)</span>
                    </div>
                    <div class="flex items-end gap-1.5 mt-1">
                        <span class="text-2xl font-bold text-teal-700">{{ $kuotaCuti->kuota_n2 }}</span>
                        <span class="text-sm text-teal-600 mb-0.5">hari</span>
                    </div>
                    <div class="mt-3 h-1.5 bg-teal-200 rounded-full overflow-hidden">
                        <div class="h-full bg-teal-500 rounded-full" style="width: {{ min(($kuotaCuti->kuota_n2 / 3) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-400 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kuota cuti akan diperbaharui setiap tahun baru.
            </p>
        </div>
    </div>

    {{-- Verifikasi Atasan --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-5 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span class="text-sm font-semibold text-white uppercase tracking-wide">Verifikasi Atasan</span>
        </div>

        <div class="p-5">
            <div class="relative pl-9">
                <div class="absolute left-[15px] top-6 bottom-6 w-px bg-gray-200"></div>

                {{-- Step 1: Ketua Tim Kerja --}}
                @if($user->role == 'user')
                <div class="relative mb-5">
                    <div class="absolute -left-9 top-0 w-[30px] h-[30px] rounded-full bg-emerald-50 border-2 border-emerald-400 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 mb-0.5">Ketua tim kerja</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $ketuaNama }}</p>
                    <p class="text-xs text-gray-400">{{ $ketuaNIP }}</p>
                </div>
                @endif

                {{-- Step 2: Kepala Bagian --}}
                @if(in_array($user->role, ['user', 'kepalatimkerja']))
                <div class="relative mb-5">
                    <div class="absolute -left-9 top-0 w-[30px] h-[30px] rounded-full bg-emerald-50 border-2 border-emerald-400 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 mb-0.5">Kepala bagian</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $kepalaBagian->name ?? 'Belum ditentukan' }}</p>
                    <p class="text-xs text-gray-400">{{ $kepalaBagian->nip ?? '-' }}</p>
                </div>
                @endif

                {{-- Step 3: Kepala Balai --}}
                <div class="relative">
                    <div class="absolute -left-9 top-0 w-[30px] h-[30px] rounded-full bg-emerald-50 border-2 border-emerald-400 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 mb-0.5">Kepala balai BBPP Batangkaluku</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $kepalaBalai->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">{{ $kepalaBalai->nip ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
        <a href="{{ route('adminpengajuancutitahunan.index') }}"
           class="w-full sm:w-auto flex items-center justify-center px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-semibold bg-white hover:bg-gray-50 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>

        @if (!$checkverifikasi && auth()->user()->role == 'admin')
        <button class="w-full sm:w-auto px-8 py-2.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all"
                onclick="openModal()">
            <span class="flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Verifikasi Pengajuan
            </span>
        </button>
        @endif
    </div>
</div>

{{-- Modal Verifikasi (Disesuaikan dengan Desain Gambar) --}}
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
        <form id="verifikasiForm" method="POST" action="{{ route('ctstatususeradmin.store') }}" class="p-6">
            @csrf
            <input type="hidden" name="id_pengajuan_cuti_tahunan" value="{{ $pengajuan->id }}">

            <label class="block text-sm font-bold text-gray-800 mb-3">Status</label>
            
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

            {{-- Container Alasan/Catatan (Muncul jika ditolak) --}}
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
                <button type="submit" class="w-full py-2.5 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-sm text-center">
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
        // Init modal hidden
        const modal = document.getElementById("verifikasiModal");
        if (modal) { modal.style.display = "none"; }

        // Edit Lama Cuti
        const editBtn    = document.getElementById("editButton");
        const saveBtn    = document.getElementById("saveButton");
        const cancelBtn  = document.getElementById("cancelButton");
        const input      = document.getElementById("lamaCutiInput");
        const satuan     = document.getElementById("satuanCuti");
        const textEl     = document.getElementById("lamaCutiText");
        const originalValue = input ? input.value : null;

        if (editBtn) {
            editBtn.addEventListener("click", function () {
                textEl.classList.add("hidden");
                editBtn.classList.add("hidden");
                input.classList.remove("hidden");
                satuan.classList.remove("hidden");
                saveBtn.classList.remove("hidden");
                cancelBtn.classList.remove("hidden");
                input.focus();
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener("click", function () {
                input.value = originalValue;
                input.classList.add("hidden");
                satuan.classList.add("hidden");
                saveBtn.classList.add("hidden");
                cancelBtn.classList.add("hidden");
                textEl.classList.remove("hidden");
                editBtn.classList.remove("hidden");
            });
        }

        // Handle Switch Card Status Modal
        const radioDisetujui = document.getElementById('radioDisetujui');
        const radioDitolak   = document.getElementById('radioDitolak');
        const cardDisetujui  = document.getElementById('cardDisetujui');
        const cardDitolak    = document.getElementById('cardDitolak');
        const dotDisetujui   = document.getElementById('dotDisetujui');
        const dotDitolak     = document.getElementById('dotDitolak');
        const textDisetujui  = document.getElementById('textDisetujui');
        const textDitolak    = document.getElementById('textDitolak');
        const badgeDisetujui = document.getElementById('badgeDisetujui');
        const badgeDitolak   = document.getElementById('badgeDitolak');
        const catatanContainer = document.getElementById('catatanContainer');

        function updateModalSelection() {
            if (radioDisetujui.checked) {
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

                if (catatanContainer) catatanContainer.classList.add('hidden');
            } else if (radioDitolak.checked) {
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

                if (catatanContainer) catatanContainer.classList.remove('hidden');
            }
        }

        if (radioDisetujui) radioDisetujui.addEventListener('change', updateModalSelection);
        if (radioDitolak)   radioDitolak.addEventListener('change', updateModalSelection);

        // Validasi Form
        const verifikasiForm = document.getElementById("verifikasiForm");
        if (verifikasiForm) {
            verifikasiForm.addEventListener("submit", function (event) {
                const catatan = document.getElementById("catatanInput");
                let valid = true;

                if (radioDitolak.checked && catatan && catatan.value.trim() === "") {
                    valid = false;
                    catatan.classList.add("border-red-500");
                    catatan.focus();
                } else if (catatan) {
                    catatan.classList.remove("border-red-500");
                }

                if (!valid) event.preventDefault();
            });
        }
    });

    function openModal() {
        document.getElementById("verifikasiModal").style.display = "flex";
    }

    function toggleModal(show) {
        document.getElementById("verifikasiModal").style.display = show ? "flex" : "none";
    }

    window.onclick = function (event) {
        const modal = document.getElementById("verifikasiModal");
        if (event.target === modal) toggleModal(false);
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') toggleModal(false);
    });
</script>

@endsection