@extends('dashboard.admin.base-admin')

@section('main')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pt-0">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Manajemen Pengajuan Cuti Tahunan</h1>
            <p class="text-gray-600 text-sm">Kelola semua permohonan cuti pegawai di sini</p>
        </div>
        {{-- <a href="{{ route('adminpengajuancutitahunan.create') }}" 
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow hover:shadow-lg transform hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Buat Permohonan Cuti
        </a> --}}
    </div>

    <!-- Info Box -->
    <div class="mb-6 bg-blue-50 border-l-4 border-emerald-500 rounded-lg p-4 flex items-start">
        <svg class="flex-shrink-0 h-5 w-5 text-emerald-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        <div class="ml-3">
            <p class="text-sm text-emerald-600">
                Admin dapat memverifikasi, menolak, atau menangguhkan permohonan cuti. Pastikan untuk memeriksa dokumen pendukung sebelum memutuskan.
            </p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button id="tab-unverified" 
                        class="py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 border-emerald-500 text-emerald-600"
                        onclick="showTable('content-unverified', 'content-verified', 'tab-unverified', 'tab-verified')">
                    <span>Belum Diverifikasi</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        {{ count($belumVerifikasi) }}
                    </span>
                </button>
                <button id="tab-verified" 
                        class="py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                        onclick="showTable('content-verified', 'content-unverified', 'tab-verified', 'tab-unverified')">
                    <span>Sudah Diverifikasi</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ count($sudahVerifikasi) }}
                    </span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Tab 1: Belum Diverifikasi -->
        <div id="content-unverified" class="tab-content">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-lime-500">
                <h2 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Pengajuan Menunggu Verifikasi
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                @if(count($belumVerifikasi) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($belumVerifikasi as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($cuti->tgl_pengajuan)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-accent/10 flex items-center justify-center text-accent/60">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cuti->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->user->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-900 space-y-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-day text-gray-400 mr-2 w-4"></i>
                                        <span>{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $cuti->lama_cuti }} Hari</span>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-comment text-gray-400 mr-2 w-4 mt-1"></i>
                                        <span class="text-gray-500 text-xs">{{ Str::limit($cuti->alasan, 50) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = $cuti->statusAdmin->status ?? 'belum disetujui';
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    
                                    if ($status == 'perubahan') {
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                    }
                                @endphp
                                <span class="items-center px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    <i class="fas fa-{{ $status == 'perubahan' ? 'sync-alt' : 'hourglass-half' }} mr-1"></i>
                                    {{ $status == 'belum disetujui' ? 'Menunggu' : ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('adminpengajuancutitahunan.show', $cuti->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-check-circle text-gray-300 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada pengajuan</h3>
                        <p class="text-gray-500">Semua permohonan cuti telah diverifikasi</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Tab 2: Sudah Diverifikasi -->
        <div id="content-verified" class="tab-content hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-500 to-primary">
                <h2 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Pengajuan Telah Diverifikasi
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                @if(count($sudahVerifikasi) > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Pegawai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Detail Cuti</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($sudahVerifikasi as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($cuti->tgl_pengajuan)->locale('id')->translatedFormat('l, d F Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center text-primary/60">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cuti->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->user->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs text-gray-900 space-y-1">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-day text-gray-400 mr-2 w-4"></i>
                                        <span>{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-gray-400 mr-2 w-4"></i>
                                        <span>{{ $cuti->lama_cuti }} Hari</span>
                                    </div>
                                    <div class="flex items-start">
                                        <i class="fas fa-comment text-gray-400 mr-2 w-4 mt-1"></i>
                                        <span class="text-gray-500 text-xs">{{ Str::limit($cuti->alasan, 50) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = $cuti->statusAdmin->status;
                                    $statusClass = 'bg-red-100 text-red-800';
                                    
                                    if ($status == 'disetujui') {
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } elseif ($status == 'ditangguhkan') {
                                        $statusClass = 'bg-orange-100 text-orange-800';
                                    }
                                @endphp
                                <span class="items-center px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    <i class="fas fa-{{ $status == 'disetujui' ? 'check' : ($status == 'ditangguhkan' ? 'pause' : 'times') }} mr-1"></i>
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('adminpengajuancutitahunan.show', $cuti->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="px-6 py-12 text-center">
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-clock text-gray-300 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada verifikasi</h3>
                        <p class="text-gray-500">Tidak ada permohonan cuti yang telah diverifikasi</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function showTable(showId, hideId, activeBtn, inactiveBtn) {
        // Show and hide tables
        document.getElementById(showId).classList.remove('hidden');
        document.getElementById(hideId).classList.add('hidden');
        
        // Update button styles
        document.getElementById(activeBtn).classList.add('border-emerald-500', 'text-emerald-600');
        document.getElementById(activeBtn).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        
        document.getElementById(inactiveBtn).classList.remove('border-emerald-500', 'text-emerald-600');
        document.getElementById(inactiveBtn).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    }
</script>

@endsection