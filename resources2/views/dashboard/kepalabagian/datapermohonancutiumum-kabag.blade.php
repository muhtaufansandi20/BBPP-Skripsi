@extends('dashboard.kepalabagian.base-kepalabagian')

@section('content')
<div class="p-6 pt-0 bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl shadow-xl">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center mb-2">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Umum</h2>
        </div>
        <div class="bg-blue-50 border-l-4 border-green-500 p-4 mb-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        Halaman ini untuk mengelola pengajuan cuti umum pegawai. Anda dapat menyetujui atau menolak pengajuan cuti sesuai dengan kebijakan yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab navigation -->
    <div class="mb-6">
        <div class="flex border-b border-gray-200">
            <button id="btn-pending" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-emerald-500 text-green-500 focus:outline-none" 
                    onclick="showTable('pending-table', 'completed-table', 'btn-pending', 'btn-completed')">
                Belum Diverifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                    {{ $pendingCount }}
                </span>
            </button>
            <button id="btn-completed" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" 
                    onclick="showTable('completed-table', 'pending-table', 'btn-completed', 'btn-pending')">
                Sudah Diverifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    {{ $verifiedCount }}
                </span>
            </button>
        </div>
    </div>

    <!-- Table for applications not yet verified by Kabag -->
    <div id="pending-table" class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-lime-500">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Cuti Yang Belum Diverifikasi Kabag
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr class="text-gray-600">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $pendingApplications = $cuStatusAdminKatimker->whereNull('cuStatusKatimkerKabag');
                    @endphp
                    
                    @if($pendingApplications->count() > 0)
                        @foreach ($pendingApplications as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->userAdmin->pengajuanCutiUmum->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $cuti->userAdmin->pengajuanCutiUmum->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cuti->userAdmin->pengajuanCutiUmum->user->nip ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $cuti->userAdmin->pengajuanCutiUmum->user->jabatan ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cuti->userAdmin->pengajuanCutiUmum->jenisCuti->nama_cuti ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->userAdmin->pengajuanCutiUmum->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->userAdmin->pengajuanCutiUmum->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Lama: {{ $cuti->userAdmin->pengajuanCutiUmum->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic">Alasan: {{ $cuti->userAdmin->pengajuanCutiUmum->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Menunggu Verifikasi
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('kabagdatapermohonancutiumum.show', $cuti->id)}}"
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
                                    <svg class="w-10 h-10 sm:w-16 sm:h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-md sm:text-lg font-medium">Semua pengajuan cuti umum sudah diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table for applications already verified by Kabag -->
    <div id="completed-table" class="bg-white rounded-xl shadow-md overflow-hidden hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-500 to-primary">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Cuti Yang Sudah Diverifikasi Kabag
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr class="text-gray-600">
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $verifiedApplications = $cuStatusAdminKatimker->whereNotNull('cuStatusKatimkerKabag');
                    @endphp
                    
                    @if($verifiedApplications->count() > 0)
                        @foreach ($verifiedApplications as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->userAdmin->pengajuanCutiUmum->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $cuti->userAdmin->pengajuanCutiUmum->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cuti->userAdmin->pengajuanCutiUmum->user->nip ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $cuti->userAdmin->pengajuanCutiUmum->user->jabatan ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cuti->userAdmin->pengajuanCutiUmum->jenisCuti->nama_cuti ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->userAdmin->pengajuanCutiUmum->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->userAdmin->pengajuanCutiUmum->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Lama: {{ $cuti->userAdmin->pengajuanCutiUmum->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic">Alasan: {{ $cuti->userAdmin->pengajuanCutiUmum->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusText = $cuti->cuStatusKatimkerKabag->status;
                                    $bgClass = 'bg-gray-100';
                                    $textClass = 'text-gray-600';
                        
                                    switch($statusText) {
                                        case 'disetujui':
                                            $bgClass = 'bg-green-100';
                                            $textClass = 'text-green-800';
                                            break;
                                        case 'ditolak':
                                            $bgClass = 'bg-red-100';
                                            $textClass = 'text-red-800';
                                            break;
                                        case 'perubahan':
                                            $bgClass = 'bg-indigo-100';
                                            $textClass = 'text-indigo-800';
                                            break;
                                        case 'ditangguhkan':
                                            $bgClass = 'bg-purple-100';
                                            $textClass = 'text-purple-800';
                                            break;
                                        case 'belum disetujui':
                                            $bgClass = 'bg-blue-100';
                                            $textClass = 'text-blue-800';
                                            break;
                                    }
                        
                                    // Format the status text to be more readable
                                    $formattedStatus = ucfirst($statusText); 
                                @endphp
                        
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $bgClass }} {{ $textClass }}">
                                    {{ $formattedStatus }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('kabagdatapermohonancutiumum.show', $cuti->id)}}" 
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
                                    <svg class="w-10 h-10 sm:w-16 sm:h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                    <p class="text-md sm:text-lg font-medium">Belum ada pengajuan cuti umum yang diverifikasi</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar for the table */
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
</style>

<script>
    function showTable(showId, hideId, activeBtn, inactiveBtn) {
        // Show and hide tables
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        // Update button styles
        document.getElementById(activeBtn).classList.add('border-emerald-600', 'text-green-600');
        document.getElementById(activeBtn).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        
        document.getElementById(inactiveBtn).classList.remove('border-emerald-600', 'text-green-600');
        document.getElementById(inactiveBtn).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
    }
</script>
@endsection