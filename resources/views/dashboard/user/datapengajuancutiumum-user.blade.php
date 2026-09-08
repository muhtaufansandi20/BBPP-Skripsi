@extends('dashboard.user.base-user')

@section('main')
    <div class="px-6 pt-0 pb-6 bg-gray-50 min-h-screen">

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-center">
                <div class="mr-4 p-2 rounded-full bg-green-100 text-green-600"><i class="fas fa-check-circle"></i></div>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 shadow-sm flex items-center">
                <div class="mr-4 p-2 rounded-full bg-red-100 text-red-600"><i class="fas fa-exclamation-circle"></i></div>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        @endif
        @if (session('info'))
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 shadow-sm flex items-center">
                <div class="mr-4 p-2 rounded-full bg-blue-100 text-blue-600"><i class="fas fa-info-circle"></i></div>
                <p class="text-blue-700 font-medium">{{ session('info') }}</p>
            </div>
        @endif

        @if (!$hasWorkPeriod)
            <div class="text-center p-8 rounded-xl bg-orange-50 border border-orange-200 shadow-sm">
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
        @elseif(!$hasTeam)
            <div class="text-center p-8 rounded-xl bg-blue-50 border border-blue-200 shadow-sm">
                <div class="mx-auto w-16 h-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-blue-700 mb-2">Anda Belum Memiliki Tim Kerja</h3>
                <p class="text-blue-600 mb-4">Silakan hubungi administrator untuk ditambahkan ke tim kerja.</p>
                @if (isset($admin) && !empty($admin->no_hp))
                    @php
                        $whatsappNumber = '62' . ltrim(preg_replace('/[^0-9]/', '', $admin->no_hp), '0');
                        $teamMessage = urlencode(
                            "*[SIBACO System Notification]* 📱\n*Assalamualaikum Admin,*\n\nSaya atas nama:\n✅ *{$user->name}*\n✅ *NIP: {$user->nip}*\n\nBelum memiliki tim kerja. Mohon bantuan untuk menambahkan saya ke tim kerja.\n\nTerima kasih 🙏",
                        );
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $teamMessage }}" target="_blank"
                        class="inline-flex items-center px-5 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.479 5.093 1.479h.005c5.451 0 9.888-4.434 9.891-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.888-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        Hubungi Admin via WhatsApp
                    </a>
                @endif
            </div>
        @else
            @php
                $hasApprovedDocs =
                    $pengajuans
                        ->where(function ($p) {
                            return $p->cuStatusUserAdmin &&
                                $p->cuStatusUserAdmin->cuStatusAdminKatimker &&
                                $p->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag &&
                                $p->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                    ->cuStatusKabagKabal &&
                                $p->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal
                                    ->status == 'disetujui';
                        })
                        ->count() > 0;
            @endphp

            <!-- Notification -->
            @if ($hasApprovedDocs)
                <div id="pdf-notification"
                    class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-full bg-green-100 text-green-600"><i class="fas fa-bell"></i></div>
                        <div>
                            <h3 class="font-bold text-green-800 text-sm">Dokumen Cuti Disetujui!</h3>
                            <p class="text-sm text-green-700">Anda memiliki dokumen cuti yang telah disetujui. Silakan unduh
                                dengan mengklik ikon <i class="fas fa-file-pdf mx-1"></i> pada tabel.</p>
                        </div>
                    </div>
                    <button onclick="closeNotification()"
                        class="text-green-600 hover:text-green-800 p-2 rounded-full hover:bg-green-200 transition-colors flex-shrink-0">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4 pt-2">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Pengajuan Cuti Umum</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Pegawai</p>
                </div>
                <a href="{{ route('userpengajuancutiumum.create') }}"
                    class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-lime-500 text-white font-semibold rounded-lg hover:from-green-600 hover:to-lime-600 transition-all duration-200 shadow-sm text-sm">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Form Cuti Baru</span>
                </a>
            </div>

            @if (count($pengajuans) > 0)
                <div class="w-full rounded-xl shadow-md border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto bg-white">
                            <thead>
                                <tr class="bg-gradient-to-r from-green-500 to-lime-500 text-white text-sm">
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        NO</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        TANGGAL PENGAJUAN</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        JENIS CUTI</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        PERIODE CUTI</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        LAMA CUTI</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        STATUS</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        CATATAN</th>
                                    <th
                                        class="py-3.5 px-4 font-semibold uppercase tracking-wider text-center whitespace-nowrap">
                                        AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach ($pengajuans as $index => $cuti)
                                    @php
                                        $isApprovedByKabal =
                                            $cuti->cuStatusUserAdmin &&
                                            $cuti->cuStatusUserAdmin->cuStatusAdminKatimker &&
                                            $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag &&
                                            $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                                ->cuStatusKabagKabal &&
                                            $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag
                                                ->cuStatusKabagKabal->status == 'disetujui';

                                        $isCanceled =
                                            $cuti->statusCutiUmum && $cuti->statusCutiUmum->status == 'dibatalkan';

                                        $status = 'Menunggu Verifikasi Admin';
                                        $statusClass = '';
                                        $statusStyle = 'background-color:#FEF9C3; color:#92700A;';
                                        $icon = 'fas fa-hourglass-half';

                                        $yellowBadge = [
                                            'class' => '',
                                            'style' => 'background-color:#FEF9C3; color:#92700A;',
                                        ];
                                        $redBadge = ['class' => 'text-red-600 bg-red-100', 'style' => ''];
                                        $greenBadge = ['class' => 'text-green-600 bg-green-100', 'style' => ''];

                                        if ($isCanceled) {
                                            $status = 'Dibatalkan oleh Anda';
                                            ['class' => $statusClass, 'style' => $statusStyle] = $redBadge;
                                            $icon = 'fas fa-ban';
                                        } elseif ($cuti->cuStatusUserAdmin) {
                                            $adminStatus = $cuti->cuStatusUserAdmin->status ?? '';

                                            if ($adminStatus == 'ditolak') {
                                                $status = 'Ditolak Admin';
                                                ['class' => $statusClass, 'style' => $statusStyle] = $redBadge;
                                                $icon = 'fas fa-times-circle';
                                            } elseif ($adminStatus == 'disetujui') {
                                                $status = 'Menunggu Kepala Tim';
                                                ['class' => $statusClass, 'style' => $statusStyle] = $yellowBadge;
                                                $icon = 'fas fa-hourglass-half';

                                                $katimker = $cuti->cuStatusUserAdmin->cuStatusAdminKatimker;
                                                if ($katimker) {
                                                    $katimkerStatus = $katimker->status ?? '';

                                                    if ($katimkerStatus == 'ditolak') {
                                                        $status = 'Ditolak Kepala Tim';
                                                        ['class' => $statusClass, 'style' => $statusStyle] = $redBadge;
                                                        $icon = 'fas fa-times-circle';
                                                    } elseif ($katimkerStatus == 'disetujui') {
                                                        $status = 'Menunggu Kabag Umum';
                                                        [
                                                            'class' => $statusClass,
                                                            'style' => $statusStyle,
                                                        ] = $yellowBadge;
                                                        $icon = 'fas fa-hourglass-half';

                                                        $kabag = $katimker->cuStatusKatimkerKabag;
                                                        if ($kabag) {
                                                            $kabagStatus = $kabag->status ?? '';

                                                            if ($kabagStatus == 'ditolak') {
                                                                $status = 'Ditolak Kabag';
                                                                [
                                                                    'class' => $statusClass,
                                                                    'style' => $statusStyle,
                                                                ] = $redBadge;
                                                                $icon = 'fas fa-times-circle';
                                                            } elseif ($kabagStatus == 'disetujui') {
                                                                $status = 'Menunggu Kepala Balai';
                                                                [
                                                                    'class' => $statusClass,
                                                                    'style' => $statusStyle,
                                                                ] = $yellowBadge;
                                                                $icon = 'fas fa-hourglass-half';

                                                                $kabal = $kabag->cuStatusKabagKabal;
                                                                if ($kabal) {
                                                                    if ($kabal->status == 'ditolak') {
                                                                        $status = 'Ditolak Kepala Balai';
                                                                        [
                                                                            'class' => $statusClass,
                                                                            'style' => $statusStyle,
                                                                        ] = $redBadge;
                                                                        $icon = 'fas fa-times-circle';
                                                                    } elseif ($kabal->status == 'disetujui') {
                                                                        $status = 'Disetujui';
                                                                        [
                                                                            'class' => $statusClass,
                                                                            'style' => $statusStyle,
                                                                        ] = $greenBadge;
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
                                    <tr class="hover:bg-green-50 transition-colors duration-150 text-center">

                                        {{-- NO --}}
                                        <td class="py-4 px-4 whitespace-nowrap text-gray-700 font-medium">
                                            {{ $pengajuans->firstItem() + $index }}
                                        </td>

                                        {{-- TANGGAL PENGAJUAN --}}
                                        <td class="py-4 px-4 whitespace-nowrap text-gray-700">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <i class="far fa-calendar-alt text-green-500"></i>
                                                <span>{{ date('d/m/Y', strtotime($cuti->tgl_pengajuan)) }}</span>
                                            </div>
                                        </td>

                                        {{-- JENIS CUTI --}}
                                        <td class="py-4 px-4 whitespace-nowrap text-gray-700 font-medium">
                                            {{ $cuti->jenisCuti->nama_cuti }}
                                        </td>

                                        {{-- PERIODE CUTI --}}
                                        <td class="py-4 px-4 whitespace-nowrap text-gray-700">
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="flex items-center gap-1.5">
                                                    <i class="far fa-play-circle text-green-500 text-xs"></i>
                                                    {{ date('d/m/Y', strtotime($cuti->tgl_mulai)) }}
                                                </span>
                                                <span class="text-gray-300 text-xs">—</span>
                                                <span class="flex items-center gap-1.5">
                                                    <i class="far fa-stop-circle text-red-400 text-xs"></i>
                                                    {{ date('d/m/Y', strtotime($cuti->tgl_selesai)) }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- LAMA CUTI --}}
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 font-semibold text-xs inline-flex items-center gap-1.5">
                                                <i class="fas fa-clock"></i>
                                                {{ $cuti->jumlah_hari }}
                                                {{ in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']) ? 'Bulan' : 'Hari' }}
                                            </span>
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClass }} inline-flex items-center gap-1.5"
                                                @if ($statusStyle) style="{{ $statusStyle }}" @endif>
                                                <i class="{{ $icon }}"></i>
                                                {{ $status }}
                                            </span>
                                        </td>

                                        {{-- CATATAN --}}
                                        <td class="py-4 px-4 text-gray-700 max-w-xs">
                                            @php
                                                $catatanAdmin = optional($cuti->cuStatusUserAdmin)->catatan ?? null;
                                                $catatanKatimker =
                                                    optional($cuti->cuStatusUserAdmin)->cuStatusAdminKatimker
                                                        ->catatan ?? null;
                                                $catatanKabag =
                                                    optional(optional($cuti->cuStatusUserAdmin)->cuStatusAdminKatimker)
                                                        ->cuStatusKatimkerKabag->catatan ?? null;
                                                $catatanKabal =
                                                    optional(
                                                        optional(
                                                            optional($cuti->cuStatusUserAdmin)->cuStatusAdminKatimker,
                                                        )->cuStatusKatimkerKabag,
                                                    )->cuStatusKabagKabal->catatan ?? null;

                                                $catatan = [];
                                                if ($catatanAdmin) {
                                                    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-blue-600 text-xs'>Admin:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanAdmin}</p></div>";
                                                }
                                                if ($catatanKatimker) {
                                                    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-yellow-600 text-xs'>Katimker:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanKatimker}</p></div>";
                                                }
                                                if ($catatanKabag) {
                                                    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-orange-600 text-xs'>Kabag:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanKabag}</p></div>";
                                                }
                                                if ($catatanKabal) {
                                                    $catatan[] = "<div class='mb-1.5'><span class='font-semibold text-green-600 text-xs'>Kepala Balai:</span><p class='text-xs text-gray-600 mt-0.5 pl-3'>{$catatanKabal}</p></div>";
                                                }
                                            @endphp
                                            @if (count($catatan) > 0)
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

                                                <a href="{{ route('userpengajuancutiumum.show', $cuti->id) }}"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-green-50 text-green-600 hover:bg-green-500 hover:text-white transition-colors duration-150 border border-green-200"
                                                    title="Detail">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </a>

                                                @if ($isApprovedByKabal)
                                                    <a href="{{ route('viewPDFUmum', ['id' => $cuti->id]) }}"
                                                        target="_blank"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-colors duration-150 border border-emerald-200 relative pdf-download-link"
                                                        data-cuti-id="{{ $cuti->id }}"
                                                        onclick="markAsDownloaded({{ $cuti->id }})"
                                                        title="Download PDF">
                                                        <i class="fas fa-file-pdf text-xs"></i>
                                                        <span id="dot-{{ $cuti->id }}"
                                                            class="notification-dot animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-500 opacity-75 top-0.5 right-0.5"></span>
                                                    </a>
                                                @endif

                                                {{-- Tombol Batal Memanggil Modal Konfirmasi --}}
                                                @if (!$isCanceled)
                                                    <button type="button"
                                                        onclick="openCancelModal('{{ route('userpengajuancutiumum.cancel', $cuti->id) }}')"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors duration-150 border border-red-200"
                                                        title="Batalkan Cuti">
                                                        <i class="fas fa-ban text-xs"></i>
                                                    </button>
                                                @else
                                                    <button disabled
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-gray-100 text-gray-300 cursor-not-allowed border border-gray-200"
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
                </div>

                <div class="flex justify-center mt-6">
                    {{ $pengajuans->links() }}
                </div>
            @else
                <div class="text-center p-10 rounded-xl bg-white border border-gray-200 shadow-sm">
                    <div
                        class="mx-auto w-16 h-16 rounded-full bg-green-100 text-green-500 flex items-center justify-center mb-4">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Pengajuan Cuti</h3>
                    <p class="text-gray-500 mb-4 text-sm">Silakan klik tombol "Buat Form Cuti Baru" untuk membuat
                        pengajuan.</p>
                </div>
            @endif
        @endif
    </div>

    <!-- Modal Konfirmasi Pembatalan -->
    <div id="cancelModal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 mx-auto flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Batalkan Pengajuan?</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin membatalkan pengajuan cuti ini? Tindakan ini tidak dapat diurungkan.</p>
                
                <form id="cancelForm" method="POST" action="">
                    @csrf
                    <div class="flex gap-3">
                        <button type="button" onclick="closeCancelModal()" class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl font-bold text-sm transition-all">
                            Tutup
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-bold text-sm transition-all shadow-lg shadow-red-500/30">
                            Ya, Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            checkDownloadedDocuments();
            updateNotificationVisibility();
        });

        // Fungsi Modal Konfirmasi Batal
        function openCancelModal(actionUrl) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            
            // Set URL tujuan pembatalan secara dinamis berdasarkan baris yang diklik
            form.action = actionUrl;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function markAsDownloaded(cutiId) {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumDocs')) || [];
            if (!downloadedDocs.includes(cutiId)) {
                downloadedDocs.push(cutiId);
                localStorage.setItem('downloadedCutiUmumDocs', JSON.stringify(downloadedDocs));
            }
            const dot = document.getElementById('dot-' + cutiId);
            if (dot) dot.style.display = 'none';
            setTimeout(updateNotificationVisibility, 500);
        }

        function checkDownloadedDocuments() {
            let downloadedDocs = JSON.parse(localStorage.getItem('downloadedCutiUmumDocs')) || [];
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