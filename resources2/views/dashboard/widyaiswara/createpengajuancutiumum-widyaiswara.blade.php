@extends('dashboard.widyaiswara.base-widyaiswara')

@section('main')

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary to-lime-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-file-alt"></i>
                    Pengajuan Cuti Umum (Widyaiswara)
                </h2>
            </div>


            <div class="p-6">
                @if (session('success'))
                    <div class="mb-6 p-4 border-l-4 border-green-500 bg-green-50 rounded-lg flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 text-xl"></i>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 border-l-4 border-red-500 bg-red-50 rounded-lg flex items-start gap-3">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 text-xl"></i>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 border-l-4 border-red-500 bg-red-50 rounded-lg">
                        <div class="flex items-start gap-3 mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mt-0.5 text-xl"></i>
                            <h4 class="font-bold text-red-700">Terdapat kesalahan!</h4>
                        </div>
                        <ul class="list-disc list-inside text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('widyaiswarapengajuancutiumum.store') }}" method="POST"
                    enctype="multipart/form-data" id="formCuti">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <div class="mb-6">
                        <label for="jeniscuti_id" class="block text-sm font-medium text-gray-700 mb-2">Jenis Cuti <span
                                class="text-red-500">*</span></label>
                        <select
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 @error('jeniscuti_id') border-red-500 @enderror"
                            id="jeniscuti_id" name="jeniscuti_id" required>
                            <option value="">Pilih Jenis Cuti</option>
                            @foreach ($jenisCuti as $cuti)
                                <option value="{{ $cuti->id }}" {{ old('jeniscuti_id') == $cuti->id ? 'selected' : '' }}
                                    data-nama="{{ $cuti->nama_cuti }}">
                                    {{ $cuti->nama_cuti }}
                                </option>
                            @endforeach
                        </select>
                        @error('jeniscuti_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="form-bawah" class="hidden space-y-6">
                        <div id="lampiran-container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran (opsional)</label>
                            <div class="flex flex-col space-y-3">
                                <div class="flex items-center gap-3">
                                    <label class="flex-1 cursor-pointer">
                                        <span class="sr-only">Choose file</span>
                                        <div
                                            class="flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                            <span id="upload-label" class="text-gray-700">Pilih File</span>
                                            <i class="fas fa-cloud-upload-alt text-gray-400 ml-2"></i>
                                        </div>
                                        <input type="file" class="hidden" id="lampiran" name="lampiran">
                                    </label>

                                    <button type="button" id="cancel-upload"
                                        class="hidden px-4 py-3 text-red-500 bg-white border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <div id="file-preview" class="hidden p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-file-alt text-primary text-lg"></i>
                                        <div class="flex-1 min-w-0">
                                            <p id="file-name" class="text-sm font-medium text-gray-700 truncate"></p>
                                            <p id="file-size" class="text-xs text-gray-500"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Silakan unggah dokumen pendukung yang diperlukan, seperti
                                surat keterangan dari dokter.</p>
                        </div>

                        <div id="durasi-cuti-besar" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Cuti Besar</label>
                            <div class="flex gap-2">
                                <button type="button"
                                    class="durasi-btn flex-1 py-2 px-3 border border-primary bg-primary/10 rounded-lg hover:border-primary hover:bg-primary/20 transition-all flex flex-col items-center focus:outline-none focus:ring-1 focus:ring-primary/30"
                                    data-durasi="1">
                                    <span class="text-lg font-semibold text-primary">1</span>
                                    <span class="text-xs text-gray-600 mt-0.5">Bulan</span>
                                </button>

                                <button type="button"
                                    class="durasi-btn flex-1 py-2 px-3 border border-primary bg-primary/10 rounded-lg hover:border-primary hover:bg-primary/20 transition-all flex flex-col items-center focus:outline-none focus:ring-1 focus:ring-primary/30"
                                    data-durasi="2">
                                    <span class="text-lg font-semibold text-primary">2</span>
                                    <span class="text-xs text-gray-600 mt-0.5">Bulan</span>
                                </button>

                                <button type="button"
                                    class="durasi-btn flex-1 py-2 px-3 border border-primary bg-primary/10 rounded-lg hover:border-primary hover:bg-primary/20 transition-all flex flex-col items-center focus:outline-none focus:ring-1 focus:ring-primary/30"
                                    data-durasi="3">
                                    <span class="text-lg font-semibold text-primary">3</span>
                                    <span class="text-xs text-gray-600 mt-0.5">Bulan</span>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-gray-400 text-xs"></i>
                                Durasi maksimal 90 hari (3 bulan)
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tgl_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                    Pengajuan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                                        id="tgl_pengajuan" name="tgl_pengajuan"
                                        value="{{ old('tgl_pengajuan', date('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tgl_mulai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai
                                    Cuti <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                                        id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required>

                                    <div id="startDateCalendar"
                                        class="absolute top-full left-0 z-50 mt-1 bg-white border rounded-lg shadow-xl hidden w-full sm:w-72">
                                        <div class="p-3 border-b bg-gray-50 rounded-t-lg">
                                            <div class="flex items-center justify-between">
                                                <button type="button"
                                                    class="prevMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&lt;</button>
                                                <span class="calendarMonth font-bold text-gray-700"></span>
                                                <button type="button"
                                                    class="nextMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&gt;</button>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div
                                                class="grid grid-cols-7 gap-1 text-center text-xs mb-2 font-semibold text-gray-500">
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
                                        <div class="p-2 border-t text-xs bg-gray-50 rounded-b-lg">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                                                <span class="text-gray-600">Hari Libur/Weekend</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="tgl_selesai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                                    Akhir Cuti <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 bg-white"
                                        id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required>

                                    <div id="endDateCalendar"
                                        class="absolute top-full right-0 z-50 mt-1 bg-white border rounded-lg shadow-xl hidden w-full sm:w-72">
                                        <div class="p-3 border-b bg-gray-50 rounded-t-lg">
                                            <div class="flex items-center justify-between">
                                                <button type="button"
                                                    class="prevMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&lt;</button>
                                                <span class="calendarMonth font-bold text-gray-700"></span>
                                                <button type="button"
                                                    class="nextMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&gt;</button>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div
                                                class="grid grid-cols-7 gap-1 text-center text-xs mb-2 font-semibold text-gray-500">
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
                                        <div class="p-2 border-t text-xs bg-gray-50 rounded-b-lg">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                                                <span class="text-gray-600">Hari Libur/Weekend</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lama Cuti</label>
                            <div class="flex">
                                <input type="text"
                                    class="flex-grow px-4 py-2.5 border border-gray-300 rounded-l-lg bg-gray-50"
                                    id="jumlah_hari" name="jumlah_hari" readonly>
                                <span
                                    class="inline-flex items-center px-4 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg text-gray-700"
                                    id="satuan_durasi"></span>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Lama cuti akan dihitung otomatis berdasarkan tanggal yang
                                dipilih</p>
                        </div>

                        <div>
                            <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Cuti <span
                                    class="text-red-500">*</span></label>
                            <textarea
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 min-h-[100px]"
                                id="alasan" name="alasan" required>{{ old('alasan') }}</textarea>
                        </div>

                        <div>
                            <label for="alamat_saat_cuti" class="block text-sm font-medium text-gray-700 mb-2">Alamat Saat
                                Cuti <span class="text-red-500">*</span></label>
                            <textarea
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 min-h-[80px]"
                                id="alamat_saat_cuti" name="alamat_saat_cuti" required>{{ old('alamat_saat_cuti') }}</textarea>
                        </div>

                        <div>
                            <label for="no_hp_cuti" class="block text-sm font-medium text-gray-700 mb-2">No. HP Saat Cuti
                                <span class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                                id="no_hp_cuti" name="no_hp_cuti" value="{{ old('no_hp_cuti', $no_hp_cuti) }}" required>
                        </div>

                        @if ($checkUser)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Masa Kerja</label>
                                <input type="text"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50"
                                    name="masa_kerja" value="{{ $masakerja->jumlah_masa_kerja }}" readonly>
                            </div>
                        @else
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Masa Kerja</label>
                                <div class="flex">
                                    <input type="text"
                                        class="flex-grow px-4 py-2.5 border border-gray-300 rounded-l-lg bg-gray-50"
                                        name="masa_kerja" placeholder="Silahkan hitung masa kerja" disabled>
                                    <a href="{{ route('usermasakerja.create') }}"
                                        class="px-4 py-2.5 bg-white border border-primary text-primary rounded-r-lg hover:bg-primary/10 transition-colors flex items-center gap-2">
                                        <i class="fas fa-calculator"></i>
                                        <span>Hitung Masa Kerja</span>
                                    </a>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Anda harus menghitung masa kerja terlebih dahulu</p>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                            <a href="{{ url()->previous() }}"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white rounded-lg hover:from-primary/80 hover:to-primary/60 transition-all  flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                <span>Simpan</span>
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="form_submitted" id="form_submitted" value="0">
                </form>
            </div>
        </div>
    </div>

    <div id="snackbar"
        class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white py-3 px-5 rounded-lg shadow-lg transition-all duration-300 ease-in-out opacity-0 invisible z-50 flex items-center gap-2">
        <i class="fas fa-info-circle"></i>
        <span id="snackbarMessage"></span>
    </div>

    <style>
        /* Styling for Calendar */
        .text-transparent {
            color: transparent;
        }

        @media (max-width: 640px) {

            #startDateCalendar,
            #endDateCalendar {
                width: 100%;
                max-width: 100%;
                left: 0 !important;
                right: auto !important;
            }

            .calendarGrid {
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }
        }

        .weekend-date {
            color: #ef4444;
            font-weight: 500;
        }

        .holiday-date {
            color: #ef4444;
            font-weight: 500;
        }
    </style>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // --- SETUP CSRF TOKEN ---
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // --- GLOBAL VARIABLES FOR CALENDAR ---
            const startDateInput = document.getElementById('tgl_mulai');
            const endDateInput = document.getElementById('tgl_selesai');
            const startDateCalendar = document.getElementById('startDateCalendar');
            const endDateCalendar = document.getElementById('endDateCalendar');
            let holidayCache = {}; // Unified Cache

            // Initialize calendar state
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

            // --- CALENDAR LOGIC (Ported from Cuti Tahunan) ---

            // Helper: Format date YYYY-MM-DD
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

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

            // Helper: Render Calendar
            async function renderCalendar(calendarId) {
                const state = calendarState[calendarId];
                const calendar = state.calendar;
                const calendarGrid = calendar.querySelector('.calendarGrid');
                const monthDisplay = calendar.querySelector('.calendarMonth');

                // Values
                const selectedStartDate = startDateInput.value;
                const selectedEndDate = endDateInput.value;
                const startDateObj = selectedStartDate ? new Date(selectedStartDate) : null;
                const endDateObj = selectedEndDate ? new Date(selectedEndDate) : null;

                calendarGrid.innerHTML = ''; // Clear

                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ];
                monthDisplay.textContent = `${monthNames[state.month]} ${state.year}`;

                const firstDay = new Date(state.year, state.month, 1);
                const lastDay = new Date(state.year, state.month + 1, 0);
                const holidays = await fetchHolidays(state.year, state.month);
                let firstDayOfWeek = firstDay.getDay(); // 0 = Sunday

                // Empty cells
                for (let i = 0; i < firstDayOfWeek; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'h-8';
                    calendarGrid.appendChild(emptyCell);
                }

                // Days
                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const date = new Date(state.year, state.month, day);
                    const dayOfWeek = date.getDay();
                    const formattedDate = formatDate(date);

                    const dayCell = document.createElement('div');
                    dayCell.className =
                        'h-8 flex items-center justify-center rounded cursor-pointer hover:bg-gray-100 transition-colors text-sm';
                    dayCell.textContent = day;
                    dayCell.dataset.date = formattedDate;

                    // Weekend Check
                    const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
                    if (isWeekend) {
                        dayCell.classList.add('text-red-500', 'font-medium');
                        dayCell.setAttribute('title', 'Akhir Pekan');
                    }

                    // Holiday Check
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

                    // Selected Check & Range
                    if (formattedDate === selectedStartDate) dayCell.classList.add('bg-primary', 'text-white',
                        'hover:bg-primary/90');
                    if (formattedDate === selectedEndDate) dayCell.classList.add('bg-primary', 'text-white',
                        'hover:bg-primary/90');

                    if (startDateObj && endDateObj && date > startDateObj && date < endDateObj) {
                        dayCell.classList.add('bg-primary/20');
                    }

                    // CLICK EVENT
                    dayCell.addEventListener('click', function() {
                        state.input.value = formattedDate;
                        state.calendar.classList.add('hidden');

                        // IMPORTANT: Trigger jQuery change event so calculations run
                        $(state.input).trigger('change');

                        // If Start Date selected, update End Date logic if needed
                        if (calendarId === 'startDate' && selectedEndDate && new Date(formattedDate) >
                            new Date(selectedEndDate)) {
                            // Optional: Clear end date if start > end
                            // endDateInput.value = ''; 
                        }
                    });

                    calendarGrid.appendChild(dayCell);
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

            // Event Listeners for Input Clicks (SHOW POPUP)
            startDateInput.addEventListener('click', function(e) {
                if (this.readOnly || this.disabled) return; // Don't show if readonly
                e.preventDefault();
                renderCalendar('startDate');
                startDateCalendar.classList.remove('hidden');
                endDateCalendar.classList.add('hidden');
            });

            endDateInput.addEventListener('click', function(e) {
                if (this.readOnly || this.disabled) return; // Don't show if readonly
                e.preventDefault();
                renderCalendar('endDate');
                endDateCalendar.classList.remove('hidden');
                startDateCalendar.classList.add('hidden');
            });

            // Hide when clicking outside
            document.addEventListener('click', function(e) {
                if (!startDateInput.contains(e.target) && !startDateCalendar.contains(e.target) &&
                    !endDateInput.contains(e.target) && !endDateCalendar.contains(e.target)) {
                    startDateCalendar.classList.add('hidden');
                    endDateCalendar.classList.add('hidden');
                }
            });

            // Navigation Buttons
            startDateCalendar.querySelector('.prevMonth').addEventListener('click', () => navigateMonth('startDate',
                -1));
            startDateCalendar.querySelector('.nextMonth').addEventListener('click', () => navigateMonth('startDate',
                1));
            endDateCalendar.querySelector('.prevMonth').addEventListener('click', () => navigateMonth('endDate', -
                1));
            endDateCalendar.querySelector('.nextMonth').addEventListener('click', () => navigateMonth('endDate',
            1));


            // --- EXISTING LOGIC FOR CUTI UMUM (VALIDATION & CALCULATION) ---

            // Debug form submission
            $('#formCuti').on('submit', function(e) {
                $('#form_submitted').val('1');
                const jeniscuti_id = $('#jeniscuti_id').val();
                if (!jeniscuti_id) {
                    e.preventDefault();
                    alert('Silakan pilih jenis cuti terlebih dahulu');
                    return false;
                }
                const tgl_mulai = $('#tgl_mulai').val();
                const tgl_selesai = $('#tgl_selesai').val();
                if (!tgl_mulai || !tgl_selesai) {
                    e.preventDefault();
                    alert('Silakan isi tanggal mulai dan tanggal selesai cuti');
                    return false;
                }
                return true;
            });

            function showSnackbar(message, duration = 3000) {
                const snackbar = document.getElementById('snackbar');
                const snackbarMessage = document.getElementById('snackbarMessage');
                snackbarMessage.textContent = message;
                snackbar.classList.remove('invisible', 'opacity-0');
                snackbar.classList.add('visible', 'opacity-100');
                setTimeout(function() {
                    snackbar.classList.remove('visible', 'opacity-100');
                    snackbar.classList.add('opacity-0');
                    setTimeout(() => snackbar.classList.add('invisible'), 300);
                }, duration);
            }

            // Holiday Check Helpers for Calculation Logic
            function isHoliday(date, holidays) {
                const formattedDate = date.toISOString().split('T')[0];
                return holidays.some(holiday => holiday.date === formattedDate);
            }

            function showHolidaysInRange(startDate, endDate, holidays) {
                $('#holidays-tooltip, #holidays-list').remove();
                const holidaysInRange = holidays.filter(holiday => {
                    const holidayDate = new Date(holiday.date);
                    return holidayDate >= startDate && holidayDate <= endDate;
                });

                if (holidaysInRange.length > 0) {
                    let tooltipContent = '<strong>Hari Libur dalam Rentang Tanggal:</strong><ul>';
                    holidaysInRange.forEach(holiday => {
                        const formattedDate = new Date(holiday.date).toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        tooltipContent += `<li>${formattedDate}: ${holiday.name}</li>`;
                    });
                    tooltipContent += '</ul>';
                    $('<div id="holidays-list" class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded text-sm"></div>')
                        .insertAfter('#satuan_durasi');
                    $('#holidays-list').html(tooltipContent);
                }
            }

            // Calculation Functions
            function hitungDurasiCuti() {
                const tglMulai = $('#tgl_mulai').val();
                const tglSelesai = $('#tgl_selesai').val();
                const jenisCutiId = $('#jeniscuti_id').val();

                if (tglMulai && tglSelesai && jenisCutiId) {
                    $('#satuan_durasi').addClass('hidden');
                    $('#jumlah_hari').val('Menghitung...');

                    $.ajax({
                        url: "/hitungDurasiCuti",
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            tgl_mulai: tglMulai,
                            tgl_selesai: tglSelesai,
                            jenis_cuti: jenisCutiId
                        },
                        success: function(response) {
                            if (response && response.jumlah_hari !== undefined) {
                                const jumlahHari = parseInt(response.jumlah_hari);
                                if (jumlahHari >= 30) {
                                    const bulan = Math.round(jumlahHari / 30 * 10) / 10;
                                    $('#jumlah_hari').val(bulan);
                                    $('#satuan_durasi').text('bulan').removeClass('hidden');
                                } else {
                                    $('#jumlah_hari').val(response.jumlah_hari);
                                    $('#satuan_durasi').text('hari kerja').removeClass('hidden');
                                }
                            } else {
                                $('#jumlah_hari').val('Error');
                            }
                        },
                        error: function() {
                            $('#jumlah_hari').val('Error');
                        }
                    });
                }
            }

            function hitungCutiMelahirkan() {
                const tglMulai = $('#tgl_mulai').val();
                if (tglMulai) {
                    $('#satuan_durasi').addClass('hidden');
                    $('#jumlah_hari').val('Menghitung...');
                    $('#tgl_selesai').val('');

                    $.ajax({
                        url: "/hitung-cuti-melahirkan",
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            tgl_mulai: tglMulai
                        },
                        success: function(response) {
                            if (response && response.jumlah_hari !== undefined && response
                                .tgl_selesai) {
                                const jumlahHari = parseInt(response.jumlah_hari);
                                if (jumlahHari >= 30) {
                                    const bulan = Math.round(jumlahHari / 30 * 10) / 10;
                                    $('#jumlah_hari').val(bulan);
                                    $('#satuan_durasi').text('bulan').removeClass('hidden');
                                } else {
                                    $('#jumlah_hari').val(response.jumlah_hari);
                                    $('#satuan_durasi').text('bulan').removeClass('hidden');
                                }
                                $('#tgl_selesai').val(response.tgl_selesai);
                            } else {
                                $('#jumlah_hari').val('Error');
                            }
                        },
                        error: function() {
                            $('#jumlah_hari').val('Error');
                        }
                    });
                }
            }

            async function hitungDurasiCutiWithHolidays() {
                const tglMulai = $('#tgl_mulai').val();
                const tglSelesai = $('#tgl_selesai').val();
                const jenisCutiNama = $('#jeniscuti_id').find('option:selected').data('nama');

                if (!tglMulai || !tglSelesai) return;

                $('#satuan_durasi').addClass('hidden');
                $('#jumlah_hari').val('Menghitung...');

                try {
                    if (jenisCutiNama === 'Cuti Sakit' || jenisCutiNama === 'Cuti Alasan Penting') {
                        const startDate = new Date(tglMulai);
                        const endDate = new Date(tglSelesai);
                        const startYear = startDate.getFullYear();
                        const endYear = endDate.getFullYear();
                        let allHolidays = [];

                        if (startYear === endYear) {
                            allHolidays = await fetchHolidays(startYear);
                        } else {
                            const h1 = await fetchHolidays(startYear);
                            const h2 = await fetchHolidays(endYear);
                            allHolidays = [...h1, ...h2];
                        }

                        let workDays = 0;
                        const currentDate = new Date(startDate);
                        while (currentDate <= endDate) {
                            const dayOfWeek = currentDate.getDay();
                            if (dayOfWeek !== 0 && dayOfWeek !== 6 && !isHoliday(currentDate, allHolidays)) {
                                workDays++;
                            }
                            currentDate.setDate(currentDate.getDate() + 1);
                        }
                        $('#jumlah_hari').val(workDays);
                        $('#satuan_durasi').text('hari kerja').removeClass('hidden');
                        showHolidaysInRange(startDate, endDate, allHolidays);
                    } else {
                        hitungDurasiCuti();
                    }
                } catch (error) {
                    $('#jumlah_hari').val('Error');
                }
            }

            function updateCutiBesar(durasi) {
                const tglMulai = $('#tgl_mulai').val();
                if (tglMulai && durasi) {
                    const tglMulaiDate = new Date(tglMulai);
                    tglMulaiDate.setMonth(tglMulaiDate.getMonth() + parseInt(durasi));
                    tglMulaiDate.setDate(tglMulaiDate.getDate() - 1);
                    const formattedDate = tglMulaiDate.toISOString().split('T')[0];
                    $('#tgl_selesai').val(formattedDate);
                    $('#jumlah_hari').val(durasi);
                    $('#satuan_durasi').text('bulan').removeClass('hidden');
                }
            }

            function toggleLampiranVisibility() {
                const jenisCutiSelect = document.getElementById('jeniscuti_id');
                const lampiranContainer = document.getElementById('lampiran-container');
                if (jenisCutiSelect && jenisCutiSelect.selectedIndex >= 0 && lampiranContainer) {
                    const selectedOption = jenisCutiSelect.options[jenisCutiSelect.selectedIndex].text;
                    if (selectedOption.includes('Sakit') || selectedOption.includes('Alasan Penting')) {
                        lampiranContainer.classList.remove('hidden');
                    } else {
                        lampiranContainer.classList.add('hidden');
                    }
                }
            }

            // --- EVENT HANDLERS FOR LOGIC ---
            function setupEventHandlers() {
                $('#jeniscuti_id').on('change', function() {
                    const jenisCutiId = $(this).val();
                    const jenisCutiNama = $(this).find('option:selected').data('nama');

                    $('#lampiran-container, #durasi-cuti-besar').addClass('hidden');
                    $('#tgl_selesai').prop('readonly', false).removeClass('bg-gray-100').addClass(
                        'bg-white');
                    $('#holidays-tooltip, #holidays-list').remove();

                    if (jenisCutiId) {
                        $('#form-bawah').removeClass('hidden');
                        if (jenisCutiNama === 'Cuti Sakit' || jenisCutiNama === 'Cuti Alasan Penting') {
                            $('#lampiran-container').removeClass('hidden');
                            if ($('#tgl_mulai').val() && $('#tgl_selesai').val())
                                hitungDurasiCutiWithHolidays();
                        } else if (jenisCutiNama === 'Cuti Besar') {
                            $('#durasi-cuti-besar').removeClass('hidden');
                            $('#tgl_selesai').prop('readonly', true).removeClass('bg-white').addClass(
                                'bg-gray-100');
                            $('.durasi-btn').removeClass('bg-blue-600 text-white').addClass(
                                'text-blue-700 bg-white');
                            if ($('#tgl_mulai').val()) updateCutiBesar($('.durasi-btn.bg-blue-600').data(
                                'durasi') || 3);
                        } else if (jenisCutiNama === 'Cuti Melahirkan') {
                            $('#tgl_selesai').prop('readonly', true).removeClass('bg-white').addClass(
                                'bg-gray-100');
                            if ($('#tgl_mulai').val()) hitungCutiMelahirkan();
                        } else {
                            if ($('#tgl_mulai').val() && $('#tgl_selesai').val()) hitungDurasiCuti();
                        }
                    } else {
                        $('#form-bawah').addClass('hidden');
                    }
                    toggleLampiranVisibility();
                });

                // TRIGGER CHANGE WHEN DATE INPUT CHANGES (Triggered by Calendar Click too)
                $('#tgl_mulai, #tgl_selesai').on('change', function() {
                    const jenisCutiNama = $('#jeniscuti_id').find('option:selected').data('nama');

                    if (jenisCutiNama === 'Cuti Melahirkan') {
                        if ($('#tgl_mulai').val()) hitungCutiMelahirkan();
                    } else if (jenisCutiNama === 'Cuti Besar') {
                        if ($('#tgl_mulai').val()) updateCutiBesar($('.durasi-btn.bg-blue-600').data(
                            'durasi') || 3);
                    } else if (jenisCutiNama === 'Cuti Sakit' || jenisCutiNama === 'Cuti Alasan Penting') {
                        if ($('#tgl_mulai').val() && $('#tgl_selesai').val())
                    hitungDurasiCutiWithHolidays();
                    } else {
                        if ($('#tgl_mulai').val() && $('#tgl_selesai').val()) hitungDurasiCuti();
                    }
                });

                $('.durasi-btn').on('click', function() {
                    const tglMulai = $('#tgl_mulai').val();
                    if (!tglMulai) {
                        showSnackbar('Mohon pilih tanggal mulai cuti terlebih dahulu');
                        return;
                    }
                    const durasi = $(this).data('durasi');
                    $('.durasi-btn').removeClass('bg-primary/30').addClass('bg-primary/10');
                    $(this).removeClass('bg-primary/10').addClass('bg-primary/30');
                    updateCutiBesar(durasi);
                });
            }

            // File Upload Logic
            const lampiranInput = document.getElementById('lampiran');
            if (lampiranInput) {
                lampiranInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        document.getElementById('file-name').textContent = this.files[0].name;
                        document.getElementById('file-preview').classList.remove('hidden');
                        document.getElementById('cancel-upload').classList.remove('hidden');
                        document.getElementById('upload-label').textContent = 'Ganti File';
                    }
                });
                document.getElementById('cancel-upload').addEventListener('click', function() {
                    lampiranInput.value = '';
                    document.getElementById('file-preview').classList.add('hidden');
                    document.getElementById('cancel-upload').classList.add('hidden');
                    document.getElementById('upload-label').textContent = 'Pilih File';
                });
            }

            setupEventHandlers();
            toggleLampiranVisibility();
            if ($('#jeniscuti_id').val()) $('#jeniscuti_id').trigger('change');
        });
    </script>
@endpush
