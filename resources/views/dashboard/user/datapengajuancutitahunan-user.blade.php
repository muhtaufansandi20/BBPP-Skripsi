@extends('dashboard.user.base-user')

@section('main')
<div class="px-6 pt-0 pb-6 bg-gray-50 min-h-screen">
    @if (!$hasWorkPeriod)
        <!-- No Work Period State -->
        <div class="text-center p-8 rounded-xl bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 shadow-sm">
            <div class="mx-auto w-16 h-16 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
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
        <div class="text-center p-8 rounded-xl bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 shadow-sm">
            <div class="mx-auto w-16 h-16 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mb-4">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-orange-700 mb-2">Kuota Cuti Belum Diverifikasi</h3>
            <p class="text-orange-600 mb-4">Silakan hubungi administrator untuk memverifikasi kuota cuti tahunan Anda.</p>
            @if(isset($admin) && !empty($admin->no_hp))
                @php
                    $whatsappNumber = '62' . ltrim(preg_replace('/[^0-9]/', '', $admin->no_hp), '0');
                    $quotaMessage = urlencode("*[SIBACO System Notification]* 📱\n*Assalamualaikum Admin,*\n\nSaya atas nama:\n✅ *{$user->name}*\n✅ *NIP: {$user->nip}*\n\nIngin memverifikasi kuota cuti tahunan saya.\n\nTerima kasih 🙏");
                @endphp
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $quotaMessage }}" 
                   target="_blank" 
                   class="inline-flex items-center px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479h.005c5.451 0 9.888-4.434 9.891-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.888-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hubungi Admin via WhatsApp
                </a>
            @endif
        </div>
    @elseif ($hasTeam !== true)
        <!-- No Team State -->
        <div class="text-center p-8 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 shadow-sm">
            <div class="mx-auto w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-blue-700 mb-2">Anda Belum Memiliki Tim Kerja</h3>
            <p class="text-blue-600 mb-4">Silakan hubungi administrator untuk ditambahkan ke tim kerja.</p>
            @if(isset($admin) && !empty($admin->no_hp))
                @php
                    $whatsappNumber = '62' . ltrim(preg_replace('/[^0-9]/', '', $admin->no_hp), '0');
                    $teamMessage = urlencode("*[SIBACO System Notification]* 📱\n*Assalamualaikum Admin,*\n\nSaya atas nama:\n✅ *{$user->name}*\n✅ *NIP: {$user->nip}*\n\nBelum memiliki tim kerja. Mohon bantuan untuk menambahkan saya ke tim kerja.\n\nTerima kasih 🙏");
                @endphp
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $teamMessage }}" 
                   target="_blank" 
                   class="inline-flex items-center px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479h.005c5.451 0 9.888-4.434 9.891-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.888-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Hubungi Admin via WhatsApp
                </a>
            @endif
        </div>
    @else
        <!-- Main Content -->
        @php
            $hasApprovedDocs = $pengajuancutitahunan->where(function($query) {
                return $query->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', function($q) {
                    $q->whereRaw('LOWER(status) = ?', ['disetujui']);
                });
            })->count() > 0;
        @endphp

        <!-- Notification Section -->
        <div id="notification-container">
            @if ($hasApprovedDocs)
                <div id="pdf-notification" class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-green-800 text-sm">Dokumen Cuti Disetujui!</h3>
                            <p class="text-sm text-green-700">Anda memiliki dokumen cuti yang telah disetujui. Silakan unduh dengan mengklik ikon <i class="fas fa-file-pdf text-green-600 mx-1"></i> pada tabel.</p>
                        </div>
                    </div>
                    <button onclick="closeNotification()" class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-200 transition-colors flex-shrink-0">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 pt-2">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Pengajuan Cuti Tahunan</h2>
                <p class="text-sm text-gray-500 mt-0.5">Pegawai</p>
            </div>
            <a href="{{ route('userpengajuancutitahunan.create') }}" 
               class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold rounded-lg hover:from-green-600 hover:to-lime-600 transition-all duration-200 shadow-sm text-sm">
                <i class="fas fa-plus-circle"></i>
                <span>Buat Form Cuti Baru</span>
            </a>
        </div>

        @if (count($pengajuancutitahunan) > 0)
            <div class="w-full rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto bg-white">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-500 to-lime-500 text-white text-sm">
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">NO</th>
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">TANGGAL PENGAJUAN</th>
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">PERIODE CUTI</th>
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">LAMA CUTI</th>
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">STATUS</th>
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">CATATAN</th>
                                <th class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach ($pengajuancutitahunan as $index => $cuti)
                            @php
                                $kabalStatus = strtolower($cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal->status ?? '');
                                $isApprovedByKabal = ($kabalStatus === 'disetujui');
                                
                                $isCanceled = (isset($cuti->statusCutiTahunan) && strtolower($cuti->statusCutiTahunan->status) === 'dibatalkan')
                                           || (isset($cuti->status) && strtolower($cuti->status) === 'dibatalkan');
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-150 text-center" data-row-id="{{ $cuti->id }}">

                                {{-- NO --}}
                                <td class="py-4 px-4 whitespace-nowrap text-gray-700 font-medium">
                                    {{ $index + 1 }}
                                </td>

                                {{-- TANGGAL PENGAJUAN --}}
                                <td class="py-4 px-4 whitespace-nowrap text-gray-700">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <i class="far fa-calendar-alt text-green-500"></i>
                                        <span>{{ date('d/m/Y', strtotime($cuti->tgl_pengajuan)) }}</span>
                                    </div>
                                </td>

                                {{-- PERIODE CUTI --}}
                                <td class="py-4 px-4 whitespace-nowrap text-gray-700">
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="flex items-center gap-1.5">
                                            <i class="far fa-play-circle text-green-500 text-xs"></i>
                                            <span>{{ date('d/m/Y', strtotime($cuti->tgl_mulai)) }}</span>
                                        </span>
                                        <span class="text-gray-300 text-xs">—</span>
                                        <span class="flex items-center gap-1.5">
                                            <i class="far fa-stop-circle text-red-400 text-xs"></i>
                                            <span>{{ date('d/m/Y', strtotime($cuti->tgl_selesai)) }}</span>
                                        </span>
                                    </div>
                                </td>

                                {{-- LAMA CUTI --}}
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 font-semibold text-xs inline-flex items-center gap-1.5">
                                        <i class="fas fa-clock"></i>
                                        {{ $cuti->lama_cuti }} Hari
                                    </span>
                                </td>

                                {{-- STATUS --}}
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @php
                                        $status = 'Menunggu Verifikasi Admin';
                                        $statusClass = 'text-amber-600 bg-amber-100';
                                        $icon = 'fas fa-hourglass-half';

                                        if ($isCanceled) {
                                            $status = 'Dibatalkan';
                                            $statusClass = 'text-red-600 bg-red-100';
                                            $icon = 'fas fa-ban';
                                        } elseif ($cuti->ctStatusUserAdmin) {
                                            $adminStatus = strtolower($cuti->ctStatusUserAdmin->status ?? '');

                                            if ($adminStatus === 'ditolak') {
                                                $status = 'Ditolak Admin';
                                                $statusClass = 'text-red-600 bg-red-100';
                                                $icon = 'fas fa-times-circle';
                                            } elseif ($adminStatus === 'disetujui') {
                                                $status = 'Menunggu Kepala Tim';
                                                $statusClass = 'text-amber-600 bg-amber-100';
                                                $icon = 'fas fa-hourglass-half';

                                                $katimker = $cuti->ctStatusUserAdmin->ctStatusAdminKatimker;
                                                if ($katimker) {
                                                    $katimkerStatus = strtolower($katimker->status ?? '');

                                                    if ($katimkerStatus === 'ditolak') {
                                                        $status = 'Ditolak Kepala Tim';
                                                        $statusClass = 'text-red-600 bg-red-100';
                                                        $icon = 'fas fa-times-circle';
                                                    } elseif ($katimkerStatus === 'disetujui') {
                                                        $status = 'Menunggu Kabag Umum';
                                                        $statusClass = 'text-amber-600 bg-amber-100';
                                                        $icon = 'fas fa-hourglass-half';

                                                        $kabag = $katimker->ctStatusKatimkerKabag;
                                                        if ($kabag) {
                                                            $kabagStatus = strtolower($kabag->status ?? '');

                                                            if ($kabagStatus === 'ditolak') {
                                                                $status = 'Ditolak Kabag';
                                                                $statusClass = 'text-red-600 bg-red-100';
                                                                $icon = 'fas fa-times-circle';
                                                            } elseif ($kabagStatus === 'disetujui') {
                                                                $status = 'Menunggu Kepala Balai';
                                                                $statusClass = 'text-amber-600 bg-amber-100';
                                                                $icon = 'fas fa-hourglass-half';

                                                                $kabal = $kabag->ctStatusKabagKabal;
                                                                if ($kabal) {
                                                                    $kabalStatusVal = strtolower($kabal->status ?? '');
                                                                    if ($kabalStatusVal === 'ditolak') {
                                                                        $status = 'Ditolak Kepala Balai';
                                                                        $statusClass = 'text-red-600 bg-red-100';
                                                                        $icon = 'fas fa-times-circle';
                                                                    } elseif ($kabalStatusVal === 'disetujui') {
                                                                        $status = 'Disetujui';
                                                                        $statusClass = 'text-green-600 bg-green-100';
                                                                        $icon = 'fas fa-check-circle';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClass }} inline-flex items-center gap-1.5">
                                        <i class="{{ $icon }}"></i>
                                        {{ $status }}
                                    </span>
                                </td>

                                {{-- CATATAN --}}
                                <td class="py-4 px-4 text-gray-700 max-w-xs">
                                    @php
                                        $catatanAdmin    = optional($cuti->ctStatusUserAdmin)->catatan ?? null;
                                        $catatanKatimker = optional($cuti->ctStatusUserAdmin)->ctStatusAdminKatimker->catatan ?? null;
                                        $catatanKabag    = optional(optional($cuti->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag->catatan ?? null;
                                        $catatanKabal    = optional(optional(optional($cuti->ctStatusUserAdmin)->ctStatusAdminKatimker)->ctStatusKatimkerKabag)->ctStatusKabagKabal->catatan ?? null;

                                        $catatan = [];
                                        if ($catatanAdmin)    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-blue-600 text-xs'>Admin:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanAdmin}</p></div>";
                                        if ($catatanKatimker) $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-yellow-600 text-xs'>Katimker:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanKatimker}</p></div>";
                                        if ($catatanKabag)    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-orange-600 text-xs'>Kabag:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanKabag}</p></div>";
                                        if ($catatanKabal)    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-green-600 text-xs'>Kepala Balai:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanKabal}</p></div>";
                                    @endphp

                                    @if(count($catatan) > 0)
                                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-left">
                                            {!! implode('', $catatan) !!}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Tidak ada catatan</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1.5">

                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('userpengajuancutitahunan.show', $cuti->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-green-50 text-green-600 hover:bg-green-500 hover:text-white transition-colors duration-150 border border-green-200" 
                                           title="Detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>

                                        {{-- Tombol Download PDF --}}
                                        @if ($isApprovedByKabal)
                                        <a href="{{ route('viewPDF', ['id' => $cuti->id]) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-colors duration-150 border border-emerald-200 relative pdf-download-link" 
                                           data-cuti-id="{{ $cuti->id }}" 
                                           onclick="markAsDownloaded({{ $cuti->id }})" 
                                           title="Download PDF">
                                            <i class="fas fa-file-pdf text-xs"></i>
                                            <span id="dot-{{ $cuti->id }}" class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 top-0.5 right-0.5"></span>
                                        </a>
                                        @endif

                                        {{-- Tombol Batalkan (Bisa dibatalkan selama belum berstatus dibatalkan) --}}
                                        @if(!$isCanceled)
                                            <button type="button" 
                                                    onclick="openCancelModal('{{ route('userpengajuancutitahunan.cancel', $cuti->id) }}', '{{ $cuti->id }}')" 
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors duration-150 border border-red-200" 
                                                    title="Batalkan Pengajuan">
                                                <i class="fas fa-ban text-xs"></i>
                                            </button>
                                        @else
                                            <button disabled 
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-gray-100 text-gray-300 cursor-not-allowed border border-gray-200" 
                                                    title="Pengajuan telah dibatalkan">
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
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center p-10 rounded-xl bg-white border border-gray-200 shadow-sm">
                <div class="mx-auto w-16 h-16 rounded-full bg-green-100 text-green-500 flex items-center justify-center mb-4">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Pengajuan Cuti</h3>
                <p class="text-gray-500 mb-4 text-sm">Silakan klik tombol "Buat Form Cuti Baru" untuk membuat pengajuan.</p>
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

    // Menutup modal jika klik di latar belakang abu-abu
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('cancelModal');
        if (e.target === modal) {
            closeCancelModal();
        }
    });

    // Fungsi Pengunduhan & Notifikasi
    function markAsDownloaded(cutiId) {
        let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiDocs')) || [];
        if (!downloadedDocs.includes(cutiId)) {
            downloadedDocs.push(cutiId);
            localStorage.setItem('downloadedCutiDocs', JSON.stringify(downloadedDocs));
        }
        const dot = document.getElementById('dot-' + cutiId);
        if (dot) dot.style.display = 'none';
        setTimeout(updateNotificationVisibility, 500);
    }

    function checkDownloadedDocuments() {
        let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiDocs')) || [];
        downloadedDocs.forEach(cutiId => {
            const dot = document.getElementById('dot-' + cutiId);
            if (dot) dot.style.display = 'none';
        });
    }

    function updateNotificationVisibility() {
        const notification = document.getElementById('pdf-notification');
        if (!notification) return;
        const visibleDots = document.querySelectorAll('.notification-dot:not([style*="display: none"])');
        if (visibleDots.length === 0) notification.style.display = 'none';
    }

    function closeNotification() {
        const notification = document.getElementById('pdf-notification');
        if (notification) notification.style.display = 'none';
    }
</script>
@endsection