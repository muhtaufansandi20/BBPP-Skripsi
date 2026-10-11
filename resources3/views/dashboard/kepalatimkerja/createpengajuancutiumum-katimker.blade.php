@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-primary to-lime-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-3">
                    <i class="fas fa-file-alt"></i>
                    Pengajuan Cuti Umum 
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

                <form action="{{ route('katimkerpengajuancutiumum.store') }}" method="POST" enctype="multipart/form-data"
                    id="formCuti">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <!-- PILIHAN JENIS CUTI BERBENTUK TOMBOL PILL -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Cuti <span
                                class="text-red-500">*</span></label>
                        
                        <input type="hidden" id="jeniscuti_id" name="jeniscuti_id" value="{{ old('jeniscuti_id') }}" required>

                        <div class="flex flex-wrap gap-3">
                            @foreach ($jenisCuti as $cuti)
                                <button type="button"
                                    class="jenis-cuti-btn flex-1 min-w-[140px] py-2.5 px-4 border rounded-full text-sm font-medium transition-all text-center focus:outline-none {{ old('jeniscuti_id') == $cuti->id ? 'bg-primary text-white border-primary shadow-sm' : 'bg-white border-gray-300 text-gray-700 hover:border-primary hover:text-primary' }}"
                                    data-id="{{ $cuti->id }}"
                                    data-nama="{{ $cuti->nama_cuti }}">
                                    {{ $cuti->nama_cuti }}
                                </button>
                            @endforeach
                        </div>

                        @error('jeniscuti_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="form-bawah" class="hidden space-y-6">
                        <!-- LAMPIRAN (MUNCUL JIKA CUTI SAKIT / ALASAN PENTING) -->
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
                            <p class="text-xs text-gray-500 mt-2">Silakan unggah dokumen pendukung yang diperlukan, seperti surat keterangan dari dokter.</p>
                        </div>

                        <!-- DURASI CUTI BESAR (DISESUAIKAN GAYANYA) -->
                        <div id="durasi-cuti-besar" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Cuti Besar</label>
                            <div class="flex gap-3">
                                <button type="button"
                                    class="durasi-btn flex-1 py-3 px-4 border rounded-xl transition-all flex flex-col items-center focus:outline-none bg-white border-gray-300 text-gray-700 hover:border-primary"
                                    data-durasi="1">
                                    <span class="text-lg font-bold">1</span>
                                    <span class="text-xs mt-0.5">Bulan</span>
                                </button>
                                <button type="button"
                                    class="durasi-btn flex-1 py-3 px-4 border rounded-xl transition-all flex flex-col items-center focus:outline-none bg-white border-gray-300 text-gray-700 hover:border-primary"
                                    data-durasi="2">
                                    <span class="text-lg font-bold">2</span>
                                    <span class="text-xs mt-0.5">Bulan</span>
                                </button>
                                <button type="button"
                                    class="durasi-btn flex-1 py-3 px-4 border rounded-xl transition-all flex flex-col items-center focus:outline-none bg-primary text-white border-primary shadow-sm"
                                    data-durasi="3">
                                    <span class="text-lg font-bold">3</span>
                                    <span class="text-xs mt-0.5">Bulan</span>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1 text-gray-400 text-xs"></i>
                                Durasi maksimal 90 hari (3 bulan)
                            </p>
                        </div>

                        <!-- TANGGAL PENGAJUAN & MASA KERJA (SEJAJAR) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tgl_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                                        id="tgl_pengajuan" name="tgl_pengajuan"
                                        value="{{ old('tgl_pengajuan', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Masa Kerja</label>
                                @if ($checkUser)
                                    <div class="px-4 py-2.5 border border-green-200 bg-green-50/50 rounded-lg flex items-center gap-2 text-green-700 font-medium">
                                        <i class="fas fa-briefcase text-primary"></i>
                                        <span>{{ $masakerja->jumlah_masa_kerja }}</span>
                                        <input type="hidden" name="masa_kerja" value="{{ $masakerja->jumlah_masa_kerja }}">
                                    </div>
                                @else
                                    <div class="flex">
                                        <input type="text"
                                            class="flex-grow px-4 py-2.5 border border-gray-300 rounded-l-lg bg-gray-50 text-sm"
                                            name="masa_kerja" placeholder="Silahkan hitung masa kerja" disabled>
                                        <a href="{{ route('katimkermasakerja.create') }}"
                                            class="px-4 py-2.5 bg-white border border-primary text-primary rounded-r-lg hover:bg-primary/10 transition-colors flex items-center gap-2 text-sm">
                                            <i class="fas fa-calculator"></i>
                                            <span>Hitung Masa Kerja</span>
                                        </a>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Anda harus menghitung masa kerja terlebih dahulu</p>
                                @endif
                            </div>
                        </div>

                        <!-- TANGGAL MULAI & TANGGAL AKHIR CUTI -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="tgl_mulai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai Cuti <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                                        id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required>

                                    <div id="startDateCalendar"
                                        class="absolute top-full left-0 z-50 mt-1 bg-white border rounded-lg shadow-xl hidden w-full sm:w-72">
                                        <div class="p-3 border-b bg-gray-50 rounded-t-lg">
                                            <div class="flex items-center justify-between">
                                                <button type="button" class="prevMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&lt;</button>
                                                <span class="calendarMonth font-bold text-gray-700"></span>
                                                <button type="button" class="nextMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&gt;</button>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="grid grid-cols-7 gap-1 text-center text-xs mb-2 font-semibold text-gray-500">
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
                                <label for="tgl_selesai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir Cuti <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="date"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 bg-white"
                                        id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required>

                                    <div id="endDateCalendar"
                                        class="absolute top-full right-0 z-50 mt-1 bg-white border rounded-lg shadow-xl hidden w-full sm:w-72">
                                        <div class="p-3 border-b bg-gray-50 rounded-t-lg">
                                            <div class="flex items-center justify-between">
                                                <button type="button" class="prevMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&lt;</button>
                                                <span class="calendarMonth font-bold text-gray-700"></span>
                                                <button type="button" class="nextMonth px-2 py-1 bg-white border rounded hover:bg-gray-100">&gt;</button>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="grid grid-cols-7 gap-1 text-center text-xs mb-2 font-semibold text-gray-500">
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

                        <!-- LAMA CUTI -->
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
                            <p class="text-xs text-gray-500 mt-2">Lama cuti akan dihitung otomatis berdasarkan tanggal yang dipilih</p>
                        </div>

                        <!-- ALASAN CUTI -->
                        <div>
                            <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Cuti <span class="text-red-500">*</span></label>
                            <textarea
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 min-h-[100px]"
                                id="alasan" name="alasan" required>{{ old('alasan') }}</textarea>
                        </div>

                        <!-- ALAMAT SAAT CUTI -->
                        <div>
                            <label for="alamat_saat_cuti" class="block text-sm font-medium text-gray-700 mb-2">Alamat Saat Cuti <span class="text-red-500">*</span></label>
                            <textarea
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300 min-h-[80px]"
                                id="alamat_saat_cuti" name="alamat_saat_cuti" required>{{ old('alamat_saat_cuti') }}</textarea>
                        </div>

                        <!-- NO HP SAAT CUTI -->
                        <div>
                            <label for="no_hp_cuti" class="block text-sm font-medium text-gray-700 mb-2">No. HP Saat Cuti <span class="text-red-500">*</span></label>
                            <input type="text"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-300"
                                id="no_hp_cuti" name="no_hp_cuti" value="{{ old('no_hp_cuti', $no_hp_cuti) }}" required>
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6">
                            <a href="{{ route('katimkerpengajuancutiumum.index') }}"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary/80 text-white rounded-lg hover:from-primary/80 hover:to-primary/60 transition-all flex items-center justify-center gap-2">
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const startDateInput = document.getElementById('tgl_mulai');
            const endDateInput = document.getElementById('tgl_selesai');
            const startDateCalendar = document.getElementById('startDateCalendar');
            const endDateCalendar = document.getElementById('endDateCalendar');
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

                const selectedStartDate = startDateInput.value;
                const selectedEndDate = endDateInput.value;
                const startDateObj = selectedStartDate ? new Date(selectedStartDate) : null;
                const endDateObj = selectedEndDate ? new Date(selectedEndDate) : null;

                calendarGrid.innerHTML = '';

                const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
                    'September', 'Oktober', 'November', 'Desember'
                ];
                monthDisplay.textContent = `${monthNames[state.month]} ${state.year}`;

                const firstDay = new Date(state.year, state.month, 1);
                const lastDay = new Date(state.year, state.month + 1, 0);
                const holidays = await fetchHolidays(state.year, state.month);
                let firstDayOfWeek = firstDay.getDay();

                for (let i = 0; i < firstDayOfWeek; i++) {
                    const emptyCell = document.createElement('div');
                    emptyCell.className = 'h-8';
                    calendarGrid.appendChild(emptyCell);
                }

                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const date = new Date(state.year, state.month, day);
                    const dayOfWeek = date.getDay();
                    const formattedDate = formatDate(date);

                    const dayCell = document.createElement('div');
                    dayCell.className =
                        'h-8 flex items-center justify-center rounded cursor-pointer hover:bg-gray-100 transition-colors text-sm';
                    dayCell.textContent = day;
                    dayCell.dataset.date = formattedDate;

                    const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
                    if (isWeekend) {
                        dayCell.classList.add('text-red-500', 'font-medium');
                        dayCell.setAttribute('title', 'Akhir Pekan');
                    }

                    const holidayInfo = holidays.find(h => h.date === formattedDate);
                    let isBlackout = false;

                    if (holidayInfo) {
                        if (holidayInfo.type === 'blackout') {
                            dayCell.classList.add('text-orange-500', 'font-medium', 'bg-orange-50',
                                'cursor-not-allowed', 'opacity-50');
                            dayCell.setAttribute('title', `Blackout Date: ${holidayInfo.name}`);
                            isBlackout = true;
                        } else {
                            dayCell.classList.add('text-red-500', 'font-medium');
                            dayCell.setAttribute('title', holidayInfo.name);
                        }
                    }

                    if (formattedDate === selectedStartDate) dayCell.classList.add('bg-primary', 'text-white', 'hover:bg-primary/90');
                    if (formattedDate === selectedEndDate) dayCell.classList.add('bg-primary', 'text-white', 'hover:bg-primary/90');

                    if (startDateObj && endDateObj && date > startDateObj && date < endDateObj) {
                        dayCell.classList.add('bg-primary/20');
                    }

                    if (!isBlackout) {
                        dayCell.addEventListener('click', function() {
                            state.input.value = formattedDate;
                            state.calendar.classList.add('hidden');
                            $(state.input).trigger('change');
                        });
                    }

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

            startDateInput.addEventListener('click', function(e) {
                if (this.readOnly || this.disabled) return;
                e.preventDefault();
                renderCalendar('startDate');
                startDateCalendar.classList.remove('hidden');
                endDateCalendar.classList.add('hidden');
            });

            endDateInput.addEventListener('click', function(e) {
                if (this.readOnly || this.disabled) return;
                e.preventDefault();
                renderCalendar('endDate');
                endDateCalendar.classList.remove('hidden');
                startDateCalendar.classList.add('hidden');
            });

            document.addEventListener('click', function(e) {
                if (!startDateInput.contains(e.target) && !startDateCalendar.contains(e.target) &&
                    !endDateInput.contains(e.target) && !endDateCalendar.contains(e.target)) {
                    startDateCalendar.classList.add('hidden');
                    endDateCalendar.classList.add('hidden');
                }
            });

            startDateCalendar.querySelector('.prevMonth').addEventListener('click', () => navigateMonth('startDate', -1));
            startDateCalendar.querySelector('.nextMonth').addEventListener('click', () => navigateMonth('startDate', 1));
            endDateCalendar.querySelector('.prevMonth').addEventListener('click', () => navigateMonth('endDate', -1));
            endDateCalendar.querySelector('.nextMonth').addEventListener('click', () => navigateMonth('endDate', 1));

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
                            if (response && response.jumlah_hari !== undefined && response.tgl_selesai) {
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
                const jenisCutiId = $('#jeniscuti_id').val();
                const jenisCutiNama = $(`.jenis-cuti-btn[data-id="${jenisCutiId}"]`).data('nama');

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

            function setupEventHandlers() {
                $('.jenis-cuti-btn').on('click', function() {
                    $('.jenis-cuti-btn').removeClass('bg-primary text-white border-primary shadow-sm').addClass('bg-white border-gray-300 text-gray-700');
                    $(this).removeClass('bg-white border-gray-300 text-gray-700').addClass('bg-primary text-white border-primary shadow-sm');

                    const jenisCutiId = $(this).data('id');
                    const jenisCutiNama = $(this).data('nama');

                    $('#jeniscuti_id').val(jenisCutiId);

                    $('#lampiran-container, #durasi-cuti-besar').addClass('hidden');
                    $('#tgl_selesai').prop('readonly', false).removeClass('bg-gray-100').addClass('bg-white');
                    $('#holidays-tooltip, #holidays-list').remove();

                    if (jenisCutiId) {
                        $('#form-bawah').removeClass('hidden');
                        if (jenisCutiNama === 'Cuti Sakit' || jenisCutiNama === 'Cuti Alasan Penting') {
                            $('#lampiran-container').removeClass('hidden');
                            if ($('#tgl_mulai').val() && $('#tgl_selesai').val())
                                hitungDurasiCutiWithHolidays();
                        } else if (jenisCutiNama === 'Cuti Besar') {
                            $('#durasi-cuti-besar').removeClass('hidden');
                            $('#tgl_selesai').prop('readonly', true).removeClass('bg-white').addClass('bg-gray-100');
                            const activeDurasiBtn = $('.durasi-btn.bg-primary');
                            const durasiVal = activeDurasiBtn.length ? activeDurasiBtn.data('durasi') : 3;
                            if ($('#tgl_mulai').val()) updateCutiBesar(durasiVal);
                        } else if (jenisCutiNama === 'Cuti Melahirkan') {
                            $('#tgl_selesai').prop('readonly', true).removeClass('bg-white').addClass('bg-gray-100');
                            if ($('#tgl_mulai').val()) hitungCutiMelahirkan();
                        } else {
                            if ($('#tgl_mulai').val() && $('#tgl_selesai').val()) hitungDurasiCuti();
                        }
                    } else {
                        $('#form-bawah').addClass('hidden');
                    }
                    toggleLampiranVisibility();
                });

                $('#tgl_mulai, #tgl_selesai').on('change', function() {
                    const jenisCutiId = $('#jeniscuti_id').val();
                    const jenisCutiNama = $(`.jenis-cuti-btn[data-id="${jenisCutiId}"]`).data('nama');

                    if (jenisCutiNama === 'Cuti Melahirkan') {
                        if ($('#tgl_mulai').val()) hitungCutiMelahirkan();
                    } else if (jenisCutiNama === 'Cuti Besar') {
                        const activeDurasiBtn = $('.durasi-btn.bg-primary');
                        const durasiVal = activeDurasiBtn.length ? activeDurasiBtn.data('durasi') : 3;
                        if ($('#tgl_mulai').val()) updateCutiBesar(durasiVal);
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
                    $('.durasi-btn').removeClass('bg-primary text-white border-primary shadow-sm').addClass('bg-white border-gray-300 text-gray-700');
                    $(this).removeClass('bg-white border-gray-300 text-gray-700').addClass('bg-primary text-white border-primary shadow-sm');
                    updateCutiBesar(durasi);
                });
            }

            function toggleLampiranVisibility() {
                const jenisCutiId = $('#jeniscuti_id').val();
                const lampiranContainer = document.getElementById('lampiran-container');
                if (jenisCutiId && lampiranContainer) {
                    const activeBtn = $(`.jenis-cuti-btn[data-id="${jenisCutiId}"]`);
                    const selectedName = activeBtn.length ? activeBtn.data('nama') : '';
                    if (selectedName && (selectedName.includes('Sakit') || selectedName.includes('Alasan Penting'))) {
                        lampiranContainer.classList.remove('hidden');
                    } else {
                        lampiranContainer.classList.add('hidden');
                    }
                } else if (lampiranContainer) {
                    lampiranContainer.classList.add('hidden');
                }
            }

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

            const oldVal = $('#jeniscuti_id').val();
            if (oldVal) {
                $(`.jenis-cuti-btn[data-id="${oldVal}"]`).trigger('click');
            } else {
                // Default pilih tombol pertama atau biarkan kosong sesuai state awal
            }
        });
    </script>
@endpush