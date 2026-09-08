{{-- @extends('dashboard.kepalabalai.base-kepalabalai')

@section('content')
<div class="max-w-4xl mx-auto p-4">
    <div class="flex items-center gap-4 mb-6">
        <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-orange-400 to-orange-500 shadow-lg">
             <i class="fas fa-file-alt text-white text-xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800 border-b-2 border-gray-800 pb-1">
            Detail Pengajuan Cuti Umum
        </h2>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-4 px-6 bg-gradient-to-r from-orange-400 to-orange-500 flex items-center gap-3">
            <i class="fas fa-user-circle text-white text-xl"></i>
            <span class="font-bold uppercase text-white tracking-wider">Biodata Pegawai</span>
        </div>
        
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-800 font-semibold" value="{{ $custatuskatimkerkabag->name }}" readonly>
                    <i class="fas fa-user absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">NIP</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->nip }}" readonly>
                    <i class="fas fa-id-card absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Jabatan</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->jabatan }}" readonly>
                    <i class="fas fa-briefcase absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Masa Kerja</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->masa_kerja }}" readonly>
                    <i class="fas fa-clock absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">No HP</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->no_hp }}" readonly>
                    <i class="fas fa-phone absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-4 px-6 bg-gradient-to-r from-emerald-400 to-emerald-500 flex items-center gap-3">
            <i class="fas fa-file-medical text-white text-xl"></i>
            <span class="font-bold uppercase text-white tracking-wider">Detail Pengajuan Cuti</span>
        </div>
        
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Cuti</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 font-semibold" value="{{ $custatuskatimkerkabag->nama_cuti }}" readonly>
                    <i class="fas fa-calendar-alt absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pengajuan</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->tgl_pengajuan }}" readonly>
                    <i class="fas fa-calendar-check absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Cuti</label>
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <div class="relative w-full">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 text-center text-sm font-medium" value="{{ $custatuskatimkerkabag->tgl_mulai }}" readonly>
                    </div>
                    <span class="text-gray-500 font-bold text-xs uppercase">s/d</span>
                    <div class="relative w-full">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50 text-center text-sm font-medium" value="{{ $custatuskatimkerkabag->tgl_selesai }}" readonly>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Lama Cuti</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->jumlah_hari }} hari" readonly>
                    <i class="fas fa-history absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">No HP Saat Cuti</label>
                <div class="relative">
                    <input type="text" class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" value="{{ $custatuskatimkerkabag->no_hp_cuti }}" readonly>
                    <i class="fas fa-mobile-alt absolute right-4 top-4 text-gray-400"></i>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Alasan Melakukan Cuti</label>
                <textarea class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" rows="2" readonly>{{ $custatuskatimkerkabag->alasan }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Alamat Saat Cuti</label>
                <textarea class="w-full p-3 border border-gray-200 rounded-xl bg-gray-50" rows="2" readonly>{{ $custatuskatimkerkabag->alamat_saat_cuti }}</textarea>
            </div>
        </div>
    </div>

    @if(isset($lampiran))
    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-4 px-6 bg-gradient-to-r from-indigo-400 to-indigo-500 flex items-center gap-3">
            <i class="fas fa-paperclip text-white text-xl"></i>
            <span class="font-bold uppercase text-white tracking-wider">Lampiran Dokumen</span>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="grid grid-cols-1 gap-3">
                <div class="p-3 border border-dashed border-gray-200 rounded-xl bg-gray-50 flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-file-pdf text-red-500 text-3xl mb-2"></i>
                        <p class="text-xs font-bold text-gray-700">{{ $lampiran->nama_doc }}</p>
                    </div>
                </div>
                <a href="{{ Storage::url($lampiran->file_path) }}" target="_blank" class="w-full py-3 bg-blue-600 text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-100">
                    <i class="fas fa-download"></i> Unduh Lampiran
                </a>
                <button onclick="openPreviewPanel()" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-indigo-100">
                    <i class="fas fa-eye"></i> Lihat Dokumen
                </button>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="py-4 px-6 bg-gray-100 border-b">
            <h5 class="text-lg font-semibold text-gray-700 uppercase flex items-center gap-2">
                <i class="fas fa-history"></i> Riwayat Verifikasi
            </h5>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase">
                        <th class="border px-4 py-3 text-left">Pihak</th>
                        <th class="border px-4 py-3 text-center">Status</th>
                        <th class="border px-4 py-3 text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr>
                        <td class="border px-4 py-3 font-bold">Admin</td>
                        <td class="border px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ str_contains($custatuskatimkerkabag->status_user_admin, 'setuju') ? 'text-green-600 bg-green-50' : 'text-amber-600 bg-amber-50' }}">
                                {{ $custatuskatimkerkabag->status_user_admin ?? 'belum disetujui' }}
                            </span>
                        </td>
                        <td class="border px-4 py-3 italic text-gray-500">{{ $custatuskatimkerkabag->catatan_user_admin ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-3 font-bold">{{ $ketuaNama }}</td>
                        <td class="border px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ str_contains($custatuskatimkerkabag->status_admin_katimker, 'setuju') ? 'text-green-600 bg-green-50' : 'text-amber-600 bg-amber-50' }}">
                                {{ $custatuskatimkerkabag->status_admin_katimker ?? 'belum disetujui' }}
                            </span>
                        </td>
                        <td class="border px-4 py-3 italic text-gray-500">{{ $custatuskatimkerkabag->catatan_admin_katimker ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-3 font-bold">Kepala Bagian</td>
                        <td class="border px-4 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ str_contains($custatuskatimkerkabag->status_katimker_kabag, 'setuju') ? 'text-green-600 bg-green-50' : 'text-amber-600 bg-amber-50' }}">
                                {{ $custatuskatimkerkabag->status_katimker_kabag ?? 'belum disetujui' }}
                            </span>
                        </td>
                        <td class="border px-4 py-3 italic text-gray-500">{{ $custatuskatimkerkabag->catatan_katimker_kabag ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-blue-100 rounded-full">
                    <i class="fas fa-user-shield text-blue-600 text-lg"></i>
                </div>
                <h2 class="text-lg font-bold text-blue-600 uppercase tracking-wide">Verifikasi Kepala Balai</h2>
            </div>
            
            <div class="flex justify-between items-center mb-4">
                <p class="text-sm text-gray-500">Verifikasi status pengajuan cuti oleh Kepala Balai</p>
                <span class="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 rounded-full text-[10px] font-bold">
                    @if(!$checkverifikasi) <span class="animate-pulse mr-1">●</span> MENUNGGU @else SELESAI @endif
                </span>
            </div>

            <div class="bg-gray-50/50 p-4 rounded-2xl border border-gray-100 mb-4">
                <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-3">Info Kepala Balai</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user text-blue-500"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ $kepalaBalai->name ?? 'Kepala Balai' }}</p>
                        <p class="text-xs text-gray-500">{{ $kepalaBalai->nip ?? '-' }}</p>
                        <p class="text-[10px] text-gray-400 italic">{{ $kepalaBalai->jabatan ?? 'Kepala Balai' }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Status Verifikasi</p>
                    @php
                        $statusText = $checkverifikasi->status ?? 'belum disetujui';
                    @endphp
                    <span class="px-4 py-2 rounded-full text-xs font-bold border inline-block {{ str_contains($statusText, 'setuju') ? 'text-green-600 bg-green-50 border-green-200' : 'text-amber-600 bg-amber-50 border-amber-200' }}">
                        {{ ucfirst($statusText) }}
                    </span>
                </div>
                
                <div>
                    <p class="text-[10px] font-bold text-orange-500 uppercase tracking-widest mb-1">Catatan</p>
                    <div class="w-full p-3 bg-gray-50 border border-gray-100 rounded-xl text-xs text-gray-600 italic">
                        {{ $checkverifikasi->catatan ?? 'Tidak ada catatan' }}
                    </div>
                </div>

                @if(!$checkverifikasi)
                <div class="space-y-3 pt-2">
                    <button class="w-full py-4 bg-blue-600 text-white rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-blue-200" data-modal="verifikasiModal">
                        <i class="fas fa-check-circle"></i> Verifikasi
                    </button>
                    <button class="w-full py-4 bg-green-600 text-white rounded-2xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-green-200" 
                            data-id="{{ $custatuskatimkerkabag->id }}" onclick="setujuiDenganTTD(this)">
                        <i class="fas fa-signature"></i> Setujui & TTD
                    </button>
                </div>
                @else
                <div class="flex flex-col items-center bg-green-50 p-4 rounded-2xl border border-green-100">
                    <span class="text-green-600 font-bold text-sm mb-2 uppercase">Terverifikasi</span>
                    @if($checkverifikasi->tanda_tangan)
                        <img src="{{ $checkverifikasi->tanda_tangan }}" alt="TTD" class="h-16 object-contain mix-blend-multiply" />
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div id="previewPanel" class="fixed inset-0 z-[70] hidden overflow-hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closePreviewPanel()"></div>
    <div class="absolute right-0 top-0 h-full w-full md:w-3/4 lg:w-2/3 bg-white shadow-2xl transform transition-transform duration-500 ease-out translate-x-full" id="panelContent">
        <div class="flex items-center justify-between p-4 bg-indigo-600 text-white">
            <h3 class="font-bold flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Preview Lampiran
            </h3>
            <button onclick="closePreviewPanel()" class="p-2 hover:bg-black/10 rounded-full transition-all">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <div class="h-[calc(100%-64px)] overflow-auto bg-gray-50 p-4">
            @if(isset($lampiran))
                <div class="w-full h-full rounded-xl bg-white shadow-inner p-2 border border-gray-200">
                    @php $fileExt = pathinfo($lampiran->file_path, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ Storage::url($lampiran->file_path) }}" class="max-w-full max-h-full mx-auto object-contain">
                    @elseif(strtolower($fileExt) == 'pdf')
                        <embed src="{{ Storage::url($lampiran->file_path) }}" type="application/pdf" width="100%" height="100%">
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                            <i class="fas fa-file-download text-5xl mb-4"></i>
                            <p class="text-sm font-bold">Format tidak didukung untuk preview</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<div id="verifikasiModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-md">
        <div class="flex justify-between items-center border-b pb-2">
            <h5 class="text-lg font-semibold uppercase">Verifikasi Pengajuan</h5>
            <button onclick="toggleModal(false)" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        <form id="verifikasiForm" method="POST" action="{{ route('kabalaiverifikasicutiumum.store') }}" class="mt-4 space-y-4">
            @csrf
            <input type="hidden" name="cu_status_katimker_kabag_id" value="{{ $custatuskatimkerkabag->id }}">

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Status</label>
                <select id="statusSelect" class="w-full p-3 border rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-blue-500/20" name="status" required>
                    <option value="-">- Pilih Status -</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <small class="text-red-500 hidden" id="statusError">Silakan pilih status terlebih dahulu.</small>
            </div>

            <div class="hidden" id="catatanContainer">
                <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Catatan</label>
                <textarea id="catatanInput" class="w-full p-3 border rounded-xl bg-gray-50 outline-none focus:ring-2 focus:ring-blue-500/20" rows="3" name="catatan"></textarea>
                <small class="text-red-500 hidden" id="catatanError">Catatan wajib diisi jika status bukan "Disetujui".</small>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" class="flex-1 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200" onclick="toggleModal(false)">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-bold shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 p-4 bg-green-500 text-white rounded-xl shadow-xl z-[100] animate-bounce">
        {{ session('success') }}
    </div>
@endif

<script>
    function toggleModal(show) {
        const modal = document.getElementById("verifikasiModal");
        modal.classList.toggle("hidden", !show);
    }
    
    function openPreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const content = document.getElementById("panelContent");
        panel.classList.remove("hidden");
        setTimeout(() => content.classList.remove("translate-x-full"), 10);
    }

    function closePreviewPanel() {
        const panel = document.getElementById("previewPanel");
        const content = document.getElementById("panelContent");
        content.classList.add("translate-x-full");
        setTimeout(() => panel.classList.add("hidden"), 300);
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("[data-modal='verifikasiModal']").forEach(button => {
            button.addEventListener("click", () => toggleModal(true));
        });

        const statusSelect = document.getElementById("statusSelect");
        const catatanContainer = document.getElementById("catatanContainer");
        const verifikasiForm = document.getElementById("verifikasiForm");

        if (statusSelect) {
            statusSelect.addEventListener("change", function () {
                catatanContainer.classList.toggle("hidden", this.value === "disetujui" || this.value === "-");
            });
        }

        if (verifikasiForm) {
            verifikasiForm.addEventListener("submit", function (event) {
                const catatanInput = document.getElementById("catatanInput");
                if (statusSelect.value !== "disetujui" && statusSelect.value !== "-" && catatanInput.value.trim() === "") {
                    document.getElementById("catatanError").classList.remove("hidden");
                    event.preventDefault();
                }
            });
        }
    });

    function setujuiDenganTTD(button) {
        const idCuti = button.getAttribute("data-id");
        if (confirm("Apakah Anda yakin ingin menyetujui pengajuan ini dengan tanda tangan?")) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("kabalverivikasicutiumum.approve-with-signature") }}';
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden'; csrfToken.name = '_token'; csrfToken.value = '{{ csrf_token() }}';
            const idInput = document.createElement('input');
            idInput.type = 'hidden'; idInput.name = 'cu_status_katimker_kabag_id'; idInput.value = idCuti;
            form.appendChild(csrfToken); form.appendChild(idInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>

<style>
    .rounded-2xl { border-radius: 1.25rem; }
    .rounded-xl { border-radius: 0.85rem; }
</style>
@endsection --}}