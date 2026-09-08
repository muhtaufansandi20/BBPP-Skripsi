{{-- @extends('dashboard.admin.base-admin')

@section('main')
<div class="max-w-lg mx-auto p-4">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-primary to-lime-500">
            <h2 class="text-xl font-semibold text-white">Edit Tim Kerja</h2>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 text-green-800 text-sm p-2 py-0 rounded-lg border border-green-100">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admintimkerja.update', $timKerja->id) }}" method="POST" class="p-6 pt-0 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="nama_tim" class="block text-sm font-medium text-gray-700">Nama Tim</label>
                <input type="text" 
                    class="block w-full px-3 py-2 border border-gray-200 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_tim') border-red-500 @enderror"
                    id="nama_tim" 
                    name="nama_tim" 
                    value="{{ old('nama_tim', $timKerja->nama_tim) }}" 
                    required>
                
                @error('nama_tim')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <!-- Tombol Kembali -->
                <a href="{{ route('admintimkerja.index') }}" 
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-sm sm:text-base">Kembali</span>
                </a>
                
                <!-- Tombol Simpan -->
                <button type="submit" 
                    class="w-full sm:w-auto px-4 sm:px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm sm:text-base">Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection --}}