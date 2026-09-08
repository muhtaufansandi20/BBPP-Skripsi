@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-10">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Detail Pengajuan Cuti</h1>
            <p class="text-sm text-gray-500 mt-0.5">Informasi lengkap pengajuan cuti tahunan Anda</p>
        </div>

        <!-- Main Card Container -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Green Gradient Header -->
            <div class="bg-gradient-to-r from-emerald-400 to-green-500 p-6 text-white">
                <h2 class="text-xl sm:text-2xl font-bold">Formulir Pengajuan Cuti</h2>
                <p class="text-emerald-50 text-sm mt-1">
                    Diajukan pada: {{ date('d F Y', strtotime($pengajuancutitahunan->tgl_pengajuan)) }}
                </p>
            </div>

            <!-- Status Banner (Jika Dibatalkan) -->
            @if ($pengajuancutitahunan->statusCutiTahunan && $pengajuancutitahunan->statusCutiTahunan->status == 'dibatalkan')
                <div class="bg-red-50 border-b border-red-200 p-5 mx-6 mt-6 rounded-xl flex items-start gap-3">
                    <div class="flex-shrink-0 text-red-600 mt-0.5">
                        <i class="fas fa-ban text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-red-800 text-sm">Pengajuan Cuti Dibatalkan</h3>
                        <p class="text-xs text-red-700 mt-1"><span class="font-semibold">Status:</span> {{ ucfirst($statusPembatalan) }}</p>
                        <p class="text-xs text-red-700 mt-0.5"><span class="font-semibold">Catatan:</span> {{ $catatanPembatalan }}</p>
                    </div>
                </div>
            @endif

            <!-- Body Content -->
            <div class="p-6 space-y-6">
                <!-- Detail Cuti Box -->
                <div class="bg-white rounded-xl border border-gray-200/80 p-5 shadow-2xs">
                    <div class="flex items-center gap-2 mb-4 text-gray-800 font-semibold text-sm">
                        <i class="far fa-calendar-alt text-emerald-500"></i>
                        <span>Detail Cuti</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                        <div>
                            <span class="block text-gray-500 text-xs mb-1">Periode Cuti</span>
                            <div class="font-medium text-gray-800 flex items-center gap-2">
                                <span>{{ date('d/m/Y', strtotime($pengajuancutitahunan->tgl_mulai)) }}</span>
                                <span class="text-gray-400 text-xs">s/d</span>
                                <span>{{ date('d/m/Y', strtotime($pengajuancutitahunan->tgl_selesai)) }}</span>
                            </div>
                        </div>

                        <div>
                            <span class="block text-gray-500 text-xs mb-1">Lama Cuti</span>
                            <div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-xs font-semibold border border-emerald-200 shadow-2xs">
                                    <i class="far fa-clock text-emerald-500"></i> {{ $pengajuancutitahunan->lama_cuti }} Hari Kerja
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="block text-gray-500 text-xs mb-1">Nomor Telepon</span>
                            <p class="font-medium text-gray-800">{{ $pengajuancutitahunan->no_hp_cuti }}</p>
                        </div>

                        <div>
                            <span class="block text-gray-500 text-xs mb-1">Alamat Selama Cuti</span>
                            <p class="font-medium text-gray-800">{{ $pengajuancutitahunan->alamat_saat_cuti }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <span class="block text-gray-500 text-xs mb-1">Alasan Cuti</span>
                            <p class="font-medium text-gray-800">{{ $pengajuancutitahunan->alasan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Verifikasi (Timeline Layout) -->
                <div class="bg-white rounded-xl border border-gray-200/80 p-5 shadow-2xs">
                    <div class="flex items-center gap-2 mb-6 text-gray-800 font-semibold text-sm">
                        <i class="fas fa-shield-alt text-emerald-500"></i>
                        <span>Status Verifikasi</span>
                    </div>

                    <div class="relative pl-6 space-y-6 before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-emerald-300">
                        
                        <!-- 1. Admin Verification -->
                        @php
                            $realAdminStatus = optional($pengajuancutitahunan->ctStatusUserAdmin)->status ?? $statusAdmin;
                            $stAdmin = strtolower($realAdminStatus);
                            $adminBg = $stAdmin == 'disetujui' ? 'bg-emerald-500' : ($stAdmin == 'ditolak' ? 'bg-rose-500' : 'bg-amber-400');
                            $adminBadge = $stAdmin == 'disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($stAdmin == 'ditolak' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-amber-50 text-amber-600 border-amber-200');
                        @endphp
                        <div class="relative">
                            <div class="absolute -left-6 mt-0.5 w-5 h-5 rounded-full {{ $adminBg }} text-white flex items-center justify-center text-xs shadow-xs">
                                @if($stAdmin == 'disetujui')
                                    <i class="fas fa-check text-[10px]"></i>
                                @elseif($stAdmin == 'ditolak')
                                    <i class="fas fa-times text-[10px]"></i>
                                @else
                                    <i class="far fa-clock text-[10px]"></i>
                                @endif
                            </div>
                            <div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100 shadow-2xs">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">Admin</h4>
                                        <p class="text-xs text-gray-500">{{ $adminNama ?? 'Administrator' }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $adminBadge }}">
                                        {{ ucfirst($realAdminStatus) }}
                                    </span>
                                </div>
                                <div class="mt-2 text-xs text-gray-600 bg-white p-2.5 rounded-lg border border-gray-200/60">
                                    <span class="font-medium text-gray-500">Catatan:</span> {{ $catatanAdmin ?: 'Tidak ada catatan' }}
                                </div>
                            </div>
                        </div>

                        <!-- 2. Kepala Bagian Verification -->
                        @php
                            $stKabag = strtolower($statusKabag);
                            $kabagBg = $stKabag == 'disetujui' ? 'bg-emerald-500' : ($stKabag == 'ditolak' ? 'bg-rose-500' : 'bg-amber-400');
                            $kabagBadge = $stKabag == 'disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($stKabag == 'ditolak' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-amber-50 text-amber-600 border-amber-200');
                        @endphp
                        <div class="relative">
                            <div class="absolute -left-6 mt-0.5 w-5 h-5 rounded-full {{ $kabagBg }} text-white flex items-center justify-center text-xs shadow-xs">
                                @if($stKabag == 'disetujui')
                                    <i class="fas fa-check text-[10px]"></i>
                                @elseif($stKabag == 'ditolak')
                                    <i class="fas fa-times text-[10px]"></i>
                                @else
                                    <i class="far fa-clock text-[10px]"></i>
                                @endif
                            </div>
                            <div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100 shadow-2xs">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">Kepala Bagian</h4>
                                        <p class="text-xs text-gray-500">{{ $kepalaBagianNama }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $kabagBadge }}">
                                        {{ ucfirst($statusKabag) }}
                                    </span>
                                </div>
                                <div class="mt-2 text-xs text-gray-600 bg-white p-2.5 rounded-lg border border-gray-200/60">
                                    <span class="font-medium text-gray-500">Catatan:</span> {{ $catatanKabag ?: 'Tidak ada catatan' }}
                                </div>
                            </div>
                        </div>

                        <!-- 3. Kepala Balai Verification -->
                        @php
                            $stKabal = strtolower($statusKabal);
                            $kabalBg = $stKabal == 'disetujui' ? 'bg-emerald-500' : ($stKabal == 'ditolak' ? 'bg-rose-500' : 'bg-amber-400');
                            $kabalBadge = $stKabal == 'disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : ($stKabal == 'ditolak' ? 'bg-rose-50 text-rose-600 border-rose-200' : 'bg-amber-50 text-amber-600 border-amber-200');
                        @endphp
                        <div class="relative">
                            <div class="absolute -left-6 mt-0.5 w-5 h-5 rounded-full {{ $kabalBg }} text-white flex items-center justify-center text-xs shadow-xs">
                                @if($stKabal == 'disetujui')
                                    <i class="fas fa-check text-[10px]"></i>
                                @elseif($stKabal == 'ditolak')
                                    <i class="fas fa-times text-[10px]"></i>
                                @else
                                    <i class="far fa-clock text-[10px]"></i>
                                @endif
                            </div>
                            <div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100 shadow-2xs">
                                <div class="flex items-center justify-between mb-1">
                                    <div>
                                        <h4 class="font-bold text-gray-800 text-sm">Kepala Balai</h4>
                                        <p class="text-xs text-gray-500">{{ $kepalaBalaiNama }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $kabalBadge }}">
                                        {{ ucfirst($statusKabal) }}
                                    </span>
                                </div>
                                <div class="mt-2 text-xs text-gray-600 bg-white p-2.5 rounded-lg border border-gray-200/60">
                                    <span class="font-medium text-gray-500">Catatan:</span> {{ $catatanKabal ?: 'Tidak ada catatan' }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('katimkerpengajuancutitahunan.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-700 hover:bg-slate-800 text-white text-sm font-medium rounded-xl shadow-xs transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>Kembali ke Daftar</span>
                    </a>

                    @if ($statusKabal == 'disetujui')
                        <a href="{{ route('viewPDF', ['id' => $pengajuancutitahunan->id]) }}" target="_blank"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-xl shadow-xs transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                            <span>Unduh Surat Cuti</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection