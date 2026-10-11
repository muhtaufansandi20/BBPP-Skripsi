@extends('dashboard.kepalabagian.base-kepalabagian')

@section('content')
    <div class="px-6 pt-0 pb-6 bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl shadow-xl">
        @if (!$hasWorkPeriod)
            <!-- No Work Period State -->
            <div
                class="text-center p-8 rounded-xl bg-gradient-to-r from-orange-100 to-amber-100 border border-orange-300 shadow-sm">
                <div
                    class="mx-auto w-16 h-16 rounded-full bg-orange-200 text-orange-700 flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-orange-800 mb-2">Masa Kerja Belum Diisi</h3>
                <p class="text-orange-700 mb-4">Silakan lengkapi data masa kerja Anda sebelum mengajukan cuti.</p>
                <p class="inline-flex items-center px-5 py-2 border border-blue-600 text-blue-700 rounded-lg transition">
                    Hubungi Admin
                </p>
            </div>
        @else
            <!-- Main Content - Only shown if all verifications pass -->
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-xl bg-gradient-to-r from-amber-100 to-orange-50 border border-amber-200 shadow-sm flex items-center">
                    <div class="mr-4 p-3 rounded-full bg-amber-100 text-amber-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-amber-800">{{ session('success') }}</p>
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
                        class="mb-6 p-4 rounded-xl bg-gradient-to-r from-amber-100 to-orange-50 border border-amber-200 shadow-sm flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-4 p-3 rounded-full bg-amber-100 text-amber-600">
                                <i class="fas fa-bell text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-amber-800">Dokumen Cuti Disetujui!</h3>
                                <p class="text-sm text-amber-700">Anda memiliki dokumen cuti umum yang telah disetujui oleh
                                    Kepala Balai. Silakan unduh dokumen cuti Anda dengan mengklik ikon <i
                                        class="fas fa-file-pdf text-amber-600 mx-1"></i> pada tabel di bawah.</p>
                            </div>
                        </div>
                        <button onclick="closeNotification()"
                            class="text-amber-600 hover:text-amber-800 p-2 rounded-full hover:bg-amber-200 transition-colors">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 pt-4">
                <div>
                    <h2 class="text-lg sm:text-2xl font-bold text-gray-800">Daftar Pengajuan Cuti Umum</h2>
                    <p class="text-blue-600 font-medium">Kepala Bagian</p>
                </div>
                <a href="{{ route('kabagpengajuancutiumum.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-blue-200/50">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Form Cuti Baru</span>
                </a>
            </div>

            @if (count($pengajuans) > 0)
                <div class="w-full overflow-x-auto rounded-2xl shadow-lg border border-gray-100">
                    <table class="w-full table-auto bg-white rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-primary to-lime-500 text-white">
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    NO</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    TANGGAL PENGAJUAN</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    JENIS CUTI</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    PERIODE CUTI</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    LAMA CUTI</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    STATUS</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
                                    CATATAN</th>
                                <th class="py-4 px-4 font-semibold uppercase tracking-wider text-xs text-center">
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

                                    $statusCutiUmum = DB::table('status_cuti_umums')
                                        ->where('id_cuti_umum', $cuti->id)
                                        ->first();
                                    
                                    $isCanceled = $statusCutiUmum && $statusCutiUmum->status == 'dibatalkan';
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-200 group text-center"
                                    data-row-id="{{ $cuti->id }}">
                                    
                                    <!-- NO -->
                                    <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-700 text-center">
                                        {{ $pengajuans->firstItem() + $index }}
                                    </td>

                                    <!-- TANGGAL PENGAJUAN -->
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700 text-center">
                                        <div class="flex items-center justify-center gap-1.5 text-xs">
                                            <i class="far fa-calendar-alt text-emerald-500"></i>
                                            <span class="font-medium">{{ date('d/m/Y', strtotime($cuti->tgl_pengajuan)) }}</span>
                                        </div>
                                    </td>

                                    <!-- JENIS CUTI -->
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-800 font-medium text-center text-xs">
                                        {{ $cuti->jenisCuti->nama_cuti }}
                                    </td>

                                    <!-- PERIODE CUTI -->
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700 text-center">
                                        <div class="flex flex-col items-center text-[11px] space-y-0.5">
                                            <span class="inline-flex items-center gap-1 text-gray-700">
                                                <i class="far fa-play-circle text-emerald-500 text-[10px]"></i>
                                                {{ date('d/m/Y', strtotime($cuti->tgl_mulai)) }}
                                            </span>
                                            <span class="text-gray-300 font-mono">-</span>
                                            <span class="inline-flex items-center gap-1 text-gray-700">
                                                <i class="far fa-stop-circle text-rose-500 text-[10px]"></i>
                                                {{ date('d/m/Y', strtotime($cuti->tgl_selesai)) }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- LAMA CUTI -->
                                    <td class="py-4 px-2 whitespace-nowrap text-center">
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold inline-flex items-center gap-1.5 shadow-sm">
                                            <i class="fas fa-clock text-[10px]"></i>
                                            @if (in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']))
                                                {{ $cuti->jumlah_hari }} Bulan
                                            @else
                                                {{ $cuti->jumlah_hari }} Hari
                                            @endif
                                        </span>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="py-4 px-2 whitespace-nowrap text-center">
                                        @php
                                            $status = 'Menunggu Verifikasi Admin';
                                            $statusClass = 'text-amber-700 bg-amber-50 border border-amber-200';
                                            $icon = '<i class="fas fa-hourglass-half text-amber-500 mr-1 text-[10px]"></i>';

                                            if ($isCanceled) {
                                                $status = 'Dibatalkan';
                                                $statusClass = 'text-gray-600 bg-gray-100 border border-gray-200';
                                                $icon = '<i class="fas fa-ban text-gray-500 mr-1 text-[10px]"></i>';
                                            } elseif ($cuti->cuStatusUserAdmin) {
                                                $adminStatus = $cuti->cuStatusUserAdmin->status ?? 'belum disetujui';

                                                if ($adminStatus == 'ditolak') {
                                                    $status = 'Ditolak Admin';
                                                    $statusClass = 'text-rose-700 bg-rose-50 border border-rose-200';
                                                    $icon = '<i class="fas fa-times-circle text-rose-500 mr-1 text-[10px]"></i>';
                                                } elseif ($adminStatus == 'ditangguhkan') {
                                                    $status = 'Ditangguhkan Admin';
                                                    $statusClass = 'text-purple-600 bg-purple-100 border border-purple-200';
                                                    $icon = '<i class="fas fa-pause-circle text-purple-500 mr-1 text-[10px]"></i>';
                                                } elseif ($adminStatus == 'perubahan') {
                                                    $status = 'Perubahan Diminta';
                                                    $statusClass = 'text-indigo-600 bg-indigo-50 border border-indigo-200';
                                                    $icon = '<i class="fas fa-edit text-indigo-500 mr-1 text-[10px]"></i>';
                                                } else {
                                                    $status = 'Diverifikasi Admin';
                                                    $statusClass = 'text-blue-700 bg-blue-50 border border-blue-200';
                                                    $icon = '<i class="fas fa-user-check text-blue-500 mr-1 text-[10px]"></i>';

                                                    if ($cuti->cuStatusUserAdmin->cuStatusAdminKabal) {
                                                        $kabalStatus = $cuti->cuStatusUserAdmin->cuStatusAdminKabal->status ?? 'belum disetujui';

                                                        if ($kabalStatus == 'ditolak') {
                                                            $status = 'Ditolak Kepala Balai';
                                                            $statusClass = 'text-rose-700 bg-rose-50 border border-rose-200';
                                                            $icon = '<i class="fas fa-times-circle text-rose-500 mr-1 text-[10px]"></i>';
                                                        } elseif ($kabalStatus == 'ditangguhkan') {
                                                            $status = 'Ditangguhkan Kabal';
                                                            $statusClass = 'text-purple-600 bg-purple-100 border border-purple-200';
                                                            $icon = '<i class="fas fa-pause-circle text-purple-500 mr-1 text-[10px]"></i>';
                                                        } elseif ($kabalStatus == 'perubahan') {
                                                            $status = 'Perubahan Diminta';
                                                            $statusClass = 'text-indigo-600 bg-indigo-50 border border-indigo-200';
                                                            $icon = '<i class="fas fa-edit text-indigo-500 mr-1 text-[10px]"></i>';
                                                        } elseif ($kabalStatus == 'disetujui') {
                                                            $status = 'Disetujui Kepala Balai';
                                                            $statusClass = 'text-emerald-700 bg-emerald-50 border border-emerald-200';
                                                            $icon = '<i class="fas fa-check-circle text-emerald-500 mr-1 text-[10px]"></i>';
                                                        }
                                                    }
                                                }
                                            }
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-full text-[11px] font-bold {{ $statusClass }} inline-flex items-center shadow-sm">
                                            {!! $icon !!}
                                            <span>{{ $status }}</span>
                                        </span>
                                    </td>

                                    <!-- CATATAN -->
                                    <td class="py-4 px-2 text-gray-700 max-w-[200px] text-center">
                                        @php
                                            $catatanAdmin = optional($cuti->cuStatusUserAdmin)->catatan ?? null;
                                            $catatanKabal = optional(optional($cuti->cuStatusUserAdmin)->cuStatusAdminKabal)->catatan ?? null;

                                            $catatan = [];
                                            if ($catatanAdmin) {
                                                $catatan[] = "<div class='mb-1.5 text-left'><span class='font-bold text-blue-600 text-[10px]'>Admin:</span><p class='text-[11px] text-gray-600 mt-0.5 leading-tight'>" . $catatanAdmin . "</p></div>";
                                            }
                                            if ($catatanKabal) {
                                                $catatan[] = "<div class='text-left'><span class='font-bold text-green-600 text-[10px]'>Kepala Balai:</span><p class='text-[11px] text-gray-600 mt-0.5 leading-tight'>" . $catatanKabal . "</p></div>";
                                            }
                                        @endphp

                                        @if (count($catatan) > 0)
                                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                                {!! implode('', $catatan) !!}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Tidak ada catatan</span>
                                        @endif
                                    </td>

                                    <!-- AKSI -->
                                    <td class="py-4 px-2 whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <!-- Detail Button -->
                                            <a href="{{ route('kabagpengajuancutiumum.show', $cuti->id) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-200 hover:text-white hover:bg-emerald-500 transition-colors duration-200"
                                                title="Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>

                                            <!-- PDF Download -->
                                            @if ($isApprovedByKabal)
                                                <a href="{{ route('viewPDFUmum', ['id' => $cuti->id]) }}" target="_blank"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-emerald-50 text-emerald-600 border border-emerald-200 hover:text-white hover:bg-emerald-500 transition-colors duration-200 relative pdf-download-link"
                                                    data-cuti-id="{{ $cuti->id }}"
                                                    onclick="markAsDownloaded({{ $cuti->id }})" title="Download PDF">
                                                    <i class="fas fa-file-pdf text-xs"></i>
                                                    <span id="dot-{{ $cuti->id }}"
                                                        class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 -top-1 -right-1"></span>
                                                </a>
                                            @endif

                                            <!-- Cancel Button (Menggunakan Modal, tetap tampil walau disetujui selama belum dibatalkan) -->
                                            @if (!$isCanceled)
                                                <button type="button"
                                                    onclick="openCancelModal('{{ route('kabagpengajuancutiumum.cancel', $cuti->id) }}', '{{ $cuti->id }}')"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-rose-50 text-rose-500 border border-rose-200 hover:text-white hover:bg-rose-500 transition-colors duration-200"
                                                    title="Batalkan Pengajuan">
                                                    <i class="fas fa-ban text-xs"></i>
                                                </button>
                                            @else
                                                <button disabled
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-gray-100 text-gray-400 border border-gray-200 cursor-not-allowed"
                                                    title="Sudah Dibatalkan">
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
                <div class="text-center p-8 rounded-xl bg-gradient-to-r from-gray-50 to-emerald-50 border border-emerald-100 shadow-sm">
                    <div class="mx-auto w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-800 mb-2">Belum Ada Pengajuan Cuti Umum</h3>
                    <p class="text-emerald-600 mb-4">Silakan klik tombol "Buat Form Cuti Baru" untuk membuat pengajuan baru.</p>
                </div>
            @endif
        @endif
    </div>

    <!-- Modal Pop-up Konfirmasi Pembatalan -->
    <div id="cancelModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 backdrop-blur-sm hidden transition-opacity duration-200">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full mx-4 p-6 text-center transform transition-all">
            <div class="mx-auto w-14 h-14 rounded-full bg-red-100 text-red-500 flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Batalkan Pengajuan?</h3>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin membatalkan pengajuan cuti ini? Tindakan ini tidak dapat diurungkan.</p>
            
            <form id="cancelForm" method="POST" action="">
                @csrf
                <input type="hidden" name="cuti_id" id="modalCutiId">
                
                <div class="flex items-center justify-center gap-3">
                    <button type="button" 
                            onclick="closeCancelModal()" 
                            class="w-1/2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Kembali
                    </button>
                    <button type="submit" 
                            class="w-1/2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        Ya, Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            checkDownloadedDocuments();
            updateNotificationVisibility();
        });

        // --- FUNGSI MODAL PEMBATALAN ---
        function openCancelModal(actionUrl, cutiId) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            const inputId = document.getElementById('modalCutiId');

            form.action = actionUrl;
            inputId.value = cutiId;

            modal.classList.remove('hidden');
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
        }

        // Tutup modal jika user mengklik area luar form
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('cancelModal');
            if (e.target === modal) {
                closeCancelModal();
            }
        });

        // --- FUNGSI DOWNLOAD & NOTIFIKASI ---
        function markAsDownloaded(cutiId) {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumKabagDocs')) || [];

            if (!downloadedDocs.includes(cutiId)) {
                downloadedDocs.push(cutiId);
                localStorage.setItem('downloadedCutiUmumKabagDocs', JSON.stringify(downloadedDocs));
            }

            const dot = document.getElementById('dot-' + cutiId);
            if (dot) {
                dot.style.display = 'none';
            }

            setTimeout(updateNotificationVisibility, 500);
        }

        function checkDownloadedDocuments() {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumKabagDocs')) || [];

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