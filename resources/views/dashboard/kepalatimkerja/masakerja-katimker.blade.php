@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')
<div class="p-6 bg-white shadow-md rounded-lg">
    @if ($masakerja)
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Data Masa Kerja</h2>
                <p class="text-lg font-medium text-gray-700 mt-2">Masa Kerja Anda: <span class="font-semibold">{{ $masakerja->jumlah_masa_kerja }}</span></p>
            </div>
            <button type="button" onclick="openModal()" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Edit Masa Kerja
            </button>
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-6">
            <p class="text-red-500 font-semibold text-lg mb-4">Anda belum menghitung masa kerja</p>
            <button type="button" onclick="openModal()" class="px-5 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                Hitung Masa Kerja
            </button>
        </div>
    @endif
</div>

<!-- Modal for calculating masa kerja -->
<div id="masaKerjaModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="max-w-lg w-full mx-auto bg-white p-6 rounded-lg shadow-lg transform transition-all">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-700">Hitung Masa Kerja</h2>
            <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Masa Honorer (Jika Ada)</label>
            <div class="mt-2 flex gap-4">
                <div>
                    <label for="honoryear" class="block text-sm">Tahun</label>
                    <input type="number" id="honoryear" min="0" value="0" required 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                </div>
                <div>
                    <label for="honormonth" class="block text-sm">Bulan</label>
                    <select id="honormonth" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                        @for ($i = 0; $i < 12; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <p id="honorError" class="text-red-500 text-xs mt-1 hidden">Nilai tidak boleh negatif</p>
        </div>

        <div class="mb-4">
            <label for="selectedDate" class="block text-sm font-medium text-gray-700">Pilih Tahun dan Bulan:</label>
            <input type="month" id="selectedDate" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
            <p id="dateError" class="text-red-500 text-xs mt-1 hidden">Tanggal tidak boleh lebih besar dari tanggal sekarang</p>
        </div>

        <div class="mb-4">
            <label for="currentDate" class="block text-sm font-medium text-gray-700">Bulan dan Tahun Sekarang:</label>
            <input type="month" id="currentDate" value="{{ date('Y-m') }}" readonly
                   class="w-full border-gray-300 bg-gray-100 rounded-md shadow-sm">
        </div>

        <div id="resultContainer" class="p-4 border border-gray-200 rounded-md mb-4 bg-gray-50 hidden">
            <p id="result" class="text-lg font-semibold text-gray-700">Selisih : </p>
        </div>

        <!-- Critical Fix: Form handling for update/create -->
        @if($masakerja)
            <form action="{{ route('katimkermasakerja.update', $masakerja->id) }}" method="POST" class="mt-4" id="masaKerjaForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
        @else
            <form action="{{ route('katimkermasakerja.store') }}" method="POST" class="mt-4" id="masaKerjaForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
        @endif
            
            <div class="flex gap-2">
                <button type="button" onclick="hitungSelisih()" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Hitung Selisih
                </button>
                <button type="submit" id="saveButton" hidden class="px-4 py-2 bg-green-600 text-white rounded-md shadow-md hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <span class="flex items-center">
                        <span id="saveText">{{ $masakerja ? 'Update' : 'Simpan' }}</span>
                        <span id="saveLoading" class="hidden ml-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </span>
                </button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-md shadow-md hover:bg-gray-600 transition focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div id="successAlert" class="fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md">
    {{ session('success') }}
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi input honorer
        document.getElementById('honoryear').addEventListener('input', validateHonor);
        // Validasi tanggal
        document.getElementById('selectedDate').addEventListener('change', validateDate);
        // Tambahkan efek loading pada saat submit
        document.getElementById('masaKerjaForm').addEventListener('submit', showLoading);
        
        // Auto-hide success alert after 3 seconds
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transition = 'opacity 1s';
                setTimeout(() => {
                    successAlert.remove();
                }, 1000);
            }, 3000);
        }
    });
    
    function openModal() {
        document.getElementById('masaKerjaModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        
        // Animation
        const modalContent = document.querySelector('#masaKerjaModal > div');
        modalContent.classList.add('scale-in');
    }
    
    function closeModal() {
        document.getElementById('masaKerjaModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        
        // Reset form
        document.getElementById('resultContainer').classList.add('hidden');
        document.getElementById('saveButton').hidden = true;
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

    function showLoading(e) {
        document.getElementById('saveText').classList.add('hidden');
        document.getElementById('saveLoading').classList.remove('hidden');
        // Form submission continues normally
    }

    function hitungSelisih() {
        // Validasi input sebelum melakukan perhitungan
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
        
        let totalMonths = ((currentYear - selectedYear) * 12 + (currentMonth - selectedMonth)) + (honoryear * 12 + honormonth);
        let years = Math.floor(totalMonths / 12);
        let months = totalMonths % 12;
        
        let resultText = `${years} Tahun, ${months} Bulan`;
        
        // Tampilkan hasil dengan animasi
        const resultContainer = document.getElementById('resultContainer');
        resultContainer.classList.remove('hidden');
        resultContainer.classList.add('animate-fade-in');
        
        document.getElementById('result').innerText = "Selisih : " + resultText;
        document.getElementById('masaKerjaInput').value = resultText;

        // Tampilkan tombol Simpan setelah hitungan selesai
        document.getElementById('saveButton').hidden = false;
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
    
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .scale-in {
        animation: scaleIn 0.3s ease-out forwards;
    }
</style>
@endsection