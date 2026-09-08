@extends('dashboard.admin.base-admin')
@section('main')

<!-- Load CSS & JS Tom Select & SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    
    <!-- Notifikasi Flash Message -->
    @if (session('success'))
        <div class="mb-6 bg-white border-l-4 border-[#00b074] rounded-2xl shadow-sm px-4 py-3 flex items-center justify-between border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-emerald-50 text-[#00b074] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-800">{{ session('success') }}</p>
                    <p class="text-[11px] text-gray-400">Cek data tim kerja sekarang</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Dashboard Tim Kerja -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="mb-5">
            <h2 class="text-base font-bold text-gray-800">Dashboard Tim Kerja</h2>
            <p class="text-xs text-gray-400 mt-0.5">Ringkasan seluruh tim kerja</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
                $timGroups = $anggotaTims->groupBy('tim_id');
                $teamThemes = [
                    ['card' => 'bg-[#eef8f2] border-l-4 border-[#00b074]', 'group_bg' => 'bg-[#eef8f2]', 'group_border' => 'border-l-4 border-[#00b074]', 'text' => 'text-[#00b074]'],
                    ['card' => 'bg-[#fdf0f4] border-l-4 border-[#e95782]', 'group_bg' => 'bg-[#fdf0f4]', 'group_border' => 'border-l-4 border-[#e95782]', 'text' => 'text-[#e95782]'],
                    ['card' => 'bg-[#f6f2fc] border-l-4 border-[#9360d8]', 'group_bg' => 'bg-[#f6f2fc]', 'group_border' => 'border-l-4 border-[#9360d8]', 'text' => 'text-[#9360d8]'],
                    ['card' => 'bg-[#fef6ed] border-l-4 border-[#f39c38]', 'group_bg' => 'bg-[#fef6ed]', 'group_border' => 'border-l-4 border-[#f39c38]', 'text' => 'text-[#f39c38]'],
                    ['card' => 'bg-[#edf5fd] border-l-4 border-[#4a97ee]', 'group_bg' => 'bg-[#edf5fd]', 'group_border' => 'border-l-4 border-[#4a97ee]', 'text' => 'text-[#4a97ee]'],
                ];
                $teamsWithKetua = $anggotaTims->where('role', 'Ketua')->pluck('tim_id')->toArray();
            @endphp

            @foreach($timGroups as $index => $anggotaGroup)
                @php
                    $tim = $anggotaGroup->first()->tim;
                    $ketua = $anggotaGroup->firstWhere('role', 'Ketua');
                    $jumlahAnggota = $anggotaGroup->count();
                    $theme = $teamThemes[$index % count($teamThemes)];
                    $timId = $tim->id;
                @endphp
                
                <div class="rounded-2xl p-5 shadow-xs transition-all hover:shadow-md flex flex-col justify-between {{ $theme['card'] }}">
                    <div>
                        <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wide truncate">
                            {{ $tim->nama_tim }}
                        </h3>
                        
                        <div class="mt-2.5">
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider">KETUA TIM</p>
                            @if($ketua)
                                <p class="text-xs font-medium text-gray-700 truncate flex items-center mt-0.5">
                                    <svg class="w-3.5 h-3.5 mr-1 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="truncate">{{ $ketua->user->name }}</span>
                                </p>
                            @else
                                <p class="text-xs text-red-500 italic truncate mt-0.5">Belum ada ketua</p>
                            @endif
                        </div>

                        <p class="text-xs font-bold mt-4 {{ $theme['text'] }}">
                            {{ $jumlahAnggota }} anggota
                        </p>
                    </div>
                    
                    <div class="mt-4 pt-3 flex justify-between items-center border-t border-black/5">
                        <div class="flex -space-x-1.5">
                            @foreach($anggotaGroup->take(4) as $anggota)
                                <div class="w-6 h-6 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[10px] font-semibold text-gray-600 overflow-hidden shadow-xs" title="{{ $anggota->user->name }}">
                                    @if($anggota->user->profile_photo_path)
                                        <img src="{{ asset($anggota->user->profile_photo_path) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($anggota->user->name, 0, 1) }}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <a href="#tim-{{ $timId }}" class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center">
                            Detail <span class="ml-1 text-[10px]">&gt;</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tabel Daftar Anggota Tim -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
            <div>
                <h2 class="text-base font-bold text-gray-800">Daftar Anggota Tim</h2>
                <p class="text-xs text-gray-400 mt-0.5">Kelola seluruh anggota tim kerja</p>
            </div>
            
            <button type="button" onclick="openTambahAnggotaModal()" 
                class="inline-flex items-center px-4 py-2 bg-[#00b074] hover:bg-[#009b63] text-white text-xs font-medium rounded-xl shadow-xs transition-all">
                + Tambah Anggota
            </button>
        </div>

        <!-- Form Pencarian -->
        <form action="{{ route('adminanggotatim.index') }}" method="GET" class="mb-5">
            <div class="flex items-center gap-2">
                <div class="relative flex-grow">
                    <input type="text" name="search" 
                           class="block w-full pl-4 pr-10 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#00b074] text-xs placeholder-gray-400" 
                           placeholder="Cari berdasarkan Nama Tim..." 
                           value="{{ request('search') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-[#fa8231] hover:bg-[#eb7422] text-white text-xs font-medium rounded-xl shadow-xs transition-all flex-shrink-0">
                    <span class="mr-1">Cari</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
                @if(request('search'))
                    <a href="{{ route('adminanggotatim.index') }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-200 text-xs font-medium rounded-xl text-gray-600 bg-white hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel Anggota -->
        <div class="overflow-x-auto rounded-xl border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#78b93b] text-white">
                        <th class="px-4 py-2.5 text-[11px] font-bold uppercase tracking-wider">TIM</th>
                        <th class="px-4 py-2.5 text-[11px] font-bold uppercase tracking-wider">ANGGOTA</th>
                        <th class="px-4 py-2.5 text-[11px] font-bold uppercase tracking-wider">ROLE</th>
                        <th class="px-4 py-2.5 text-[11px] font-bold uppercase tracking-wider">JABATAN</th>
                        <th class="px-4 py-2.5 text-center text-[11px] font-bold uppercase tracking-wider">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($timGroups as $index => $anggotaGroup)
                        @php
                            $tim = $anggotaGroup->first()->tim;
                            $timId = $tim->id;
                            $theme = $teamThemes[$index % count($teamThemes)];
                        @endphp
                        
                        <!-- Header Tim -->
                        <tr id="tim-{{ $timId }}" class="{{ $theme['group_bg'] }}">
                            <td colspan="5" class="px-4 py-2.5 text-xs font-bold text-gray-800 uppercase tracking-wide {{ $theme['group_border'] }}">
                                {{ $tim->nama_tim }}
                            </td>
                        </tr>

                        @foreach ($anggotaGroup as $anggota)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="px-4 py-3 text-xs text-gray-400 uppercase font-medium">
                                    {{ $tim->nama_tim }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center flex-shrink-0 text-gray-400">
                                            @if($anggota->user->profile_photo_path)
                                                <img src="{{ asset($anggota->user->profile_photo_path) }}" class="w-full h-full object-cover rounded-full">
                                            @else
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-800 leading-snug">{{ $anggota->user->name }}</p>
                                            <p class="text-[11px] text-gray-400">{{ $anggota->user->nip ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs">
                                    @if(strtolower($anggota->role) === 'ketua')
                                        <span class="font-medium text-emerald-600">( Ketua )</span>
                                    @else
                                        <span class="text-gray-600">Anggota</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-xs text-gray-600 font-normal">
                                    {{ $anggota->user->jabatan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                            data-id="{{ $anggota->id }}"
                                            data-nama="{{ $anggota->user->name }}"
                                            data-nip="{{ $anggota->user->nip ?? '-' }}"
                                            data-jabatan="{{ $anggota->user->jabatan ?? '-' }}"
                                            data-tim-id="{{ $anggota->tim_id }}"
                                            data-role="{{ $anggota->role }}"
                                            data-url="{{ route('adminanggotatim.update', $anggota->id) }}"
                                            onclick="openEditAnggotaModal(this)"
                                            class="text-blue-500 hover:text-blue-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        
                                        <form action="{{ route('adminanggotatim.destroy', $anggota->id) }}" method="POST" class="inline" id="delete-anggota-form-{{ $anggota->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" 
                                                onclick="confirmDeleteAnggota('{{ $anggota->id }}', '{{ addslashes($anggota->user->name) }}', '{{ addslashes($tim->nama_tim) }}')" 
                                                class="text-red-500 hover:text-red-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-xs text-gray-400">Tidak ada data ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($anggotaTims, 'links'))
            <div class="mt-4">
                {{ $anggotaTims->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH ANGGOTA -->
    <div id="modalTambahAnggota" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 hidden">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-gray-100 transform transition-all">
            
            <div class="bg-gradient-to-r from-emerald-400 to-green-500 px-6 py-4 flex justify-between items-center text-white">
                <h2 class="text-lg font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Anggota Tim
                </h2>
                <button type="button" onclick="closeModal('modalTambahAnggota')" class="text-white hover:text-gray-100 text-2xl font-bold leading-none">&times;</button>
            </div>

            <form id="formTambahAnggota" method="POST" action="{{ route('adminanggotatim.store') }}" class="p-6 space-y-4">
                @csrf

                <div class="space-y-1">
                    <label for="modal_tim_id" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        Tim Kerja
                    </label>
                    <select name="tim_id" id="modal_tim_id" class="searchable-select w-full" placeholder="Pilih Tim Kerja" required>
                        <option value="">Pilih Tim Kerja</option>
                        @foreach ($timKerjas as $tim)
                            <option value="{{ $tim->id }}" data-has-ketua="{{ in_array($tim->id, $teamsWithKetua) ? '1' : '0' }}" {{ old('tim_id') == $tim->id ? 'selected' : '' }}>
                                {{ $tim->nama_tim }}
                            </option>
                        @endforeach
                    </select>
                    @error('tim_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="modal_user_id" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        Nama Pegawai
                    </label>
                    <select name="user_id" id="modal_user_id" class="searchable-select w-full" placeholder="Pilih Pengguna" required>
                        <option value="">Pilih Pengguna</option>
                        <optgroup label="--- KHUSUS KETUA TIM ---">
                            @foreach ($calonKetua as $user)
                                <option value="{{ $user->id }}" data-type="ketua" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->nip }}) - {{ $user->jabatan }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="--- CALON ANGGOTA BIASA ---">
                            @foreach ($calonAnggota as $user)
                                <option value="{{ $user->id }}" data-type="anggota" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->nip }}) - {{ $user->jabatan }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('user_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label for="modal_role" class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        Peran Anggota
                    </label>
                    <select name="role" id="modal_role" class="searchable-select w-full" placeholder="Pilih Peran" required>
                        <option value="">Pilih Peran</option>
                        <option value="Ketua" {{ old('role') == 'Ketua' ? 'selected' : '' }}>Ketua Tim</option>
                        <option value="anggota" {{ old('role') == 'anggota' ? 'selected' : '' }}>Anggota Tim</option>
                    </select>
                    @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('modalTambahAnggota')" class="px-5 py-2.5 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        Batalkan
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#00b074] text-white text-sm font-medium rounded-xl hover:bg-[#009b63] transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ANGGOTA TIM -->
    <div id="modalEditAnggota" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 hidden">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform transition-all">
            
            <div class="bg-gradient-to-r from-[#00b074] to-[#70c239] px-6 py-4 flex justify-between items-center text-white">
                <h2 class="text-lg font-bold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Anggota Tim
                </h2>
                <button type="button" onclick="closeModal('modalEditAnggota')" class="text-white hover:text-gray-100 text-2xl font-bold leading-none">&times;</button>
            </div>

            <form id="formEditAnggota" method="POST" action="" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                <div class="border border-gray-200 rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#fef0ea] text-[#fa8231] flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1 space-y-1">
                        <h4 class="font-bold text-gray-800 text-sm truncate" id="editNamaPegawai">-</h4>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium truncate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-800 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 3a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm0 4a1 1 0 011-1h2a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>NIP : <span id="editNipPegawai">-</span></span>
                        </p>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium truncate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-800 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                            </svg>
                            <span>Jabatan : <span id="editJabatanPegawai">-</span></span>
                        </p>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        Tim Kerja
                    </label>
                    <div class="relative">
                        <select name="tim_id" id="editTimId" required
                                class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] text-sm text-gray-700 appearance-none">
                            <option value="">Pilih Tim Kerja</option>
                            @foreach ($timKerjas as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->nama_tim }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700 flex items-center gap-2">
                        Peran Anggota
                    </label>
                    <div class="relative">
                        <select name="role" id="editRole" required
                                class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] text-sm text-gray-700 appearance-none">
                            <option value="">Pilih Peran</option>
                            <option value="Ketua">Ketua</option>
                            <option value="anggota">Anggota</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" onclick="closeModal('modalEditAnggota')" class="px-6 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        Batalkan
                    </button>
                    <button type="submit" class="px-7 py-2 bg-[#00b074] hover:bg-[#009b63] text-white text-sm font-medium rounded-xl transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- Script Modal & Validasi Penambahan Anggota -->
<script>
    let tomSelectInstances = [];

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    function openTambahAnggotaModal() {
        openModal('modalTambahAnggota');
        setTimeout(() => {
            if (typeof TomSelect !== 'undefined' && tomSelectInstances.length === 0) {
                document.querySelectorAll('#modalTambahAnggota .searchable-select').forEach((el) => {
                    if (!el.tomselect) {
                        let instance = new TomSelect(el, { create: false });
                        tomSelectInstances.push(instance);
                    }
                });
            }
        }, 50);
    }

    function openEditAnggotaModal(btn) {
        const nama = btn.getAttribute('data-nama');
        const nip = btn.getAttribute('data-nip');
        const jabatan = btn.getAttribute('data-jabatan');
        const timId = btn.getAttribute('data-tim-id');
        const role = btn.getAttribute('data-role');
        const url = btn.getAttribute('data-url');

        document.getElementById('editNamaPegawai').textContent = nama || '-';
        document.getElementById('editNipPegawai').textContent = nip || '-';
        document.getElementById('editJabatanPegawai').textContent = jabatan || '-';
        document.getElementById('editTimId').value = timId || '';
        document.getElementById('editRole').value = role || '';
        document.getElementById('formEditAnggota').action = url;

        openModal('modalEditAnggota');
    }

    function confirmDeleteAnggota(id, namaPegawai, namaTim) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: '<span class="text-xl font-bold text-gray-800">Hapus Tim Kerja?</span>',
                html: `<p class="text-sm text-gray-600 mt-2">Apakah Anda yakin ingin menghapus <b>${namaPegawai}</b></p><p class="text-sm text-gray-600 mt-1">Dari Tim Kerja <b class="text-[#00b074] uppercase">${namaTim}</b> ?</p>`,
                icon: 'error',
                iconColor: '#f43f5e',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Batalkan',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-3xl p-6 max-w-sm',
                    confirmButton: 'px-7 py-2 bg-[#f43f5e] hover:bg-[#e11d48] text-white font-medium rounded-xl text-sm transition-all mr-3',
                    cancelButton: 'px-7 py-2 border border-gray-300 text-gray-700 font-medium rounded-xl text-sm hover:bg-gray-50 transition-all'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-anggota-form-' + id).submit();
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus ${namaPegawai} dari tim ${namaTim}?`)) {
                document.getElementById('delete-anggota-form-' + id).submit();
            }
        }
    }

    // Validasi Form Tambah Anggota saat Submit
    document.addEventListener('DOMContentLoaded', function () {
        const formTambah = document.getElementById('formTambahAnggota');
        if (formTambah) {
            formTambah.addEventListener('submit', function (e) {
                const userSelect = document.getElementById('modal_user_id');
                const roleSelect = document.getElementById('modal_role');
                const timSelect = document.getElementById('modal_tim_id');

                const selectedUserVal = userSelect.value;
                const selectedRoleVal = roleSelect.value;
                const selectedTimVal = timSelect.value;

                // Dapatkan option yang dipilih
                const selectedUserOpt = userSelect.querySelector(`option[value="${selectedUserVal}"]`);
                const selectedTimOpt = timSelect.querySelector(`option[value="${selectedTimVal}"]`);

                const userCategory = selectedUserOpt ? selectedUserOpt.getAttribute('data-type') : null;
                const teamHasKetua = selectedTimOpt ? (selectedTimOpt.getAttribute('data-has-ketua') === '1') : false;

                // 1. Pegawai kategori 'ketua' tapi role yang dipilih 'anggota'
                if (userCategory === 'ketua' && selectedRoleVal.toLowerCase() === 'anggota') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Role Tidak Sesuai',
                        text: 'Pegawai ini terdaftar pada kategori Khusus Ketua Tim, sehingga tidak dapat dipilih sebagai Anggota Tim.',
                        confirmButtonColor: '#00b074'
                    });
                    return false;
                }

                // 2. Pegawai kategori 'anggota' tapi role yang dipilih 'Ketua'
                if (userCategory === 'anggota' && selectedRoleVal.toLowerCase() === 'ketua') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Role Tidak Sesuai',
                        text: 'Pegawai ini terdaftar pada kategori Calon Anggota Biasa, sehingga tidak dapat dipilih sebagai Ketua Tim.',
                        confirmButtonColor: '#00b074'
                    });
                    return false;
                }

                // 3. Tim sudah memiliki Ketua dan admin mencoba memilih role 'Ketua' lagi
                if (selectedRoleVal.toLowerCase() === 'ketua' && teamHasKetua) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Ketua Tim Sudah Ada',
                        text: 'Tim kerja yang dipilih sudah memiliki Ketua Tim. Satu tim hanya diperbolehkan memiliki satu Ketua.',
                        confirmButtonColor: '#f43f5e'
                    });
                    return false;
                }
            });
        }
    });
</script>

<style>
    .ts-control {
        border-radius: 0.75rem !important;
        padding: 0.65rem 1rem !important;
        background-color: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        box-shadow: none !important;
        font-size: 0.875rem !important;
        color: #374151 !important;
    }
    
    .ts-wrapper.focus .ts-control {
        border-color: #00b074 !important;
        box-shadow: 0 0 0 2px rgba(0, 176, 116, 0.2) !important;
    }

    .ts-dropdown {
        z-index: 9999 !important;
    }
</style>
@endsection