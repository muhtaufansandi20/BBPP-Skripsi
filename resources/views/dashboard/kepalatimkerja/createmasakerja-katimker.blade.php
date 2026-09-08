@extends('dashboard.kepalatimkerja.base-kepalatimkerja')

@section('content')

<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Hitung Masa Kerja</h2>

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

    <form action="{{ route('katimkermasakerja.store')}}" method="POST" class="mt-4" id="masaKerjaForm">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="jumlah_masa_kerja" id="masaKerjaInput">
        
        <div class="flex gap-2">
            <button type="button" onclick="hitungSelisih()" class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                Hitung Selisih
            </button>
            <button type="submit" id="saveButton" hidden class="px-4 py-2 bg-green-600 text-white rounded-md shadow-md hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                <span class="flex items-center">
                    <span id="saveText">Simpan</span>
                    <span id="saveLoading" class="hidden ml-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </span>
            </button>
         
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi input honorer
        document.getElementById('honoryear').addEventListener('input', validateHonor);
        // Validasi tanggal
        document.getElementById('selectedDate').addEventListener('change', validateDate);
        // Tambahkan efek loading pada saat submit
        document.getElementById('masaKerjaForm').addEventListener('submit', showLoading);
    });

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

    // Tambahkan animasi fade-in
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }
        </style>
    `);
</script>

@endsection