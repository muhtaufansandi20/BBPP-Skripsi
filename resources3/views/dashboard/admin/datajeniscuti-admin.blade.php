{{-- @extends('dashboard.admin.base-admin')

@section('main')

<div class="max-w-6xl mx-auto space-y-6 mb-8">
    <!-- Alert Notification -->
    <div class="flex items-start p-4 bg-amber-50 rounded-xl border border-amber-200 shadow-sm">
        <svg class="flex-shrink-0 w-5 h-5 text-amber-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd"></path>
        </svg>
        <div class="text-sm text-amber-700">
            <strong class="font-medium">Perhatian!</strong> Mohon untuk tidak mengubah data jenis cuti yang sudah tersedia agar sistem tetap konsisten.
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Table Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-6 pt-4 pb-0">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Manajemen Jenis Cuti</h2>
                <p class="text-sm text-gray-500 mt-1">Daftar seluruh jenis cuti yang tersedia</p>
            </div>
            <a href="{{ route('admindatajeniscuti.index') }}" 
               class="flex items-center gap-2 bg-gray-400 text-white px-5 py-2.5 rounded-xl cursor-not-allowed"
               aria-disabled="true" tabindex="-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm">Tambah Jenis Cuti</span>
            </a>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto px-4 mt-4">
            <table class="w-full table-auto bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gradient-to-r from-primary to-lime-500">
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Jenis Cuti</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($jeniscutis as $cuti)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">{{ $cuti->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $cuti->nama_cuti }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right space-x-2">
                            <a href="{{ route('admindatajeniscuti.index', $cuti->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-gray-500 bg-gray-100 cursor-not-allowed"
                               aria-disabled="true" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('admindatajeniscuti.index') }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-lg text-gray-500 bg-gray-100 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection --}}