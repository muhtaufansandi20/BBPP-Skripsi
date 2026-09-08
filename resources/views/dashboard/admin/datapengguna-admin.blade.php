@extends('dashboard.admin.base-admin')
@section('main')
    <div class="w-full mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Dashboard Statistik -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div
                    class="bg-gradient-to-r from-blue-50 to-white p-4 rounded-xl border border-blue-100 shadow-sm relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xs uppercase tracking-wider text-blue-700 mb-3 flex items-center">
                        <span class="w-2 h-2 bg-blue-600 rounded-full mr-2"></span>
                        Kepala Balai
                    </h3>
                    @if ($kepalaBalai)
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-600 p-2 rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 leading-tight">{{ $kepalaBalai->name }}</p>
                                <p class="text-xs text-blue-600 mt-1 font-mono">NIP. {{ $kepalaBalai->nip }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 py-2">
                            <div class="bg-gray-100 p-2 rounded-lg border border-dashed border-gray-300">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 italic font-medium">Data Kepala Balai belum diatur</p>
                        </div>
                    @endif
                </div>

                <div
                    class="bg-gradient-to-r from-emerald-50 to-white p-4 rounded-xl border border-emerald-100 shadow-sm relative overflow-hidden">
                    <div class="absolute right-0 top-0 opacity-10">
                        <svg class="w-20 h-20 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xs uppercase tracking-wider text-emerald-700 mb-3 flex items-center">
                        <span class="w-2 h-2 bg-emerald-600 rounded-full mr-2"></span>
                        Kepala Bagian Umum
                    </h3>
                    @if ($kepalaBagianUmum)
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-600 p-2 rounded-lg shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-gray-800 leading-tight">{{ $kepalaBagianUmum->name }}</p>
                                <p class="text-xs text-emerald-600 mt-1 font-mono">NIP. {{ $kepalaBagianUmum->nip }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 py-2">
                            <div class="bg-gray-100 p-2 rounded-lg border border-dashed border-gray-300">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 italic font-medium">Data Kabag Umum belum diatur</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div
                    class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-blue-200 transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <div
                            class="p-2 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-full uppercase">TIM</span>
                    </div>
                    <p class="text-gray-500 text-xs font-medium">Kepala Tim Kerja</p>
                    <p class="text-2xl font-black text-gray-800">{{ $jumlahKepalaTim }}</p>
                </div>

                <div
                    class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-violet-200 transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <div
                            class="p-2 bg-violet-50 text-violet-600 rounded-lg group-hover:bg-violet-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span
                            class="text-[10px] font-bold text-violet-500 bg-violet-50 px-2 py-1 rounded-full uppercase">FUNGSIONAL</span>
                    </div>
                    <p class="text-gray-500 text-xs font-medium">Widyaiswara</p>
                    <p class="text-2xl font-black text-gray-800">{{ $jumlahwidyaiswara }}</p>
                </div>

                <div
                    class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-amber-200 transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <div
                            class="p-2 bg-amber-50 text-amber-600 rounded-lg group-hover:bg-amber-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span
                            class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-full uppercase">STAF</span>
                    </div>
                    <p class="text-gray-500 text-xs font-medium">Pegawai</p>
                    <p class="text-2xl font-black text-gray-800">{{ $jumlahPegawaiBiasa }}</p>
                </div>

                <div
                    class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:border-indigo-200 transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <div
                            class="p-2 bg-indigo-50 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span
                            class="text-[10px] font-bold text-indigo-500 bg-indigo-50 px-2 py-1 rounded-full uppercase">TOTAL</span>
                    </div>
                    <p class="text-gray-500 text-xs font-medium">Total Pengguna</p>
                    <p class="text-2xl font-black text-gray-800">{{ $totalUser }}</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h2>
                <p class="text-xs text-gray-500 mt-1">Kelola data pengguna sistem</p>
            </div>
           <a href="{{ route('admindatapengguna.create') }}"
                class="flex items-center gap-2 bg-gradient-to-br from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white text-sm px-3 py-2 rounded-md transition-all shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah User
            </a>
        </div>

        <!-- Search Form -->
        <div class="mb-6">
            <form action="{{ route('admindatapengguna.index') }}" method="GET" class="flex gap-3 items-center">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pengguna"
                        class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all shadow-sm">
                </div>

                <button type="submit"
                    class="flex items-center gap-2 bg-gradient-to-br from-accent/90 to-accent/60 text-white px-5 py-2 rounded-xl hover:from-accent hover:to-accent/70 transition-all shadow-md hover:shadow-lg active:scale-95">
                    <span>Cari</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>

                @if (isset($search) && $search)
                    <a href="{{ route('admindatapengguna.index') }}"
                        class="flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        <span>Reset</span>
                    </a>
                @endif
            </form>
        </div>

        <!-- Search Results Info -->
        @if (isset($search) && $search)
            <div class="mb-4 bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-4">
                <p>Hasil pencarian untuk: <strong>{{ $search }}</strong> ({{ $users->count() }} hasil)</p>
            </div>
        @endif

        <div class="w-full overflow-x-auto">
            <table class="w-full table-auto bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gradient-to-r from-primary to-lime-500">
                        <th
                            class="px-3 py-3 border-b w-10 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            #</th>
                        <th class="px-3 py-3 border-b text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Nama</th>
                        <th class="px-3 py-3 border-b text-left text-xs font-semibold text-white uppercase tracking-wider">
                            NIP</th>
                        <th
                            class="px-3 py-3 border-b text-left text-xs font-semibold text-white uppercase tracking-wider w-20">
                            Role</th>
                        <th class="px-3 py-3 border-b text-left text-xs font-semibold text-white uppercase tracking-wider">
                            No HP</th>
                        <th class="px-3 py-3 border-b text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Jabatan</th>
                        <th
                            class="px-3 py-3 border-b text-left text-xs font-semibold text-white uppercase tracking-wider w-32 text-center">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $users->firstItem() + $index }}</td>
                            <td
                                class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900 truncate max-w-[180px]">
                                {{ $user->name }}</td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $user->nip }}</td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-800 capitalize">{{ $user->role }}</span>
                                    @if ($user->role == 'kepalabagian' || $user->role == 'kepalabalai')
                                        <span
                                            class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Unik
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $user->no_hp ?? '-' }}</td>
                            <td class="px-3 py-3 text-sm text-gray-500 truncate max-w-[200px]">{{ $user->jabatan ?? '-' }}
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admindatapengguna.edit', $user->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200
                                    bg-white border border-blue-100 text-blue-600 
                                    hover:bg-blue-50 hover:border-blue-200 hover:text-blue-700
                                    focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-300
                                    shadow-sm hover:shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <button type="button"
                                        onclick="prepareDelete('{{ $user->id }}', '{{ $user->name }}')"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-200 bg-white border border-red-100 text-red-600 hover:bg-red-50 hover:border-red-200 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-300 shadow-sm hover:shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                @if (isset($search) && $search)
                                    Tidak ada pengguna yang sesuai dengan pencarian "{{ $search }}"
                                @else
                                    Belum ada data pengguna
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">

        <div
            class="relative bg-white rounded-[40px] shadow-2xl max-w-md w-full p-10 text-center 
        border-[24px] border-white/65 bg-clip-padding">

            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center animate-pulse">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                        <div
                            class="w-10 h-10 bg-[#FF4D67] rotate-45 rounded-lg flex items-center justify-center shadow-lg shadow-red-200">
                            <span class="text-white text-2xl font-bold -rotate-45">!</span>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-[#1A202C] text-2xl font-bold mb-4">Hapus Pengguna?</h3>

            <p class="text-gray-500 text-sm leading-relaxed mb-8 px-2">
                Apakah Anda yakin ingin menghapus <br>
                <span id="deleteUserName" class="font-black text-gray-800 text-base"></span>?<br>
                <span class="text-red-500 font-medium">Data yang telah dihapus tidak dapat dikembalikan.</span>
            </p>

            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')

                <div class="flex gap-4 justify-center">
                    <button type="submit"
                        class="flex-1 bg-[#FF4D67] hover:bg-red-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-red-100 active:scale-95">
                        Hapus
                    </button>

                    <button type="button" onclick="closeDeleteModal()"
                        class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 px-6 rounded-xl transition-all duration-200 active:scale-95">
                        Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- All Notifications as Snackbars -->
    <div id="snackbarContainer" class="fixed top-5 right-5 flex flex-col gap-3"></div>

    <div class="py-4">
        <div class="shadow-sm rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full">
            </table>

            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $users->links() }}
            </div>
        </div>

        @if ($users->isEmpty())
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to create and manage snackbars
            function createSnackbar(message, subMessage, type) {
                const container = document.getElementById("snackbarContainer");

                // Create snackbar element
                const snackbar = document.createElement("div");
                snackbar.className =
                    "flex items-center gap-3 bg-white p-4 rounded-xl shadow-lg border-l-4 transition-all duration-300 ease-in-out";

                // Set border color based on type
                if (type === "success") {
                    snackbar.classList.add("border-green-500");
                } else if (type === "info") {
                    snackbar.classList.add("border-blue-500");
                } else if (type === "error") {
                    snackbar.classList.add("border-red-500");
                }

                // Icon based on type
                let iconSvg = "";
                if (type === "success") {
                    iconSvg =
                        '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>';
                } else if (type === "info") {
                    iconSvg =
                        '<svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                } else if (type === "error") {
                    iconSvg =
                        '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                }

                // Set content
                snackbar.innerHTML = `
                ${iconSvg}
                <div>
                    <p class="font-semibold text-black">${message}</p>
                    ${subMessage ? `<p class="text-gray-600 text-sm">${subMessage}</p>` : ''}
                </div>
            `;

                // Add to container
                container.appendChild(snackbar);

                // Remove after 3 seconds
                setTimeout(() => {
                    snackbar.classList.add("opacity-0", "translate-y-5");
                    setTimeout(() => snackbar.remove(), 200);
                }, 3000);
            }

            // Display snackbars for session messages
            @if (session('success'))
                createSnackbar("{{ session('success') }}", "Cek data pengguna sekarang", "success");
            @endif

            @if (session('error'))
                createSnackbar("Error", "{{ session('error') }}", "error");
            @endif

            @if (isset($hasKepalaBagian) && $hasKepalaBagian)
                createSnackbar("Informasi", "User dengan role Kepala Bagian sudah ada dalam sistem.", "info");
            @endif

            @if (isset($hasKepalaBalai) && $hasKepalaBalai)
                createSnackbar("Informasi", "User dengan role Kepala Balai sudah ada dalam sistem.", "info");
            @endif
        });

        function prepareDelete(userId, userName) {
            const modal = document.getElementById("deleteModal");
            const form = document.getElementById("deleteForm");
            const nameDisplay = document.getElementById("deleteUserName");

            // Set nama user di teks modal
            nameDisplay.innerText = userName;

            // Set URL action secara dinamis
            // Sesuaikan dengan struktur URL route Anda, contoh: /admindatapengguna/1
            form.action = `/admindatapengguna/${userId}`;

            modal.style.display = "flex";
        }

        function prepareDelete(userId, userName) {
            const modal = document.getElementById("deleteModal");
            const form = document.getElementById("deleteForm");
            const nameDisplay = document.getElementById("deleteUserName");

            // 1. Tampilkan Nama User yang akan dihapus
            nameDisplay.innerText = userName;

            // 2. Set URL Action Form secara dinamis
            // Ganti 'admindatapengguna' sesuai dengan prefix route Anda
            form.action = `/admindatapengguna/${userId}`;

            // 3. Munculkan Modal dengan flex (karena Tailwind 'hidden' akan menutupnya)
            modal.classList.remove("hidden");
            modal.classList.add("flex");

            // Mencegah scroll pada body saat modal terbuka
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            const modal = document.getElementById("deleteModal");
            modal.classList.add("hidden");
            modal.classList.remove("flex");

            // Mengembalikan scroll
            document.body.style.overflow = 'auto';
        }

        // Menutup modal jika klik di area luar modal (backdrop)
        window.onclick = function(event) {
            const modal = document.getElementById("deleteModal");
            if (event.target == modal) {
                closeDeleteModal();
            }
        }
    </script>
@endsection
