@extends('dashboard.admin.base-admin')

@section('main')
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full px-4">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">Alur Verifikasi Cuti</h3>
                    </div>
                    <!-- Card Body -->
                    <div class="p-6 pt-0">
                        <!-- Tabs -->
                        <div class="mb-4 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="leaveTypeTabs"
                                role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 border-emerald-500 rounded-t-lg text-emerald-600 active"
                                        id="cuti-tahunan-tab" type="button" role="tab" aria-controls="cuti-tahunan"
                                        aria-selected="true">Cuti Tahunan</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                                        id="cuti-umum-tab" type="button" role="tab" aria-controls="cuti-umum"
                                        aria-selected="false">Cuti Umum</button>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div id="myTabContent">
                            <!-- TAB CUTI UMUM -->
                            <div class="hidden" id="cuti-umum" role="tabpanel" aria-labelledby="cuti-umum-tab">
                                <div class="overflow-x-auto">
                                    <table id="table-cuti-umum"
                                        class="w-full table-auto bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <thead class="bg-gray-50">
                                            <tr class="bg-gradient-to-r from-primary to-lime-500">
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    No</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Pegawai</th>
                                                <th scope="col"
                                                    class="min-w-[210px] max-w-[400px] px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Cuti</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Jenis Cuti</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Status Pengajuan User</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Status Admin</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider text-center align-middle">
                                                    Status Kepala Tim Kerja</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider text-center align-middle">
                                                    Status Kabag Umum</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider text-center align-middle">
                                                    Status Kepala Balai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($cutiUmums as $index => $cuti)
                                                @php
                                                    $isWidyaiswara = strtolower(optional($cuti->user)->role ?? '') === 'widyaiswara';
                                                @endphp
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $index + 1 }}</td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $cuti->user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $cuti->user->nip }}</div>
                                                        <div class="text-sm text-gray-500">{{ $cuti->user->jabatan }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        <div class="space-y-1">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                                <span>Mulai: {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                <span>Selesai: {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                <span>Lama: {{ $cuti->jumlah_hari }} {{ in_array($cuti->jenisCuti->nama_cuti, ['Cuti Melahirkan', 'Cuti Besar']) ? 'bulan' : 'hari' }}</span>
                                                            </div>
                                                            <div class="flex items-start gap-2 mt-2">
                                                                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                                </svg>
                                                                <span class="text-gray-600 italic">Alasan: {{ $cuti->alasan }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $cuti->jenisCuti->nama_cuti }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if (isset($cuti->statusCutiUmum) && $cuti->statusCutiUmum->status === 'dibatalkan')
                                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                                <i class="fas fa-ban mr-1"></i> Dibatalkan User
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                                <i class="fas fa-hand-paper mr-1"></i> Diajukan
                                                            </span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Admin --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->status === 'disetujui')
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                        @elseif ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->status === 'ditolak')
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                        @elseif ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->status === 'perubahan')
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Katimker --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if (!$isWidyaiswara && ($cuti->is_kabag || optional($cuti->user)->role == 'kepalatimkerja'))
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Dilewati</span>
                                                        @elseif ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->cuStatusAdminKatimker)
                                                            @if ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Kabag Umum --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if (!$isWidyaiswara && $cuti->is_kabag)
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Dilewati</span>
                                                        @elseif ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->cuStatusAdminKatimker && $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag)
                                                            @if ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Kepala Balai --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if (!$isWidyaiswara && $cuti->is_kabag && $cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->cuStatusAdminKabal)
                                                            @if ($cuti->cuStatusUserAdmin->cuStatusAdminKabal->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKabal->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKabal->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @elseif ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->cuStatusAdminKatimker && $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag && $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal)
                                                            @if ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- TAB CUTI TAHUNAN -->
                            <div class="block" id="cuti-tahunan" role="tabpanel" aria-labelledby="cuti-tahunan-tab">
                                <div class="overflow-x-auto">
                                    <table id="table-cuti-tahunan"
                                        class="w-full table-auto bg-white border border-gray-200 rounded-lg overflow-hidden">
                                        <thead>
                                            <tr class="bg-gradient-to-r from-lime-500 to-primary">
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    No</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Pegawai</th>
                                                <th scope="col"
                                                    class="min-w-[210px] max-w-[400px] px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Cuti</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Status Pengajuan User</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                    Status Admin</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider text-center align-middle">
                                                    Status Kepala Tim Kerja</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider text-center align-middle">
                                                    Status Kabag Umum</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-white uppercase tracking-wider text-center align-middle">
                                                    Status Kepala Balai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($cutiTahunans as $index => $cuti)
                                                @php
                                                    $isWidyaiswara = strtolower(optional($cuti->user)->role ?? '') === 'widyaiswara';
                                                @endphp
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $index + 1 }}</td>
                                                    <td class="px-6 py-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $cuti->user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $cuti->user->nip }}</div>
                                                        <div class="text-sm text-gray-500">{{ $cuti->user->jabatan }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm text-gray-500">
                                                        <div class="space-y-1">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                                <span>Mulai: {{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                                <span>Selesai: {{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}</span>
                                                            </div>
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                <span>Lama: {{ $cuti->lama_cuti }} Hari</span>
                                                            </div>
                                                            <div class="flex items-start gap-2 mt-2">
                                                                <svg class="w-4 h-4 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                                                </svg>
                                                                <span class="text-gray-600 italic">Alasan: {{ $cuti->alasan }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if (isset($cuti->statusCutiTahunan) && $cuti->statusCutiTahunan->status === 'dibatalkan')
                                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                                <i class="fas fa-ban mr-1"></i> Dibatalkan User
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                                <i class="fas fa-hand-paper mr-1"></i> Diajukan
                                                            </span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Admin --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if ($cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->status === 'disetujui')
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                        @elseif ($cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->status === 'ditolak')
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                        @elseif ($cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->status === 'perubahan')
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Katimker --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if (!$isWidyaiswara && ($cuti->is_kabag || optional($cuti->user)->role == 'kepalatimkerja'))
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Dilewati</span>
                                                        @elseif ($cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->ctStatusAdminKatimker)
                                                            @if ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Kabag Umum --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if (!$isWidyaiswara && $cuti->is_kabag)
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Dilewati</span>
                                                        @elseif ($cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->ctStatusAdminKatimker && $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag)
                                                            @if ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>

                                                    {{-- Status Kepala Balai --}}
                                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                                        @if (!$isWidyaiswara && $cuti->is_kabag && $cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->ctStatusAdminKabal)
                                                            @if ($cuti->ctStatusUserAdmin->ctStatusAdminKabal->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKabal->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKabal->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @elseif ($cuti->ctStatusUserAdmin && $cuti->ctStatusUserAdmin->ctStatusAdminKatimker && $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag && $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal)
                                                            @if ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal->status === 'disetujui')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal->status === 'ditolak')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                                            @elseif ($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal->status === 'perubahan')
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Perubahan</span>
                                                            @else
                                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                            @endif
                                                        @else
                                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cutiUmumTab = document.getElementById('cuti-umum-tab');
            const cutiTahunanTab = document.getElementById('cuti-tahunan-tab');
            const cutiUmumContent = document.getElementById('cuti-umum');
            const cutiTahunanContent = document.getElementById('cuti-tahunan');

            cutiUmumTab.addEventListener('click', function() {
                cutiUmumContent.classList.remove('hidden');
                cutiUmumContent.classList.add('block');

                cutiTahunanContent.classList.remove('block');
                cutiTahunanContent.classList.add('hidden');

                cutiUmumTab.classList.add('border-emerald-500', 'text-emerald-600', 'active');
                cutiUmumTab.classList.remove('border-transparent', 'text-gray-500');

                cutiTahunanTab.classList.remove('border-emerald-500', 'text-emerald-600', 'active');
                cutiTahunanTab.classList.add('border-transparent', 'text-gray-500');
            });

            cutiTahunanTab.addEventListener('click', function() {
                cutiTahunanContent.classList.remove('hidden');
                cutiTahunanContent.classList.add('block');

                cutiUmumContent.classList.remove('block');
                cutiUmumContent.classList.add('hidden');

                cutiTahunanTab.classList.add('border-emerald-500', 'text-emerald-600', 'active');
                cutiTahunanTab.classList.remove('border-transparent', 'text-gray-500');

                cutiUmumTab.classList.remove('border-emerald-500', 'text-emerald-600', 'active');
                cutiUmumTab.classList.add('border-transparent', 'text-gray-500');
            });

            const dataTableOptions = {
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print', 'colvis']
            };

            if (document.getElementById('table-cuti-umum')) {
                new DataTable('#table-cuti-umum', dataTableOptions);
            }

            if (document.getElementById('table-cuti-tahunan')) {
                new DataTable('#table-cuti-tahunan', dataTableOptions);
            }
        });
    </script>
@endsection