@extends('dashboard.user.base-user')

@section('main')

    <div class="max-w-3xl mx-auto bg-white px-6 py-8 pt-6 rounded-xl shadow-lg border border-gray-100">
        <!-- Informasi Kuota Cuti -->
        <div class="mb-8 bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.05)] overflow-hidden backdrop-blur-sm bg-opacity-80">
            <div class="px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 rounded-lg bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.05)]">
                            <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2V6a2 2 0-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-white">Kuota Cuti</h3>
                    </div>
                    <span class="text-xs font-medium bg-white text-emerald-600 px-2.5 py-1 rounded-full border border-emerald-100 shadow-sm">
                        {{ now()->year }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 py-3">
                <div class="text-center">
                    <p class="text-xs text-gray-500">Tahun Ini (N)</p>
                    <p class="text-xl font-bold text-emerald-600">{{ $user->kuotaCutiTahunan->kuota_n ?? 0 }}</p>
                    <p class="text-xs text-gray-400">hari</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">Tahun Lalu (N-1)</p>
                    <p class="text-xl font-bold text-teal-600">{{ $user->kuotaCutiTahunan->kuota_n1 ?? 0 }}</p>
                    <p class="text-xs text-gray-400">hari</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500">2 Tahun Lalu (N-2)</p>
                    <p class="text-xl font-bold text-teal-700">{{ $user->kuotaCutiTahunan->kuota_n2 ?? 0 }}</p>
                    <p class="text-xs text-gray-400">hari</p>
                </div>
            </div>
        </div>

        <div class="mb-8 group">
            <h2 class="text-lg sm:text-xl font-semibold mb-1 relative inline-block">
                <span class="relative z-10 bg-clip-text text-gray-800">Form Pengajuan Cuti Tahunan</span>
                <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-300 to-teal-300 rounded-full opacity-75 group-hover:opacity-100 transition-opacity duration-300"></span>
            </h2>
            <p class="text-xs text-gray-500 flex items-center gap-2 mt-1">
                <span class="inline-flex w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></span>
                Isi formulir berikut untuk mengajukan cuti tahunan
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 rounded-lg flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                <div class="flex items-start gap-3 mb-2">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <h4 class="font-bold">Terdapat kesalahan!</h4>
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm ml-8">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('userpengajuancutitahunan.store') }}" method="POST" class="space-y-6" id="leaveForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan</label>
                    <input type="date" name="tgl_pengajuan" id="tgl_pengajuan"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                        required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masa Kerja</label>
                    @if ($checkUser)
                        <input type="text" name="masa_kerja" value="{{ $masakerja->jumlah_masa_kerja }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700" readonly>
                    @else
                        <div class="flex items-center gap-2">
                            <input type="text" placeholder="Silahkan hitung masa kerja"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50" disabled>
                            <a href="{{ route('katimkermasakerja.index') }}"
                                class="whitespace-nowrap text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline">
                                Hitung
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Cuti</label>
                <div class="flex flex-col sm:flex-row sm:gap-4 relative">
                    <div class="w-full sm:w-1/2 relative mb-4 sm:mb-0">
                        <label class="block text-xs text-gray-500 mb-1">Mulai</label>
                        <input type="date" name="tgl_mulai"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            id="tanggalCutiMulai" required>
                        <div id="startDateCalendar"
                            class="absolute top-full left-0 z-20 mt-1 bg-white border rounded-lg shadow-lg hidden w-full sm:w-64">
                            <div class="p-2 border-b">
                                <div class="flex items-center justify-between">
                                    <button type="button" class="prevMonth px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">&lt;</button>
                                    <span class="calendarMonth font-medium text-sm"></span>
                                    <button type="button" class="nextMonth px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">&gt;</button>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="grid grid-cols-7 gap-1 text-center text-xs mb-1">
                                    <div class="text-red-500">Min</div>
                                    <div>Sen</div>
                                    <div>Sel</div>
                                    <div>Rab</div>
                                    <div>Kam</div>
                                    <div>Jum</div>
                                    <div class="text-red-500">Sab</div>
                                </div>
                                <div class="calendarGrid grid grid-cols-7 gap-1 text-center text-sm"></div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 relative">
                        <label class="block text-xs text-gray-500 mb-1">Selesai</label>
                        <input type="date" name="tgl_selesai"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            id="tanggalCutiSelesai" required>
                        <div id="endDateCalendar"
                            class="absolute top-full right-0 z-20 mt-1 bg-white border rounded-lg shadow-lg hidden w-full sm:w-64">
                            <div class="p-2 border-b">
                                <div class="flex items-center justify-between">
                                    <button type="button" class="prevMonth px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">&lt;</button>
                                    <span class="calendarMonth font-medium text-sm"></span>
                                    <button type="button" class="nextMonth px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">&gt;</button>
                                </div>
                            </div>
                            <div class="p-2">
                                <div class="grid grid-cols-7 gap-1 text-center text-xs mb-1">
                                    <div class="text-red-500">Min</div>
                                    <div>Sen</div>
                                    <div>Sel</div>
                                    <div>Rab</div>
                                    <div>Kam</div>
                                    <div>Jum</div>
                                    <div class="text-red-500">Sab</div>
                                </div>
                                <div class="calendarGrid grid grid-cols-7 gap-1 text-center text-sm"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <p id="dateError" class="mt-2 text-sm text-red-600 hidden">Tanggal selesai harus lebih besar atau sama dengan tanggal mulai</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lama Cuti</label>
                    <div class="flex items-center gap-3">
                        <input type="text" name="lama_cuti"
                            class="w-20 px-4 py-2.5 border border-gray-300 rounded-lg text-center bg-gray-50 font-semibold text-emerald-700"
                            id="lama_cuti" value="0" readonly>
                        <span class="text-sm text-gray-600">Hari Kerja</span>
                        <div id="loading" class="hidden ml-2">
                            <span class="inline-block w-4 h-4 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No HP Saat Cuti</label>
                    <input type="text" name="no_hp_cuti" id="no_hp_cuti"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                        required>
                    <p id="phoneError" class="mt-2 text-sm text-red-600 hidden">Nomor HP tidak valid</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Cuti</label>
                <textarea name="alasan" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                    required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Saat Cuti</label>
                <input type="text" name="alamat_saat_cuti"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                    required>
            </div>

            @if ($checkUser)
                <div class="pt-2">
                    <button id="submitCuti" type="submit"
                        class="w-full py-3 px-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Ajukan Cuti</span>
                    </button>
                </div>
            @else
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-lg text-center">
                    <p class="text-amber-700">Silakan hitung masa kerja terlebih dahulu untuk mengajukan cuti</p>
                </div>
            @endif
        </form>
    </div>

    <!-- Modal Peringatan: Kuota Terlampaui -->
    <div id="quotaExceededModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs flex items-center justify-center z-50 hidden p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 text-center transform transition-all animate-scale-in">
            <div class="w-16 h-16 mx-auto mb-4 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-2">Lama Cuti Melebihi Kuota!</h3>
            <p class="text-sm text-gray-600 mb-4">
                Hari cuti yang dipilih (<span id="modalSelectedDays" class="font-bold text-red-600">0</span> hari kerja) melebihi sisa kuota Anda (<span id="modalQuotaDays" class="font-bold text-emerald-600">0</span> hari).
            </p>

            <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 mb-5 text-xs text-amber-800 text-left">
                💡 Silakan kurangi rentang tanggal cuti agar sesuai dengan sisa kuota yang tersedia.
            </div>

            <button type="button" onclick="closeQuotaModal()"
                class="w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition shadow-md shadow-emerald-500/20 active:scale-95">
                Mengerti
            </button>
        </div>
    </div>

    <script>
        function showQuotaModal(selectedDays, totalQuota) {
            document.getElementById('modalSelectedDays').textContent = selectedDays;
            document.getElementById('modalQuotaDays').textContent = totalQuota;
            document.getElementById('quotaExceededModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeQuotaModal() {
            document.getElementById('quotaExceededModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        window.addEventListener('click', function(e) {
            const quotaModal = document.getElementById('quotaExceededModal');
            if (e.target === quotaModal) closeQuotaModal();
        });

        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("tgl_pengajuan").value = today;

            const startDateInput = document.getElementById('tanggalCutiMulai');
            const endDateInput = document.getElementById('tanggalCutiSelesai');
            const startDateCalendar = document.getElementById('startDateCalendar');
            const endDateCalendar = document.getElementById('endDateCalendar');
            const leaveForm = document.getElementById('leaveForm');
            const phoneInput = document.getElementById('no_hp_cuti');
            const phoneError = document.getElementById('phoneError');
            const dateError = document.getElementById('dateError');

            let holidayCache = {};

            const calendarState = {
                startDate: {
                    year: new Date().getFullYear(),
                    month: new Date().getMonth(),
                    calendar: startDateCalendar,
                    input: startDateInput
                },
                endDate: {
                    year: new Date().getFullYear(),
                    month: new Date().getMonth(),
                    calendar: endDateCalendar,
                    input: endDateInput
                }
            };

            startDateInput.addEventListener('click', function(e) {
                e.preventDefault();
                renderCalendar('startDate');
                startDateCalendar.classList.remove('hidden');
                endDateCalendar.classList.add('hidden');
            });

            endDateInput.addEventListener('click', function(e) {
                e.preventDefault();
                renderCalendar('endDate');
                endDateCalendar.classList.remove('hidden');
                startDateCalendar.classList.add('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!startDateInput.contains(e.target) &&
                    !startDateCalendar.contains(e.target) &&
                    !endDateInput.contains(e.target) &&
                    !endDateCalendar.contains(e.target)) {
                    startDateCalendar.classList.add('hidden');
                    endDateCalendar.classList.add('hidden');
                }
            });

            startDateCalendar.querySelector('.prevMonth').addEventListener('click', function() {
                navigateMonth('startDate', -1);
            });

            startDateCalendar.querySelector('.nextMonth').addEventListener('click', function() {
                navigateMonth('startDate', 1);
            });

            endDateCalendar.querySelector('.prevMonth').addEventListener('click', function() {
                navigateMonth('endDate', -1);
            });

            endDateCalendar.querySelector('.nextMonth').addEventListener('click', function() {
                navigateMonth('endDate', 1);
            });

            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);
            startDateInput.addEventListener('change', calculateDays);
            endDateInput.addEventListener('change', calculateDays);
            phoneInput.addEventListener('input', validatePhone);

            leaveForm.addEventListener('submit', function(e) {
                const isValidDate = validateDates();
                const isValidPhone = validatePhone();

                if (isValidDate && isValidPhone) {
                    const submitBtn = document.getElementById('submitCuti');
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses Pengajuan...</span>
                    `;
                    return true;
                } else {
                    e.preventDefault();
                    return false;
                }
            });

            function validatePhone() {
                const phoneRegex = /^(\+62|62|0)[0-9]{9,12}$/;
                const phone = phoneInput.value.trim();

                if (!phoneRegex.test(phone)) {
                    phoneError.classList.remove('hidden');
                    phoneInput.classList.add('border-red-500');
                    return false;
                } else {
                    phoneError.classList.add('hidden');
                    phoneInput.classList.remove('border-red-500');
                    return true;
                }
            }

            function validateDates() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDateInput.value && endDateInput.value && endDate < startDate) {
                    dateError.classList.remove('hidden');
                    endDateInput.classList.add('border-red-500');
                    return false;
                } else {
                    dateError.classList.add('hidden');
                    endDateInput.classList.remove('border-red-500');
                    return true;
                }
            }

            function navigateMonth(calendarId, direction) {
                calendarState[calendarId].month += direction;

                if (calendarState[calendarId].month < 0) {
                    calendarState[calendarId].month = 11;
                    calendarState[calendarId].year--;
                } else if (calendarState[calendarId].month > 11) {
                    calendarState[calendarId].month = 0;
                    calendarState[calendarId].year++;
                }

                renderCalendar(calendarId);
            }

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            async function fetchHolidays(year, month = null) {
                const cacheKey = month !== null ? `${year}-${month}` : year;
                if (holidayCache[cacheKey]) return holidayCache[cacheKey];

                try {
                    let url = `/api/libur-internal?year=${year}`;
                    if (month !== null) url += `&month=${month + 1}`;

                    const response = await fetch(url);
                    if (response.ok) {
                        const data = await response.json();
                        holidayCache[cacheKey] = data;
                        return data;
                    }
                    return [];
                } catch (error) {
                    console.error(`Error fetching holidays:`, error);
                    return [];
                }
            }

            async function renderCalendar(calendarId) {
                const state = calendarState[calendarId];
                const calendar = state.calendar;
                const calendarGrid = calendar.querySelector('.calendarGrid');
                const monthDisplay = calendar.querySelector('.calendarMonth');

                const selectedStartDate = document.getElementById('tanggalCutiMulai').value;
                const selectedEndDate = document.getElementById('tanggalCutiSelesai').value;
                const startDateObj = selectedStartDate ? new Date(selectedStartDate) : null;
                const endDateObj = selectedEndDate ? new Date(selectedEndDate) : null;

                calendarGrid.innerHTML = '';

                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                monthDisplay.textContent = `${monthNames[state.month]} ${state.year}`;

                const firstDay = new Date(state.year, state.month, 1);
                const lastDay = new Date(state.year, state.month + 1, 0);
                const holidays = await fetchHolidays(state.year, state.month);

                let firstDayOfWeek = firstDay.getDay();

                for (let i = 0; i < firstDayOfWeek; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'h-6';
                    calendarGrid.appendChild(emptyCell);
                }

                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const date = new Date(state.year, state.month, day);
                    const dayOfWeek = date.getDay();
                    const formattedDate = formatDate(date);

                    const dayCell = document.createElement('div');
                    dayCell.className = 'h-6 flex items-center justify-center rounded cursor-pointer hover:bg-gray-100 text-xs';
                    dayCell.textContent = day;
                    dayCell.dataset.date = formattedDate;

                    const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
                    if (isWeekend) {
                        dayCell.classList.add('text-red-500', 'font-medium');
                        const weekendNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        dayCell.setAttribute('title', weekendNames[dayOfWeek]);
                    }

                    const holidayInfo = holidays.find(h => h.date === formattedDate);
                    let isBlackout = false;

                    if (holidayInfo) {
                        if (holidayInfo.type === 'blackout') {
                            dayCell.classList.add('text-amber-500', 'font-medium', 'bg-amber-50', 'cursor-not-allowed', 'opacity-50');
                            dayCell.setAttribute('title', `Blackout Date: ${holidayInfo.name}`);
                            isBlackout = true;
                        } else {
                            dayCell.classList.add('text-red-500', 'font-medium');
                            dayCell.setAttribute('title', holidayInfo.name);
                        }
                    }

                    if (formattedDate === selectedStartDate || formattedDate === selectedEndDate) {
                        dayCell.classList.add('bg-emerald-600', 'text-white', 'hover:bg-emerald-700');
                    } else if (startDateObj && endDateObj && date > startDateObj && date < endDateObj) {
                        dayCell.classList.add('bg-emerald-100');
                    }

                    if (!isBlackout) {
                        dayCell.addEventListener('click', function() {
                            state.input.value = formattedDate;

                            if (calendarId === 'startDate' && selectedEndDate && new Date(formattedDate) > new Date(selectedEndDate)) {
                                document.getElementById('tanggalCutiSelesai').value = formattedDate;
                            }

                            if (calendarId === 'endDate' && selectedStartDate && new Date(formattedDate) < new Date(selectedStartDate)) {
                                document.getElementById('tanggalCutiMulai').value = formattedDate;
                            }

                            state.calendar.classList.add('hidden');

                            const event = new Event('change');
                            state.input.dispatchEvent(event);

                            const otherCalendarId = calendarId === 'startDate' ? 'endDate' : 'startDate';
                            renderCalendar(otherCalendarId);
                        });
                    }

                    calendarGrid.appendChild(dayCell);
                }
            }

            async function calculateDays() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const lamaCutiInput = document.getElementById('lama_cuti');
                const submitButton = document.getElementById('submitCuti');
                const loading = document.getElementById('loading');

                if (!startDate || !endDate || !validateDates()) {
                    lamaCutiInput.value = 0;
                    return;
                }

                loading.classList.remove('hidden');

                const start = new Date(startDate);
                const end = new Date(endDate);
                let validDaysCount = 0;

                const startYear = start.getFullYear();
                const endYear = end.getFullYear();

                for (let year = startYear; year <= endYear; year++) {
                    if (!holidayCache[year]) {
                        await fetchHolidays(year);
                    }
                }

                for (let currentDate = new Date(start); currentDate <= end; currentDate.setDate(currentDate.getDate() + 1)) {
                    const dayOfWeek = currentDate.getDay();
                    const formattedDate = formatDate(currentDate);

                    if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                        const isHoliday = Object.values(holidayCache).some(holidays =>
                            holidays.some(h => h.date === formattedDate)
                        );

                        if (!isHoliday) {
                            validDaysCount++;
                        }
                    }
                }

                loading.classList.add('hidden');
                lamaCutiInput.value = validDaysCount;

                const kuotaCuti = {{ ($user->kuotaCutiTahunan->kuota_n ?? 0) + ($user->kuotaCutiTahunan->kuota_n1 ?? 0) + ($user->kuotaCutiTahunan->kuota_n2 ?? 0) }};

                if (validDaysCount > kuotaCuti) {
                    showQuotaModal(validDaysCount, kuotaCuti);

                    lamaCutiInput.classList.add('border-red-500', 'text-red-600');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.classList.remove('from-emerald-500', 'to-teal-600', 'hover:from-emerald-600', 'hover:to-teal-700');
                        submitButton.classList.add('bg-red-500', 'opacity-60', 'cursor-not-allowed');
                    }
                } else {
                    lamaCutiInput.classList.remove('border-red-500', 'text-red-600');
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.classList.remove('bg-red-500', 'opacity-60', 'cursor-not-allowed');
                        submitButton.classList.add('from-emerald-500', 'to-teal-600', 'hover:from-emerald-600', 'hover:to-teal-700');
                    }
                }
            }
        });
    </script>

    <style>
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
        .animate-scale-in {
            animation: scaleIn 0.2s ease-out forwards;
        }
    </style>

@endsection