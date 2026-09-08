@extends('dashboard.admin.base-admin')
@section('main')

<div class="max-w-lg mx-auto bg-white rounded-lg shadow-md">
    <div class="max-w-lg mx-auto bg-gradient-to-r from-primary to-lime-500 px-6 py-4 rounded-t-lg shadow-md">
        <h2 class="text-xl font-semibold text-white">
            Tambah Pengguna
        </h2>
    </div>
    
    <div class="p-6">
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('admindatapengguna.store') }}" class="space-y-4"> 
            @csrf
            
            <div>
                <label for="name" class="block font-medium text-gray-700">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('name') border-red-500 @enderror"
                       placeholder="Nama lengkap">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- <div>
                <label for="e_mail" class="block font-medium text-gray-700">E-mail <span class="text-red-500">*</span></label>
                <input type="email" name="e_mail" id="e_mail" required value="{{ old('e_mail') }}"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('e_mail') border-red-500 @enderror"
                       placeholder="email@contoh.com">
                @error('e_mail')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> --}}
            
            <div>
                <label for="nip" class="block font-medium text-gray-700">NIP <span class="text-red-500">*</span></label>
                <input type="number" name="nip" id="nip" required value="{{ old('nip') }}"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('nip') border-red-500 @enderror"
                       placeholder="Nomor Induk Pegawai">
                @error('nip')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password" id="password" required 
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('password') border-red-500 @enderror"
                           placeholder="Minimal 8 karakter">
                    <button type="button" onclick="togglePassword('password')" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="role" class="block font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
                <select name="role" id="role" required 
                        class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('role') border-red-500 @enderror">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kepalatimkerja" {{ old('role') == 'kepalatimkerja' ? 'selected' : '' }}>Kepala Tim Kerja</option>
                    <option value="widyaiswara" {{ old('role') == 'widyaiswara' ? 'selected' : '' }}>Widyaiswara</option>
                    <option value="kepalabagian" {{ old('role') == 'kepalabagian' ? 'selected' : '' }} {{ isset($hasKepalaBagian) && $hasKepalaBagian ? 'disabled' : '' }}>
                        Kepala Bagian {{ isset($hasKepalaBagian) && $hasKepalaBagian ? '(Sudah Ada)' : '' }}
                    </option>
                    <option value="kepalabalai" {{ old('role') == 'kepalabalai' ? 'selected' : '' }} {{ isset($hasKepalaBalai) && $hasKepalaBalai ? 'disabled' : '' }}>
                        Kepala Balai {{ isset($hasKepalaBalai) && $hasKepalaBalai ? '(Sudah Ada)' : '' }}
                    </option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="no_hp" class="block font-medium text-gray-700">Nomor HP</label>
                <input type="text" name="no_hp" id="no_hp" maxlength="15" value="{{ old('no_hp') }}"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('no_hp') border-red-500 @enderror"
                       placeholder="081234567890">
                @error('no_hp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="jabatan" class="block font-medium text-gray-700">Jabatan</label>
                <input type="text" name="jabatan" id="jabatan" maxlength="50" value="{{ old('jabatan') }}"
                       class="w-full p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 @error('jabatan') border-red-500 @enderror"
                       placeholder="Jabatan pengguna">
                @error('jabatan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between pt-2">
                <a href="{{ route('admindatapengguna.index') }}" 
                   class="flex items-center justify-center gap-2 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg 
                          hover:bg-gray-300 hover:shadow-lg hover:-translate-y-1 
                          active:bg-gray-400 active:translate-y-0 
                          transition-all duration-200 ease-in-out transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <button type="submit" 
                        class="flex items-center justify-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg 
                              hover:bg-blue-700 hover:shadow-lg hover:-translate-y-1 
                              active:bg-blue-800 active:translate-y-0 
                              transition-all duration-200 ease-in-out transform">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@if(isset($hasKepalaBagian) && $hasKepalaBagian)
    <div class="max-w-lg mx-auto mt-4 bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-lg shadow-sm 
                transform transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
        <div class="flex items-start">
            <svg class="h-5 w-5 text-amber-600 mt-0.5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="font-bold text-amber-900">Perhatian!</p>
                <p class="text-sm">User dengan role Kepala Bagian sudah ada. Tidak dapat menambahkan user dengan role yang sama.</p>
            </div>
        </div>
    </div>
@endif

@if(isset($hasKepalaBalai) && $hasKepalaBalai)
    <div class="max-w-lg mx-auto mt-4 bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-lg shadow-sm 
                transform transition-all duration-300 hover:shadow-md hover:-translate-y-0.5">
        <div class="flex items-start">
            <svg class="h-5 w-5 text-amber-600 mt-0.5 mr-2 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.485 3.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 3.495zM10 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 6zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
            </svg>
            <div>
                <p class="font-bold text-amber-900">Perhatian!</p>
                <p class="text-sm">User dengan role Kepala Balai sudah ada. Tidak dapat menambahkan user dengan role yang sama.</p>
            </div>
        </div>
    </div>
@endif

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        field.type = field.type === 'password' ? 'text' : 'password';
    }
</script>

@endsection