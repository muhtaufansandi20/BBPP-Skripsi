@extends('dashboard.kepalabagian.base-kepalabagian')

@section('content')
    <div class="max-w-6xl mx-auto p-6 pt-0">
        <!-- Header with Gradient Text -->
        <div class="flex items-center gap-4 mb-6 group">
            <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-accent/90 to-primary/90 shadow-lg group-hover:from-accent/100 group-hover:to-primary/100 transition-all duration-300 ring-2 ring-white/20 ring-inset hover:ring-accent/40 hover:scale-105">
                <i class="fas fa-file-alt text-lg text-white"></i>
            </div>
            <div class="w-full">
                <h2 class="text-xl sm:text-2xl font-bold bg-clip-text text-gray-900">
                    Detail Pengajuan Cuti Umum
                </h2>
                <div class="relative mt-2">
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-accent/80 to-primary/80 rounded-full w-0 group-hover:w-full transition-all duration-500 ease-out"></div>
                    <div class="h-0.5 bg-gray-200 dark:bg-gray-700 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Biodata Pegawai Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
            <div class="py-3 px-6 bg-gradient-to-r from-accent/90 to-accent/60 border-b border-gray-100">
                <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                    <i class="fas fa-user-circle"></i>
                    <span class="font-semibold bg-clip-text">BIODATA PEGAWAI</span>
                </h5>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->name }}" readonly>
                        <i class="fas fa-user absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">NIP</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->nip }}" readonly>
                        <i class="fas fa-id-card absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->jabatan }}" readonly>
                        <i class="fas fa-briefcase absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Masa Kerja</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->masa_kerja }}" readonly>
                        <i class="fas fa-clock absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">No HP</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->no_hp }}" readonly>
                        <i class="fas fa-phone-alt absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pengajuan Cuti Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
            <div class="px-6 py-3 bg-gradient-to-r from-primary/90 to-primary/60 border-b border-gray-100">
                <h5 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fas fa-file-alt text-white"></i>
                    <span class="font-semibold bg-clip-text text-white">DETAIL PENGAJUAN CUTI</span>
                </h5>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Jenis Cuti</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->nama_cuti }}" readonly>
                        <i class="fas fa-calendar-alt absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->tgl_pengajuan }}" readonly>
                        <i class="fas fa-calendar-alt absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="md:col-span-2 space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Cuti</label>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="relative flex-1">
                            <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->tgl_mulai }}" readonly>
                            <i class="fas fa-calendar-day absolute right-3 top-3.5 text-gray-400 hidden sm:block"></i>
                        </div>
                        <span class="text-gray-500 font-medium">s/d</span>
                        <div class="relative flex-1">
                            <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->tgl_selesai }}" readonly>
                            <i class="fas fa-calendar-day absolute right-3 top-3.5 text-gray-400 hidden sm:block"></i>
                        </div>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Lama Cuti</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->jumlah_hari }} hari" readonly>
                        <i class="fas fa-clock absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">No HP Saat Cuti</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-primary/50" value="{{ $custatusadminkatimker->no_hp_cuti }}" readonly>
                        <i class="fas fa-mobile-alt absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="md:col-span-2 space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Alasan Melakukan Cuti</label>
                    <div class="relative">
                        <textarea class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 min-h-[100px] focus:ring-2 focus:ring-primary/50" readonly>{{ $custatusadminkatimker->alasan }}</textarea>
                        <i class="fas fa-comment-dots absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
                <div class="md:col-span-2 space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Alamat Saat Cuti</label>
                    <div class="relative">
                        <textarea class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 min-h-[100px] focus:ring-2 focus:ring-primary/50" readonly>{{ $custatusadminkatimker->alamat_saat_cuti }}</textarea>
                        <i class="fas fa-map-marker-alt absolute right-3 top-3.5 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lampiran Dokumen -->
        @if (isset($lampiran))
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
                <div class="px-6 py-3 bg-gradient-to-r from-indigo-500/90 to-indigo-600/60 border-b border-gray-100">
                    <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                        <i class="fas fa-paperclip"></i>
                        <span class="font-semibold bg-clip-text">LAMPIRAN DOKUMEN</span>
                    </h5>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-2">
                                <p class="text-sm font-medium text-gray-700">Nama Dokumen</p>
                                <p class="p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $lampiran->nama_doc }}</p>
                            </div>
                            <div class="space-y-2 mt-4">
                                <p class="text-sm font-medium text-gray-700">Diunggah pada</p>
                                <p class="p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $lampiran->uploaded_at }}</p>
                            </div>
                            @if ($lampiran->description)
                                <div class="space-y-2 mt-4">
                                    <p class="text-sm font-medium text-gray-700">Deskripsi</p>
                                    <p class="p-3 bg-gray-50 rounded-lg border border-gray-200">{{ $lampiran->description }}</p>
                                </div>
                            @endif
                            <div class="mt-6 flex flex-wrap gap-3">
                                <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center gap-2 transition-colors">
                                    <i class="fas fa-download"></i> Unduh Lampiran
                                </a>
                                <button type="button" onclick="openPreviewPanel()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center gap-2 transition-colors">
                                    <i class="fas fa-eye"></i> Lihat Dokumen
                                </button>
                            </div>
                        </div>
                        <div>
                            <!-- Thumbnail Preview -->
                            <div class="border-2 border-dashed border-gray-200 rounded-xl overflow-hidden h-64 cursor-pointer hover:border-indigo-300 transition-colors" onclick="openPreviewPanel()">
                                @php
                                    $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
                                    $fileUrl = Storage::url($lampiran->file_path);
                                @endphp
                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <div class="relative h-full bg-gray-100 flex items-center justify-center">
                                        <img src="{{ $fileUrl }}" alt="Preview" class="max-w-full max-h-full object-contain">
                                        <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                            <span class="text-white font-medium px-4 py-2 bg-black bg-opacity-60 rounded-lg flex items-center gap-2">
                                                <i class="fas fa-expand"></i> Klik untuk memperbesar
                                            </span>
                                        </div>
                                    </div>
                                @elseif(strtolower($fileExtension) == 'pdf')
                                    <div class="h-full w-full bg-gray-100 flex flex-col items-center justify-center hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-file-pdf text-red-500 text-5xl mb-3"></i>
                                        <p class="text-gray-700 font-medium">Dokumen PDF</p>
                                        <p class="text-gray-500 text-sm mt-1">Klik untuk melihat preview</p>
                                    </div>
                                @else
                                    <div class="h-full w-full bg-gray-100 flex flex-col items-center justify-center hover:bg-gray-200 transition-colors">
                                        <i class="fas fa-file text-blue-500 text-5xl mb-3"></i>
                                        <p class="text-gray-700 font-medium">File {{ strtoupper($fileExtension) }}</p>
                                        <p class="text-gray-500 text-sm mt-1">Klik untuk melihat</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- VERIFIKASI ATASAN (Admin -> Kepala Bagian -> Kepala Balai) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="bg-[#10B981] px-6 py-3 border-b border-[#0ea5e9]/10">
                <h5 class="text-sm font-semibold flex items-center gap-2 text-white">
                    <i class="fas fa-check-shield"></i> VERIFIKASI ATASAN
                </h5>
            </div>
            <div class="p-6 relative">
                <!-- Garis Vertikal Timeline (3 Tahap: Admin -> Kabag -> Kabal) -->
                <div class="absolute left-[39px] top-[40px] bottom-[40px] w-0.5 flex flex-col">
                    <div class="h-1/2 {{ ($custatusadminkatimker->status ?? 'disetujui') == 'disetujui' ? 'bg-[#10B981]' : 'bg-gray-200' }}"></div>
                    <div class="h-1/2 {{ ($checkverifikasi->status ?? '') == 'disetujui' ? 'bg-[#10B981]' : 'bg-gray-200' }}"></div>
                </div>
                <div class="space-y-8 relative z-10">
                    <!-- Step 1: Admin -->
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white border-2 border-[#10B981] flex items-center justify-center text-[#10B981]">
                            <i class="fas fa-check text-xs"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800">Admin</h4>
                            <p class="text-sm text-gray-500">Administrator</p>
                            <p class="text-xs text-gray-400 mb-1.5">Verifikasi Kepegawaian</p>
                            @php
                                $adminStatus = $custatusadminkatimker->status ?? 'disetujui';
                                $adminBadgeClass = match (strtolower($adminStatus)) {
                                    'disetujui' => 'bg-green-100 text-green-700',
                                    'ditolak' => 'bg-red-100 text-red-700',
                                    default => 'bg-yellow-100 text-yellow-700',
                                };
                                $adminDotClass = match (strtolower($adminStatus)) {
                                    'disetujui' => 'bg-green-500',
                                    'ditolak' => 'bg-red-500',
                                    default => 'bg-yellow-500',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $adminBadgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $adminDotClass }}"></span> 
                                {{ ucfirst($adminStatus) }}
                            </span>
                        </div>
                    </div>

                    <!-- Step 2: Kepala Bagian Umum -->
                    <div class="flex items-start gap-4">
                        @if ($checkverifikasi && strtolower($checkverifikasi->status) == 'disetujui')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white border-2 border-[#10B981] flex items-center justify-center text-[#10B981]">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        @elseif ($checkverifikasi && strtolower($checkverifikasi->status) == 'ditolak')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white border-2 border-red-500 flex items-center justify-center text-red-500">
                                <i class="fas fa-times text-xs"></i>
                            </div>
                        @else
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white border-2 border-yellow-400 flex items-center justify-center text-yellow-500 shadow-[0_0_10px_rgba(250,204,21,0.2)]">
                                <i class="far fa-clock text-xs"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="text-sm font-bold text-gray-800">Kepala Bagian Umum</h4>
                            <p class="text-sm text-gray-500">Rosdiana, S. Pi, MM</p>
                            <p class="text-xs text-gray-400 mb-1.5">NIP 197001141999032001</p>
                            @if ($checkverifikasi)
                                @php
                                    $statusText = strtolower($checkverifikasi->status);
                                    $badgeClass = match ($statusText) {
                                        'disetujui' => 'bg-green-100 text-green-700',
                                        'ditolak' => 'bg-red-100 text-red-700',
                                        'perubahan' => 'bg-indigo-100 text-indigo-700',
                                        'ditangguhkan' => 'bg-purple-100 text-purple-700',
                                        default => 'bg-yellow-100 text-yellow-700',
                                    };
                                    $dotClass = match ($statusText) {
                                        'disetujui' => 'bg-green-500',
                                        'ditolak' => 'bg-red-500',
                                        'perubahan' => 'bg-indigo-500',
                                        'ditangguhkan' => 'bg-purple-500',
                                        default => 'bg-yellow-500',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $badgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span> {{ ucfirst($statusText) }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-[#FFFBEB] text-yellow-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Anda Belum Memverifikasi
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Step 3: Kepala Balai -->
                    <div class="flex items-start gap-4">
                        @php
                            $kabalStatus = optional(optional(optional($custatusadminkatimker->cuStatusAdminKatimker)->cuStatusKatimkerKabag)->cuStatusKabagKabal)->status ?? null;
                            $kabalLower = strtolower(trim($kabalStatus ?? ''));
                        @endphp
                        
                        @if($kabalLower === 'disetujui')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white border-2 border-[#10B981] flex items-center justify-center text-[#10B981]">
                                <i class="fas fa-check text-xs"></i>
                            </div>
                        @elseif($kabalLower === 'ditolak')
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-white border-2 border-red-500 flex items-center justify-center text-red-500">
                                <i class="fas fa-times text-xs"></i>
                            </div>
                        @else
                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-[#F3F4F6] border border-gray-200 flex items-center justify-center text-gray-400">
                                <i class="fas fa-minus text-xs"></i>
                            </div>
                        @endif

                        <div class="{{ $kabalLower ? '' : 'opacity-60' }}">
                            <h4 class="text-sm font-bold text-gray-800">Kepala Balai</h4>
                            <p class="text-sm text-gray-500">Jamaluddin Al Afgani, S.Pd.,MP</p>
                            <p class="text-xs text-gray-400 mb-1.5">NIP 197705012008011010</p>
                            
                            @if($kabalLower === 'disetujui')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disetujui
                                </span>
                            @elseif($kabalLower === 'ditolak')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center justify-center h-5 px-2.5 rounded-full bg-gray-100 text-gray-500 text-[11px] font-medium">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END OF VERIFIKASI CARD -->

        <!-- Action Buttons Bottom (DI LUAR CARD) -->
        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-4 mb-4">
            <!-- Tombol Kembali -->
            <a href="javascript:history.back()" 
                class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-gray-200 hover:bg-gray-50 hover:border-gray-300 text-gray-700 rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <!-- Tombol Verifikasi -->
            @if (!$checkverifikasi)
                <button type="button" data-modal="verifikasiModal" 
                    class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-[#10B981] to-[#22c55e] hover:from-green-600 hover:to-green-500 text-white rounded-xl font-bold text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-green-500/30">
                    <i class="fas fa-check-circle"></i> Verifikasi Pengajuan
                </button>
            @else
                <button type="button" disabled 
                    class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-400 rounded-xl font-bold text-sm flex items-center justify-center gap-2 cursor-not-allowed border-2 border-gray-200">
                    <i class="fas fa-check-double"></i> Sudah Diverifikasi
                </button>
            @endif
        </div>
    </div> <!-- END OF MAIN CONTAINER MAX-W-6XL -->

    <!-- Modal Verifikasi Pengajuan Cuti (Card Radio + Opsi Tanda Tangan) -->
    <div id="verifikasiModal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in-95 duration-200">
            
            <!-- Header Modal -->
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white flex items-center gap-3">
                <svg class="w-6 h-6 text-white shrink-0" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <h5 class="text-base sm:text-lg font-bold tracking-wide">
                    Verifikasi Pengajuan Cuti
                </h5>
            </div>

            <!-- Form Modal -->
            <form id="verifikasiForm" method="POST" action="{{ route('kabagverivikasicutiumum.store') }}" class="p-6">
                @csrf
                <input type="hidden" name="cu_status_admin_katimker_id" value="{{ $custatusadminkatimker->id }}">
                <input type="hidden" name="cu_status_user_admin_id" value="{{ $custatusadminkatimker->cu_status_user_admin_id }}">

                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2.5">Status</label>
                
                <!-- Pilihan Status (Card Radio) -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <!-- Option Disetujui -->
                    <label id="cardDisetujui" class="relative flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/50 cursor-pointer transition-all select-none">
                        <input type="radio" name="status" value="disetujui" id="radioDisetujui" class="hidden" checked>
                        <div class="flex items-center gap-2.5">
                            <div id="dotDisetujui" class="w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                            </div>
                            <span id="textDisetujui" class="text-sm font-semibold text-emerald-600">Disetujui</span>
                        </div>
                        <div id="badgeDisetujui" class="w-5 h-5 rounded bg-emerald-500 flex items-center justify-center text-white">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </label>

                    <!-- Option Ditolak -->
                    <label id="cardDitolak" class="relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none">
                        <input type="radio" name="status" value="ditolak" id="radioDitolak" class="hidden">
                        <div class="flex items-center gap-2.5">
                            <div id="dotDitolak" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                            </div>
                            <span id="textDitolak" class="text-sm font-medium text-gray-500">Ditolak</span>
                        </div>
                        <div id="badgeDitolak" class="text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </label>
                </div>

                <!-- Container Tanda Tangan (Tampil Jika Disetujui) -->
                <div id="tandaTanganContainer" class="p-4 rounded-2xl bg-emerald-50/40 border border-emerald-200 mb-4 transition-all">
                    <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">
                        <span>✍️</span>
                        <span>Tanda Tangan</span>
                    </div>
                    <p class="text-xs text-gray-700 font-medium mb-3">Bagaimana dokumen cuti ini akan ditandatangani?</p>

                    <div class="space-y-2.5">
                        <!-- Option 1: Akan ditempel tanda tangan -->
                        <label id="cardTtdYa" class="flex items-center gap-3 p-3 rounded-xl border-2 border-emerald-500 bg-white cursor-pointer transition-all select-none shadow-sm">
                            <input type="radio" name="tempel_ttd" value="ya" id="radioTtdYa" class="hidden" checked>
                            <div id="dotTtdYa" class="w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>
                            </div>
                            <div class="shrink-0 text-gray-700">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs sm:text-sm font-bold text-gray-800">Akan ditempel tanda tangan</p>
                                <p class="text-[11px] text-emerald-600 font-medium mt-0.5">Tanda tangan otomatis ditempelkan pada dokumen</p>
                            </div>
                        </label>

                        <!-- Option 2: Tidak ditempel tanda tangan -->
                        <label id="cardTtdTidak" class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none">
                            <input type="radio" name="tempel_ttd" value="tidak" id="radioTtdTidak" class="hidden">
                            <div id="dotTtdTidak" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0">
                                <div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>
                            </div>
                            <div class="shrink-0 text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs sm:text-sm font-semibold text-gray-700">Tidak ditempel tanda tangan</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Akan ditandatangani secara langsung / manual</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Container Alasan/Catatan (Tampil Jika Ditolak) -->
                <div id="catatanContainer" class="hidden mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-1 tracking-wider uppercase">Alasan Penolakan</label>
                    <textarea id="catatanInput" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-red-500/30 focus:border-red-400 outline-none text-sm transition-all" rows="3" name="catatan" placeholder="Tuliskan alasan penolakan..."></textarea>
                </div>

                <!-- Tombol Aksi Modal -->
                <div class="grid grid-cols-2 gap-3 mt-6">
                    <button type="button" class="w-full py-2.5 px-4 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all text-sm shadow-sm text-center"
                            onclick="toggleModal(false)">
                        Batalkan
                    </button>
                    <button type="submit" class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all text-sm text-center">
                        Simpan Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Panel -->
    <div id="previewPanel" class="fixed inset-0 z-50 hidden">
        <div class="flex h-full">
            <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePreviewPanel()"></div>
            
            <div class="relative flex flex-col w-full md:w-3/4 lg:w-2/3 h-full bg-white shadow-xl ml-auto transform transition-transform duration-300 ease-in-out translate-x-full" id="panelContent">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold">Preview Dokumen</h3>
                    <div class="flex items-center space-x-2">
                        @if(isset($lampiran))
                        <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                            <i class="fas fa-external-link-alt mr-1"></i> Buka di Tab Baru
                        </a>
                        @endif
                        <button onclick="closePreviewPanel()" class="p-2 rounded-full hover:bg-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                
                <div class="flex-1 p-4 overflow-auto bg-gray-100">
                    @if(isset($lampiran))
                    @php
                        $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
                        $fileUrl = Storage::url($lampiran->file_path);
                    @endphp

                    <div class="bg-white shadow rounded-lg p-2 h-full">
                        @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                            <div class="flex items-center justify-center h-full">
                                <img src="{{ $fileUrl }}" alt="Preview" class="max-w-full max-h-full object-contain">
                            </div>
                        @elseif(strtolower($fileExtension) == 'pdf')
                            <div class="h-full w-full">
                                <embed src="{{ $fileUrl }}" type="application/pdf" width="100%" height="100%" class="h-full">
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full">
                                <i class="fas fa-file text-blue-500 text-6xl mb-4"></i>
                                <p class="text-lg font-medium">File {{ strtoupper($fileExtension) }}</p>
                                <p class="text-gray-600 mt-2">File ini tidak dapat ditampilkan secara langsung di browser</p>
                                <a href="{{ $fileUrl }}" download class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-download mr-1"></i> Download File
                                </a>
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
             class="fixed bottom-10 right-10 bg-emerald-600 text-white px-6 py-3 rounded-2xl shadow-2xl z-[100] border border-white/20 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("verifikasiModal");
            if (modal) modal.style.display = "none";

            // Setup Verifikasi Tombol Trigger
            document.querySelectorAll("[data-modal='verifikasiModal']").forEach(button => {
                button.addEventListener("click", () => openModal());
            });

            // Elements Switch Status
            const radioDisetujui       = document.getElementById('radioDisetujui');
            const radioDitolak         = document.getElementById('radioDitolak');
            const cardDisetujui        = document.getElementById('cardDisetujui');
            const cardDitolak          = document.getElementById('cardDitolak');
            const dotDisetujui         = document.getElementById('dotDisetujui');
            const dotDitolak           = document.getElementById('dotDitolak');
            const textDisetujui        = document.getElementById('textDisetujui');
            const textDitolak          = document.getElementById('textDitolak');
            const badgeDisetujui       = document.getElementById('badgeDisetujui');
            const badgeDitolak         = document.getElementById('badgeDitolak');
            const tandaTanganContainer = document.getElementById('tandaTanganContainer');
            const catatanContainer     = document.getElementById('catatanContainer');

            // Elements Switch TTD
            const radioTtdYa       = document.getElementById('radioTtdYa');
            const radioTtdTidak    = document.getElementById('radioTtdTidak');
            const cardTtdYa        = document.getElementById('cardTtdYa');
            const cardTtdTidak     = document.getElementById('cardTtdTidak');
            const dotTtdYa         = document.getElementById('dotTtdYa');
            const dotTtdTidak      = document.getElementById('dotTtdTidak');

            function updateStatusSelection() {
                if (radioDisetujui && radioDisetujui.checked) {
                    cardDisetujui.className = "relative flex items-center justify-between p-3.5 rounded-xl border-2 border-emerald-500 bg-emerald-50/50 cursor-pointer transition-all select-none";
                    dotDisetujui.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center";
                    dotDisetujui.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';
                    textDisetujui.className = "text-sm font-semibold text-emerald-600";
                    badgeDisetujui.className = "w-5 h-5 rounded bg-emerald-500 flex items-center justify-center text-white";

                    cardDitolak.className   = "relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                    dotDitolak.className    = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
                    dotDitolak.innerHTML    = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                    textDitolak.className   = "text-sm font-medium text-gray-500";
                    badgeDitolak.className  = "text-gray-400";
                    badgeDitolak.innerHTML  = `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>`;

                    if (tandaTanganContainer) tandaTanganContainer.classList.remove('hidden');
                    if (catatanContainer) catatanContainer.classList.add('hidden');
                } else if (radioDitolak && radioDitolak.checked) {
                    cardDisetujui.className = "relative flex items-center justify-between p-3.5 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                    dotDisetujui.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
                    dotDisetujui.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                    textDisetujui.className = "text-sm font-medium text-gray-500";
                    badgeDisetujui.className = "w-5 h-5 rounded bg-gray-200 flex items-center justify-center text-gray-400";

                    cardDitolak.className   = "relative flex items-center justify-between p-3.5 rounded-xl border-2 border-red-500 bg-red-50/50 cursor-pointer transition-all select-none";
                    dotDitolak.className    = "w-5 h-5 rounded-full border-2 border-red-500 flex items-center justify-center";
                    dotDitolak.innerHTML    = '<div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>';
                    textDitolak.className   = "text-sm font-semibold text-red-600";
                    badgeDitolak.className  = "w-5 h-5 rounded bg-red-500 flex items-center justify-center text-white";
                    badgeDitolak.innerHTML  = `<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>`;

                    if (tandaTanganContainer) tandaTanganContainer.classList.add('hidden');
                    if (catatanContainer) catatanContainer.classList.remove('hidden');
                }
            }

            function updateTtdSelection() {
                if (radioTtdYa.checked) {
                    cardTtdYa.className = "flex items-center gap-3 p-3 rounded-xl border-2 border-emerald-500 bg-white cursor-pointer transition-all select-none shadow-sm";
                    dotTtdYa.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center shrink-0";
                    dotTtdYa.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';

                    cardTtdTidak.className = "flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                    dotTtdTidak.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0";
                    dotTtdTidak.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';
                } else if (radioTtdTidak.checked) {
                    cardTtdYa.className = "flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white cursor-pointer hover:border-gray-300 transition-all select-none";
                    dotTtdYa.className  = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center shrink-0";
                    dotTtdYa.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-transparent"></div>';

                    cardTtdTidak.className = "flex items-center gap-3 p-3 rounded-xl border-2 border-emerald-500 bg-white cursor-pointer transition-all select-none shadow-sm";
                    dotTtdTidak.className  = "w-5 h-5 rounded-full border-2 border-emerald-500 flex items-center justify-center shrink-0";
                    dotTtdTidak.innerHTML  = '<div class="w-2.5 h-2.5 rounded-full bg-emerald-500"></div>';
                }
            }

            if (radioDisetujui) radioDisetujui.addEventListener('change', updateStatusSelection);
            if (radioDitolak)   radioDitolak.addEventListener('change', updateStatusSelection);
            if (radioTtdYa)     radioTtdYa.addEventListener('change', updateTtdSelection);
            if (radioTtdTidak)  radioTtdTidak.addEventListener('change', updateTtdSelection);

            // Validasi Form & Routing Action Dinamis
            const verifikasiForm = document.getElementById("verifikasiForm");
            if (verifikasiForm) {
                verifikasiForm.addEventListener("submit", function (e) {
                    const catatan = document.getElementById("catatanInput");
                    let valid = true;

                    if (radioDitolak && radioDitolak.checked && catatan && catatan.value.trim() === "") {
                        valid = false;
                        catatan.classList.add("border-red-500");
                        catatan.focus();
                    } else if (catatan) {
                        catatan.classList.remove("border-red-500");
                    }

                    if (!valid) {
                        e.preventDefault();
                        return;
                    }

                    if (radioDisetujui && radioDisetujui.checked && radioTtdYa && radioTtdYa.checked) {
                        @if(Route::has('kabag.cuti-umum.approve-with-signature'))
                            verifikasiForm.action = '{{ route("kabag.cuti-umum.approve-with-signature") }}';
                        @endif
                    } else {
                        verifikasiForm.action = '{{ route("kabagverivikasicutiumum.store") }}';
                    }
                });
            }
        });

        // Panel Preview Functions
        function openPreviewPanel() {
            const panel = document.getElementById("previewPanel");
            const panelContent = document.getElementById("panelContent");
            if(panel && panelContent) {
                panel.classList.remove("hidden");
                setTimeout(() => { panelContent.classList.remove("translate-x-full"); }, 10);
            }
        }

        function closePreviewPanel() {
            const panel = document.getElementById("previewPanel");
            const panelContent = document.getElementById("panelContent");
            if(panel && panelContent) {
                panelContent.classList.add("translate-x-full");
                setTimeout(() => { panel.classList.add("hidden"); }, 300);
            }
        }

        function openModal() {
            const radioDisetujui = document.getElementById('radioDisetujui');
            const radioTtdYa     = document.getElementById('radioTtdYa');
            
            if (radioDisetujui) {
                radioDisetujui.checked = true;
                radioDisetujui.dispatchEvent(new Event('change'));
            }
            if (radioTtdYa) {
                radioTtdYa.checked = true;
                radioTtdYa.dispatchEvent(new Event('change'));
            }

            const modal = document.getElementById("verifikasiModal");
            if (modal) modal.style.display = "flex";
        }

        function toggleModal(show) {
            const modal = document.getElementById("verifikasiModal");
            if (modal) modal.style.display = show ? "flex" : "none";
        }

        window.onclick = function (e) {
            const modal = document.getElementById("verifikasiModal");
            if (e.target === modal) toggleModal(false);
        };

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                toggleModal(false);
                closePreviewPanel();
            }
        });
    </script>
@endsection