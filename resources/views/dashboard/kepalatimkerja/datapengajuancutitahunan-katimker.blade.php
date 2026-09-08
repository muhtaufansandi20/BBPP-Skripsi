@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
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
                <p class="inline-flex items-center px-5 py-2 border border-blue-600 text-blue-700 rounded-lg transition">
                    Hubungi Admin
                </p>
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
                    <p class="text-blue-600 font-medium">Kepala Tim Kerja</p>
                </div>
                <a href="{{ route('katimkerpengajuancutitahunan.create') }}"
                    class="flex items-center gap-2 px-5 py-3 bg-primary text-white font-semibold rounded-xl hover:bg-emerald-600 transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-blue-200/50">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Form Cuti Baru</span>
                </a>
            </div>

            @if (count($pengajuancutitahunan) > 0)
                <div class="w-full overflow-x-auto rounded-2xl shadow-lg border border-gray-100 bg-white">
                    <table class="w-full table-auto rounded-xl overflow-hidden">
                        <thead>
                            <tr class="bg-gradient-to-r from-emerald-400 to-green-500 text-white">
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">NO</th>
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">TANGGAL PENGAJUAN</th>
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">PERIODE CUTI</th>
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">LAMA CUTI</th>
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">STATUS</th>
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">CATATAN</th>
                                <th class="py-4 px-4 text-center font-semibold uppercase tracking-wider text-xs">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($pengajuancutitahunan as $index => $cuti)
                                @php
                                    $isApprovedByKabal = $cuti->kabalStatus == 'disetujui';
                                    $isCanceled = $cuti->statusCutiTahunan && $cuti->statusCutiTahunan->status == 'dibatalkan';
                                @endphp
                                <tr class="hover:bg-indigo-50/40 transition-colors duration-200 group text-center"
                                    data-row-id="{{ $cuti->id }}">
                                    <td class="py-4 px-4 whitespace-nowrap font-medium text-gray-700">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <i class="far fa-calendar-alt text-emerald-500"></i>
                                            <span>{{ date('d/m/Y', strtotime($cuti->tgl_pengajuan)) }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap text-gray-700">
                                        <div class="flex flex-col items-center gap-1 text-xs">
                                            <span class="flex items-center gap-1.5">
                                                <i class="far fa-play-circle text-emerald-500"></i>
                                                <span>{{ date('d/m/Y', strtotime($cuti->tgl_mulai)) }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <i class="far fa-stop-circle text-rose-400"></i>
                                                <span>{{ date('d/m/Y', strtotime($cuti->tgl_selesai)) }}</span>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 font-medium text-xs inline-flex items-center gap-1.5 border border-emerald-100">
                                            <i class="far fa-clock text-emerald-500"></i>
                                            {{ $cuti->lama_cuti }} Hari
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap">
                                        @php
                                            // Mengambil status yang akurat langsung dari relasi/database
                                            $realAdminSt = optional($cuti->ctStatusUserAdmin)->status ?? $cuti->adminStatus ?? 'Belum diproses';
                                            $realKabagSt = optional(optional(optional($cuti->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag)->status ?? $cuti->kabagStatus ?? 'Belum diproses';
                                            $realKabalSt = optional($cuti)->kabalStatus ?? 'Belum diproses';

                                            $status = 'Belum diverifikasi';
                                            $statusClass = 'text-gray-600 bg-gray-100 border-gray-200';
                                            $dotColor = 'bg-gray-400';

                                            if ($isCanceled) {
                                                $status = 'Dibatalkan';
                                                $statusClass = 'text-red-700 bg-red-50 border-red-200';
                                                $dotColor = 'bg-red-500';
                                            } else {
                                                if (strtolower($realAdminSt) != 'belum diproses') {
                                                    if (strtolower($realAdminSt) == 'ditolak') {
                                                        $status = 'Ditolak Admin';
                                                        $statusClass = 'text-red-700 bg-red-50 border-red-200';
                                                        $dotColor = 'bg-red-500';
                                                    } elseif (strtolower($realAdminSt) == 'ditangguhkan') {
                                                        $status = 'Ditangguhkan Admin';
                                                        $statusClass = 'text-purple-700 bg-purple-50 border-purple-200';
                                                        $dotColor = 'bg-purple-500';
                                                    } elseif (strtolower($realAdminSt) == 'perubahan') {
                                                        $status = 'Perubahan Diminta';
                                                        $statusClass = 'text-indigo-700 bg-indigo-50 border-indigo-200';
                                                        $dotColor = 'bg-indigo-500';
                                                    } elseif (strtolower($realAdminSt) == 'disetujui') {
                                                        $status = 'Menunggu Kepala Bagian';
                                                        $statusClass = 'text-amber-700 bg-amber-50 border-amber-200';
                                                        $dotColor = 'bg-amber-400';

                                                        if (strtolower($realKabagSt) != 'belum diproses') {
                                                            if (strtolower($realKabagSt) == 'ditolak') {
                                                                $status = 'Ditolak Kabag';
                                                                $statusClass = 'text-red-700 bg-red-50 border-red-200';
                                                                $dotColor = 'bg-red-500';
                                                            } elseif (strtolower($realKabagSt) == 'ditangguhkan') {
                                                                $status = 'Ditangguhkan Kabag';
                                                                $statusClass = 'text-purple-700 bg-purple-50 border-purple-200';
                                                                $dotColor = 'bg-purple-500';
                                                            } elseif (strtolower($realKabagSt) == 'disetujui') {
                                                                if (strtolower($realKabalSt) == 'disetujui') {
                                                                    $status = 'Disetujui';
                                                                    $statusClass = 'text-emerald-700 bg-emerald-50 border-emerald-200';
                                                                    $dotColor = 'bg-emerald-500';
                                                                } elseif (strtolower($realKabalSt) == 'ditolak') {
                                                                    $status = 'Ditolak Kepala Balai';
                                                                    $statusClass = 'text-red-700 bg-red-50 border-red-200';
                                                                    $dotColor = 'bg-red-500';
                                                                } else {
                                                                    $status = 'Menunggu Kepala Balai';
                                                                    $statusClass = 'text-amber-700 bg-amber-50 border-amber-200';
                                                                    $dotColor = 'bg-amber-400';
                                                                }
                                                            }
                                                        } else {
                                                            $status = 'Menunggu Kepala Bagian';
                                                            $statusClass = 'text-amber-700 bg-amber-50 border-amber-200';
                                                            $dotColor = 'bg-amber-400';
                                                        }
                                                    }
                                                } else {
                                                    $status = 'Menunggu Admin';
                                                    $statusClass = 'text-amber-700 bg-amber-50 border-amber-200';
                                                    $dotColor = 'bg-amber-400';
                                                }
                                            }
                                        @endphp
                                        <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClass }} border inline-flex items-center gap-1.5 shadow-xs">
                                            <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                                            <span>{{ $status }}</span>
                                        </span>
                                    </td>
                                    <td class="py-4 px-3 text-gray-600 max-w-xs text-left text-xs">
                                        @php
                                            $catatanAdmin = optional($cuti->ctStatusUserAdmin)->catatan ?? null;
                                            $catatanKabag = optional(optional($cuti->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag->catatan ?? null;
                                            $catatanKabal = optional(optional(optional($cuti->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag)->ctStatusKabagKabal->catatan ?? null;

                                            $catatan = [];
                                            if ($catatanAdmin) $catatan[] = "<div class='mb-1'><span class='font-semibold text-blue-600'>Admin:</span> {$catatanAdmin}</div>";
                                            if ($catatanKabag) $catatan[] = "<div class='mb-1'><span class='font-semibold text-orange-600'>Kabag:</span> {$catatanKabag}</div>";
                                            if ($catatanKabal) $catatan[] = "<div class='mb-1'><span class='font-semibold text-green-600'>Kepala Balai:</span> {$catatanKabal}</div>";
                                        @endphp

                                        @if (count($catatan) > 0)
                                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-200">
                                                {!! implode('', $catatan) !!}
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada catatan</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-2 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('katimkerpengajuancutitahunan.show', $cuti->id) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors duration-150 border border-emerald-200 shadow-xs"
                                                title="Detail">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>

                                            {{-- Tombol Download PDF --}}
                                            @if ($isApprovedByKabal)
                                                <a href="{{ route('viewPDF', ['id' => $cuti->id]) }}" target="_blank"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors duration-150 border border-emerald-200 relative pdf-download-link shadow-xs"
                                                    data-cuti-id="{{ $cuti->id }}"
                                                    onclick="markAsDownloaded({{ $cuti->id }})" title="Download PDF">
                                                    <i class="fas fa-file-pdf text-xs"></i>
                                                    <span id="dot-{{ $cuti->id }}"
                                                        class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 top-0.5 right-0.5"></span>
                                                </a>
                                            @endif

                                            {{-- Tombol Batalkan via Modal --}}
                                            @if (!$isCanceled && !$isApprovedByKabal)
                                                <button type="button"
                                                    onclick="openCancelModal('{{ route('katimkerpengajuancutitahunan.cancel', $cuti->id) }}', '{{ $cuti->id }}')"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 transition-colors duration-150 border border-rose-200 shadow-xs"
                                                    title="Batalkan Pengajuan">
                                                    <i class="fas fa-ban text-xs"></i>
                                                </button>
                                            @else
                                                <button disabled
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-300 cursor-not-allowed border border-gray-200"
                                                    title="Tidak dapat dibatalkan">
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
            @else
                <!-- No Leave Applications State -->
                <div
                    class="text-center p-8 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 shadow-sm">
                    <div
                        class="mx-auto w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-blue-700 mb-2">Belum Ada Pengajuan Cuti</h3>
                    <p class="text-blue-600 mb-4">Silakan klik tombol "Buat Form Cuti Baru" untuk membuat pengajuan baru.</p>
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

        // Fungsi Modal Pembatalan
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

        window.addEventListener('click', function(e) {
            const modal = document.getElementById('cancelModal');
            if (e.target === modal) {
                closeCancelModal();
            }
        });

        // Fungsi Unduhan & Notifikasi
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