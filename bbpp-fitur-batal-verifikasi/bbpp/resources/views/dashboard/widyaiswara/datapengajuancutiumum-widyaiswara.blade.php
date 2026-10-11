@extends('dashboard.widyaiswara.base-widyaiswara')

@section('main')
    <div class="px-6 pt-0 pb-6 bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl shadow-xl">
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
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-user-edit mr-2"></i>
                    Lengkapi Profil
                </a>
            </div>
        @else
            <!-- Main Content - Only shown if all verifications pass -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-xl bg-gradient-to-r from-green-100 to-green-50 border border-green-200 shadow-sm flex items-center">
                    <div class="mr-4 p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @php
                $hasApprovedDocs =
                    $pengajuans
                        ->where(function ($pengajuan) {
                            return $pengajuan->cuStatusUserAdmin &&
                                $pengajuan->cuStatusUserAdmin->cuStatusAdminKabal &&
                                $pengajuan->cuStatusUserAdmin->cuStatusAdminKabal->status == 'disetujui';
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
                    <p class="text-blue-600 font-medium">Widyaiswara</p>
                </div>
                <a href="{{ route('widyaiswarapengajuancutiumum.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-primary  text-white font-semibold rounded-xl hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-blue-200/50">
                    <i class="fas fa-file-alt"></i>
                    <span>Buat Form Cuti</span>
                </a>
            </div>

            @if (count($pengajuans) > 0)
                <div class="w-full overflow-x-auto rounded-2xl shadow-lg border border-gray-100">
                    <table class="w-full table-auto bg-white rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-primary to-yellow-500 text-white">
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    NO</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    TANGGAL PENGAJUAN</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    JENIS CUTI</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    PERIODE CUTI</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    LAMA CUTI</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    STATUS</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    CATATAN</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($pengajuans as $index => $cuti)
                                @php
                                    $isApprovedByKabal = false;
                                    if (
                                        $cuti->cuStatusUserAdmin &&
                                        $cuti->cuStatusUserAdmin->cuStatusAdminKabal &&
                                        $cuti->cuStatusUserAdmin->cuStatusAdminKabal->status == 'disetujui'
                                    ) {
                                        $isApprovedByKabal = true;
                                    }
                                @endphp
                                <tr class="hover:bg-indigo-50 transition-colors duration-200 group text-center"
                                    data-row-id="{{ $cuti->id }}">
                                    <td
                                        class="py-4 px-6 whitespace-nowrap font-medium text-gray-900 group-hover:text-indigo-700 justify-center">
                                        <span
                                            class="inline-block w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                            {{ $pengajuans->firstItem() + $index }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700 text-center">
                                        <div class="flex items-center justify-center">
                                            <i class="far fa-calendar-alt mr-3 text-indigo-500"></i>
                                            <span
                                                class="font-medium">{{ date('d-m-Y', strtotime($cuti->tgl_pengajuan)) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700">
                                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                            {{ $cuti->jenisCuti->nama_cuti }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700">
                                        <div class="flex flex-col space-y-1">
                                            <span class="flex items-center">
                                                <i class="far fa-play-circle mr-2 text-green-500"></i>
                                                <span
                                                    class="font-medium">{{ date('d-m-Y', strtotime($cuti->tgl_mulai)) }}</span>
                                            </span>
                                            <span class="flex items-center">
                                                <i class="far fa-stop-circle mr-2 text-red-500"></i>
                                                <span
                                                    class="font-medium">{{ date('d-m-Y', strtotime($cuti->tgl_selesai)) }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-center">
                                        <span
                                            class="px-4 py-2 rounded-full bg-indigo-100 text-indigo-700 font-bold inline-flex items-center">
                                            <i class="fas fa-clock mr-2"></i>
                                            @if (in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                                {{ $cuti->jumlah_hari }} BULAN
                                            @else
                                                {{ $cuti->jumlah_hari }} HARI
                                            @endif
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-center">
                                        @php
                                            $status = 'Belum diverifikasi';
                                            $statusClass = 'text-gray-600 bg-gray-100';
                                            $icon = '<i class="fas fa-hourglass-start mr-2"></i>';

                                            // Periksa status di tabel status_cuti_umums (jika user membatalkan)
                                            $statusCutiUmum = DB::table('status_cuti_umums')
                                                ->where('id_cuti_umum', $cuti->id)
                                                ->first();

                                            if ($statusCutiUmum && $statusCutiUmum->status == 'dibatalkan') {
                                                $status = 'Anda Membatalkan Cuti Ini';
                                                $statusClass = 'text-yellow-600 bg-yellow-100';
                                                $icon = '<i class="fas fa-ban mr-2"></i>';
                                            } elseif ($cuti->cuStatusUserAdmin) {
                                                $adminStatus = $cuti->cuStatusUserAdmin->status ?? 'belum disetujui';

                                                if ($adminStatus == 'ditolak') {
                                                    $status = 'Ditolak oleh Admin';
                                                    $statusClass = 'text-red-600 bg-red-100';
                                                    $icon = '<i class="fas fa-times-circle mr-2"></i>';
                                                } elseif ($adminStatus == 'ditangguhkan') {
                                                    $status = 'Ditangguhkan oleh Admin';
                                                    $statusClass = 'text-purple-600 bg-purple-100';
                                                    $icon = '<i class="fas fa-pause-circle mr-2"></i>';
                                                } elseif ($adminStatus == 'perubahan') {
                                                    $status = 'Perubahan diminta oleh Admin';
                                                    $statusClass = 'text-indigo-600 bg-indigo-100';
                                                    $icon = '<i class="fas fa-edit mr-2"></i>';
                                                } else {
                                                    $status = 'Diverifikasi Admin';
                                                    $statusClass = 'text-blue-600 bg-blue-100';
                                                    $icon = '<i class="fas fa-user-check mr-2"></i>';

                                                    // Khusus untuk Kabag, langsung ke Kabal
                                                    if ($cuti->cuStatusUserAdmin->cuStatusAdminKabal) {
                                                        $kabalStatus =
                                                            $cuti->cuStatusUserAdmin->cuStatusAdminKabal->status ??
                                                            'belum disetujui';

                                                        if ($kabalStatus == 'ditolak') {
                                                            $status = 'Ditolak oleh Kepala Balai';
                                                            $statusClass = 'text-red-600 bg-red-100';
                                                            $icon = '<i class="fas fa-times-circle mr-2"></i>';
                                                        } elseif ($kabalStatus == 'ditangguhkan') {
                                                            $status = 'Ditangguhkan oleh Kepala Balai';
                                                            $statusClass = 'text-purple-600 bg-purple-100';
                                                            $icon = '<i class="fas fa-pause-circle mr-2"></i>';
                                                        } elseif ($kabalStatus == 'perubahan') {
                                                            $status = 'Perubahan diminta oleh Kepala Balai';
                                                            $statusClass = 'text-indigo-600 bg-indigo-100';
                                                            $icon = '<i class="fas fa-edit mr-2"></i>';
                                                        } else {
                                                            $status = 'Disetujui Kepala Balai';
                                                            $statusClass = 'text-green-600 bg-green-100';
                                                            $icon = '<i class="fas fa-check-circle mr-2"></i>';
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <span
                                            class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusClass }} inline-flex items-center">
                                            {!! $icon !!}
                                            <span>{{ $status }}</span>
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-gray-700 max-w-xs text-center">
                                        @php
                                            $catatanAdmin = optional($cuti->cuStatusUserAdmin)->catatan ?? null;
                                            $catatanKabal =
                                                optional($cuti->cuStatusUserAdmin)->cuStatusAdminKabal->catatan ?? null;

                                            $catatan = [];
                                            if ($catatanAdmin) {
                                                $catatan[] =
                                                    "<div class='mb-2'><span class='font-bold text-blue-600'>Admin:</span><p class='text-sm mt-1 pl-4'>" .
                                                    $catatanAdmin .
                                                    '</p></div>';
                                            }
                                            if ($catatanKabal) {
                                                $catatan[] =
                                                    "<div class='mb-2'><span class='font-bold text-green-600'>Kepala Balai:</span><p class='text-sm mt-1 pl-4'>" .
                                                    $catatanKabal .
                                                    '</p></div>';
                                            }
                                        @endphp

                                        @if (count($catatan) > 0)
                                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                                <div class="text-xs font-semibold text-gray-500 mb-2">CATATAN VERIFIKASI
                                                </div>
                                                {!! implode('', $catatan) !!}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('widyaiswarapengajuancutiumum.show', $cuti->id) }}"
                                                class="text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors duration-200 p-3 rounded-full hover:shadow-md"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($isApprovedByKabal)
                                                <a href="{{ route('viewPDFUmum', ['id' => $cuti->id]) }}" target="_blank"
                                                    class="text-green-600 hover:text-white hover:bg-green-600 transition-colors duration-200 p-3 rounded-full hover:shadow-md relative pdf-download-link"
                                                    data-cuti-id="{{ $cuti->id }}"
                                                    onclick="markAsDownloaded({{ $cuti->id }})">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span id="dot-{{ $cuti->id }}"
                                                        class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 top-2 right-2"></span>
                                                </a>
                                            @endif

                                            @php
                                                // Check if not approved by admin yet
                                                $isNotApprovedByAdmin =
                                                    !$cuti->cuStatusUserAdmin ||
                                                    ($cuti->cuStatusUserAdmin &&
                                                        $cuti->cuStatusUserAdmin->status != 'disetujui');

                                                $isCanceled =
                                                    $cuti->statusCutiTahunan &&
                                                    $cuti->statusCutiTahunan->status == 'dibatalkan';
                                            @endphp



                                            {{-- Tombol Batalkan: hanya muncul jika belum disetujui oleh Kepala Balai --}}
                                            @if (!$isApprovedByKabal && !$isCanceled)
                                                <form
                                                    action="{{ route('widyaiswarapengajuancutiumum.cancel', $cuti->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin membatalkan pengajuan cuti ini?');">
                                                    @csrf
                                                    <input type="hidden" name="cuti_id" value="{{ $cuti->id }}">
                                                    <button type="submit"
                                                        class="text-yellow-600 hover:text-white hover:bg-yellow-600 transition-colors duration-200 p-3 rounded-full hover:shadow-md"
                                                        title="Batalkan">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @elseif($isApprovedByKabal)
                                                <button disabled class="text-gray-400 cursor-not-allowed p-3 rounded-full"
                                                    title="Tidak dapat dibatalkan">
                                                    <i class="fas fa-ban"></i>
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
                    <h3 class="text-xl font-bold text-blue-700 mb-2">Belum Ada Pengajuan Cuti Umum</h3>
                    <p class="text-blue-600 mb-4">Silakan klik tombol "Buat Form Cuti" untuk membuat pengajuan baru.</p>
                </div>
            @endif
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check which documents have been downloaded before
            checkDownloadedDocuments();

            // Check if we should display the notification
            updateNotificationVisibility();
        });

        function markAsDownloaded(cutiId) {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumDocs')) || [];

            if (!downloadedDocs.includes(cutiId)) {
                downloadedDocs.push(cutiId);
                localStorage.setItem('downloadedCutiUmumDocs', JSON.stringify(downloadedDocs));
            }

            const dot = document.getElementById('dot-' + cutiId);
            if (dot) {
                dot.style.display = 'none';
            }

            setTimeout(updateNotificationVisibility, 500);
        }

        function checkDownloadedDocuments() {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumDocs')) || [];

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
