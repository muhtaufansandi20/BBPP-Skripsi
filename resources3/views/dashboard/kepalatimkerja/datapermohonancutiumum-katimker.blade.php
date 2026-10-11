@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
@if(!$timKepala)
    <!-- No Team Leader State -->
    <div class="text-center p-8 rounded-xl bg-gradient-to-r from-indigo-50 to-blue-50 border border-indigo-200 shadow-sm">
        <div class="mx-auto w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-indigo-700 mb-2">Anda Belum Ditugaskan Sebagai Kepala Tim</h3>
        <p class="text-indigo-600 mb-6">Saat ini Anda tidak memiliki akses ke halaman ini karena belum ditetapkan sebagai kepala tim kerja.</p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center px-5 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
            
            @if(isset($admin) && !empty($admin->no_hp))
                @php
                    $whatsappNumber = '62' . ltrim(preg_replace('/[^0-9]/', '', $admin->no_hp), '0');
                    $leaderMessage = urlencode("*[SIBACO System Notification]* 📱\n" .
                        "*Assalamualaikum Admin,*\n\n" .
                        "Saya atas nama:\n" .
                        "✅ *{$user->name}*\n" .
                        "✅ *NIP: {$user->nip}*\n\n" .
                        "Belum memiliki akses sebagai kepala tim. Mohon bantuan untuk menetapkan saya sebagai kepala tim.\n\n" .
                        "Terima kasih 🙏");
                @endphp
                
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $leaderMessage }}" 
                   target="_blank" 
                   class="inline-flex items-center px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    <svg class="w-6 h-6 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479h.005c5.451 0 9.888-4.434 9.891-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.888-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    Hubungi Admin via WhatsApp
                </a>
            @endif
        </div>
    </div>
@else
<div class="p-6 pt-0 bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl shadow-xl">
    <!-- Header Section -->
    <div class="mb-6">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Umum</h2>
        <p class="text-blue-600 font-medium">Kepala Tim Kerja</p>
    </div>

    <!-- Tab navigation -->
    <div class="mb-6">
        <div class="flex border-b border-gray-200">
            <button id="btn-pending" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-emerald-500 text-emerald-600 focus:outline-none" 
                    onclick="showTable('pending-table', 'completed-table', 'btn-pending', 'btn-completed')">
                Menunggu Verifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                    {{ $pendingApplications->count() }}
                </span>
            </button>
            <button id="btn-completed" class="flex items-center justify-center px-4 py-2 font-medium text-sm border-b-2 border-transparent text-gray-500 hover:text-gray-700 focus:outline-none" 
                    onclick="showTable('completed-table', 'pending-table', 'btn-completed', 'btn-pending')">
                Sudah Diverifikasi
                <span class="ml-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    {{ $completedApplications->count() }}
                </span>
            </button>
        </div>
    </div>

    <!-- Table for pending applications -->
    <div id="pending-table" class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-lime-500">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center text-white">
                <svg class="w-12 h-12 sm:w-5 sm:h-5 mr-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Pengajuan Menunggu Persetujuan
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($pendingApplications->count() > 0)
                        @foreach ($pendingApplications as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $cuti->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cuti->nip ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $cuti->jabatan ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cuti->nama_cuti ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Lama: {{ $cuti->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic">Alasan: {{ $cuti->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $cuti->status_katimker == 'disetujui' ? 'bg-green-100 text-green-800' : 
                                       ($cuti->status_katimker == 'ditolak' ? 'bg-red-100 text-red-800' : 
                                       ($cuti->status_katimker == 'perubahan' ? 'bg-indigo-100 text-indigo-800' : 
                                       ($cuti->status_katimker == 'ditangguhkan' ? 'bg-purple-100 text-purple-800' : 
                                       'bg-yellow-100 text-yellow-800'))) }}">
                                    {{ $cuti->status_katimker ?? 'Menunggu' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('katimkerdatapermohonancutiumum.show', $cuti->id) }}" 
                                   class="inline-flex items-center justify-center p-2 rounded-md text-primary hover:bg-primary/10 transition-colors"
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
                                    <p class="text-md sm:text-lg font-medium">Tidak ada pengajuan cuti yang menunggu persetujuan</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table for completed applications -->
    <div id="completed-table" class="bg-white rounded-xl shadow-md overflow-hidden hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-lime-500 to-primary">
            <h3 class="text-lg font-semibold flex items-center text-white">
                <svg class="w-12 h-12 sm:w-5 sm:h-5 mr-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Daftar Pengajuan Sudah Diproses
            </h3>
        </div>
        <div class="overflow-x-auto max-h-[600px]">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Cuti</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail Cuti</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($completedApplications->count() > 0)
                        @foreach ($completedApplications as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->tgl_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $cuti->name }}</div>
                                <div class="text-xs text-gray-500">{{ $cuti->nip ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $cuti->jabatan ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cuti->nama_cuti ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Mulai: {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Selesai: {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Lama: {{ $cuti->jumlah_hari }} Hari</span>
                                    </div>
                                    <div class="flex items-start gap-2 mt-2">
                                        <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                        </svg>
                                        <span class="text-gray-600 italic">Alasan: {{ $cuti->alasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $cuti->status_katimker == 'disetujui' ? 'bg-green-100 text-green-800' : 
                                       ($cuti->status_katimker == 'ditolak' ? 'bg-red-100 text-red-800' : 
                                       ($cuti->status_katimker == 'perubahan' ? 'bg-indigo-100 text-indigo-800' : 
                                       ($cuti->status_katimker == 'ditangguhkan' ? 'bg-purple-100 text-purple-800' : 
                                       'bg-yellow-100 text-yellow-800'))) }}">
                                    {{ $cuti->status_katimker ?? 'Menunggu' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('katimkerdatapermohonancutiumum.show', $cuti->id) }}" 
                                   class="inline-flex items-center justify-center p-2 rounded-md text-primary hover:bg-primary/10 transition-colors"
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
                                    <p class="text-md sm:text-lg font-medium">Tidak ada pengajuan cuti yang sudah diproses</p>
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
        document.getElementById(activeBtn).classList.add('border-emerald-500', 'text-emerald-600');
        document.getElementById(activeBtn).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700');
        
        document.getElementById(inactiveBtn).classList.remove('border-emerald-500', 'text-emerald-600');
        document.getElementById(inactiveBtn).classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700');
    }
</script>
@endif
@endsection