@extends('dashboard.kepalabalai.base-kepalabalai')

@section('content')
<div class="p-6 bg-gradient-to-br from-gray-50 to-emerald-50/40 rounded-2xl shadow-xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 pt-4">
        <div>
            <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Tahunan</h2>
            <p class="text-emerald-600 font-medium">Kepala Balai</p>
        </div>
    </div>

    <!-- Tab navigation -->
    <div class="mb-6">
        <div class="flex border-b border-gray-200">
            <button id="btn-pending" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-green-500 text-green-600 focus:outline-none" 
                    onclick="showTable('pending-table', 'completed-table', 'btn-pending', 'btn-completed')">
                Menunggu Verifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    {{ count($viewData['regularRequestsPending']) + count($viewData['kabagRequestsPending']) }}
                </span>
            </button>
            <button id="btn-completed" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" 
                    onclick="showTable('completed-table', 'pending-table', 'btn-completed', 'btn-pending')">
                Sudah Diverifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    {{ count($viewData['regularRequestsVerified']) + count($viewData['kabagRequestsVerified']) }}
                </span>
            </button>
        </div>
    </div>

    <!-- Table for applications not yet verified -->
    <div id="pending-table" class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-emerald-600 to-green-500">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Cuti Yang Belum Diverifikasi
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $index = 1; @endphp

                    @if(count($viewData['regularRequestsPending']) > 0 || count($viewData['kabagRequestsPending']) > 0)
                        <!-- Regular leave requests pending verification -->
                        @foreach ($viewData['regularRequestsPending'] as $cuti)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                    {{ $index++ }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->tgl_pengajuan)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->user->nip ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->user->jabatan ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Mulai: {{ \Carbon\Carbon::parse($cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->tgl_mulai)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Selesai: {{ \Carbon\Carbon::parse($cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->tgl_selesai)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Lama: {{ $cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->lama_cuti }} Hari</span>
                                        </div>
                                        <div class="flex items-start gap-2 mt-2">
                                            <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                            </svg>
                                            <span class="text-gray-600 italic">Alasan: {{ $cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan->alasan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Menunggu Verifikasi
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <!-- Diubah dari emerald ke blue -->
                                    <a href="{{ route('kepalabalaidatapermohonancuti.show', $cuti->id) }}" 
                                       class="inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                       title="Lihat Detail">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                       </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        <!-- Kabag leave requests pending verification -->
                        @foreach ($viewData['kabagRequestsPending'] as $cuti)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                    {{ $index++ }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($cuti->pengajuanCutiTahunan->tgl_pengajuan)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cuti->pengajuanCutiTahunan->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $cuti->pengajuanCutiTahunan->user->nip ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $cuti->pengajuanCutiTahunan->user->jabatan ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>Mulai: {{ \Carbon\Carbon::parse($cuti->pengajuanCutiTahunan->tgl_mulai)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Selesai: {{ \Carbon\Carbon::parse($cuti->pengajuanCutiTahunan->tgl_selesai)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Lama: {{ $cuti->pengajuanCutiTahunan->lama_cuti }} Hari</span>
                                        </div>
                                        <div class="flex items-start gap-2 mt-2">
                                            <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                            </svg>
                                            <span class="text-gray-600 italic">Alasan: {{ $cuti->pengajuanCutiTahunan->alasan }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                                        Menunggu Verifikasi
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <!-- Diubah dari emerald ke blue -->
                                    <a href="{{ route('kepalabalaidatapermohonancuti.show', $cuti->id) }}?type=kabag" 
                                       class="inline-flex items-center justify-center p-2 rounded-lg text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition-colors"
                                       title="Lihat Detail">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                       </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Semua pengajuan cuti sudah diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table for applications already verified -->
    <div id="completed-table" class="bg-white rounded-xl shadow-md overflow-hidden hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-600 to-emerald-500">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Cuti Yang Sudah Diverifikasi
            </h3>
        </div>

        <div class="max-h-[600px] overflow-y-auto">
            <table class="w-full">
                <thead class="hidden md:table-header-group bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @php $index = 1; @endphp

                    @if(count($viewData['regularRequestsVerified']) > 0 || count($viewData['kabagRequestsVerified']) > 0)
                        {{-- Loop Regular Requests --}}
                        @foreach ($viewData['regularRequestsVerified'] as $cuti)
                            @php 
                                $pCuti = $cuti->statusAdminKatimker->statusUserAdmin->pengajuanCutiTahunan;
                                $statusText = strtolower($cuti->ctStatusKabagKabal->status ?? 'selesai');
                            @endphp
                            <tr class="flex flex-col md:table-row hover:bg-gray-50 transition-colors p-4 md:p-0">
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-center font-medium text-gray-900">{{ $index++ }}</td>
                                
                                <td class="px-0 md:px-6 py-1 md:py-4 text-sm text-gray-500">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Tanggal Pengajuan</span>
                                    {{ \Carbon\Carbon::parse($pCuti->tgl_pengajuan)->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-0 md:px-6 py-2 md:py-4">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Pegawai</span>
                                    <div class="text-sm font-medium text-gray-900">{{ $pCuti->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $pCuti->user->nip ?? '-' }}</div>
                                </td>

                                <td class="px-0 md:px-6 py-2 md:py-4 text-sm text-gray-600">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Detail Cuti</span>
                                    <div class="flex flex-col">
                                        <span class="text-xs md:text-sm">{{ \Carbon\Carbon::parse($pCuti->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($pCuti->tgl_selesai)->format('d/m/Y') }}</span>
                                        <span class="font-bold text-emerald-600 text-xs">{{ $pCuti->lama_cuti }} Hari</span>
                                    </div>
                                </td>

                                <td class="px-0 md:px-6 py-3 md:py-4 text-left md:text-center">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Status Verifikasi</span>
                                    @php
                                        $badgeClass = match($statusText) {
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            'perubahan' => 'bg-indigo-100 text-indigo-800',
                                            'ditangguhkan' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-blue-100 text-blue-800'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-0 md:px-6 py-3 md:py-4 text-center border-t border-gray-100 md:border-none mt-2 md:mt-0 pt-4 md:pt-4">
                                    <!-- Diubah dari emerald ke blue -->
                                    <a href="{{ route('kepalabalaidatapermohonancuti.show', $cuti->id) }}" 
                                       class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all text-xs font-bold group">
                                        <i class="fas fa-eye mr-2"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Loop Kabag Requests --}}
                        @foreach ($viewData['kabagRequestsVerified'] as $cuti)
                            @php 
                                $pCuti = $cuti->pengajuanCutiTahunan;
                                $statusText = strtolower($cuti->ctStatusAdminKabal->status ?? 'selesai');
                            @endphp
                            <tr class="flex flex-col md:table-row hover:bg-gray-50 transition-colors p-4 md:p-0">
                                <td class="hidden md:table-cell px-6 py-4 text-sm text-center font-medium text-gray-900">{{ $index++ }}</td>
                                
                                <td class="px-0 md:px-6 py-1 md:py-4 text-sm text-gray-500">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Tanggal Pengajuan</span>
                                    {{ \Carbon\Carbon::parse($pCuti->tgl_pengajuan)->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-0 md:px-6 py-2 md:py-4">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Pegawai (Kabag)</span>
                                    <div class="text-sm font-medium text-gray-900">{{ $pCuti->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $pCuti->user->nip ?? '-' }}</div>
                                </td>

                                <td class="px-0 md:px-6 py-2 md:py-4 text-sm text-gray-600">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Detail Cuti</span>
                                    <div class="flex flex-col">
                                        <span class="text-xs md:text-sm">{{ \Carbon\Carbon::parse($pCuti->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($pCuti->tgl_selesai)->format('d/m/Y') }}</span>
                                        <span class="font-bold text-emerald-600 text-xs">{{ $pCuti->lama_cuti }} Hari</span>
                                    </div>
                                </td>

                                <td class="px-0 md:px-6 py-3 md:py-4 text-left md:text-center">
                                    <span class="md:hidden font-bold text-[10px] text-green-600 uppercase block mb-1">Status Verifikasi</span>
                                    @php
                                        $badgeClass = match($statusText) {
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                            default => 'bg-blue-100 text-blue-800'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-0 md:px-6 py-3 md:py-4 text-center border-t border-gray-100 md:border-none mt-2 md:mt-0 pt-4 md:pt-4">
                                    <!-- Diubah dari emerald ke blue -->
                                    <a href="{{ route('kepalabalaidatapermohonancuti.show', $cuti->id) }}?type=kabag" 
                                       class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all text-xs font-bold">
                                        <i class="fas fa-eye mr-2"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                    <p class="text-lg font-medium italic">Belum ada pengajuan cuti yang diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showTable(showId, hideId, activeBtn, inactiveBtn) {
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        document.getElementById(activeBtn).classList.add('border-green-500', 'text-green-600');
        document.getElementById(activeBtn).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        
        document.getElementById(inactiveBtn).classList.remove('border-green-500', 'text-green-600');
        document.getElementById(inactiveBtn).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
    }
</script>

<style>
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
    
    .max-h-\[600px\] {
        max-height: 600px;
    }
    
    .transition-colors {
        transition: background-color 0.2s ease;
    }
    
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }
</style>
@endsection