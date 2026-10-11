@extends('dashboard.admin.base-admin')
@section('main')
    <div class="container mx-auto px-4 pb-6">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 px-6 pb-4">
            <div class="py-4 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">Daftar Verifikasi</h1>
                        <p class="text-gray-500 text-sm mt-1">Daftar pengguna yang memerlukan verifikasi</p>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button id="btnBulkVerifikasi" onclick="showBulkVerifikasiModal()"
                            class="hidden items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all text-sm font-medium shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Verifikasi Terpilih (<span id="selectedCount">0</span>)
                        </button>

                        <form method="GET" action="{{ route('admindatakuotacutitahunan.index') }}"
                            class="relative w-full sm:w-auto">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pengguna..."
                                class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                        </form>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <div class="max-h-[500px] overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="tabelVerifikasi">
                        <thead class="bg-gradient-to-r from-primary to-lime-500 sticky top-0 z-10">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left w-12">
                                    <input type="checkbox" id="selectAll"
                                        class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-4 w-4 cursor-pointer">
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">NIP
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" value="{{ $item->id }}"
                                            class="user-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 h-4 w-4 cursor-pointer">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 rounded-full bg-accent/10 flex items-center justify-center">
                                                <span
                                                    class="text-accent font-medium">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $item->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $item->nip }}</div>
                                        <div class="text-sm text-gray-500">Status: <span
                                                class="text-amber-600">Menunggu</span></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button onclick="showVerifikasiModal({{ $item->id }})"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Verifikasi
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($users->isEmpty())
                <div class="px-6 py-4 text-center text-gray-500">
                    Tidak ada data yang ditemukan
                </div>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800 border-b pb-2">Data Kuota Cuti Tahunan User</h1>
                <div class="flex items-center gap-3">
                    <!-- Tombol Reset Kuota Cuti Tahunan (Membuka Popup Modal) -->
                    <button type="button" onclick="openModal('resetKuotaModal')"
                        class="flex items-center gap-2 px-5 py-2.5 bg-[#2163e8] hover:bg-[#1a51c2] text-white text-xs sm:text-sm font-semibold tracking-wide uppercase rounded-xl shadow-sm hover:shadow transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        <span>RESET KUOTA CUTI TAHUNAN</span>
                    </button>

                    <!-- Tombol Export Excel (Hijau) -->
                    <button type="button" onclick="exportKuotaCutiToExcel()"
                        class="flex items-center gap-2 px-5 py-2.5 bg-[#159e4b] hover:bg-[#10833e] text-white text-xs sm:text-sm font-medium rounded-xl shadow-sm hover:shadow transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <rect x="9" y="12" width="6" height="6" rx="1"></rect>
                            <path d="M12 13.5v3m-1-1l1 1 1-1"></path>
                        </svg>
                        <span>Export Excel</span>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gradient-to-r from-accent/90 to-rose-500 text-white">
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider" colspan="3">Kuota Cuti</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-1/4">Catatan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Terakhir Diedit</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                        </tr>
                        <tr class="bg-accent/10 text-rose-400">
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider font-medium">N</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider font-medium">N1</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider font-medium">N2</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach ($kuotacutitahunan as $item)
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-3">{{ $item->name }}</td>
                                <td class="p-3">{{ $item->nip }}</td>
                                <td class="p-3 text-center font-medium">
                                    <span class="inline-block bg-blue-100 text-blue-800 py-1 px-3 rounded-full">{{ $item->kuota_n }}</span>
                                </td>
                                <td class="p-3 text-center font-medium">
                                    <span class="inline-block bg-green-100 text-green-800 py-1 px-3 rounded-full">{{ $item->kuota_n1 }}</span>
                                </td>
                                <td class="p-3 text-center font-medium">
                                    <span class="inline-block bg-amber-100 text-amber-800 py-1 px-3 rounded-full">{{ $item->kuota_n2 }}</span>
                                </td>
                                <td class="p-3">
                                    @php
                                        $catatan = $item->catatan;
                                        if (empty($catatan)) {
                                            echo '<span class="text-gray-400 italic text-sm">Tidak ada catatan</span>';
                                        } else {
                                            $noteEntries = explode("\n\n---\n\n", $catatan);

                                            echo '<div class="bg-blue-50/40 p-3 rounded-lg border-l-4 border-purple-500 shadow-sm text-sm text-gray-700 whitespace-pre-wrap leading-relaxed">' .
                                                e(trim($noteEntries[0])) .
                                                '</div>';

                                            if (count($noteEntries) > 1) {
                                                echo '<details class="mt-3 group">';
                                                echo '<summary class="cursor-pointer text-sm text-purple-600 hover:text-purple-800 font-medium flex items-center gap-1 select-none transition-colors">';
                                                echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-open:rotate-90 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>';
                                                echo 'Riwayat Catatan (' . (count($noteEntries) - 1) . ')';
                                                echo '</summary>';

                                                echo '<div class="mt-3 flex flex-col gap-2 pl-2 border-l-2 border-gray-100 ml-2">';
                                                for ($i = 1; $i < count($noteEntries); $i++) {
                                                    echo '<div class="whitespace-pre-wrap text-xs p-3 bg-gray-50 rounded-md border border-gray-200 border-l-4 border-l-gray-400 text-gray-600 leading-relaxed shadow-sm">' .
                                                        e(trim($noteEntries[$i])) .
                                                        '</div>';
                                                }
                                                echo '</div>';
                                                echo '</details>';
                                            }
                                        }
                                    @endphp
                                </td>
                                <td class="p-3 text-sm">
                                    @if ($item->date_edit)
                                        <span class="text-gray-600">{{ $item->date_edit }} <br>
                                            {{ $item->time_edit ?? '' }}</span>
                                    @else
                                        <span class="text-gray-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <div class="flex gap-2">
                                        <button type="button"
                                            class="bg-yellow-500 text-white px-3 py-2 rounded-md hover:bg-yellow-600 transition-colors flex items-center gap-1"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->name ?? ($item->user->name ?? '') }}"
                                            data-nip="{{ $item->nip ?? ($item->user->nip ?? '') }}"
                                            data-jabatan="{{ $item->jabatan ?? ($item->user->jabatan ?? '-') }}"
                                            data-n="{{ $item->kuota_n ?? 0 }}"
                                            data-n1="{{ $item->kuota_n1 ?? 0 }}"
                                            data-n2="{{ $item->kuota_n2 ?? 0 }}"
                                            onclick="openEditModal(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                            Edit
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Verifikasi --}}
    <div id="verifikasiModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-1/3 max-w-md transform transition-all">
            <div class="flex justify-between items-center border-b p-4">
                <h3 class="text-lg font-semibold text-gray-800" id="modalVerifikasiTitle">Verifikasi User</h3>
                <button onclick="closeModal('verifikasiModal')"
                    class="text-gray-500 hover:text-red-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <form id="verifikasiForm" method="POST" action="{{ route('admindatakuotacutitahunan.store') }}">
                    @csrf
                    <div id="userIdsContainer"></div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700" id="modalVerifikasiText">
                                    Apakah Anda yakin ingin memverifikasi user ini?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal('verifikasiModal')"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors">
                            Verifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Reset Kuota Cuti Tahunan (Sesuai Referensi Gambar) --}}
    <div id="resetKuotaModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 transition-opacity hidden">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-sm p-8 text-center transform transition-all border border-gray-100">
            <!-- Lingkaran Ikon Kunci Biru -->
            <div class="mx-auto w-24 h-24 rounded-full bg-[#e3f0fd] flex items-center justify-center mb-6">
                <div class="w-14 h-14 rounded-full bg-[#c8e2fb] flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#1f66e5]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.65 10C11.83 7.67 9.61 6 7 6c-3.31 0-6 2.69-6 6s2.69 6 6 6c2.61 0 4.83-1.67 5.65-4H17v4h4v-4h2v-4H12.65zM7 14c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                        <path d="M18 10a6 6 0 1 0 4.24 10.24l1.42 1.42A8 8 0 1 1 18 8v-3l-4 4 4 4v-3z" fill-rule="evenodd" opacity="0.9"/>
                    </svg>
                </div>
            </div>

            <!-- Judul Modal -->
            <h3 class="text-xl font-bold text-gray-900 mb-3">
                Reset Kuota Cuti Tahunan
            </h3>

            <!-- Teks Penjelasan -->
            <p class="text-gray-600 text-sm leading-relaxed mb-8">
                Apakah Anda yakin ingin mengatur ulang kuota Cuti <span class="font-bold text-gray-800">(N)</span> <span class="font-bold text-gray-800">seluruh pegawai</span> ke saldo awal <span class="font-bold text-gray-800">(12 hari)</span>?
            </p>

            <!-- Aksi Tombol -->
            <form action="{{ route('admindatakuotacutitahunan.bulkReset') }}" method="POST" class="flex items-center gap-3">
                @csrf
                <button type="submit"
                    class="w-1/2 py-3 px-4 bg-[#2163e8] hover:bg-[#1a51c2] text-white text-sm font-semibold rounded-xl transition duration-150 shadow-sm">
                    Ya, Proses Semua
                </button>
                <button type="button" onclick="closeModal('resetKuotaModal')"
                    class="w-1/2 py-3 px-4 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl transition duration-150">
                    Batalkan
                </button>
            </form>
        </div>
    </div>

    {{-- Modal Edit Kuota (Kelola Kuota Cuti) --}}
    <div id="editKuotaModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 transition-opacity hidden">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform transition-all">
            
            <!-- Header Gradient Hijau -->
            <div class="bg-gradient-to-r from-[#00b074] to-[#70c239] px-6 py-4 flex items-center justify-between text-white">
                <h3 class="text-lg font-bold">Kelola Kuota Cuti</h3>
                <button type="button" onclick="closeModal('editKuotaModal')" class="text-white/80 hover:text-white text-2xl font-bold leading-none">&times;</button>
            </div>

            <form id="editForm" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="kuotaId">

                <!-- Card Info Pegawai -->
                <div class="border border-gray-200 rounded-2xl p-4 flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-[#eaf8f1] text-[#00b074] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1 space-y-1">
                        <h4 class="font-bold text-gray-800 text-sm truncate" id="modalPegawaiNama">-</h4>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium truncate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-800 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 3a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm0 4a1 1 0 011-1h2a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>NIP : <span id="modalPegawaiNip">-</span></span>
                        </p>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium truncate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-800 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                            </svg>
                            <span>Jabatan : <span id="modalPegawaiJabatan">-</span></span>
                        </p>
                    </div>
                </div>

                <!-- Input Grid Kuota -->
                <div class="grid grid-cols-3 gap-3 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Kuota N</label>
                        <input type="number" name="kuota_n" id="kuotaN" min="0" max="12" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] font-bold text-gray-800 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Kuota N1</label>
                        <input type="number" name="kuota_n1" id="kuotaN1" min="0" max="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] font-bold text-gray-800 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1.5">Kuota N2</label>
                        <input type="number" name="kuota_n2" id="kuotaN2" min="0" max="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] font-bold text-gray-800 text-sm">
                    </div>
                </div>

                <!-- Input Catatan Baru -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-800 mb-1.5">Catatan Baru</label>
                    <textarea name="catatan" id="catatan" rows="4"
                            placeholder="Masukkan catatan baru untuk perubahan ini.&#10;Catatan sebelumnya akan tetap tersimpan"
                            class="w-full p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] text-sm text-gray-700 placeholder-gray-400 resize-none leading-relaxed"></textarea>
                </div>

                <!-- Footer Tombol -->
                <div class="flex justify-end items-center gap-3">
                    <button type="button" onclick="closeModal('editKuotaModal')"
                            class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        Batalkan
                    </button>
                    <button type="submit"
                            class="px-7 py-2 bg-[#00b074] hover:bg-[#009b63] text-white text-sm font-medium rounded-xl transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        const selectAll = document.getElementById('selectAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        const btnBulkVerifikasi = document.getElementById('btnBulkVerifikasi');
        const selectedCount = document.getElementById('selectedCount');

        // Toggle semua checkbox
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkButton();
            });
        }

        // Toggle per checkbox
        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkButton();
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    const allChecked = Array.from(userCheckboxes).every(c => c.checked);
                    selectAll.checked = allChecked;
                }
            });
        });

        function updateBulkButton() {
            const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
            selectedCount.textContent = checkedCount;

            if (checkedCount > 0) {
                btnBulkVerifikasi.classList.remove('hidden');
                btnBulkVerifikasi.classList.add('inline-flex');
            } else {
                btnBulkVerifikasi.classList.add('hidden');
                btnBulkVerifikasi.classList.remove('inline-flex');
            }
        }

        // Tampilkan Modal Bulk Verifikasi
        window.showBulkVerifikasiModal = function() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkedBoxes.length === 0) return;

            const container = document.getElementById('userIdsContainer');
            container.innerHTML = '';

            checkedBoxes.forEach(box => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_id[]';
                input.value = box.value;
                container.appendChild(input);
            });

            document.getElementById('modalVerifikasiTitle').textContent = 'Verifikasi Massal';
            document.getElementById('modalVerifikasiText').textContent =
                `Apakah Anda yakin ingin memverifikasi ${checkedBoxes.length} user yang dipilih?`;

            openModal('verifikasiModal');
        };

        // Fungsi Single Verification
        window.showVerifikasiModal = function(userId) {
            const container = document.getElementById('userIdsContainer');
            container.innerHTML = '';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'user_id[]';
            input.value = userId;
            container.appendChild(input);

            document.getElementById('modalVerifikasiTitle').textContent = 'Verifikasi User';
            document.getElementById('modalVerifikasiText').textContent =
                'Apakah Anda yakin ingin memverifikasi user ini?';

            openModal('verifikasiModal');
        };

        // Modal Utility
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove("hidden");
                modal.style.display = "flex";
                document.body.style.overflow = "hidden";
            }
        }

        window.closeModal = function(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add("hidden");
                modal.style.display = "none";
                document.body.style.overflow = "auto";
            }
        };

        // Fungsi Edit Kuota
        window.openEditModal = function(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const nip = button.getAttribute('data-nip');
            const jabatan = button.getAttribute('data-jabatan');
            const kuotaN = button.getAttribute('data-n');
            const kuotaN1 = button.getAttribute('data-n1');
            const kuotaN2 = button.getAttribute('data-n2');

            document.getElementById('kuotaId').value = id;
            document.getElementById('modalPegawaiNama').textContent = nama || '-';
            document.getElementById('modalPegawaiNip').textContent = nip || '-';
            document.getElementById('modalPegawaiJabatan').textContent = (jabatan && jabatan !== 'null') ? jabatan : '-';

            document.getElementById('kuotaN').value = kuotaN ?? 0;
            document.getElementById('kuotaN1').value = kuotaN1 ?? 0;
            document.getElementById('kuotaN2').value = kuotaN2 ?? 0;
            document.getElementById('catatan').value = '';

            document.getElementById('editForm').action = '/admindatakuotacutitahunan/' + id;

            openModal('editKuotaModal');
        };

        // Form submission handling untuk Edit
        document.getElementById('editForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const kuotaN = document.getElementById('kuotaN').value;
            const kuotaN1 = document.getElementById('kuotaN1').value;
            const kuotaN2 = document.getElementById('kuotaN2').value;

            if (!kuotaN || !kuotaN1 || !kuotaN2) {
                alert('Semua field kuota harus diisi');
                return;
            }

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new URLSearchParams(new FormData(this))
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        throw new Error('Network response was not ok');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan perubahan');
                });
        });

        // Export Excel
        function exportKuotaCutiToExcel() {
            const exportBtn = document.querySelector('button[onclick="exportKuotaCutiToExcel()"]');
            const originalContent = exportBtn.innerHTML;
            exportBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengekspor...
            `;

            try {
                const excelData = [
                    ['No', 'Nama Pegawai', 'NIP', 'Kuota N', 'Kuota N1', 'Kuota N2', 'Catatan', 'Terakhir Diedit']
                ];

                const table = document.querySelectorAll('table')[1];
                const rows = table.querySelectorAll('tbody tr');

                rows.forEach((row, index) => {
                    const cells = row.querySelectorAll('td');

                    const nama = cells[0].textContent.trim();
                    const nip = cells[1].textContent.trim();
                    const kuotaN = cells[2].textContent.trim();
                    const kuotaN1 = cells[3].textContent.trim();
                    const kuotaN2 = cells[4].textContent.trim();

                    let catatan = '';
                    const noteDiv = cells[5].querySelector('div');
                    if (noteDiv) {
                        catatan = noteDiv.textContent.trim();
                    }

                    const lastEdited = cells[6].textContent.trim();

                    excelData.push([
                        index + 1, nama, nip, kuotaN, kuotaN1, kuotaN2, catatan, lastEdited
                    ]);
                });

                const wb = XLSX.utils.book_new();
                const ws = XLSX.utils.aoa_to_sheet(excelData);

                ws['!cols'] = [
                    { wch: 5 },
                    { wch: 25 },
                    { wch: 20 },
                    { wch: 10 },
                    { wch: 10 },
                    { wch: 10 },
                    { wch: 40 },
                    { wch: 20 }
                ];

                XLSX.utils.book_append_sheet(wb, ws, "Data Kuota Cuti");

                const dateStr = new Date().toISOString().slice(0, 10).replace(/-/g, '');
                XLSX.writeFile(wb, `Data_Kuota_Cuti_${dateStr}.xlsx`);

            } catch (error) {
                console.error('Error exporting to Excel:', error);
                alert('Terjadi kesalahan saat mengekspor data ke Excel');
            } finally {
                setTimeout(() => {
                    exportBtn.innerHTML = originalContent;
                }, 1000);
            }
        }
    </script>
@endsection