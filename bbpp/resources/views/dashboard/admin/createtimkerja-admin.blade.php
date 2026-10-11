{{-- @extends('dashboard.admin.base-admin')
@section('main')

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg mt-8 border border-gray-100">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-primary to-lime-500">
            <h2 class="text-xl font-semibold text-white">Tambah Tim Kerja</h2>
        {{-- <div class="w-10 h-1 bg-gradient-to-r w-full from-blue-500 to-blue-300 rounded-full"></div> --}}
        {{-- </div>

        <div class="p-8 pt-4">
            <form method="POST" action="{{ route('admintimkerja.store') }}" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label for="nama_tim" class="block text-sm font-medium text-gray-600 mb-1">
                        Nama Tim
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_tim" name="nama_tim" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none 
                            focus:ring-2 focus:ring-blue-300 focus:border-transparent transition
                            placeholder-gray-400 hover:border-blue-200">
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
</div>

@endsection --}} 