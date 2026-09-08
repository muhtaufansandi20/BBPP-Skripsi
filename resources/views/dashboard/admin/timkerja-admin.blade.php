@extends('dashboard.admin.base-admin')
@section('main')

<div class="max-w-6xl mx-auto bg-white p-6 pt-3 rounded-xl shadow-sm" 
     x-data="{ 
         openTambahModal: {{ $errors->any() && !old('_method') ? 'true' : 'false' }},
         openEditModal: false,
         editForm: {
             nama_tim: '',
             actionUrl: ''
         },
         openEdit(namaTim, actionUrl) {
             this.editForm.nama_tim = namaTim;
             this.editForm.actionUrl = actionUrl;
             this.openEditModal = true;
         }
     }">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Manajemen Tim Kerja</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar seluruh tim kerja yang terdaftar</p>
        </div>
        
        <!-- Tombol Tambah Tim (Warna Hijau) -->
        <button type="button" 
           @click="openTambahModal = true"
           class="flex items-center gap-2 bg-[#00b074] hover:bg-[#009b63] text-white px-3.5 py-2 rounded-xl hover:shadow-md transition-all active:scale-[0.98]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            <span class="text-sm font-medium">Tambah Tim</span>
        </button>
    </div>
    
    @if (session('success'))
        <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg mb-6 border border-emerald-100 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="border border-gray-100 rounded-xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50/80 backdrop-blur">
                    <tr class="bg-gradient-to-r from-primary to-lime-500">
                        <th class="px-6 py-3 text-left text-sm font-medium text-white uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-white uppercase tracking-wider">Nama Tim</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-white uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($timkerjas as $key => $tim)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">{{ $key + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $tim->nama_tim }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right space-x-2">
                                <!-- Tombol Trigger Modal Edit -->
                                <button type="button" 
                                   @click="openEdit('{{ addslashes($tim->nama_tim) }}', '{{ route('admintimkerja.update', $tim->id) }}')"
                                   class="inline-flex items-center px-3 py-1.5 border border-blue-200 rounded-lg text-blue-600 hover:bg-blue-50 transition-all hover:border-blue-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </button>

                                <form action="{{ route('admintimkerja.destroy', $tim->id) }}" method="POST" class="inline" id="delete-form-{{ $tim->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete('{{ $tim->id }}', '{{ $tim->nama_tim }}')"
                                            class="inline-flex items-center px-3 py-1.5 border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition-all hover:border-red-300">
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

    <!-- MODAL TAMBAH TIM KERJA -->
    <div x-show="openTambahModal" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 transition-opacity" 
         x-cloak>
        <div @click.away="openTambahModal = false" 
             class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform transition-all">
            
            <div class="bg-[#00b074] px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">Tambah Tim Kerja</h3>
                </div>
                <button type="button" @click="openTambahModal = false" class="text-white/80 hover:text-white text-2xl font-bold leading-none">&times;</button>
            </div>

            <form method="POST" action="{{ route('admintimkerja.store') }}" class="p-6">
                @csrf
                <div class="bg-[#eaf8f1] p-4 rounded-2xl border border-emerald-100 mb-6">
                    <label for="nama_tim_tambah" class="block text-sm font-semibold text-[#00a86b] mb-2">
                        Nama Tim Kerja
                    </label>
                    <input type="text" 
                           id="nama_tim_tambah" 
                           name="nama_tim" 
                           value="{{ old('nama_tim') }}"
                           required 
                           placeholder="Masukkan nama tim kerja"
                           class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] focus:border-transparent text-gray-800 text-sm placeholder-gray-400 uppercase tracking-wide">
                    @error('nama_tim')
                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end items-center gap-3">
                    <button type="button" 
                            @click="openTambahModal = false" 
                            class="px-5 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        Batalkan
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-[#00b074] hover:bg-[#009b63] text-white text-sm font-medium rounded-xl transition shadow-sm">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT TIM KERJA -->
    <div x-show="openEditModal" 
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 transition-opacity" 
         x-cloak>
        <div @click.away="openEditModal = false" 
             class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform transition-all">
            
            <div class="bg-[#00b074] px-6 py-4 flex items-center justify-between text-white">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold">Edit Tim Kerja</h3>
                </div>
                <button type="button" @click="openEditModal = false" class="text-white/80 hover:text-white text-2xl font-bold leading-none">&times;</button>
            </div>

            <form method="POST" :action="editForm.actionUrl" class="p-6">
                @csrf
                @method('PUT')

                <div class="bg-[#eaf8f1] p-4 rounded-2xl border border-emerald-100 mb-6">
                    <label for="nama_tim_edit" class="block text-sm font-semibold text-[#00a86b] mb-2">
                        Nama Tim Kerja
                    </label>
                    <input type="text" 
                           id="nama_tim_edit" 
                           name="nama_tim" 
                           x-model="editForm.nama_tim"
                           required 
                           placeholder="Masukkan nama tim kerja"
                           class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#00b074] focus:border-transparent text-gray-800 text-sm placeholder-gray-400 uppercase tracking-wide">
                </div>

                <div class="flex justify-end items-center gap-3">
                    <button type="button" 
                            @click="openEditModal = false" 
                            class="px-5 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                        Batalkan
                    </button>
                    <button type="submit" 
                            class="px-6 py-2 bg-[#00b074] hover:bg-[#009b63] text-white text-sm font-medium rounded-xl transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id, namaTim) {
    Swal.fire({
        title: '<span style="font-size: 20px; font-weight: bold; color: #1f2937;">Hapus Tim Kerja?</span>',
        html: `<span style="font-size: 14px; color: #4b5563;">Apakah Anda yakin ingin menghapus <b>${namaTim}</b> ?</span><br><span style="font-size: 12px; color: #6b7280;">Data yang telah dihapus tidak dapat dikembalikan</span>`,
        icon: 'error',
        iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Batalkan',
        buttonsStyling: false,
        customClass: {
            popup: 'rounded-3xl p-6',
            confirmButton: 'bg-red-500 text-white px-6 py-2.5 rounded-xl font-medium hover:bg-red-600 transition mx-1',
            cancelButton: 'bg-white text-gray-700 border border-gray-300 px-6 py-2.5 rounded-xl font-medium hover:bg-gray-50 transition mx-1'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection