@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
    <div class="px-6 pt-0 pb-6 bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl shadow-xl" 
         x-data="{ showCancelModal: false, cancelId: null }">
        
        @if (session('success'))
            <div
                class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-100 to-green-50 border border-green-200 shadow-sm flex items-center">
                <div class="mr-4 p-2 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 p-4 rounded-xl bg-gradient-to-r from-red-100 to-red-50 border border-red-200 shadow-sm flex items-center">
                <div class="mr-4 p-2 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if (session('info'))
            <div
                class="mb-6 p-4 rounded-xl bg-gradient-to-r from-blue-100 to-blue-50 border border-blue-200 shadow-sm flex items-center">
                <div class="mr-4 p-2 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-info-circle"></i>
                </div>
                <p class="text-blue-700 font-medium">{{ session('info') }}</p>
            </div>
        @endif

        @if (!$hasWorkPeriod)
            <!-- No Work Period State -->
            <div
                class="text-center p-8 rounded-xl bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 shadow-sm">
                <div
                    class="mx-auto w-16 h-16 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-orange-700 mb-2">Masa Kerja Belum Diisi</h3>
                <p class="text-orange-600 mb-4">Silakan lengkapi data masa kerja Anda sebelum mengajukan cuti.</p>
                <p class="inline-flex items-center px-5 py-2 border border-blue-600 text-blue-700 rounded-lg transition">
                    Hubungi Admin
                </p>
            </div>
        @else
            @php
                $hasApprovedDocs =
                    $pengajuans
                        ->where(function ($pengajuan) {
                            return $pengajuan->cuStatusUserAdmin &&
                                $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker &&
                                $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag &&
                                $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                    ->cuStatusKabagKabal &&
                                $pengajuan->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                    ->cuStatusKabagKabal->status == 'disetujui';
                        })
                        ->count() > 0;
            @endphp

            <!-- Notification Section -->
            <div id="notification-container">
                @if ($hasApprovedDocs)
                    <div id="pdf-notification"
                        class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-100 to-green-50 border border-green-200 shadow-sm flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-bell text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-green-800">Dokumen Cuti Disetujui!</h3>
                                <p class="text-sm text-green-700">Anda memiliki dokumen cuti umum yang telah disetujui oleh
                                    Kepala Balai. Silakan unduh dokumen cuti Anda dengan mengklik ikon <i
                                        class="fas fa-file-pdf text-green-600 mx-1"></i> pada tabel di bawah.</p>
                            </div>
                        </div>
                        <button onclick="closeNotification()"
                            class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-200 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 pt-4">
                <div>
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Umum</h2>
                    <p class="text-blue-600 font-medium">Kepala Tim Kerja</p>
                </div>
                <a href="{{ route('katimkerpengajuancutiumum.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg">
                    <span>Buat Form Cuti Baru</span>
                </a>
            </div>

            @if (count($pengajuans) > 0)
                <div class="w-full overflow-x-auto rounded-2xl shadow-lg border border-gray-100 bg-white">
                    <table class="w-full table-auto rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                                <th class="py-4 px-4 font-semibold text-center">NO</th>
                                <th class="py-4 px-4 font-semibold text-center">TANGGAL PENGAJUAN</th>
                                <th class="py-4 px-4 font-semibold text-center">JENIS CUTI</th>
                                <th class="py-4 px-4 font-semibold text-center">PERIODE CUTI</th>
                                <th class="py-4 px-4 font-semibold text-center">LAMA CUTI</th>
                                <th class="py-4 px-4 font-semibold text-center">STATUS</th>
                                <th class="py-4 px-4 font-semibold text-center">CATATAN</th>
                                <th class="py-4 px-4 font-semibold text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($pengajuans as $index => $cuti)
                                @php
                                    $isApprovedByKabal = false;
                                    $isApprovedByAdmin = false;
                                    $isCanceled = false;

                                    if (
                                        ($cuti->cuStatusUserAdmin &&
                                            $cuti->cuStatusUserAdmin->status == 'dibatalkan') ||
                                        DB::table('status_cuti_umums')
                                            ->where('id_cuti_umum', $cuti->id)
                                            ->where('status', 'dibatalkan')
                                            ->exists()
                                    ) {
                                        $isCanceled = true;
                                    }

                                    if (
                                        $cuti->cuStatusUserAdmin &&
                                        $cuti->cuStatusUserAdmin->cuStatusAdminKatimker &&
                                        $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag &&
                                        $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                            ->cuStatusKabagKabal &&
                                        $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                            ->cuStatusKabagKabal->status == 'disetujui'
                                    ) {
                                        $isApprovedByKabal = true;
                                    }

                                    if ($cuti->cuStatusUserAdmin && $cuti->cuStatusUserAdmin->status == 'disetujui') {
                                        $isApprovedByAdmin = true;
                                    }
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-200 text-center"
                                    data-row-id="{{ $cuti->id }}">
                                    <td class="py-4 px-4 font-medium text-gray-800">
                                        {{ $pengajuans->firstItem() + $index }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-700">
                                        <div class="inline-flex items-center gap-1.5 text-gray-600">
                                            <i class="far fa-calendar-alt text-emerald-500"></i>
                                            <span>{{ date('d/m/Y', strtotime($cuti->tgl_pengajuan)) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-gray-800 font-medium">
                                        {{ $cuti->jenisCuti->nama_cuti }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-700">
                                        <div class="flex flex-col items-center text-xs space-y-0.5">
                                            <span class="inline-flex items-center gap-1 text-gray-700">
                                                <i class="far fa-play-circle text-emerald-500 text-[10px]"></i>
                                                {{ date('d/m/Y', strtotime($cuti->tgl_mulai)) }}
                                            </span>
                                            <span class="text-gray-400 font-mono">-</span>
                                            <span class="inline-flex items-center gap-1 text-gray-700">
                                                <i class="far fa-stop-circle text-rose-500 text-[10px]"></i>
                                                {{ date('d/m/Y', strtotime($cuti->tgl_selesai)) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold inline-flex items-center gap-1">
                                            <i class="far fa-clock text-[10px]"></i>
                                            @if (in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                                {{ $cuti->jumlah_hari }} Bulan
                                            @else
                                                {{ $cuti->jumlah_hari }} Hari
                                            @endif
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @php
                                            $status = 'Menunggu Verifikasi Admin';
                                            $statusClass = 'text-amber-700 bg-amber-50 border border-amber-200';
                                            $icon = '<i class="fas fa-hourglass-half text-amber-500 text-xs"></i>';

                                            if ($cuti->cuStatusUserAdmin) {
                                                $adminStatus = strtolower($cuti->cuStatusUserAdmin->status ?? 'belum disetujui');

                                                if ($adminStatus == 'dibatalkan') {
                                                    $status = 'Dibatalkan';
                                                    $statusClass = 'text-gray-600 bg-gray-100 border border-gray-200';
                                                    $icon = '<i class="fas fa-ban text-gray-500 text-xs"></i>';
                                                } elseif ($adminStatus == 'ditolak') {
                                                    $status = 'Ditolak Admin';
                                                    $statusClass = 'text-rose-700 bg-rose-50 border border-rose-200';
                                                    $icon = '<i class="fas fa-times-circle text-rose-500 text-xs"></i>';
                                                } elseif ($adminStatus == 'disetujui') {
                                                    $status = 'Disetujui Admin';
                                                    $statusClass = 'text-blue-700 bg-blue-50 border border-blue-200';
                                                    $icon = '<i class="fas fa-check-circle text-blue-500 text-xs"></i>';
                                                    
                                                    // Cek hirarki berikutnya: Kepala Bagian Umum (Kabag)
                                                    $kabagModel = optional($cuti->cuStatusUserAdmin->cuStatusAdminKatimker)->cuStatusKatimkerKabag;
                                                    $kabagStatus = strtolower($kabagModel->status ?? '');

                                                    if ($kabagStatus == 'disetujui') {
                                                        $status = 'Disetujui Kepala Bagian Umum';
                                                        $statusClass = 'text-teal-700 bg-teal-50 border border-teal-200';
                                                        $icon = '<i class="fas fa-check-circle text-teal-500 text-xs"></i>';

                                                        // Cek hirarki berikutnya: Kepala Balai (Kabal)
                                                        $kabalModel = optional($kabagModel)->cuStatusKabagKabal;
                                                        $kabalStatus = strtolower($kabalModel->status ?? '');

                                                        if ($kabalStatus == 'disetujui') {
                                                            $status = 'Disetujui Kepala Balai';
                                                            $statusClass = 'text-emerald-700 bg-emerald-50 border border-emerald-200';
                                                            $icon = '<i class="fas fa-check-circle text-emerald-500 text-xs"></i>';
                                                        } elseif ($kabalStatus == 'ditolak') {
                                                            $status = 'Ditolak Kepala Balai';
                                                            $statusClass = 'text-rose-700 bg-rose-50 border border-rose-200';
                                                            $icon = '<i class="fas fa-times-circle text-rose-500 text-xs"></i>';
                                                        }
                                                    } elseif ($kabagStatus == 'ditolak') {
                                                        $status = 'Ditolak Kepala Bagian Umum';
                                                        $statusClass = 'text-rose-700 bg-rose-50 border border-rose-200';
                                                        $icon = '<i class="fas fa-times-circle text-rose-500 text-xs"></i>';
                                                    }
                                                }
                                            }

                                            $statusCutiUmum = DB::table('status_cuti_umums')
                                                ->where('id_cuti_umum', $cuti->id)
                                                ->first();

                                            if ($statusCutiUmum && $statusCutiUmum->status == 'dibatalkan') {
                                                $status = 'Dibatalkan';
                                                $statusClass = 'text-gray-600 bg-gray-100 border border-gray-200';
                                                $icon = '<i class="fas fa-ban text-gray-500 text-xs"></i>';
                                                $isCanceled = true;
                                            }
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClass }} inline-flex items-center gap-1.5 shadow-xs">
                                            {!! $icon !!}
                                            <span>{{ $status }}</span>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-700 text-xs">
                                        @php
                                            $catatanAdmin = optional($cuti->cuStatusUserAdmin)->catatan ?? null;
                                            $catatanKabag = optional(optional($cuti->cuStatusUserAdmin)->cuStatusAdminKatimker)->cuStatusKatimkerKabag->catatan ?? null;
                                            $catatanKabal = optional(optional(optional($cuti->cuStatusUserAdmin)->cuStatusAdminKatimker)->cuStatusKatimkerKabag)->cuStatusKabagKabal->catatan ?? null;

                                            $allCatatan = [];
                                            if ($catatanAdmin) $allCatatan[] = "<span class='font-semibold text-blue-600'>Admin:</span> " . $catatanAdmin;
                                            if ($catatanKabag) $allCatatan[] = "<span class='font-semibold text-teal-600'>Kabag:</span> " . $catatanKabag;
                                            if ($catatanKabal) $allCatatan[] = "<span class='font-semibold text-emerald-600'>Kabal:</span> " . $catatanKabal;
                                        @endphp

                                        @if(count($allCatatan) > 0)
                                            <div class="flex flex-col space-y-1 text-left bg-gray-50 p-2 rounded-lg border border-gray-100">
                                                {!! implode('', $allCatatan) !!}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada catatan</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <!-- View detail button -->
                                            <a href="{{ route('katimkerpengajuancutiumum.show', $cuti->id) }}"
                                                class="w-8 h-8 rounded-lg border border-emerald-200 text-emerald-600 hover:bg-emerald-50 transition-colors flex items-center justify-center"
                                                title="Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>

                                            <!-- PDF download button -->
                                            @if ($isApprovedByKabal)
                                                <a href="{{ route('viewPDFUmum', ['id' => $cuti->id]) }}" target="_blank"
                                                    class="w-8 h-8 rounded-lg border border-emerald-200 text-emerald-600 hover:bg-emerald-50 transition-colors flex items-center justify-center relative pdf-download-link"
                                                    data-cuti-id="{{ $cuti->id }}"
                                                    onclick="markAsDownloaded({{ $cuti->id }})" title="Download PDF">
                                                    <i class="fas fa-file-pdf text-xs"></i>
                                                    <span id="dot-{{ $cuti->id }}"
                                                        class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 top-1 right-1"></span>
                                                </a>
                                            @endif

                                            <!-- Cancel button (sekarang selalu tampil kecuali sudah dibatalkan) -->
                                            @if (!$isCanceled)
                                                <button type="button" title="Batalkan Pengajuan"
                                                    class="w-8 h-8 rounded-lg border border-rose-200 text-rose-500 hover:bg-rose-50 transition-colors flex items-center justify-center cursor-pointer"
                                                    @@click="showCancelModal = true; cancelId = {{ $cuti->id }}">
                                                    <i class="fas fa-ban text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-center mt-6">
                    {{ $pengajuans->links() }}
                </div>
            @else
                <!-- No Leave Applications State -->
                <div
                    class="text-center p-8 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 shadow-sm">
                    <div
                        class="mx-auto w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-700 mb-2">Belum Ada Pengajuan Cuti</h3>
                    <p class="text-blue-600 mb-4">Silakan klik tombol "Buat Form Cuti" untuk membuat pengajuan baru.</p>
                </div>
            @endif
        @endif

        <!-- MODAL KONFIRMASI PEMBATALAN DENGAN ALPINE.JS YANG TERHUBUNG KE BACKEND -->
        <div x-show="showCancelModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
             x-transition.opacity
             style="display: none;">
            <div @click.outside="showCancelModal = false" 
                 class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-gray-100 transform transition-all">
                <div class="text-center">
                    <div class="mx-auto w-12 h-12 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center mb-4">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Konfirmasi Pembatalan</h3>
                    <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin membatalkan pengajuan cuti ini? Status pengajuan akan diubah menjadi dibatalkan.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showCancelModal = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-sm">
                        Batal
                    </button>
                    <!-- Form POST yang mengarah ke route backend pembatalan berdasarkan cancelId -->
                    <form :action="'/katimker/pengajuan-cuti-umum/' + cancelId + '/cancel'" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-xl transition-colors shadow-sm text-sm">
                            Ya, Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            checkDownloadedDocuments();
            updateNotificationVisibility();
        });

        function markAsDownloaded(cutiId) {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumKatimkerDocs')) || [];
            if (!downloadedDocs.includes(cutiId)) {
                downloadedDocs.push(cutiId);
                localStorage.setItem('downloadedCutiUmumKatimkerDocs', JSON.stringify(downloadedDocs));
            }
            const dot = document.getElementById('dot-' + cutiId);
            if (dot) {
                dot.style.display = 'none';
            }
            setTimeout(updateNotificationVisibility, 500);
        }

        function checkDownloadedDocuments() {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumKatimkerDocs')) || [];
            downloadedDocs.forEach(cutiId => {
                const dot = document.getElementById('dot-' + cutiId);
                if (dot) {
                    dot.style.display = 'none';
                }
            });
        }

        function updateNotificationVisibility() {
            const notification = document.getElementById('pdf-notification');
            if (!notification) return;
            const visibleDots = document.querySelectorAll('.notification-dot:not([style*="display: none"])');
            if (visibleDots.length === 0) {
                notification.style.display = 'none';
            }
        }

        function closeNotification() {
            const notification = document.getElementById('pdf-notification');
            if (notification) {
                notification.style.display = 'none';
            }
        }
    </script>
@endsection