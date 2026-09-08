{{-- @extends('dashboard.admin.base-admin')

@section('main')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<div class="max-w-lg mx-auto my-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-primary to-lime-500 px-6 py-2 border-b">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Tambah Anggota Tim
            </h2>
        </div>

        <form method="POST" action="{{ route('adminanggotatim.store') }}" class="p-6 space-y-5">
            @csrf

            <div class="space-y-2">
                <label for="tim_id" class="block text-sm font-medium text-gray-700">Tim Kerja</label>
                <select name="tim_id" id="tim_id" class="searchable-select" placeholder="Cari Tim...">
                    <option value="">Pilih Tim</option>
                    @foreach ($timKerjas as $tim)
                        <option value="{{ $tim->id }}" {{ old('tim_id') == $tim->id ? 'selected' : '' }}>
                            {{ $tim->nama_tim }}
                        </option>
                    @endforeach
                </select>
                @error('tim_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Pilih Pengguna</label>
                <select name="user_id" id="user_id" class="searchable-select" placeholder="Cari Nama, NIP atau Jabatan...">
                 <option value="">Pilih Pengguna</option>
    
                <!-- Kelompok Khusus Calon Ketua Tim (Hanya 2 Orang) -->
                <optgroup label="--- KHUSUS KETUA TIM ---">
                    @foreach ($calonKetua as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->nip }}) - {{ $user->jabatan }}
                        </option>
                    @endforeach
                </optgroup>

                <!-- Kelompok Pegawai Lainnya -->
                <optgroup label="--- CALON ANGGOTA BIASA ---">
                    @foreach ($calonAnggota as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->nip }}) - {{ $user->jabatan }}
                        </option>
                    @endforeach
                </optgroup>
                
            </select>
                @error('user_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label for="role" class="block text-sm font-medium text-gray-700">Peran</label>
                <select name="role" id="role" class="searchable-select">
                    <option value="">Pilih Peran</option>
                    <option value="Ketua" {{ old('role') == 'Ketua' ? 'selected' : '' }}>Ketua Tim</option>
                    <option value="anggota" {{ old('role') == 'anggota' ? 'selected' : '' }}>Anggota Tim</option>
                </select>
                @error('role') 
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div class="flex space-x-4 pt-4">
                <a href="{{ route('adminanggotatim.index') }}" class="flex-1 bg-gray-300 text-center py-2 rounded-lg">Kembali</a>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.searchable-select').forEach((el) => {
        new TomSelect(el, {
            create: false
        });
    });
</script>

<style>
    /* Menyesuaikan tampilan Tom Select agar senada dengan Tailwind */
    .ts-control {
        border-radius: 0.5rem !important; /* rounded-lg */
        padding: 0.6rem 0.75rem !important;
        background-color: #f9fafb !important; /* bg-gray-50 */
        border: 1px solid #d1d5db !important; /* border-gray-300 */
    }
    .ts-wrapper.focus .ts-control {
        box-shadow: 0 0 0 2px rgba(var(--primary-rgb), 0.2) !important;
        border-color: #primary !important;
    }
</style>
@endsection --}}