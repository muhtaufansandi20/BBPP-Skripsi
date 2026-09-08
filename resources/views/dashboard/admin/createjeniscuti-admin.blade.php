@extends('dashboard.admin.base-admin')
@section('main')

<div class="max-w-md mx-auto my-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 transform transition-all hover:shadow-xl">
        <!-- Header with gradient -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Tambah Jenis Cuti Baru
                </h2>
                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-leaf text-white"></i>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admindatajeniscuti.store') }}" class="p-6 space-y-6">
            @csrf

            <!-- Cuti Name -->
            <div class="space-y-2">
                <label for="nama_cuti" class="block text-sm font-medium text-gray-700 flex items-center">
                    <i class="fas fa-tag mr-2 text-blue-500"></i>
                    <span>Nama Jenis Cuti</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-pen text-gray-400"></i>
                    </div>
                    <input type="text" id="nama_cuti" name="nama_cuti" required
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                        placeholder="Masukkan nama jenis cuti">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3 px-4 rounded-lg shadow-md hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Jenis Cuti
                </button>
            </div>
        </form>
    </div>
</div>

@endsection