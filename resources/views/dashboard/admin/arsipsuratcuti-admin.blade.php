@extends('dashboard.admin.base-admin')

@section('main')
    <div class="mt-4 p-6 bg-white shadow-sm rounded-2xl border border-gray-100">
        <!-- Header Judul -->
        <div class="mb-4">
            <h1 class="text-xl font-bold text-gray-800 tracking-tight">Berkas Surat Cuti</h1>
            <p class="text-xs text-gray-500 mt-1">Preview dan unduh dokumen surat cuti yang telah disetujui Kabalai</p>
        </div>

        <!-- Banner Informasi Hijau -->
        <div class="bg-emerald-50/80 border-l-4 border-emerald-500 p-3.5 rounded-r-xl mb-6 flex items-start">
            <div class="flex-shrink-0 mt-0.5">
                <svg class="h-4 w-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-xs text-emerald-800 leading-relaxed">
                    Halaman ini menampilkan seluruh surat cuti yang telah disetujui Kabalai. Admin dapat melihat pratinjau atau mengunduh dokumen surat cuti.
                </p>
            </div>
        </div>

        <!-- Toolbar Periode & Filter -->
        <form method="GET" action="{{ route('arsipsuratcuti.index') }}" class="flex items-center gap-3 mb-6">
            <!-- Dropdown Periode Tahun -->
            {{-- <div class="inline-flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-xs text-gray-700 shadow-sm">
                <span class="text-gray-400 uppercase tracking-wider text-[10px] mr-2 font-medium">Periode</span>
                <select name="tahun" onchange="this.form.submit()" class="bg-transparent font-semibold text-gray-800 focus:outline-none border-none p-0 cursor-pointer pr-2 text-xs">
                    @php $selectedTahun = request('tahun', date('Y')); @endphp
                    @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                        <option value="{{ $y }}" {{ $selectedTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div> --}}

            <!-- Tombol Filter Tambahan -->
            <div class="relative">
                <button type="button" onclick="document.getElementById('searchDropdown').classList.toggle('hidden')" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                    <svg class="w-3.5 h-3.5 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                    <svg class="w-3 h-3 ml-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Menu Dropdown Pencarian Cepat -->
                <div id="searchDropdown" class="hidden absolute left-0 mt-2 w-64 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-30">
                    <label class="block text-[11px] font-medium text-gray-600 mb-1">Cari Nama Pegawai / NIP</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama..." class="w-full text-xs p-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-emerald-500 focus:outline-none mb-2">
                    <div class="flex justify-end gap-1">
                        <a href="{{ route('arsipsuratcuti.index') }}" class="px-2.5 py-1 text-[11px] text-gray-500 hover:text-gray-700">Reset</a>
                        <button type="submit" class="px-3 py-1 bg-emerald-600 text-white rounded-md text-[11px] font-medium hover:bg-emerald-700">Terapkan</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Tabel Berkas Surat Cuti -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="w-full text-left text-xs">
                <thead class="bg-emerald-600 text-white uppercase text-[11px] font-bold tracking-wider">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 text-center w-12">No</th>
                        <th scope="col" class="px-6 py-3.5">Tanggal Pengajuan</th>
                        <th scope="col" class="px-6 py-3.5">Pegawai</th>
                        <th scope="col" class="px-6 py-3.5">Jenis Cuti</th>
                        <th scope="col" class="px-6 py-3.5">Informasi Lama Cuti</th>
                        <th scope="col" class="px-6 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($arsipCuti as $index => $cuti)
                        @php
                            // Ambil nama cuti dengan fallback berjenjang
                            $namaCuti = $cuti->nama_jenis_cuti 
                                ?? (optional($cuti->jenisCuti)->nama_cuti 
                                ?? ($cuti->jenis_cuti ?? 'Cuti Tahunan'));

                            // Normalisasi teks cuti
                            if (strtolower(trim($namaCuti)) === 'tahunan') {
                                $namaCuti = 'Cuti Tahunan';
                            }

                            $type = $cuti->type ?? (isset($cuti->is_kabag) || ($cuti->jenis_cuti ?? '') == 'Tahunan' ? 'tahunan' : 'umum');
                            $initial = strtoupper(substr($cuti->user->name ?? 'P', 0, 1));
                            $lamaHari = $cuti->lama_cuti ?? ($cuti->jumlah_hari ?? '-');
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <!-- Nomor Urut -->
                            <td class="px-5 py-4 text-center font-medium text-gray-700">
                                {{ method_exists($arsipCuti, 'firstItem') ? $arsipCuti->firstItem() + $index : $index + 1 }}
                            </td>

                            <!-- Tanggal Pengajuan -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($cuti->tgl_pengajuan)->format('d/m/Y') }}
                            </td>

                            <!-- Info Pegawai -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $cuti->user->name ?? '-' }}</div>
                                        <div class="text-[11px] text-gray-400">{{ $cuti->user->nip ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Badge Jenis Cuti -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (str_contains(strtolower($namaCuti), 'sakit'))
                                    <!-- Kuning: Cuti Sakit -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $namaCuti }}
                                    </span>
                                @elseif (str_contains(strtolower($namaCuti), 'alasan penting') || str_contains(strtolower($namaCuti), 'penting'))
                                    <!-- Indigo: Cuti Alasan Penting -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $namaCuti }}
                                    </span>
                                @else
                                    <!-- Biru: Cuti Tahunan & Lainnya -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $namaCuti }}
                                    </span>
                                @endif
                            </td>

                            <!-- Informasi Lama Cuti -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                                {{ $lamaHari }} Hari
                            </td>

                            <!-- Aksi (Pratinjau & Download) -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center justify-center gap-3">
                                    <!-- Tombol Pratinjau (Mata) -->
                                    <button type="button" 
                                            onclick="openPreviewPanel('{{ $cuti->id }}', '{{ $type }}')" 
                                            class="text-blue-500 hover:text-blue-700 p-1 transition-colors" 
                                            title="Pratinjau Dokumen">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Tombol Unduh (Download Icon) -->
                                    <a href="{{ $type === 'tahunan' ? route('viewPDF', ['id' => $cuti->id]) : route('viewPDFUmum', ['id' => $cuti->id]) }}" 
                                       target="_blank" 
                                       class="text-emerald-600 hover:text-emerald-800 p-1 transition-colors" 
                                       title="Unduh Dokumen">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-xs font-medium">Belum ada berkas arsip surat cuti</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if (method_exists($arsipCuti, 'links'))
            <div class="mt-5 flex flex-col md:flex-row items-center justify-between text-xs text-gray-500 gap-3">
                <div>
                    Showing {{ $arsipCuti->firstItem() ?? 0 }} to {{ $arsipCuti->lastItem() ?? 0 }} of {{ $arsipCuti->total() ?? 0 }} results
                </div>
                <div>
                    {{ $arsipCuti->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Side Panel Preview Dokumen PDF -->
    <div id="previewPanel" class="fixed inset-y-0 right-0 w-3/4 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="h-full flex flex-col">
            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b">
                <h3 class="text-sm font-semibold text-gray-800">Preview Dokumen Surat Cuti</h3>
                <button type="button" onclick="closePreviewPanel()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow p-4">
                <iframe id="previewFrame" class="w-full h-full border rounded-lg"></iframe>
            </div>
        </div>
    </div>

    <script>
        function openPreviewPanel(id, type) {
            const panel = document.getElementById('previewPanel');
            const previewFrame = document.getElementById('previewFrame');

            const previewUrl = type === 'tahunan'
                ? "{{ route('viewPDF', ['id' => ':id']) }}".replace(':id', id)
                : "{{ route('viewPDFUmum', ['id' => ':id']) }}".replace(':id', id);

            previewFrame.src = previewUrl;
            panel.classList.remove('translate-x-full');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewPanel() {
            const panel = document.getElementById('previewPanel');
            panel.classList.add('translate-x-full');
            document.body.style.overflow = '';
            setTimeout(() => {
                document.getElementById('previewFrame').src = '';
            }, 300);
        }
    </script>
@endsection