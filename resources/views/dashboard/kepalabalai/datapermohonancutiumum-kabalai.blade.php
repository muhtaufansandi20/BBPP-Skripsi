@extends('dashboard.kepalabalai.base-kepalabalai')

@section('content')
<div class="p-6 bg-gradient-to-br from-gray-50 to-green-50 rounded-2xl shadow-xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 pt-4">
        <div>
            <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Umum</h2>
            <p class="text-blue-600 font-medium">Kepala Balai</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="flex border-b border-gray-200">
            <button id="btn-pending" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-green-500 text-green-600 focus:outline-none" 
                    onclick="showTable('pending-table', 'completed-table', 'btn-pending', 'btn-completed')">
                Menunggu Verifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    {{ count($viewData['pendingRegularRequests']) + count($viewData['pendingKabagRequests']) }}
                </span>
            </button>
            <button id="btn-completed" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" 
                    onclick="showTable('completed-table', 'pending-table', 'btn-completed', 'btn-pending')">
                Sudah Diverifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                    {{ count($viewData['verifiedRegularRequests']) + count($viewData['verifiedKabagRequests']) }}
                </span>
            </button>
        </div>
    </div>

    <div id="pending-table" class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-lime-500">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Cuti Yang Belum Diverifikasi
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $index = 1; @endphp
                    
                    @if(count($viewData['pendingRegularRequests']) > 0 || count($viewData['pendingKabagRequests']) > 0)
                        @foreach ($viewData['pendingRegularRequests'] as $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index++ }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[200px]">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="font-bold text-blue-600">{{ substr($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->nip ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->jenisCuti->nama_cuti ?? 'Tidak Diketahui' }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[250px]">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-medium mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic break-words">Alasan: {{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @php
                                    $status = $cuti->kabagKabal->status ?? 'Menunggu';
                                @endphp
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $status == 'disetujui' ? 'bg-green-100 text-green-600' : 
                                   ($status == 'ditolak' ? 'bg-red-100 text-red-600' : 
                                   ($status == 'perubahan' ? 'bg-indigo-100 text-indigo-600' : 
                                   ($status == 'ditangguhkan' ? 'bg-purple-100 text-purple-600' : 
                                   'bg-yellow-100 text-yellow-600'))) }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('kabalaidatapermohonancutiumum.show', $cuti->id) }}" 
                                   class="inline-flex items-center justify-center p-2 rounded-md text-blue-600 hover:bg-blue-50 transition-colors"
                                   title="Lihat Detail">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                   </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        
                        @foreach ($viewData['pendingKabagRequests'] as $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index++ }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->pengajuanCutiUmum->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[200px]">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <span class="font-bold text-yellow-600">{{ substr($cuti->pengajuanCutiUmum->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $cuti->pengajuanCutiUmum->user->name }}</div>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $cuti->pengajuanCutiUmum->user->nip ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->pengajuanCutiUmum->user->jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $cuti->pengajuanCutiUmum->jenisCuti->nama_cuti ?? 'Tidak Diketahui' }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[250px]">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->pengajuanCutiUmum->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->pengajuanCutiUmum->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-medium mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $cuti->pengajuanCutiUmum->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic break-words">Alasan: {{ $cuti->pengajuanCutiUmum->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @php
                                    $status = $cuti->cuStatusAdminKabal->status ?? 'Menunggu';
                                @endphp
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $status == 'disetujui' ? 'bg-green-100 text-green-600' : 
                                   ($status == 'ditolak' ? 'bg-red-100 text-red-600' : 
                                   ($status == 'perubahan' ? 'bg-indigo-100 text-indigo-600' : 
                                   ($status == 'ditangguhkan' ? 'bg-purple-100 text-purple-600' : 
                                   'bg-yellow-100 text-yellow-600'))) }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('kabalaidatapermohonancutiumum.show', $cuti->id) }}?type=kabag" 
                                   class="inline-flex items-center justify-center p-2 rounded-md text-blue-600 hover:bg-blue-50 transition-colors"
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada pengajuan cuti yang memerlukan verifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div id="completed-table" class="bg-white rounded-xl shadow-md overflow-hidden hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-500 to-primary">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Cuti Yang Sudah Diverifikasi
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $index = 1; @endphp
                    
                    @if(count($viewData['verifiedRegularRequests']) > 0 || count($viewData['verifiedKabagRequests']) > 0)
                        @foreach ($viewData['verifiedRegularRequests'] as $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index++ }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[200px]">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="font-bold text-blue-600">{{ substr($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->nip ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->user->jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->jenisCuti->nama_cuti ?? 'Tidak Diketahui' }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[250px]">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->adminKatimker->userAdmin->pengajuanCutiUmum->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-medium mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic break-words">Alasan: {{ $cuti->adminKatimker->userAdmin->pengajuanCutiUmum->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @php
                                    $status = $cuti->kabagKabal->status ?? 'Menunggu';
                                @endphp
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $status == 'disetujui' ? 'bg-green-100 text-green-600' : 
                                   ($status == 'ditolak' ? 'bg-red-100 text-red-600' : 
                                   ($status == 'perubahan' ? 'bg-indigo-100 text-indigo-600' : 
                                   ($status == 'ditangguhkan' ? 'bg-purple-100 text-purple-600' : 
                                   'bg-yellow-100 text-yellow-600'))) }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('kabalaidatapermohonancutiumum.show', $cuti->id) }}" 
                                   class="inline-flex items-center justify-center p-2 rounded-md text-blue-600 hover:bg-blue-50 transition-colors"
                                   title="Lihat Detail">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                   </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        
                        @foreach ($viewData['verifiedKabagRequests'] as $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $index++ }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->pengajuanCutiUmum->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[200px]">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <span class="font-bold text-yellow-600">{{ substr($cuti->pengajuanCutiUmum->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $cuti->pengajuanCutiUmum->user->name }}</div>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $cuti->pengajuanCutiUmum->user->nip ?? '-' }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->pengajuanCutiUmum->user->jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $cuti->pengajuanCutiUmum->jenisCuti->nama_cuti ?? 'Tidak Diketahui' }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-normal min-w-[250px]">
                                <div class="text-sm text-gray-900">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->pengajuanCutiUmum->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->pengajuanCutiUmum->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 font-medium mt-1">
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $cuti->pengajuanCutiUmum->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic break-words">Alasan: {{ $cuti->pengajuanCutiUmum->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                @php
                                    $status = $cuti->cuStatusAdminKabal->status ?? 'Menunggu';
                                @endphp
                                
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                {{ $status == 'disetujui' ? 'bg-green-100 text-green-600' : 
                                   ($status == 'ditolak' ? 'bg-red-100 text-red-600' : 
                                   ($status == 'perubahan' ? 'bg-indigo-100 text-indigo-600' : 
                                   ($status == 'ditangguhkan' ? 'bg-purple-100 text-purple-600' : 
                                   'bg-yellow-100 text-yellow-600'))) }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('kabalaidatapermohonancutiumum.show', $cuti->id) }}?type=kabag" 
                                   class="inline-flex items-center justify-center p-2 rounded-md text-blue-600 hover:bg-blue-50 transition-colors"
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada pengajuan cuti yang diverifikasi</p>
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
        // Show and hide tables
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        // Update button styles
        document.getElementById(activeBtn).classList.add('border-green-500', 'text-green-600');
        document.getElementById(activeBtn).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        
        document.getElementById(inactiveBtn).classList.remove('border-green-500', 'text-green-600');
        document.getElementById(inactiveBtn).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
    }
</script>

<style>
    /* Custom scrollbar styling */
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
    
    /* Max height scroll for tables */
    .max-h-\[600px\] {
        max-height: 600px;
    }
    
    /* Smooth transitions */
    .transition-colors {
        transition: background-color 0.2s ease;
    }
    
    /* Hover effects */
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }
    
    .hover\:bg-blue-50:hover {
        background-color: #eff6ff;
    }
</style>
@endsection