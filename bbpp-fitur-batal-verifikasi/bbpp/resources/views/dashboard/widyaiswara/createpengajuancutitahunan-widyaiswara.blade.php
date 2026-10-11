@extends('dashboard.widyaiswara.base-widyaiswara')

@section('main')

<div class="max-w-3xl mx-auto bg-white px-6 py-8 pt-6 rounded-xl shadow-lg border border-gray-100">
    <!-- Header Section -->
    <div class="mb-8 bg-white rounded-xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.05)] overflow-hidden backdrop-blur-sm bg-opacity-80">
        <div class="px-4 py-3 bg-gradient-to-r from-green-500 to-lime-500 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="p-1.5 rounded-lg bg-white shadow-[inset_0_2px_4px_rgba(0,0,0,0.05)]">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-white">Kuota Cuti</h3>
                </div>
                <span class="text-xs font-medium bg-white text-emerald-500 px-2.5 py-1 rounded-full border border-orange-100 shadow-sm">
                    {{ now()->year }}
                </span>
            </div>
        </div>
        
        <div class="grid grid-cols-3 gap-4 py-2">
            <div class="text-center">
                <p class="text-xs text-grey-800">Tahun Ini</p>
                <p class="text-xl font-bold text-emerald-500">{{ $user->kuotaCutiTahunan->kuota_n ?? 0 }}</p>
                <p class="text-xs text-grey-800">hari</p>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-grey-800">Tahun Lalu</p>
                <p class="text-xl font-bold text-green-500">{{ $user->kuotaCutiTahunan->kuota_n1 ?? 0 }}</p>
                <p class="text-xs text-grey-800">hari</p>
            </div>
            
            <div class="text-center">
                <p class="text-xs text-grey-800">2 Tahun Lalu</p>
                <p class="text-xl font-bold text-lime-500">{{ $user->kuotaCutiTahunan->kuota_n2 ?? 0 }}</p>
                <p class="text-xs text-grey-800">hari</p>
            </div>
        </div>
    </div>

    <div class="mb-8 group">
        <h2 class="text-lg sm:text-xl font-semibold mb-1 relative inline-block">
            <span class="relative z-10 bg-clip-text text-black">Form Pengajuan Cuti Tahunan</span>
            <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-300 to-yellow-300 rounded-full opacity-75 group-hover:opacity-100 transition-opacity duration-300"></span>
        </h2>
        <p class="text-xs text-gray-500 flex items-center gap-2">
            <span class="inline-flex w-3 h-3 bg-gradient-to-r from-green-400 to-lime-400 rounded-full animate-pulse"></span>
            Isi form berikut untuk mengajukan cuti tahunan
        </p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg flex items-start gap-3">
            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
            <div class="flex items-start gap-3 mb-2">
                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
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

    <!-- Form Section -->
    <form action="{{ route('widyaiswarapengajuancutitahunan.store') }}" method="POST" class="space-y-6" id="leaveForm">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Tanggal Pengajuan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan</label>
                <input type="date" name="tgl_pengajuan" id="tgl_pengajuan" 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary" 
                       required>
            </div>
            
            <!-- Masa Kerja -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Masa Kerja</label>
                @if ($checkUser)
                    <input type="text" name="masa_kerja" value="{{ $masakerja->jumlah_masa_kerja }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50" readonly>
                @else
                    <div class="flex items-center gap-2">
                        <input type="text" placeholder="Silahkan hitung masa kerja" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50" disabled>
                        <a href="{{route('katimkermasakerja.index')}}" 
                           class="whitespace-nowrap text-sm text-primary hover:text-primary/80 hover:underline">
                            Hitung
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tanggal Cuti -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Cuti</label>
            <div class="flex flex-col sm:flex-row sm:gap-4 relative">
                <div class="w-full sm:w-1/2 relative mb-4 sm:mb-0">
                    <label class="block text-xs text-gray-500 mb-1">Mulai</label>
                    <input type="date" name="tgl_mulai" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary" 
                           id="tanggalCutiMulai" required>
                    <!-- Custom calendar for start date -->
                    <div id="startDateCalendar" class="absolute top-full left-0 z-20 mt-1 bg-white border rounded-lg shadow-lg hidden w-full sm:w-64">
                        <div class="p-2 border-b">
                            <div class="flex items-center justify-between">
                                <button type="button" class="prevMonth px-2 py-1 bg-gray-100 rounded">&lt;</button>
                                <span class="calendarMonth font-medium"></span>
                                <button type="button" class="nextMonth px-2 py-1 bg-gray-100 rounded">&gt;</button>
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
                        <div class="p-2 border-t text-xs">
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                                <span>Hari Libur/Weekend</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-1/2 relative">
                    <label class="block text-xs text-gray-500 mb-1">Selesai</label>
                    <input type="date" name="tgl_selesai" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary" 
                           id="tanggalCutiSelesai" required>
                    <!-- Custom calendar for end date -->
                    <div id="endDateCalendar" class="absolute top-full right-0 z-20 mt-1 bg-white border rounded-lg shadow-lg hidden w-full sm:w-64">
                        <div class="p-2 border-b">
                            <div class="flex items-center justify-between">
                                <button type="button" class="prevMonth px-2 py-1 bg-gray-100 rounded">&lt;</button>
                                <span class="calendarMonth font-medium"></span>
                                <button type="button" class="nextMonth px-2 py-1 bg-gray-100 rounded">&gt;</button>
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
                        <div class="p-2 border-t text-xs">
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                                <span>Hari Libur/Weekend</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p id="dateError" class="mt-2 text-sm text-red-600 hidden">Tanggal selesai harus lebih besar atau sama dengan tanggal mulai</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Lama Cuti -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lama Cuti</label>
                <div class="flex items-center gap-3">
                    <input type="text" name="lama_cuti" 
                           class="w-16 px-4 py-2.5 border border-gray-300 rounded-lg text-center bg-gray-50 font-medium" 
                           id="lama_cuti" value="0" readonly>
                    <span class="text-sm text-gray-600">Hari Kerja</span>
                    <div id="loading" class="hidden ml-2">
                        <span class="inline-block w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></span>
                        <span class="text-sm text-gray-500 ml-2">Memeriksa hari libur...</span>
                    </div>
                </div>
            </div>
            
            <!-- No HP Cuti -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">No HP Saat Cuti</label>
                <input type="text" name="no_hp_cuti" id="no_hp_cuti" 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary" 
                       required>
                <p id="phoneError" class="mt-2 text-sm text-red-600 hidden">Nomor HP tidak valid. Gunakan format yang benar (contoh: 081234567890)</p>
            </div>
        </div>

        <!-- Alasan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Cuti</label>
            <textarea name="alasan" rows="3" 
                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary" 
                      required></textarea>
        </div>

        <!-- Alamat Saat Cuti -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Saat Cuti</label>
            <input type="text" name="alamat_saat_cuti" 
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary" 
                   required>
        </div>

        @if ($checkUser)
            <div class="pt-2">
                <button id="submitCuti" type="submit" 
                        class="w-full py-3 px-6 bg-gradient-to-r from-primary/90 to-lime-500 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:from-primary hover:to-lime-600 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-2 flex items-center justify-center gap-2">
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set today's date as default for application date
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("tgl_pengajuan").value = today;

            // Setup event listeners
            const startDateInput = document.getElementById('tanggalCutiMulai');
            const endDateInput = document.getElementById('tanggalCutiSelesai');
            const startDateCalendar = document.getElementById('startDateCalendar');
            const endDateCalendar = document.getElementById('endDateCalendar');
            const leaveForm = document.getElementById('leaveForm');
            const phoneInput = document.getElementById('no_hp_cuti');
            const phoneError = document.getElementById('phoneError');
            const dateError = document.getElementById('dateError');

            // Setup holiday data cache
            let holidayCache = {};

            // Initialize calendar state for each picker
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

            // Setup event listeners for date inputs
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

            // Close calendars when clicking outside
            document.addEventListener('click', function(e) {
                if (!startDateInput.contains(e.target) &&
                    !startDateCalendar.contains(e.target) &&
                    !endDateInput.contains(e.target) &&
                    !endDateCalendar.contains(e.target)) {
                    startDateCalendar.classList.add('hidden');
                    endDateCalendar.classList.add('hidden');
                }
            });

            // Setup calendar navigation buttons for both calendars
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

            // Form validation event listeners
            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);
            startDateInput.addEventListener('change', calculateDays);
            endDateInput.addEventListener('change', calculateDays);

            phoneInput.addEventListener('input', validatePhone);

            // Form submission validation
            leaveForm.addEventListener('submit', function(e) {
                // Jalankan validasi yang sudah ada
                const isValidDate = validateDates();
                const isValidPhone = validatePhone();

                if (isValidDate && isValidPhone) {
                    // AMBIL TOMBOL SUBMIT
                    const submitBtn = document.getElementById('submitCuti');

                    // 1. Matikan tombol agar tidak bisa diklik lagi
                    submitBtn.disabled = true;

                    // 2. Tambahkan feedback visual agar user tahu proses sedang berjalan
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    submitBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memproses Pengajuan...</span>
        `;

                    // Form akan terkirim secara otomatis setelah ini
                    return true;
                } else {
                    // Jika validasi gagal, jangan kirim form
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

            // Navigate month for calendar
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

            // Format date to YYYY-MM-DD
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Fetch holidays for a specific year and month
            // Helper: Fetch Holidays
            async function fetchHolidays(year, month = null) {
                const cacheKey = month !== null ? `${year}-${month}` : year;
                if (holidayCache[cacheKey]) return holidayCache[cacheKey];

                try {
                    // MENGUBAH URL KE API INTERNAL KITA
                    let url = `/api/libur-internal?year=${year}`;
                    if (month !== null) url += `&month=${month + 1}`;

                    const response = await fetch(url);
                    if (response.ok) {
                        const data = await response.json();
                        // Data sekarang memiliki: date, name, dan type (tipe)
                        holidayCache[cacheKey] = data;
                        return data;
                    }
                    return [];
                } catch (error) {
                    console.error(`Error fetching holidays:`, error);
                    return [];
                }
            }

            // Render calendar for a specific month
            async function renderCalendar(calendarId) {
                const state = calendarState[calendarId];
                const calendar = state.calendar;
                const calendarGrid = calendar.querySelector('.calendarGrid');
                const monthDisplay = calendar.querySelector('.calendarMonth');

                // Get the selected dates from both inputs
                const selectedStartDate = document.getElementById('tanggalCutiMulai').value;
                const selectedEndDate = document.getElementById('tanggalCutiSelesai').value;
                const startDateObj = selectedStartDate ? new Date(selectedStartDate) : null;
                const endDateObj = selectedEndDate ? new Date(selectedEndDate) : null;

                // Clear the grid
                calendarGrid.innerHTML = '';

                // Set the header
                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                monthDisplay.textContent = `${monthNames[state.month]} ${state.year}`;

                // Get first day of month and last day
                const firstDay = new Date(state.year, state.month, 1);
                const lastDay = new Date(state.year, state.month + 1, 0);

                // Fetch holidays for this month
                const holidays = await fetchHolidays(state.year, state.month);

                // Calculate day of week of first day (0 = Sunday)
                let firstDayOfWeek = firstDay.getDay();

                // Add empty cells for days before the first day of month
                for (let i = 0; i < firstDayOfWeek; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'h-6';
                    calendarGrid.appendChild(emptyCell);
                }

                // Add cells for all days in the month
                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const date = new Date(state.year, state.month, day);
                    const dayOfWeek = date.getDay();
                    const formattedDate = formatDate(date);

                    const dayCell = document.createElement('div');
                    dayCell.className =
                        'h-6 flex items-center justify-center rounded cursor-pointer hover:bg-gray-100';
                    dayCell.textContent = day;
                    dayCell.dataset.date = formattedDate;

                    // Mark weekends with red text
                    const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
                    if (isWeekend) {
                        dayCell.classList.add('text-red-500', 'font-medium');
                        // Add weekend day name as tooltip
                        const weekendNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        dayCell.setAttribute('title', weekendNames[dayOfWeek]);
                    }

                    // Check if this date is a holiday and add tooltip with holiday name
                    const holidayInfo = holidays.find(h => h.date === formattedDate);
                    let isBlackout = false; // Penanda untuk memblokir klik

                    if (holidayInfo) {
                        if (holidayInfo.type === 'blackout') {
                            dayCell.classList.add('text-orange-500', 'font-medium', 'bg-orange-50',
                                'cursor-not-allowed', 'opacity-50');
                            dayCell.setAttribute('title', `Blackout Date: ${holidayInfo.name}`);
                            isBlackout = true; // Tandai sebagai blackout
                        } else {
                            dayCell.classList.add('text-red-500', 'font-medium');
                            dayCell.setAttribute('title', holidayInfo.name);
                        }
                    }

                    // Selected Check & Range
                    if (formattedDate === selectedStartDate) dayCell.classList.add('bg-primary', 'text-white',
                        'hover:bg-primary/90');
                    if (formattedDate === selectedEndDate) dayCell.classList.add('bg-primary', 'text-white',
                        'hover:bg-primary/90');

                    if (startDateObj && endDateObj && date > startDateObj && date < endDateObj) {
                        dayCell.classList.add('bg-primary/20');
                    }

                    // CLICK EVENT (Hanya tambahkan event click jika BUKAN blackout date)
                    if (!isBlackout) {
                        dayCell.addEventListener('click', function() {
                            state.input.value = formattedDate;
                            state.calendar.classList.add('hidden');

                            // IMPORTANT: Trigger jQuery change event so calculations run
                            $(state.input).trigger('change');
                        });
                    }

                    // Highlight today
                    const isToday = (day === new Date().getDate() &&
                        state.month === new Date().getMonth() &&
                        state.year === new Date().getFullYear());
                    if (isToday) {
                        dayCell.classList.add('border', 'border-blue-500');
                    }
                    if (formattedDate === selectedStartDate) {
                        dayCell.classList.add('bg-blue-600', 'text-white');
                    }

                    // Highlight the date range between start and end dates
                    if (startDateObj && endDateObj && date >= startDateObj && date <= endDateObj) {
                        dayCell.classList.add('bg-blue-100');

                        // Highlight the start date with a different style
                        if (formattedDate === selectedStartDate) {
                            dayCell.classList.remove('bg-blue-100');
                            dayCell.classList.add('bg-blue-600', 'text-white');
                        }

                        // Highlight the end date with a different style
                        if (formattedDate === selectedEndDate) {
                            dayCell.classList.remove('bg-blue-100');
                            dayCell.classList.add('bg-blue-600', 'text-white');
                        }
                    } else {
                        // Highlight if this specific date is selected
                        if (formattedDate === state.input.value) {
                            dayCell.classList.add('bg-blue-600', 'text-white');
                        }
                    }

                    // Add click handler to select the date
                    dayCell.addEventListener('click', function() {
                        state.input.value = formattedDate;

                        // If we're selecting start date, and end date is earlier, update end date too
                        if (calendarId === 'startDate' && selectedEndDate && new Date(formattedDate) >
                            new Date(selectedEndDate)) {
                            document.getElementById('tanggalCutiSelesai').value = formattedDate;
                        }

                        // If we're selecting end date, and start date is later, update start date too
                        if (calendarId === 'endDate' && selectedStartDate && new Date(formattedDate) <
                            new Date(selectedStartDate)) {
                            document.getElementById('tanggalCutiMulai').value = formattedDate;
                        }

                        state.calendar.classList.add('hidden');

                        // Trigger change event to update calculations and refresh both calendars
                        const event = new Event('change');
                        state.input.dispatchEvent(event);

                        // Re-render the other calendar to show the updated range
                        const otherCalendarId = calendarId === 'startDate' ? 'endDate' : 'startDate';
                        renderCalendar(otherCalendarId);
                    });

                    calendarGrid.appendChild(dayCell);
                }
            }

            // Calculate number of working days between dates
            async function calculateDays() {
                const startDate = startDateInput.value;
                const endDate = endDateInput.value;
                const lamaCutiInput = document.getElementById('lama_cuti');
                const submitButton = document.querySelector('button[type="submit"]');
                const loading = document.getElementById('loading');

                if (!startDate || !endDate || !validateDates()) {
                    lamaCutiInput.value = 0;
                    return;
                }

                loading.classList.remove('hidden');

                const start = new Date(startDate);
                const end = new Date(endDate);
                let validDaysCount = 0;

                // Get holiday data for the date range year(s)
                const startYear = start.getFullYear();
                const endYear = end.getFullYear();

                // Ensure we have holiday data for all relevant years
                for (let year = startYear; year <= endYear; year++) {
                    if (!holidayCache[year]) {
                        await fetchHolidays(year);
                    }
                }

                // Calculate working days excluding weekends and holidays
                for (let currentDate = new Date(start); currentDate <= end; currentDate.setDate(currentDate
                        .getDate() + 1)) {
                    const dayOfWeek = currentDate.getDay();
                    const formattedDate = formatDate(currentDate);

                    // Skip weekends (Saturday=6, Sunday=0)
                    if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                        // Check if the date is a holiday in any of our cached holiday lists
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

                // Get total annual leave quota from Laravel Blade
                const kuotaCuti = {{ $kuotaCuti->kuota_n + $kuotaCuti->kuota_n1 + $kuotaCuti->kuota_n2 ?? 0 }};

                if (validDaysCount > kuotaCuti) {
                    alert('Lama hari cuti melebihi kuota cuti tahunan Anda!');
                    lamaCutiInput.classList.add('border-red-500');
                    submitButton.disabled = true;
                    submitButton.classList.remove('bg-gradient-to-r', 'from-primary', 'to-accent',
                        'hover:from-primary/90', 'hover:to-accent/90');
                    submitButton.classList.add('bg-red-500', 'cursor-not-allowed');
                } else {
                    lamaCutiInput.classList.remove('border-red-500');
                    submitButton.disabled = false;
                    submitButton.classList.remove('bg-red-500', 'cursor-not-allowed');
                    submitButton.classList.add('bg-gradient-to-r', 'from-primary', 'to-accent',
                        'hover:from-primary/90', 'hover:to-accent/90');
                }
            }
        });
    </script>
    <style>
        /* Add this to your existing style tag */
        .text-transparent {
            color: transparent;
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.3;
            }

            50% {
                opacity: 0.5;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }
    </style>

@endsection