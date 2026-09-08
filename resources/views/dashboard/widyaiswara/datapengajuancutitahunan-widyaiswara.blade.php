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
        @elseif (!$checkVerifikasi)
            <!-- Unverified Quota State -->
            <div
                class="text-center p-8 rounded-xl bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 shadow-sm">
                <div
                    class="mx-auto w-16 h-16 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-orange-700 mb-2">Kuota Cuti Belum Diverifikasi</h3>
                <p class="text-orange-600 mb-4">Silakan hubungi administrator untuk memverifikasi kuota cuti tahunan Anda.
                </p>

                @if (isset($admin) && !empty($admin->no_hp))
                    @php
                        $whatsappNumber = '62' . ltrim(preg_replace('/[^0-9]/', '', $admin->no_hp), '0');
                        $quotaMessage = urlencode(
                            "*[SIBACO System Notification]* 📱\n" .
                                "*Assalamualaikum Admin,*\n\n" .
                                "Saya atas nama:\n" .
                                "✅ *{$user->name}*\n" .
                                "✅ *NIP: {$user->nip}*\n\n" .
                                "Ingin memverifikasi kuota cuti tahunan saya.\n\n" .
                                'Terima kasih 🙏',
                        );
                    @endphp

                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $quotaMessage }}" target="_blank"
                        class="inline-flex items-center px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        <svg class="w-6 h-6 sm:w-4 sm:h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479h.005c5.451 0 9.888-4.434 9.891-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.888-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        Hubungi Admin via WhatsApp
                    </a>
                @endif
            </div>
        @else
            <!-- Main Content - Only shown if all verifications pass -->
            @php
                $hasApprovedDocs =
                    $pengajuancutitahunan
                        ->where(function ($query) {
                            return $query->where('kabalStatus', 'disetujui');
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
                                <p class="text-sm text-green-700">Anda memiliki dokumen cuti yang telah disetujui oleh
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
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Tahunan</h2>
                    <p class="text-blue-600 font-medium">Widyaiswara</p>
                </div>
                <a href="{{ route('widyaiswarapengajuancutitahunan.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-primary  text-white font-semibold rounded-xl hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-blue-200/50">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Form Cuti Baru</span>
                </a>
            </div>

            @if (count($pengajuancutitahunan) > 0)
                <div class="w-full overflow-x-auto rounded-2xl shadow-lg border border-gray-100">
                    <table class="w-full table-auto bg-white rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-primary to-yellow-500 text-white">
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    NO</th>
                                <th class="py-4 px-4 text-left font-semibold uppercase tracking-wider text-sm text-center">
                                    TANGGAL PENGAJUAN</th>
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
                            @foreach ($pengajuancutitahunan as $index => $cuti)
                                @php
                                    $isApprovedByKabal = $cuti->kabalStatus == 'disetujui';
                                @endphp
                                <tr class="hover:bg-indigo-50 transition-colors duration-200 group text-center"
                                    data-row-id="{{ $cuti->id }}">
                                    <td
                                        class="py-4 px-6 whitespace-nowrap font-medium text-gray-900 group-hover:text-indigo-700 justify-center">
                                        <span
                                            class="inline-block w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                            {{ $index + 1 }}
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
                                            {{ $cuti->lama_cuti }} HARI
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-center">
                                        @php
                                            $status = 'Belum diverifikasi';
                                            $statusClass = 'text-gray-600 bg-gray-100';
                                            $icon = '<i class="fas fa-hourglass-start mr-2"></i>';

                                            // Check if the application has been canceled
                                            if (
                                                isset($cuti->statusCutiTahunan) &&
                                                $cuti->statusCutiTahunan->status == 'dibatalkan'
                                            ) {
                                                $status = 'Dibatalkan oleh Anda';
                                                $statusClass = 'text-red-600 bg-red-100';
                                                $icon = '<i class="fas fa-ban mr-2"></i>';
                                            } else {
                                                // The original status logic
                                                if ($cuti->adminStatus != 'Belum diproses') {
                                                    if ($cuti->adminStatus == 'ditolak') {
                                                        $status = 'Ditolak oleh Admin';
                                                        $statusClass = 'text-red-600 bg-red-100';
                                                        $icon = '<i class="fas fa-times-circle mr-2"></i>';
                                                    } elseif ($cuti->adminStatus == 'ditangguhkan') {
                                                        $status = 'Ditangguhkan oleh Admin';
                                                        $statusClass = 'text-purple-600 bg-purple-100';
                                                        $icon = '<i class="fas fa-pause-circle mr-2"></i>';
                                                    } elseif ($cuti->adminStatus == 'perubahan') {
                                                        $status = 'Perubahan diminta oleh Admin';
                                                        $statusClass = 'text-indigo-600 bg-indigo-100';
                                                        $icon = '<i class="fas fa-edit mr-2"></i>';
                                                    } elseif ($cuti->adminStatus == 'disetujui') {
                                                        $status = 'Diverifikasi Admin';
                                                        $statusClass = 'text-blue-600 bg-blue-100';
                                                        $icon = '<i class="fas fa-user-check mr-2"></i>';

                                                        if ($cuti->kabalStatus != 'Belum diproses') {
                                                            if ($cuti->kabalStatus == 'ditolak') {
                                                                $status = 'Ditolak oleh Kepala Balai';
                                                                $statusClass = 'text-red-600 bg-red-100';
                                                                $icon = '<i class="fas fa-times-circle mr-2"></i>';
                                                            } elseif ($cuti->kabalStatus == 'ditangguhkan') {
                                                                $status = 'Ditangguhkan oleh Kepala Balai';
                                                                $statusClass = 'text-purple-600 bg-purple-100';
                                                                $icon = '<i class="fas fa-pause-circle mr-2"></i>';
                                                            } elseif ($cuti->kabalStatus == 'perubahan') {
                                                                $status = 'Perubahan diminta oleh Kepala Balai';
                                                                $statusClass = 'text-indigo-600 bg-indigo-100';
                                                                $icon = '<i class="fas fa-edit mr-2"></i>';
                                                            } elseif ($cuti->kabalStatus == 'disetujui') {
                                                                $status = 'Disetujui Kepala Balai';
                                                                $statusClass = 'text-green-600 bg-green-100';
                                                                $icon = '<i class="fas fa-check-circle mr-2"></i>';
                                                            }
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
                                            $catatanAdmin = optional($cuti->ctStatusUserAdmin)->catatan ?? null;
                                            $catatanKabal =
                                                optional(optional($cuti->ctStatusUserAdmin)->ctStatusAdminKabal)
                                                    ->catatan ?? null;

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
                                            <a href="{{ route('widyaiswarapengajuancutitahunan.show', $cuti->id) }}"
                                                class="text-indigo-600 hover:text-white hover:bg-indigo-600 transition-colors duration-200 p-3 rounded-full hover:shadow-md"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if ($isApprovedByKabal)
                                                <a href="{{ route('viewPDF', ['id' => $cuti->id]) }}" target="_blank"
                                                    class="text-green-600 hover:text-white hover:bg-green-600 transition-colors duration-200 p-3 rounded-full hover:shadow-md relative pdf-download-link"
                                                    data-cuti-id="{{ $cuti->id }}"
                                                    onclick="markAsDownloaded({{ $cuti->id }})" title="Download PDF">
                                                    <i class="fas fa-file-pdf"></i>
                                                    <span id="dot-{{ $cuti->id }}"
                                                        class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 top-2 right-2"></span>
                                                </a>
                                            @endif

                                            @php
                                                // Check if the leave application has been approved by Kabal
                                                $isApprovedByKabal = $cuti->kabalStatus == 'disetujui';
                                                $isCanceled =
                                                    $cuti->statusCutiTahunan &&
                                                    $cuti->statusCutiTahunan->status == 'dibatalkan';
                                            @endphp

                                            @if (!$isApprovedByKabal && !$isCanceled)
                                                <form
                                                    action="{{ route('widyaiswarapengajuancutitahunan.cancel', $cuti->id) }}"
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check which documents have been downloaded before
            checkDownloadedDocuments();

            // Check if we should display the notification
            updateNotificationVisibility();
        });

        function markAsDownloaded(cutiId) {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiDocs')) || [];

            if (!downloadedDocs.includes(cutiId)) {
                downloadedDocs.push(cutiId);
                localStorage.setItem('downloadedCutiDocs', JSON.stringify(downloadedDocs));
            }

            const dot = document.getElementById('dot-' + cutiId);
            if (dot) {
                dot.style.display = 'none';
            }

            setTimeout(updateNotificationVisibility, 500);
        }

        function checkDownloadedDocuments() {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiDocs')) || [];

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
