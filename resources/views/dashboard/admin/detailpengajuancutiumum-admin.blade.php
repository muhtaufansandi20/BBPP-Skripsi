@extends('dashboard.admin.base-admin')

@section('main')

<div class="max-w-6xl mx-auto p-6 pt-0">
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
                Detail Pengajuan Cuti Umum
            </h2>
            <div class="relative mt-2">
                <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full w-0 
                            group-hover:w-full transition-all duration-500 ease-out"></div>
                <div class="h-0.5 bg-gray-200 rounded-full"></div>
            </div>
        </div>
    </div>

    {{-- BIODATA PEGAWAI --}}
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Nama
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuanumum->user->name }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        NIP
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuanumum->user->nip }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Jabatan
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuanumum->user->jabatan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Masa Kerja
                    </p>
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuanumum->masa_kerja }}</p>
                </div>
            </div>

            <div class="py-4 px-2">
                <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    No HP
                </p>
                <p class="text-sm font-medium text-gray-800">{{ $pengajuanumum->user->no_hp }}</p>
            </div>
        </div>
    </div>
    
    {{-- DETAIL PENGAJUAN CUTI --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="font-semibold uppercase text-white">Detail Pengajuan Cuti</span>
            </h5>
        </div>

        <div class="px-6 pt-4 pb-0">
            @if(isset($pengajuanumum->jenisCuti))
                @php
                    $jenisCutiColors = [
                        'Cuti Melahirkan'     => 'bg-pink-100 text-pink-600 border-pink-200',
                        'Cuti Besar'          => 'bg-green-100 text-green-600 border-green-200',
                        'Cuti Alasan Penting' => 'bg-blue-100 text-blue-600 border-blue-200',
                        'Cuti Sakit'          => 'bg-red-100 text-red-500 border-red-200',
                    ];
                    $colorClass = $jenisCutiColors[$pengajuanumum->jenisCuti->nama_cuti] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                    <i class="fas fa-tag text-[10px]"></i>
                    {{ $pengajuanumum->jenisCuti->nama_cuti }}
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border bg-gray-100 text-gray-400 border-gray-200 italic">
                    Tidak tersedia
                </span>
            @endif
        </div>

        <div class="px-6 pb-6 pt-2 space-y-0 divide-y divide-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Pengajuan
                    </p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($pengajuanumum->tgl_pengajuan)->translatedFormat('d F Y') }}
                    </p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal Cuti
                    </p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($pengajuanumum->tgl_mulai)->translatedFormat('d F Y') }}
                        <span class="text-gray-400 mx-1.5">—</span>
                        {{ \Carbon\Carbon::parse($pengajuanumum->tgl_selesai)->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Durasi Cuti
                    </p>
                    <form id="editJumlahHariForm" method="POST" action="{{ route('adminpengajuancutiumum.update', $pengajuanumum->id) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')

                        <p id="durasi-text" class="text-sm font-medium text-gray-800">
                            {{ $pengajuanumum->jumlah_hari }}
                            @if(isset($pengajuanumum->jenisCuti) && in_array($pengajuanumum->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                bulan
                            @elseif(isset($pengajuanumum->jenisCuti) && in_array($pengajuanumum->jenisCuti->nama_cuti, ['Cuti Alasan Penting', 'Cuti Sakit']))
                                hari kerja
                            @else
                                hari
                            @endif
                        </p>

                        <input type="number" id="jumlahHariInput" name="jumlah_hari" value="{{ $pengajuanumum->jumlah_hari }}" min="1"
                               class="hidden w-20 px-2.5 py-1 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/50 focus:outline-none">
                        <span id="satuan_cuti" class="hidden text-gray-600 text-sm">
                            @if(isset($pengajuanumum->jenisCuti) && in_array($pengajuanumum->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                bulan
                            @elseif(isset($pengajuanumum->jenisCuti) && in_array($pengajuanumum->jenisCuti->nama_cuti, ['Cuti Alasan Penting', 'Cuti Sakit']))
                                hari kerja
                            @else
                                hari
                            @endif
                        </span>

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
                    <p class="text-sm font-medium text-gray-800">{{ $pengajuanumum->no_hp_cuti }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                <div class="py-4 px-2">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Alasan Melakukan Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pengajuanumum->alasan }}</p>
                </div>
                <div class="py-4 px-2 md:pl-6">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Alamat Saat Cuti
                    </p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pengajuanumum->alamat_saat_cuti }}</p>
                </div>
            </div>
        </div>

        {{-- Lampiran Dokumen --}}
        @if(isset($lampiran))
        @php
            $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
            $fileUrl = Storage::url($lampiran->file_path);
        @endphp
        <div class="mx-6 mb-6 rounded-xl border border-gray-200 overflow-hidden">
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
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- VERIFIKASI ATASAN (DINAMIS SESUAI ROLE PEGAWAI) --}}
    @if(in_array($pengajuanumum->user->role, ['user', 'kepalatimkerja', 'kepalabagian']))
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-6 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="font-semibold uppercase text-white">Verifikasi Atasan</span>
            </h5>
        </div>
        
        <div class="p-6">
            <div class="relative pl-6 space-y-6 before:absolute before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-gray-200">
                
                {{-- 1. Admin (Selalu Ada) --}}
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-amber-500 shadow-sm z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Admin</h4>
                        <p class="text-xs font-medium text-gray-600">{{ $adminNama ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIP {{ $adminNIP ?? '-' }}</p>
                        <div class="mt-1.5">
                            @php
                                $statusAdminVal = $statusAdmin ?? 'Belum Memverifikasi';
                                $badgeAdminClass = strtolower($statusAdminVal) == 'disetujui' ? 'bg-green-100 text-green-800 border-green-200' : (strtolower($statusAdminVal) == 'ditolak' ? 'bg-red-100 text-red-800 border-green-200' : 'bg-amber-100 text-amber-800 border-amber-200');
                                $dotAdminClass = strtolower($statusAdminVal) == 'disetujui' ? 'bg-green-500' : (strtolower($statusAdminVal) == 'ditolak' ? 'bg-red-500' : 'bg-amber-500');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $badgeAdminClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotAdminClass }} mr-1.5 animate-pulse"></span>
                                {{ ucfirst($statusAdminVal) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- 2. Ketua Tim Kerja (Hanya jika role = 'user') --}}
                @if($pengajuanumum->user->role == 'user')
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-amber-500 shadow-sm z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Ketua Tim Kerja</h4>
                        <p class="text-xs font-medium text-gray-600">{{ $ketuaNama ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIP {{ $ketuaNIP ?? '-' }}</p>
                        <div class="mt-1.5 flex flex-wrap items-center gap-3">
                            @php
                                $statusKatimVal = $statusKatimker ?? 'Menunggu';
                                $badgeKatimClass = strtolower($statusKatimVal) == 'disetujui' ? 'bg-green-100 text-green-800 border-green-200' : (strtolower($statusKatimVal) == 'ditolak' ? 'bg-red-100 text-red-800 border-green-200' : 'bg-amber-100 text-amber-800 border-amber-200');
                                $dotKatimClass = strtolower($statusKatimVal) == 'disetujui' ? 'bg-green-500' : (strtolower($statusKatimVal) == 'ditolak' ? 'bg-red-500' : 'bg-amber-500');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $badgeKatimClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotKatimClass }} mr-1.5 animate-pulse"></span>
                                {{ ucfirst($statusKatimVal) }}
                            </span>
                            @if(isset($catatanKatimker) && $catatanKatimker)
                                <span class="text-xs text-gray-600 italic">Catatan: "{{ $catatanKatimker }}"</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- 3. Kepala Bagian Umum (Hanya jika role = 'user' atau 'kepalatimkerja') --}}
                @if(in_array($pengajuanumum->user->role, ['user', 'kepalatimkerja']))
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-amber-500 shadow-sm z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Kepala Bagian Umum</h4>
                        <p class="text-xs font-medium text-gray-600">{{ $kabagNama ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIP {{ $kabagNIP ?? '-' }}</p>
                        <div class="mt-1.5 flex flex-wrap items-center gap-3">
                            @php
                                $statusKabagVal = $statusKabag ?? 'Menunggu';
                                $badgeKabagClass = strtolower($statusKabagVal) == 'disetujui' ? 'bg-green-100 text-green-800 border-green-200' : (strtolower($statusKabagVal) == 'ditolak' ? 'bg-red-100 text-red-800 border-green-200' : 'bg-amber-100 text-amber-800 border-amber-200');
                                $dotKabagClass = strtolower($statusKabagVal) == 'disetujui' ? 'bg-green-500' : (strtolower($statusKabagVal) == 'ditolak' ? 'bg-red-500' : 'bg-amber-500');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $badgeKabagClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotKabagClass }} mr-1.5 animate-pulse"></span>
                                {{ ucfirst($statusKabagVal) }}
                            </span>
                            @if(isset($catatanKabag) && $catatanKabag)
                                <span class="text-xs text-gray-600 italic">Catatan: "{{ $catatanKabag }}"</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- 4. Kepala Balai (Selalu Ada) --}}
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-amber-500 shadow-sm z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Kepala Balai</h4>
                        <p class="text-xs font-medium text-gray-600">{{ $kabalaiNama ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIP {{ $kabalaiNIP ?? '-' }}</p>
                        <div class="mt-1.5 flex flex-wrap items-center gap-3">
                            @php
                                $statusKabalaiVal = $statusKabalai ?? 'Menunggu';
                                $badgeKabalaiClass = strtolower($statusKabalaiVal) == 'disetujui' ? 'bg-green-100 text-green-800 border-green-200' : (strtolower($statusKabalaiVal) == 'ditolak' ? 'bg-red-100 text-red-800 border-green-200' : 'bg-amber-100 text-amber-800 border-amber-200');
                                $dotKabalaiClass = strtolower($statusKabalaiVal) == 'disetujui' ? 'bg-green-500' : (strtolower($statusKabalaiVal) == 'ditolak' ? 'bg-red-500' : 'bg-amber-500');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $badgeKabalaiClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotKabalaiClass }} mr-1.5 animate-pulse"></span>
                                {{ ucfirst($statusKabalaiVal) }}
                            </span>
                            @if(isset($catatanKabalai) && $catatanKabalai)
                                <span class="text-xs text-gray-600 italic">Catatan: "{{ $catatanKabalai }}"</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

    {{-- STATUS VERIFIKASI AKHIR --}}
    @if($checkverifikasicutiumum)
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-6 bg-gradient-to-r from-blue-600 to-indigo-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="font-semibold uppercase text-white">Status Verifikasi Akhir</span>
            </h5>
        </div>
        <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Keputusan Final:</p>
                    <span class="inline-flex items-center px-4 py-1 rounded-full text-sm font-bold uppercase tracking-wider
                        @if($checkverifikasicutiumum->status_cuti == 'disetujui') bg-green-100 text-green-800 border border-green-200
                        @elseif($checkverifikasicutiumum->status_cuti == 'ditolak') bg-red-100 text-red-800 border border-green-200
                        @else bg-orange-100 text-orange-800 border border-orange-200 @endif">
                        {{ $checkverifikasicutiumum->status_cuti }}
                    </span>
                </div>
            </div>
            @if($checkverifikasicutiumum->alasan_penolakan)
            <div class="flex-1 bg-gray-50 p-3 rounded-lg border border-gray-200">
                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Catatan Verifikator:</p>
                <p class="text-sm text-gray-700">"{{ $checkverifikasicutiumum->alasan_penolakan }}"</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
        <a href="{{ route('adminpengajuancutiumum.index') }}" 
        class="w-full sm:w-auto flex items-center justify-center px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-semibold bg-white hover:bg-gray-50 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>

        @if (!$checkverifikasicutiumum && auth()->user()->role == 'admin')
        <button class="w-full sm:w-auto relative px-8 py-2.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all"
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

{{-- MODAL VERIFIKASI BARU (SESUAI GAMBAR) --}}
<div id="verifikasiModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden transform transition-all">
        <div class="p-5 bg-gradient-to-r from-green-600 to-emerald-500 text-white flex items-center gap-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11l2 2 4-4" />
            </svg>
            <h5 class="text-lg font-bold">Verifikasi Pengajuan Cuti</h5>
        </div>
        
        <form id="verifikasiForm" method="POST" action="{{ route('adminverifikasicutiumum.store') }}" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="id_pengajuan_cuti_umum" value="{{ $pengajuanumum->id }}">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Opsi Disetujui --}}
                    <label id="labelDisetujui" onclick="selectStatus('disetujui')" class="cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-green-500 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="status_cuti" value="disetujui" id="radioDisetujui" class="sr-only" required>
                            <span id="circleDisetujui" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <span class="w-2 h-2 rounded-full bg-transparent"></span>
                            </span>
                            <span id="textDisetujui" class="text-sm font-semibold text-gray-400">Disetujui</span>
                        </div>
                        <span id="checkDisetujui" class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                            ✓
                        </span>
                    </label>

                    {{-- Opsi Ditolak --}}
                    <label id="labelDitolak" onclick="selectStatus('ditolak')" class="cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-red-400 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="status_cuti" value="ditolak" id="radioDitolak" class="sr-only">
                            <span id="circleDitolak" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <span class="w-2 h-2 rounded-full bg-transparent"></span>
                            </span>
                            <span id="textDitolak" class="text-sm font-semibold text-gray-600">Ditolak</span>
                        </div>
                        <span id="checkDitolak" class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                            ✕
                        </span>
                    </label>
                </div>
            </div>
            
            <div id="catatanContainer" class="hidden animate-fade-in">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alasan Penolakan :</label>
                <textarea id="catatanInput" class="w-full p-3.5 border border-red-300 focus:border-red-500 rounded-xl bg-white focus:ring-2 focus:ring-red-500/20 outline-none transition-all text-sm text-gray-700 placeholder-gray-300 shadow-sm" rows="3" name="alasan_penolakan" placeholder="Contoh : Pekerjaan mendesak, silahkan ajukan bulan depan"></textarea>
            </div>
            
            <div class="flex items-center gap-3 pt-2">
                <button type="button" class="flex-1 px-5 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all text-sm"
                        onclick="toggleModal(false)">
                    Batalkan
                </button>
                <button type="submit" class="flex-1 px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-semibold shadow-md hover:shadow-lg transition-all text-sm">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>

{{-- PANEL PREVIEW LAMPIRAN --}}
<div id="previewPanel" class="fixed inset-0 z-[70] hidden overflow-hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closePreviewPanel()"></div>
    <div class="absolute right-0 top-0 h-full w-full md:w-3/4 lg:w-2/3 bg-white shadow-2xl transform transition-transform duration-500 ease-out translate-x-full" id="panelContent">
        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-600 to-emerald-500 text-white">
            <h3 class="font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Preview Lampiran
            </h3>
            <div class="flex items-center gap-2">
                @if(isset($lampiran))
                <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" class="px-3 py-1 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-bold transition-all border border-white/30">
                    Buka Tab Baru
                </a>
                @endif
                <button onclick="closePreviewPanel()" class="p-2 hover:bg-black/10 rounded-full transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="h-[calc(100%-64px)] overflow-auto bg-gray-50 p-6 flex justify-center">
            @if(isset($lampiran))
                @php
                    $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
                    $fileUrl = Storage::url($lampiran->file_path);
                @endphp
                <div class="w-full h-full rounded-2xl bg-white shadow-inner p-4 overflow-hidden border border-gray-200">
                    @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ $fileUrl }}" alt="Preview" class="max-w-full max-h-full mx-auto object-contain">
                    @elseif(strtolower($fileExtension) == 'pdf')
                        <embed src="{{ $fileUrl }}" type="application/pdf" width="100%" height="100%">
                    @else
                        <div class="flex flex-col items-center justify-center h-full space-y-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 font-bold tracking-widest uppercase">File format tidak didukung untuk preview</p>
                            <a href="{{ $fileUrl }}" download class="px-6 py-2 bg-emerald-600 text-white rounded-xl font-bold shadow-md">Download File</a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition 
         class="fixed bottom-10 right-10 bg-emerald-600 text-white px-6 py-3 rounded-2xl shadow-2xl z-[100] border border-white/20 flex items-center gap-3 animate-bounce">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        ["verifikasiModal", "previewPanel"].forEach(id => {
            const el = document.getElementById(id);
            if (el) { el.classList.remove("hidden"); el.style.display = "none"; }
        });

        // Tombol Edit Durasi Cuti
        const editBtn    = document.getElementById("editButton");
        const saveBtn    = document.getElementById("saveButton");
        const cancelBtn  = document.getElementById("cancelButton");
        const input      = document.getElementById("jumlahHariInput");
        const satuan     = document.getElementById("satuan_cuti");
        const durasiText = document.getElementById("durasi-text");
        let originalValue = input ? input.value : null;

        if (editBtn) {
            editBtn.addEventListener("click", function () {
                durasiText.classList.add("hidden");
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
                durasiText.classList.remove("hidden");
                editBtn.classList.remove("hidden");
            });
        }
    });

    // Fungsi Interaktif Pemilihan Status di Modal
    function selectStatus(status) {
        const radioDisetujui = document.getElementById("radioDisetujui");
        const radioDitolak = document.getElementById("radioDitolak");
        const labelDisetujui = document.getElementById("labelDisetujui");
        const labelDitolak = document.getElementById("labelDitolak");
        const textDisetujui = document.getElementById("textDisetujui");
        const textDitolak = document.getElementById("textDitolak");
        const circleDisetujui = document.getElementById("circleDisetujui");
        const circleDitolak = document.getElementById("circleDitolak");
        const checkDisetujui = document.getElementById("checkDisetujui");
        const checkDitolak = document.getElementById("checkDitolak");
        const catatanContainer = document.getElementById("catatanContainer");
        const catatanInput = document.getElementById("catatanInput");

        if (status === 'disetujui') {
            radioDisetujui.checked = true;
            radioDitolak.checked = false;

            // Style Card Disetujui (Aktif)
            labelDisetujui.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-green-500 bg-white transition-all shadow-sm";
            textDisetujui.className = "text-sm font-semibold text-green-600";
            circleDisetujui.className = "w-5 h-5 rounded-full border-2 border-green-500 flex items-center justify-center bg-green-500";
            circleDisetujui.innerHTML = '<span class="w-2 h-2 rounded-full bg-white"></span>';
            checkDisetujui.className = "w-6 h-6 rounded-md bg-green-100 flex items-center justify-center text-green-600 text-xs font-bold";

            // Style Card Ditolak (Non-aktif)
            labelDitolak.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-red-400 transition-all";
            textDitolak.className = "text-sm font-semibold text-gray-600";
            circleDitolak.className = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
            circleDitolak.innerHTML = '<span class="w-2 h-2 rounded-full bg-transparent"></span>';
            checkDitolak.className = "w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs";

            // Sembunyikan Alasan Penolakan
            catatanContainer.classList.add("hidden");
            catatanInput.required = false;
        } else {
            radioDitolak.checked = true;
            radioDisetujui.checked = false;

            // Style Card Ditolak (Aktif)
            labelDitolak.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-red-400 bg-white transition-all shadow-sm";
            textDitolak.className = "text-sm font-semibold text-red-600";
            circleDitolak.className = "w-5 h-5 rounded-full border-2 border-red-500 flex items-center justify-center bg-red-500";
            circleDitolak.innerHTML = '<span class="w-2 h-2 rounded-full bg-white"></span>';
            checkDitolak.className = "w-6 h-6 rounded-md bg-red-100 flex items-center justify-center text-red-600 text-xs font-bold";

            // Style Card Disetujui (Non-aktif)
            labelDisetujui.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-green-500 transition-all";
            textDisetujui.className = "text-sm font-semibold text-gray-400";
            circleDisetujui.className = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
            circleDisetujui.innerHTML = '<span class="w-2 h-2 rounded-full bg-transparent"></span>';
            checkDisetujui.className = "w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs";

            // Tampilkan Alasan Penolakan
            catatanContainer.classList.remove("hidden");
            catatanContainer.classList.add("animate-fade-in");
            catatanInput.required = true;
        }
    }

    function openModal() {
        document.getElementById("verifikasiModal").style.display = "flex";
    }

    function toggleModal(show) {
        document.getElementById("verifikasiModal").style.display = show ? "flex" : "none";
    }

    function openPreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const content = document.getElementById("panelContent");
        panel.style.display = "block";
        setTimeout(() => content.classList.remove("translate-x-full"), 10);
    }

    function closePreviewPanel() {
        const content = document.getElementById("panelContent");
        content.classList.add("translate-x-full");
        setTimeout(() => document.getElementById("previewPanel").style.display = "none", 500);
    }

    window.onclick = function (event) {
        const vModal = document.getElementById("verifikasiModal");
        if (event.target == vModal) toggleModal(false);
    }
</script>

<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
</style>

@endsection