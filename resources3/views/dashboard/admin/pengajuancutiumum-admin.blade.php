@extends('dashboard.admin.base-admin')

@section('main')
<div class="container mx-auto px-4 py-6 pt-0">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
            <div>
                <h1 class="text-xl font-semibold text-gray-800">Manajemen Pengajuan Cuti Umum</h1>
                <p class="text-gray-600 text-sm">Kelola semua permohonan cuti pegawai di sini</p>
            </div>
        </div>
        
        <!-- Info Box -->
        <div class="bg-blue-50 border-l-4 border-emerald-500 rounded-lg p-4 flex items-start">
            <svg class="flex-shrink-0 h-5 w-5 text-emerald-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
            <div class="ml-3">
                <p class="text-sm text-emerald-700">
                    Admin dapat memverifikasi, menolak, atau menangguhkan permohonan cuti. Pastikan untuk memeriksa dokumen pendukung sebelum memutuskan.
                </p>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button id="btn-pending" onclick="showTable('pending-table', 'completed-table', 'btn-pending', 'btn-completed')" 
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-emerald-500 text-emerald-600 flex items-center">
                    <span>Belum Diverifikasi</span>
                    <span class="ml-2 bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        {{ $belumVerifikasi->count() }}
                    </span>
                </button>
                <button id="btn-completed" onclick="showTable('completed-table', 'pending-table', 'btn-completed', 'btn-pending')" 
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 flex items-center">
                    <span>Sudah Diverifikasi</span>
                    <span class="ml-2 bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                        {{ $sudahVerifikasi->count() }}
                    </span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Pending Requests Table -->
    <div id="pending-table" class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-lime-500">
            <h2 class="text-lg font-medium text-white flex items-center">
                <i class="fas fa-clock mr-2"></i>
                Pengajuan Menunggu Verifikasi
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($belumVerifikasi as $index => $cuti)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-accent/10 flex items-center justify-center text-accent font-medium">
                                    {{ substr($cuti->user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cuti->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $cuti->user->nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $cutiStyle = '';
                                if($cuti->jenisCuti) {
                                    switch($cuti->jenisCuti->nama_cuti) {
                                        case 'Cuti Besar':
                                            $cutiStyle = 'bg-green-100 text-green-800';
                                            break;
                                        case 'Cuti Melahirkan':
                                            $cutiStyle = 'bg-pink-100 text-pink-800';
                                            break;
                                        case 'Cuti Sakit':
                                            $cutiStyle = 'bg-red-100 text-red-800';
                                            break;
                                        case 'Cuti Alasan Penting':
                                            $cutiStyle = 'bg-blue-100 text-blue-800';
                                            break;
                                        default:
                                            $cutiStyle = 'bg-gray-100 text-gray-800';
                                    }
                                }
                            @endphp
                            <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium {{ $cutiStyle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $cuti->jenisCuti->nama_cuti ?? '-' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d M Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $cuti->jumlah_hari }} 
                                @if($cuti->jenisCuti && in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                    Bulan
                                @elseif($cuti->jenisCuti && in_array($cuti->jenisCuti->nama_cuti, ['Cuti Sakit', 'Cuti Alasan Penting']))
                                    Hari Kerja
                                @else
                                    Hari
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Menunggu Verifikasi
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('adminpengajuancutiumum.show', $cuti->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>                           
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-lg font-medium">Tidak ada pengajuan cuti yang menunggu verifikasi</p>
                                <p class="text-sm mt-1">Semua permohonan cuti telah diproses</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Completed Requests Table -->
    <div id="completed-table" class="bg-white rounded-xl shadow-sm overflow-hidden hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-500 to-primary">
            <h2 class="text-lg font-medium text-white flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                Pengajuan Telah Diverifikasi
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($sudahVerifikasi as $index => $cuti)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-medium">
                                    {{ substr($cuti->user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $cuti->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $cuti->user->nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $cutiStyle = '';
                                if($cuti->jenisCuti) {
                                    switch($cuti->jenisCuti->nama_cuti) {
                                        case 'Cuti Besar':
                                            $cutiStyle = 'bg-green-100 text-green-800';
                                            break;
                                        case 'Cuti Melahirkan':
                                            $cutiStyle = 'bg-pink-100 text-pink-800';
                                            break;
                                        case 'Cuti Sakit':
                                            $cutiStyle = 'bg-red-100 text-red-800';
                                            break;
                                        case 'Cuti Alasan Penting':
                                            $cutiStyle = 'bg-blue-100 text-blue-800';
                                            break;
                                        default:
                                            $cutiStyle = 'bg-gray-100 text-gray-800';
                                    }
                                }
                            @endphp
                            <span class="px-3 py-1 inline-flex items-center rounded-full text-xs font-medium {{ $cutiStyle }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $cuti->jenisCuti->nama_cuti ?? '-' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d M Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $cuti->jumlah_hari }} 
                                @if($cuti->jenisCuti && in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                    Bulan
                                @elseif($cuti->jenisCuti && in_array($cuti->jenisCuti->nama_cuti, ['Cuti Sakit', 'Cuti Alasan Penting']))
                                    Hari Kerja
                                @else
                                    Hari
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $status = $cuti->StatusAdminUmum->status ?? 'pending';
                                $statusClass = 'bg-red-100 text-red-800'; 
                                
                                if ($status == 'disetujui') {
                                    $statusClass = 'bg-green-100 text-green-800';
                                } elseif ($status == 'ditangguhkan') {
                                    $statusClass = 'bg-orange-100 text-orange-800';
                                }
                            @endphp
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('adminpengajuancutiumum.show', $cuti->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                                <p class="text-lg font-medium">Belum ada pengajuan cuti yang sudah diverifikasi</p>
                                <p class="text-sm mt-1">Semua permohonan cuti masih dalam proses verifikasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function showTable(showId, hideId, activeBtn, inactiveBtn) {
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        document.getElementById(activeBtn).classList.add('border-emerald-500', 'text-emerald-600');
        document.getElementById(activeBtn).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        
        document.getElementById(inactiveBtn).classList.remove('border-emerald-500', 'text-emerald-600');
        document.getElementById(inactiveBtn).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    }
</script>

@endsection