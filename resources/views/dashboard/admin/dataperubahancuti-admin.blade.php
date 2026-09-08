@extends('dashboard.admin.base-admin')

@section('main')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-xl shadow-md overflow-x-auto">
        <!-- Header Section -->
        <div class="p-6 pt-4 bg-gradient-to-r from-primary to-lime-500 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-100">Perubahan Cuti</h1>
                    <p class="text-gray-200">Manajemen perubahan jadwal cuti pegawai</p>
                </div>
            </div>
        </div>

        <!-- Info Alert -->
        <div class="p-4 border-b">
            <div class="flex items-start bg-blue-50 rounded-lg p-4 border border-blue-100">
                <div class="flex-shrink-0 mt-1">
                    <svg class="h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                    <div class="mt-1 text-sm text-blue-700">
                        <p>Halaman ini menampilkan cuti yang memerlukan perubahan tanggal. Admin dapat mengubah jadwal cuti yang sedang berjalan dengan disertai alasan yang jelas sebagai dokumentasi.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 mx-4 mt-4 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Table Section -->
        <div class="px-6 py-4">
            <div class="shadow-sm rounded-lg overflow-x-auto border border-gray-200">
                <table class="w-full border-collapse bg-white rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gradient-to-r from-primary to-lime-500 text-white">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">No</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal Pengajuan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pegawai</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Informasi Cuti</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Catatan</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pengajuancutitahunan as $index => $cuti)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($cuti->tgl_pengajuan)->translatedFormat('l, d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 font-medium">{{ substr($cuti->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $cuti->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $cuti->user->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 space-y-1">
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $cuti->lama_cuti }} Hari</span>
                                    </div>
                                    <div class="text-xs text-gray-500 italic mt-1">
                                        "{{ $cuti->alasan }}"
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($cuti->catatan)
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-2 rounded">
                                        <p class="text-xs text-yellow-700">{{ $cuti->catatan }}</p>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">Tidak ada catatan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('adminperubahancuti.edit', $cuti->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($pengajuancutitahunan->isEmpty())
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada permintaan perubahan</h3>
                <p class="mt-1 text-sm text-gray-500">Saat ini tidak ada cuti yang memerlukan perubahan tanggal.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection