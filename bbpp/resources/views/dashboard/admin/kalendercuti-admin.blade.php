@extends('dashboard.admin.base-admin')

@section('main')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex items-center gap-4 mb-6 group">
        <div class="p-3 w-12 h-12 flex items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-green-500 shadow-lg
                    group-hover:from-emerald-700 group-hover:to-green-600 transition-all duration-300
                    ring-2 ring-white/20 ring-inset hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div class="w-full">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Master Kalender Custom</h2>
            <div class="relative mt-1.5">
                <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-emerald-500 to-green-400 rounded-full w-0
                            group-hover:w-full transition-all duration-500 ease-out"></div>
                <div class="h-0.5 bg-gray-200 rounded-full"></div>
            </div>
            <p class="text-sm text-gray-500 mt-1">Kelola hari libur nasional dan tanggal pemblokiran cuti (blackout date).</p>
        </div>
    </div>

    {{-- ALERT PESAN SUKSES / ERROR --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any() || session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
            <div class="flex items-center gap-3 mb-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('error') ?? 'Terdapat kesalahan input:' }}</span>
            </div>
            @if($errors->any())
                <ul class="list-disc list-inside text-xs mt-2 ml-8 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    {{-- ===== MAIN GRID: FORM + TABEL ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- KOLOM KIRI: FORM INPUT --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden sticky top-6">

                <div class="px-5 py-3.5 bg-gradient-to-r from-emerald-600 to-green-500 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wide">Tambah Hari Kalender</h3>
                </div>

                {{-- FORM START --}}
                <form action="{{ route('adminkalendercuti.store') }}" method="POST">
                    @csrf
                    <div class="p-5 space-y-5">

                        {{-- Input Tipe Hari --}}
                        <div>
                            <label for="tipe" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                Tipe Hari
                            </label>
                            <select id="tipe" name="tipe" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none bg-white">
                                <option value="" disabled selected>— Pilih Tipe —</option>
                                <option value="libur_nasional" {{ old('tipe') == 'libur_nasional' ? 'selected' : '' }}>🔴 Libur Nasional</option>
                                <option value="blackout" {{ old('tipe') == 'blackout' ? 'selected' : '' }}>🟠 Blokir Cuti (Blackout Date)</option>
                            </select>
                            <p id="desc-libur" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Tidak memotong kuota & tidak dihitung sebagai hari kerja.
                            </p>
                            <p id="desc-blackout" class="hidden mt-1.5 text-xs text-orange-500 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                Pegawai dilarang mengajukan cuti pada tanggal ini.
                            </p>
                        </div>

                        {{-- Input Nama Hari Libur --}}
                        <div>
                            <label for="nama" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Nama Hari / Kegiatan
                            </label>
                            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                                   placeholder="Contoh: Libur Cuti Bersama"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none">
                        </div>

                        {{-- Toggle Tipe Tanggal --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Pilih Tanggal
                            </label>
                            <div class="flex rounded-lg border border-gray-300 overflow-hidden mb-3 text-xs">
                                <button type="button" id="btn-single"
                                        onclick="switchDateMode('single')"
                                        class="flex-1 py-2 font-semibold transition-all bg-emerald-600 text-white">
                                    Tanggal Tunggal
                                </button>
                                <button type="button" id="btn-range"
                                        onclick="switchDateMode('range')"
                                        class="flex-1 py-2 font-semibold transition-all bg-white text-gray-500 hover:bg-gray-50">
                                    Range Tanggal
                                </button>
                            </div>
                            
                            {{-- Input Tunggal (Perhatikan perubahan name) --}}
                            <div id="mode-single">
                                <input type="date" name="tanggal_tunggal" id="tanggal_tunggal" value="{{ old('tanggal_tunggal') }}"
                                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none">
                            </div>

                            {{-- Input Range --}}
                            <div id="mode-range" class="hidden space-y-2">
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Dari</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_dari" value="{{ old('tanggal_mulai') }}"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-400 mb-1">Sampai</label>
                                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                           class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex gap-2 pt-1">
                            <button type="submit"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-green-500 text-white rounded-lg text-sm font-bold hover:from-emerald-700 hover:to-green-600 hover:shadow-lg hover:scale-[1.02] transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
                {{-- FORM END --}}

            </div>
        </div>

        {{-- KOLOM KANAN: DAFTAR --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

                {{-- Header tabel --}}
                <div class="px-5 py-3.5 bg-gradient-to-r from-emerald-600 to-green-500 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wide">Daftar Kalender Custom</h3>
                    </div>
                    <span class="text-xs bg-white/20 text-white px-2.5 py-1 rounded-full font-semibold">
                        {{ isset($hariLiburs) ? $hariLiburs->count() : 0 }} entri
                    </span>
                </div>

                {{-- Search & Filter --}}
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row gap-2">
                    <div class="flex gap-2 flex-1">
                        <input type="text" placeholder="Cari nama hari atau kegiatan..."
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition-all">
                        <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition-all bg-white">
                            <option value="">Semua Tipe</option>
                            <option value="libur_nasional">Libur Nasional</option>
                            <option value="blackout">Blackout Date</option>
                        </select>
                        <button type="button"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-all">
                            Cari
                        </button>
                    </div>
                </div>

                {{-- Tabel Dinamis --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-left">
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">No</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Hari / Kegiatan</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">

                            @if(isset($hariLiburs) && $hariLiburs->count() > 0)
                                @foreach($hariLiburs as $index => $libur)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3.5 text-gray-400 text-xs font-medium">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3.5">
                                            <p class="font-semibold text-gray-800">{{ $libur->nama }}</p>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded text-xs font-medium">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($libur->tanggal)->translatedFormat('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($libur->tipe == 'libur_nasional')
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                                    Libur Nasional
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                                    Blackout Date
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </button>
                                                
                                                {{-- Form Delete --}}
                                                <form action="{{ route('adminkalendercuti.destroy', $libur->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus hari ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
                                        Belum ada data kalender custom yang ditambahkan.
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Legenda --}}
            <div class="mt-3 flex flex-wrap gap-3 px-1">
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 border border-red-200 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                        Libur Nasional
                    </span>
                    <span>— Tidak memotong kuota, bukan hari kerja</span>
                </div>
                <div class="flex items-center gap-1.5 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 border border-orange-200 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                        Blackout Date
                    </span>
                    <span>— Pegawai dilarang mengajukan cuti</span>
                </div>
            </div>
        </div>

    </div>{{-- end grid --}}
</div>

<script>
    function switchDateMode(mode) {
        const modeSingle  = document.getElementById('mode-single');
        const modeRange   = document.getElementById('mode-range');
        const btnSingle   = document.getElementById('btn-single');
        const btnRange    = document.getElementById('btn-range');
        const inputTunggal = document.getElementById('tanggal_tunggal');
        const inputMulai = document.getElementById('tanggal_dari');

        if (mode === 'single') {
            modeSingle.classList.remove('hidden');
            modeRange.classList.add('hidden');
            btnSingle.classList.add('bg-emerald-600', 'text-white');
            btnSingle.classList.remove('bg-white', 'text-gray-500');
            btnRange.classList.add('bg-white', 'text-gray-500');
            btnRange.classList.remove('bg-emerald-600', 'text-white');
            
            // Focus manipulation
            inputTunggal.focus();
        } else {
            modeRange.classList.remove('hidden');
            modeSingle.classList.add('hidden');
            btnRange.classList.add('bg-emerald-600', 'text-white');
            btnRange.classList.remove('bg-white', 'text-gray-500');
            btnSingle.classList.add('bg-white', 'text-gray-500');
            btnSingle.classList.remove('bg-emerald-600', 'text-white');
            
            // Focus manipulation
            inputMulai.focus();
        }
    }

    document.getElementById('tipe').addEventListener('change', function () {
        document.getElementById('desc-libur').classList.add('hidden');
        document.getElementById('desc-blackout').classList.add('hidden');

        if (this.value === 'libur_nasional') {
            document.getElementById('desc-libur').classList.remove('hidden');
        } else if (this.value === 'blackout') {
            document.getElementById('desc-blackout').classList.remove('hidden');
        }
    });

    // Jalankan pengecekan deskripsi saat pertama kali load (untuk menangani old input)
    if(document.getElementById('tipe').value) {
        document.getElementById('tipe').dispatchEvent(new Event('change'));
    }
</script>

@endsection