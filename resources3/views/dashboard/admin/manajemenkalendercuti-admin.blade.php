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

    {{-- ===== ALERT SESSION ===== --}}
    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
    <div class="mb-5 flex items-start gap-3 p-4 bg-green-50 border-l-4 border-emerald-500 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-emerald-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Tampilkan pesan error jika ada --}}
    @if(session('error'))
    <div class="mb-5 flex items-start gap-3 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    {{-- Tampilkan error validasi jika ada --}}
    @if($errors->any())
    <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        <div class="flex items-start gap-3 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-sm font-semibold text-red-700">Terdapat kesalahan pada input:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5 pl-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ===== MAIN GRID: FORM + TABEL ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ==========================================
             KOLOM KIRI: FORM INPUT
        =========================================== --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden sticky top-6">

                {{-- Header form --}}
                <div class="px-5 py-3.5 bg-gradient-to-r from-emerald-600 to-green-500 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{-- Ubah judul form secara dinamis: jika mode edit, tampilkan "Edit", jika tidak tampilkan "Tambah" --}}
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wide">
                        {{ isset($editData) ? 'Edit Hari Kalender' : 'Tambah Hari Kalender' }}
                    </h3>
                </div>

                {{-- Form body --}}
                <form
                    {{-- Jika mode edit, arahkan ke route update; jika tidak, ke route store --}}
                    action="{{ isset($editData) ? route('masterkalender.update', $editData->id) : route('masterkalender.store') }}"
                    method="POST"
                    class="p-5 space-y-5">
                    @csrf
                    {{-- Method spoofing untuk edit --}}
                    @if(isset($editData)) @method('PUT') @endif

                    {{-- ---- Input Tipe Hari ---- --}}
                    <div>
                        <label for="tipe" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Tipe Hari
                        </label>
                        <select id="tipe" name="tipe" required
                                class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none bg-white @error('tipe') border-red-400 @enderror">
                            <option value="" disabled {{ !isset($editData) ? 'selected' : '' }}>— Pilih Tipe —</option>
                            {{-- Libur Nasional: tidak memotong kuota, tidak dihitung hari kerja --}}
                            <option value="libur_nasional"
                                {{ (isset($editData) && $editData->tipe === 'libur_nasional') || old('tipe') === 'libur_nasional' ? 'selected' : '' }}>
                                🔴 Libur Nasional
                            </option>
                            {{-- Blackout Date: pegawai dilarang mengajukan cuti --}}
                            <option value="blackout"
                                {{ (isset($editData) && $editData->tipe === 'blackout') || old('tipe') === 'blackout' ? 'selected' : '' }}>
                                🟠 Blokir Cuti (Blackout Date)
                            </option>
                        </select>

                        {{-- Deskripsi dinamis berdasarkan tipe yang dipilih --}}
                        <p id="desc-libur" class="hidden mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Tidak memotong kuota & tidak dihitung sebagai hari kerja.
                        </p>
                        <p id="desc-blackout" class="hidden mt-1.5 text-xs text-orange-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            Pegawai dilarang mengajukan cuti pada tanggal ini.
                        </p>
                        @error('tipe') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- ---- Input Nama Hari Libur ---- --}}
                    <div>
                        <label for="nama" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Nama Hari / Kegiatan
                        </label>
                        <input type="text" id="nama" name="nama"
                               value="{{ old('nama', $editData->nama ?? '') }}"
                               placeholder="Contoh: Libur Cuti Bersama"
                               required
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none @error('nama') border-red-400 @enderror">
                        @error('nama') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- ---- Toggle Tipe Tanggal ---- --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-2 flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Pilih Tanggal
                        </label>

                        {{-- Toggle antara tanggal tunggal dan range --}}
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

                        {{-- Mode: Tanggal Tunggal --}}
                        <div id="mode-single">
                            <input type="date" name="tanggal_mulai" id="tanggal_tunggal"
                                   value="{{ old('tanggal_mulai', isset($editData) && !$editData->tanggal_selesai ? $editData->tanggal_mulai : '') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none @error('tanggal_mulai') border-red-400 @enderror">
                            @error('tanggal_mulai') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Mode: Range Tanggal --}}
                        <div id="mode-range" class="hidden space-y-2">
                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Dari</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_dari"
                                       value="{{ old('tanggal_mulai', isset($editData) && $editData->tanggal_selesai ? $editData->tanggal_mulai : '') }}"
                                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-400 mb-1">Sampai</label>
                                <input type="date" name="tanggal_selesai"
                                       value="{{ old('tanggal_selesai', $editData->tanggal_selesai ?? '') }}"
                                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    {{-- ---- Tombol Aksi ---- --}}
                    <div class="flex gap-2 pt-1">
                        {{-- Jika mode edit, tampilkan tombol Batal --}}
                        @if(isset($editData))
                        <a href="{{ route('masterkalender.index') }}"
                           class="flex-1 flex items-center justify-center gap-1.5 px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Batal
                        </a>
                        @endif

                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-1.5 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-green-500 text-white rounded-lg text-sm font-bold hover:from-emerald-700 hover:to-green-600 hover:shadow-lg hover:scale-[1.02] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($editData) ? 'Perbarui' : 'Simpan' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ==========================================
             KOLOM KANAN: DAFTAR RIWAYAT
        =========================================== --}}
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
                    {{-- Counter total data --}}
                    <span class="text-xs bg-white/20 text-white px-2.5 py-1 rounded-full font-semibold">
                        {{ $kalenders->total() ?? count($kalenders) }} entri
                    </span>
                </div>

                {{-- Filter / Search bar --}}
                <div class="px-5 py-3 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row gap-2">
                    <form method="GET" action="{{ route('masterkalender.index') }}" class="flex gap-2 flex-1">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama hari atau kegiatan..."
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition-all">
                        <select name="filter_tipe"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 outline-none transition-all bg-white">
                            <option value="">Semua Tipe</option>
                            <option value="libur_nasional" {{ request('filter_tipe') === 'libur_nasional' ? 'selected' : '' }}>Libur Nasional</option>
                            <option value="blackout" {{ request('filter_tipe') === 'blackout' ? 'selected' : '' }}>Blackout Date</option>
                        </select>
                        <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-semibold hover:bg-emerald-700 transition-all">
                            Cari
                        </button>
                        @if(request('search') || request('filter_tipe'))
                        <a href="{{ route('masterkalender.index') }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg text-sm text-gray-500 hover:bg-gray-100 transition-all">
                            Reset
                        </a>
                        @endif
                    </form>
                </div>

                {{-- Isi tabel --}}
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

                            {{-- Cek apakah data ada atau kosong --}}
                            @forelse($kalenders as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">

                                {{-- Nomor urut (support pagination) --}}
                                <td class="px-4 py-3.5 text-gray-400 text-xs font-medium">
                                    {{ ($kalenders->currentPage() - 1) * $kalenders->perPage() + $loop->iteration }}
                                </td>

                                {{-- Nama hari/kegiatan --}}
                                <td class="px-4 py-3.5">
                                    <p class="font-semibold text-gray-800">{{ $item->nama }}</p>
                                </td>

                                {{-- Tampilkan tanggal: jika ada tanggal_selesai, tampilkan sebagai range --}}
                                <td class="px-4 py-3.5">
                                    @if($item->tanggal_selesai && $item->tanggal_selesai !== $item->tanggal_mulai)
                                        {{-- Mode range --}}
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded text-xs font-medium">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                            </span>
                                            <span class="text-gray-400 text-xs">s/d</span>
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded text-xs font-medium">
                                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                            </span>
                                        </div>
                                    @else
                                        {{-- Mode tanggal tunggal --}}
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded text-xs font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Badge tipe dengan warna berbeda --}}
                                <td class="px-4 py-3.5">
                                    @if($item->tipe === 'libur_nasional')
                                        {{-- Badge merah untuk Libur Nasional --}}
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Libur Nasional
                                        </span>
                                    @elseif($item->tipe === 'blackout')
                                        {{-- Badge oranye untuk Blackout Date --}}
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 border border-orange-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                            Blackout Date
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                            {{ ucfirst($item->tipe) }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Tombol aksi: Edit & Hapus --}}
                                <td class="px-4 py-3.5">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Edit: arahkan ke route edit --}}
                                        <a href="{{ route('masterkalender.edit', $item->id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>

                                        {{-- Tombol Hapus: gunakan form POST dengan method DELETE --}}
                                        <form action="{{ route('masterkalender.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus \'{{ $item->nama }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- Empty state: tampil jika tidak ada data --}}
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-500">Belum ada data kalender</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Tambahkan hari libur atau blackout date melalui form di sebelah kiri.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(isset($kalenders) && method_exists($kalenders, 'links'))
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $kalenders->withQueryString()->links() }}
                </div>
                @endif

            </div>

            {{-- Legenda badge --}}
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
    // ===== Toggle Mode Tanggal (Tunggal / Range) =====
    function switchDateMode(mode) {
        const modeSingle = document.getElementById('mode-single');
        const modeRange  = document.getElementById('mode-range');
        const btnSingle  = document.getElementById('btn-single');
        const btnRange   = document.getElementById('btn-range');
        const inputSingle = document.getElementById('tanggal_tunggal');
        const inputDari   = document.getElementById('tanggal_dari');

        if (mode === 'single') {
            modeSingle.classList.remove('hidden');
            modeRange.classList.add('hidden');
            btnSingle.classList.add('bg-emerald-600', 'text-white');
            btnSingle.classList.remove('bg-white', 'text-gray-500');
            btnRange.classList.add('bg-white', 'text-gray-500');
            btnRange.classList.remove('bg-emerald-600', 'text-white');
            // Aktifkan required pada input tunggal, nonaktifkan range
            inputSingle.required = true;
            inputDari.required   = false;
        } else {
            modeRange.classList.remove('hidden');
            modeSingle.classList.add('hidden');
            btnRange.classList.add('bg-emerald-600', 'text-white');
            btnRange.classList.remove('bg-white', 'text-gray-500');
            btnSingle.classList.add('bg-white', 'text-gray-500');
            btnSingle.classList.remove('bg-emerald-600', 'text-white');
            inputSingle.required = false;
            inputDari.required   = true;
        }
    }

    // ===== Tampilkan deskripsi sesuai tipe yang dipilih =====
    document.getElementById('tipe').addEventListener('change', function () {
        document.getElementById('desc-libur').classList.add('hidden');
        document.getElementById('desc-blackout').classList.add('hidden');

        if (this.value === 'libur_nasional') {
            document.getElementById('desc-libur').classList.remove('hidden');
        } else if (this.value === 'blackout') {
            document.getElementById('desc-blackout').classList.remove('hidden');
        }
    });

    // ===== Inisialisasi saat halaman load =====
    document.addEventListener('DOMContentLoaded', function () {
        // Jika mode edit dan punya tanggal_selesai, tampilkan mode range otomatis
        @if(isset($editData) && $editData->tanggal_selesai && $editData->tanggal_selesai !== $editData->tanggal_mulai)
            switchDateMode('range');
        @endif

        // Picu event change pada select tipe agar deskripsi muncul jika ada old value
        const tipeSelect = document.getElementById('tipe');
        if (tipeSelect.value) tipeSelect.dispatchEvent(new Event('change'));
    });
</script>

@endsection