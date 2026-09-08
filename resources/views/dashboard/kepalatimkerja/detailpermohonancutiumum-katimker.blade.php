@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
<div class="max-w-6xl mx-auto p-6 pt-0">
    <!-- Header with Gradient Text -->
    <div class="flex items-center gap-4 mb-6 group">
        <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-green-600 to-emerald-500 shadow-lg 
                    group-hover:from-green-700 group-hover:to-emerald-600 transition-all duration-300
                    ring-2 ring-white/20 ring-inset hover:ring-green-400/40 hover:scale-105">
            <i class="fas fa-file-alt text-lg text-white"></i>
        </div>
        
        <div class="w-full">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
                Detail Pengajuan Cuti Tahunan
            </h2>
            <div class="relative mt-2">
                <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full w-0 
                            group-hover:w-full transition-all duration-500 ease-out"></div>
                <div class="h-0.5 bg-gray-200 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Biodata Pegawai Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-3 px-6 bg-gradient-to-r from-green-600 to-emerald-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <i class="fas fa-user-circle"></i>
                <span class="font-semibold uppercase">Biodata Pegawai</span>
            </h5>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->name ?? '-' }}" readonly>
                    <i class="fas fa-user absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">NIP</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->nip ?? '-' }}" readonly>
                    <i class="fas fa-id-card absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->jabatan ?? '-' }}" readonly>
                    <i class="fas fa-briefcase absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Masa Kerja</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->masa_kerja ?? '-' }}" readonly>
                    <i class="fas fa-clock absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">No HP</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->no_hp ?? '-' }}" readonly>
                    <i class="fas fa-phone-alt absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Detail Pengajuan Cuti Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 border-b border-gray-100">
            <h5 class="text-lg font-semibold flex items-center gap-2 text-white">
                <i class="fas fa-file-alt"></i>
                <span class="font-semibold uppercase">Detail Pengajuan Cuti</span>
            </h5>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Jenis Cuti</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->nama_cuti ?? 'Cuti Tahunan' }}" readonly>
                    <i class="fas fa-calendar-week absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->tgl_pengajuan ?? '-' }}" readonly>
                    <i class="fas fa-calendar-alt absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="md:col-span-2 space-y-1">
                <label class="block text-sm font-medium text-gray-700">Tanggal Cuti</label>
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="relative flex-1">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                            value="{{ $custatususeradmin->tgl_mulai ?? '-' }}" readonly>
                    </div>
                    <span class="text-gray-500 font-medium">s/d</span>
                    <div class="relative flex-1">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                            value="{{ $custatususeradmin->tgl_selesai ?? '-' }}" readonly>
                    </div>
                </div>
            </div>
    
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Jumlah Hari</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->jumlah_hari ?? '-' }}" readonly>
                    <span class="absolute right-3 top-3.5 text-gray-700">hari</span>
                </div>
            </div>
            
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">No HP Saat Cuti</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50" 
                           value="{{ $custatususeradmin->no_hp_cuti ?? '-' }}" readonly>
                    <i class="fas fa-mobile-alt absolute right-3 top-3.5 text-gray-400"></i>
                </div>
            </div>
            
            <div class="md:col-span-2 space-y-1">
                <label class="block text-sm font-medium text-gray-700">Alasan Melakukan Cuti</label>
                <div class="relative">
                    <textarea class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 min-h-[100px]" readonly>{{ $custatususeradmin->alasan ?? '-' }}</textarea>
                </div>
            </div>
            
            <div class="md:col-span-2 space-y-1">
                <label class="block text-sm font-medium text-gray-700">Alamat Saat Cuti</label>
                <div class="relative">
                    <textarea class="w-full p-3 border border-gray-200 rounded-lg bg-gray-50 min-h-[100px]" readonly>{{ $custatususeradmin->alamat_saat_cuti ?? '-' }}</textarea>
                </div>
            </div>
        </div>
        
        <!-- Lampiran Dokumen -->
        @if(isset($lampiran))
        <div class="p-6 border-t border-gray-200">
            <div class="bg-gray-50 p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold flex items-center gap-2 mb-4">
                    <i class="fas fa-paperclip text-emerald-600"></i>
                    <span class="uppercase text-gray-800">Lampiran Dokumen</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="space-y-2">
                            <p class="text-sm"><span class="font-medium text-gray-700">Nama Dokumen:</span> {{ $lampiran->nama_doc }}</p>
                            <p class="text-sm"><span class="font-medium text-gray-700">Diunggah pada:</span> {{ $lampiran->uploaded_at }}</p>
                            @if($lampiran->description)
                            <p class="text-sm"><span class="font-medium text-gray-700">Deskripsi:</span> {{ $lampiran->description }}</p>
                            @endif
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all flex items-center gap-2 text-xs">
                                <i class="fas fa-download"></i> Unduh Lampiran
                            </a>
                            <button type="button" onclick="openPreviewPanel()" 
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all flex items-center gap-2 text-xs">
                                <i class="fas fa-eye"></i> Lihat Dokumen
                            </button>
                        </div>
                    </div>
                    <div>
                        <div class="border rounded-xl overflow-hidden h-48 cursor-pointer hover:shadow-md transition-shadow bg-gray-100 flex items-center justify-center" onclick="openPreviewPanel()">
                            @php
                            $fileExtension = pathinfo($lampiran->file_path, PATHINFO_EXTENSION);
                            $fileUrl = Storage::url($lampiran->file_path);
                            @endphp

                            @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ $fileUrl }}" alt="Preview" class="w-full h-full object-contain">
                            @elseif(strtolower($fileExtension) == 'pdf')
                                <div class="flex flex-col items-center justify-center p-4">
                                    <i class="fas fa-file-pdf text-red-500 text-4xl mb-2"></i>
                                    <p class="text-sm text-gray-700 font-medium">Preview PDF</p>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center p-4">
                                    <i class="fas fa-file text-blue-500 text-4xl mb-2"></i>
                                    <p class="text-sm text-gray-700 font-medium">File {{ strtoupper($fileExtension) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Verifikasi Atasan Card (Timeline Vertikal 3 Tingkat sesuai Gambar Referensi) -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <!-- Header Hijau sesuai Gambar -->
        <div class="py-3 px-6 bg-emerald-500 text-white flex items-center gap-2">
            <i class="fas fa-shield-alt"></i>
            <h5 class="text-base font-bold uppercase tracking-wider">Verifikasi Atasan</h5>
        </div>
        
        <div class="p-6">
            <div class="relative pl-6 space-y-8 before:absolute before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-gray-200">
                
                {{-- 1. Ketua Tim Kerja --}}
                <div class="relative flex items-start gap-4">
                    @php
                        $statusKatim = $checkverifikasi->status ?? null;
                    @endphp
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full {{ $statusKatim ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-500' }} border-2 border-white flex items-center justify-center shadow-sm z-10">
                        <i class="fas {{ $statusKatim ? 'fa-check' : 'fa-clock' }} text-[10px]"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-800">Ketua Tim Kerja</h4>
                        <p class="text-xs font-medium text-gray-600">{{ $ketuaNama ?? 'Sabaruddin, S. Pt' }}</p>
                        <p class="text-xs text-gray-400">NIP {{ $ketuaNIP ?? '197610032011011001' }}</p>
                        <div class="mt-2">
                            @if ($checkverifikasi)
                                @php
                                    $statusText = $checkverifikasi->status;
                                    $statusClass = match(strtolower($statusText)) {
                                        'disetujui' => 'bg-green-100 text-green-800 border-green-200',
                                        'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-yellow-100 text-yellow-800 border-yellow-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium border {{ $statusClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current mr-1.5 animate-pulse"></span>
                                    {{ ucfirst($statusText) }}
                                </span>
                                @if($checkverifikasi->catatan)
                                    <span class="text-xs text-gray-600 italic ml-2">Catatan: "{{ $checkverifikasi->catatan }}"</span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                    Anda Belum Memverifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 2. Kepala Bagian Umum --}}
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-gray-400 shadow-sm z-10">
                        <i class="fas fa-minus text-[10px]"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-400">Kepala Bagian Umum</h4>
                        <p class="text-xs font-medium text-gray-400">{{ $kabagNama ?? 'Rosdiana, S. Pi, MM' }}</p>
                        <p class="text-xs text-gray-300">NIP {{ $kabagNIP ?? '197001141999032001' }}</p>
                        <div class="mt-1.5">
                            <span class="text-xs text-gray-400">-</span>
                        </div>
                    </div>
                </div>

                {{-- 3. Kepala Balai --}}
                <div class="relative flex items-start gap-4">
                    <div class="absolute -left-6 mt-0.5 w-6 h-6 rounded-full bg-gray-100 border-2 border-white flex items-center justify-center text-gray-400 shadow-sm z-10">
                        <i class="fas fa-minus text-[10px]"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-400">Kepala Balai</h4>
                        <p class="text-xs font-medium text-gray-400">{{ $kabalaiNama ?? 'Jamaluddin Al Afgani, S.Pd, MP' }}</p>
                        <p class="text-xs text-gray-300">NIP {{ $kabalaiNIP ?? '197705012008011010' }}</p>
                        <div class="mt-1.5">
                            <span class="text-xs text-gray-400">-</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tombol Navigasi Bawah sesuai Referensi Gambar -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-6">
        <a href="{{ route('katimkerpengajuancutiumum.index') ?? '#' }}" 
           class="w-full sm:w-auto px-6 py-2.5 border border-gray-300 rounded-xl text-gray-700 font-semibold bg-white hover:bg-gray-50 transition-all shadow-sm flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        @if (!$checkverifikasi)
        <button onclick="openModal()" 
                class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-md flex items-center justify-center gap-2">
            <i class="fas fa-check-circle"></i> Verifikasi Pengajuan
        </button>
        @endif
    </div>
</div>

<!-- Modal Verifikasi Pengajuan Cuti (Interaktif Card Design) -->
<div id="verifikasiModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/30 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden transform transition-all">
        <div class="p-5 bg-gradient-to-r from-green-600 to-emerald-500 text-white flex items-center gap-2.5">
            <i class="fas fa-user-check text-xl"></i>
            <h5 class="text-lg font-bold">Verifikasi Pengajuan Cuti</h5>
        </div>
        
        <form id="verifikasiForm" method="POST" action="{{ route('katimkerverifikasicutiumum.store') }}" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="cu_status_user_admin_id" value="{{ $custatususeradmin->id }}">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Opsi Disetujui --}}
                    <label id="labelDisetujui" onclick="selectStatus('disetujui')" class="cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-green-500 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="status" value="disetujui" id="radioDisetujui" class="sr-only" required>
                            <span id="circleDisetujui" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <span class="w-2 h-2 rounded-full bg-transparent"></span>
                            </span>
                            <span id="textDisetujui" class="text-sm font-semibold text-gray-400">Disetujui</span>
                        </div>
                        <span id="checkDisetujui" class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                            ✓
                        </span>
                    </label>

                    {{-- Opsi Ditolak --}}
                    <label id="labelDitolak" onclick="selectStatus('ditolak')" class="cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-red-400 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="status" value="ditolak" id="radioDitolak" class="sr-only">
                            <span id="circleDitolak" class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center">
                                <span class="w-2 h-2 rounded-full bg-transparent"></span>
                            </span>
                            <span id="textDitolak" class="text-sm font-semibold text-gray-600">Ditolak</span>
                        </div>
                        <span id="checkDitolak" class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                            ✕
                        </span>
                    </label>
                </div>
            </div>
            
            <div id="catatanContainer" class="hidden animate-fade-in">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alasan Penolakan :</label>
                <textarea id="catatanInput" class="w-full p-3.5 border border-red-300 focus:border-red-500 rounded-xl bg-white focus:ring-2 focus:ring-red-500/20 outline-none transition-all text-sm text-gray-700 placeholder-gray-300 shadow-sm" rows="3" name="catatan" placeholder="Contoh : Pekerjaan mendesak, silahkan ajukan bulan depan"></textarea>
            </div>
            
            <div class="flex items-center gap-3 pt-2">
                <button type="button" class="flex-1 px-5 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all text-sm"
                        onclick="toggleModal(false)">
                    Batalkan
                </button>
                <button type="submit" class="flex-1 px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-xl font-semibold shadow-md hover:shadow-lg transition-all text-sm">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Side Panel untuk Preview Dokumen -->
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
                            <a href="{{ $fileUrl }}" download class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
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
<div class="fixed bottom-4 right-4 z-50">
    <div class="px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg flex items-center gap-2 animate-bounce">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
</div>
@endif

<script>
    function toggleModal(show) {
        const modal = document.getElementById("verifikasiModal");
        if (show) {
            modal.classList.remove("hidden");
        } else {
            modal.classList.add("hidden");
        }
    }

    function openModal() {
        toggleModal(true);
    }
    
    function openPreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const panelContent = document.getElementById("panelContent");
        
        panel.classList.remove("hidden");
        setTimeout(() => {
            panelContent.classList.remove("translate-x-full");
        }, 10);
    }

    function closePreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const panelContent = document.getElementById("panelContent");
        
        panelContent.classList.add("translate-x-full");
        setTimeout(() => {
            panel.classList.add("hidden");
        }, 300);
    }

    // Fungsi Interaktif Pemilihan Status di Modal
    function selectStatus(status) {
        const radioDisetujui = document.getElementById("radioDisetujui");
        const radioDitolak = document.getElementById("radioDitolak");
        const labelDisetujui = document.getElementById("labelDisetujui");
        const labelDitolak = document.getElementById("labelDitolak");
        const textDisetujui = document.getElementById("textDisetujui");
        const textDitolak = document.getElementById("textDitolak");
        const circleDisetujui = document.getElementById("circleDisetujui");
        const circleDitolak = document.getElementById("circleDitolak");
        const checkDisetujui = document.getElementById("checkDisetujui");
        const checkDitolak = document.getElementById("checkDitolak");
        const catatanContainer = document.getElementById("catatanContainer");
        const catatanInput = document.getElementById("catatanInput");

        if (status === 'disetujui') {
            radioDisetujui.checked = true;
            radioDitolak.checked = false;

            labelDisetujui.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-green-500 bg-white transition-all shadow-sm";
            textDisetujui.className = "text-sm font-semibold text-green-600";
            circleDisetujui.className = "w-5 h-5 rounded-full border-2 border-green-500 flex items-center justify-center bg-green-500";
            circleDisetujui.innerHTML = '<span class="w-2 h-2 rounded-full bg-white"></span>';
            checkDisetujui.className = "w-6 h-6 rounded-md bg-green-100 flex items-center justify-center text-green-600 text-xs font-bold";

            labelDitolak.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-red-400 transition-all";
            textDitolak.className = "text-sm font-semibold text-gray-600";
            circleDitolak.className = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
            circleDitolak.innerHTML = '<span class="w-2 h-2 rounded-full bg-transparent"></span>';
            checkDitolak.className = "w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs";

            catatanContainer.classList.add("hidden");
            catatanInput.required = false;
        } else {
            radioDitolak.checked = true;
            radioDisetujui.checked = false;

            labelDitolak.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-red-400 bg-white transition-all shadow-sm";
            textDitolak.className = "text-sm font-semibold text-red-600";
            circleDitolak.className = "w-5 h-5 rounded-full border-2 border-red-500 flex items-center justify-center bg-red-500";
            circleDitolak.innerHTML = '<span class="w-2 h-2 rounded-full bg-white"></span>';
            checkDitolak.className = "w-6 h-6 rounded-md bg-red-100 flex items-center justify-center text-red-600 text-xs font-bold";

            labelDisetujui.className = "cursor-pointer flex items-center justify-between p-3.5 rounded-xl border-2 border-gray-200 bg-white hover:border-green-500 transition-all";
            textDisetujui.className = "text-sm font-semibold text-gray-400";
            circleDisetujui.className = "w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center";
            circleDisetujui.innerHTML = '<span class="w-2 h-2 rounded-full bg-transparent"></span>';
            checkDisetujui.className = "w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-gray-400 text-xs";

            catatanContainer.classList.remove("hidden");
            catatanContainer.classList.add("animate-fade-in");
            catatanInput.required = true;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                closePreviewPanel();
                toggleModal(false);
            }
        });
    });
</script>

<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
</style>
@endsection