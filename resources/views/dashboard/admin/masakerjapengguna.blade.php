@extends('dashboard.admin.base-admin')

@section('main')
    <div class="container px-4 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Data Masa Kerja Pegawai</h2>
                <p class="text-sm text-gray-500 mt-1">Rekap masa kerja seluruh pegawai</p>
            </div>

            <form action="{{ route('adminmasakerja.index') }}" method="GET" class="w-full md:w-auto">
                <div class="relative flex">
                    <input type="text" name="search"
                        class="w-full md:w-64 px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Cari nama pegawai" value="{{ $search ?? '' }}">
                    <button type="submit" class="absolute right-2.5 top-2.5 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div id="successAlert" class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg flex items-center animate-bounce">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div id="errorAlert" class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="bg-gradient-to-r from-primary to-lime-500">
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Pegawai
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Masa
                                Kerja</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Terakhir
                                Diperbarui</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $index => $user)
                            @php
                                $masaKerjaUser = $masakerja->firstWhere('user_id', $user->id);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-accent/10 rounded-full flex items-center justify-center text-accent">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->nip ?? '-' }}</div>
                                            <div class="text-xs text-gray-400 mt-1">{{ $user->jabatan ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($masaKerjaUser && $masaKerjaUser->jumlah_masa_kerja)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $masaKerjaUser->jumlah_masa_kerja }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">Belum ada data</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($masaKerjaUser && $masaKerjaUser->updated_at)
                                        {{ $masaKerjaUser->updated_at->format('d M Y, H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button
                                        onclick="openModal({{ $user->id }}, '{{ $user->name }}', {{ $masaKerjaUser ? $masaKerjaUser->id : 'null' }}, '{{ $masaKerjaUser ? $masaKerjaUser->jumlah_masa_kerja : '' }}')"
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        {{ $masaKerjaUser ? 'Edit' : 'Tambah' }}
                                    </button>

                                    @if ($masaKerjaUser)
                                        <button onclick="confirmDelete({{ $masaKerjaUser->id }})"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    @if (isset($search) && $search)
                                        Data tidak ditemukan untuk "{{ $search }}"
                                    @else
                                        Belum ada data masa kerja
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4 px-4 py-3 bg-gray-50 border-t border-gray-200 sm:px-6 rounded-b-lg">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Masa Kerja -->
    <div id="masaKerjaModal" class="fixed inset-0 bg-gray-900/70 hidden flex items-center justify-center z-50 p-4">
        <div
            class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 ease-out">
            <!-- Modal Header -->
            <div class="bg-primary p-4 text-gray-100">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 rounded-lg bg-white/10 backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold tracking-tight" id="modalTitle">
                            Hitung Masa Kerja
                        </h3>
                    </div>
                    <button onclick="closeModal()"
                        class="p-1 rounded-full hover:bg-white/30 transition-colors focus:outline-none focus:ring-2 focus:ring-white/100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-sm text-white/80 mt-2" id="modalSubtitle">Pegawai: -</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Honorer Section -->
                <div class="bg-blue-50 rounded-xl p-3 border border-blue-100 shadow-inner">
                    <label class="block text-sm font-semibold text-blue-800 mb-3 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Masa Honorer (Jika Ada)
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="honoryear" class="block text-xs font-medium text-blue-600 mb-2">Tahun</label>
                            <input type="number" id="honoryear" min="0" value="0"
                                class="w-full px-4 py-2.5 text-sm border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label for="honormonth" class="block text-xs font-medium text-blue-600 mb-2">Bulan</label>
                            <select id="honormonth"
                                class="w-full px-4 py-2.5 text-sm border border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                                @for ($i = 0; $i < 12; $i++)
                                    <option value="{{ $i }}">{{ $i }} Bulan</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <p id="honorError" class="text-red-500 text-xs mt-2 hidden flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Nilai tidak boleh negatif
                    </p>
                </div>

                <!-- Date Selection -->
                <div class="space-y-3">
                    <div>
                        <label for="selectedDate" class="block text-sm font-semibold text-gray-700 mb-2">Mulai
                            Bekerja</label>
                        <div class="relative">
                            <input type="month" id="selectedDate"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-400"
                                placeholder="contoh: 2026-01">
                        </div>
                        <p id="dateError"
                            class="text-red-600 text-xs mt-2 hidden transform transition-all duration-300 ease-out origin-top">
                            <span class="inline-flex items-center px-2 py-1 bg-red-50/80 rounded-lg border border-red-100">
                                <svg class="w-3.5 h-3.5 mr-1.5 flex-shrink-0 text-red-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Tanggal tidak boleh lebih besar dari tanggal sekarang</span>
                            </span>
                        </p>
                    </div>
                    <div>
                        <label for="currentDate" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal
                            Sekarang</label>
                        <input type="month" id="currentDate" value="{{ date('Y-m') }}" readonly
                            class="w-full px-4 py-2.5 text-sm bg-gray-100 border border-gray-300 rounded-xl">
                    </div>
                </div>

                <!-- Result -->
                <div id="resultContainer"
                    class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-5 border border-blue-100 shadow-inner hidden transform transition-all duration-300">
                    <div class="flex items-center">
                        <span class="text-sm font-semibold text-blue-800">Total Masa Kerja:</span>
                        <span id="result"
                            class="text-md font-bold bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent ml-4"></span>
                    </div>
                    <div id="honorIndicator" class="mt-2 text-xs text-blue-500 hidden items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Termasuk masa honorer yang diinput
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                <button type="button" onclick="closeModal()"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all">
                    Batal
                </button>
                <button type="button" onclick="hitungSelisih()"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-500 rounded-xl hover:from-blue-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-blue-300 shadow-md hover:shadow-blue-200 transition-all">
                    Hitung
                </button>
                <button type="submit" id="saveButton" form="masaKerjaForm" hidden
                    class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-500 rounded-xl hover:from-green-700 hover:to-emerald-600 focus:outline-none focus:ring-2 focus:ring-green-300 shadow-md hover:shadow-green-200 transition-all">
                    <span class="flex items-center">
                        <span id="saveText">Simpan</span>
                        <span id="saveLoading" class="hidden ml-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </span>
                    </span>
                </button>
            </div>

            <!-- Dynamic Form -->
            <form id="masaKerjaForm" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="user_id" id="userId">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900/70 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden w-full max-w-md">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-center text-gray-900">Hapus Data Masa Kerja?</h3>
                <p class="mt-2 text-sm text-center text-gray-500">Data yang sudah dihapus tidak dapat dikembalikan.</p>

                <form id="deleteForm" method="POST" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentUserId = null;
        let currentMasaKerjaId = null;
        let isEditMode = false;

        function openModal(userId, userName, masaKerjaId, currentMasaKerja) {
            currentUserId = userId;
            currentMasaKerjaId = masaKerjaId;
            isEditMode = masaKerjaId !== null;

            document.getElementById('masaKerjaModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Update modal title and subtitle
            document.getElementById('modalTitle').textContent = isEditMode ? 'Edit Masa Kerja' : 'Tambah Masa Kerja';
            document.getElementById('modalSubtitle').textContent = 'Pegawai: ' + userName;
            document.getElementById('saveText').textContent = isEditMode ? 'Update' : 'Simpan';

            // Set form action and method
            const form = document.getElementById('masaKerjaForm');
            const formMethod = document.getElementById('formMethod');

            if (isEditMode) {
                form.action = `/admin/masakerja/${masaKerjaId}`;
                formMethod.value = 'PUT';
            } else {
                form.action = '/admin/masakerja/store';
                formMethod.value = 'POST';
            }

            // Set user ID
            document.getElementById('userId').value = userId;

            // Reset form
            document.getElementById('honoryear').value = 0;
            document.getElementById('honormonth').value = 0;
            document.getElementById('selectedDate').value = '';
            document.getElementById('resultContainer').classList.add('hidden');
            document.getElementById('saveButton').hidden = true;

            // Animation
            const modalContent = document.querySelector('#masaKerjaModal > div');
            modalContent.classList.add('scale-in');
        }

        function closeModal() {
            document.getElementById('masaKerjaModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            currentUserId = null;
            currentMasaKerjaId = null;
            isEditMode = false;
        }

        function validateHonor() {
            const honoryear = parseInt(document.getElementById('honoryear').value);
            const errorElement = document.getElementById('honorError');

            if (honoryear < 0) {
                errorElement.classList.remove('hidden');
                return false;
            } else {
                errorElement.classList.add('hidden');
                return true;
            }
        }

        function validateDate() {
            const selectedDate = document.getElementById('selectedDate').value;
            const currentDate = document.getElementById('currentDate').value;
            const errorElement = document.getElementById('dateError');

            if (selectedDate && selectedDate > currentDate) {
                errorElement.classList.remove('hidden');
                return false;
            } else {
                errorElement.classList.add('hidden');
                return true;
            }
        }

        function hitungSelisih() {
            if (!validateHonor() || !validateDate()) {
                return;
            }

            let selectedDate = document.getElementById('selectedDate').value;
            let currentDate = document.getElementById('currentDate').value;
            let honoryear = parseInt(document.getElementById('honoryear').value) || 0;
            let honormonth = parseInt(document.getElementById('honormonth').value) || 0;

            if (!selectedDate || !currentDate) {
                alert('Harap pilih kedua tanggal!');
                return;
            }

            let selectedParts = selectedDate.split('-');
            let currentParts = currentDate.split('-');

            let selectedYear = parseInt(selectedParts[0]);
            let selectedMonth = parseInt(selectedParts[1]);
            let currentYear = parseInt(currentParts[0]);
            let currentMonth = parseInt(currentParts[1]);

            let totalMonths = ((currentYear - selectedYear) * 12 + (currentMonth - selectedMonth)) + (honoryear * 12 +
                honormonth);
            let years = Math.floor(totalMonths / 12);
            let months = totalMonths % 12;

            let resultText = `${years} Tahun, ${months} Bulan`;

            const resultContainer = document.getElementById('resultContainer');
            resultContainer.classList.remove('hidden');
            resultContainer.classList.add('animate-fade-in');

            document.getElementById('result').innerText = resultText;
            document.getElementById('masaKerjaInput').value = resultText;
            document.getElementById('saveButton').hidden = false;

            // --- LOGIKA BARU UNTUK INDIKATOR HONORER ---
            const honorIndicator = document.getElementById('honorIndicator');
            if (honoryear > 0 || honormonth > 0) {
                // Jika ada input honorer, tampilkan pesan
                honorIndicator.classList.remove('hidden');
                honorIndicator.classList.add('flex');
            } else {
                // Jika 0, sembunyikan pesan
                honorIndicator.classList.add('hidden');
                honorIndicator.classList.remove('flex');
            }
        } 

        function confirmDelete(masaKerjaId) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = `/admin/masakerja/${masaKerjaId}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('honoryear').addEventListener('input', validateHonor);
            document.getElementById('selectedDate').addEventListener('change', validateDate);

            document.getElementById('masaKerjaForm').addEventListener('submit', function() {
                document.getElementById('saveText').classList.add('hidden');
                document.getElementById('saveLoading').classList.remove('hidden');
            });

            // Auto-hide alerts
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    successAlert.style.transition = 'opacity 1s';
                    setTimeout(() => successAlert.remove(), 1000);
                }, 3000);
            }

            const errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.opacity = '0';
                    errorAlert.style.transition = 'opacity 1s';
                    setTimeout(() => errorAlert.remove(), 1000);
                }, 5000);
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .scale-in {
            animation: scaleIn 0.2s ease-out forwards;
        }
    </style>
@endsection
