{{-- @extends('dashboard.admin.base-admin')

@section('main')
<div class="max-w-md mx-auto my-8">
    <div class="bg-gray-50 rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header with gradient accent -->
        <div class="bg-gradient-to-r from-primary to-lime-500 border-b px-6 py-4">
            <h2 class="text-xl text-white font-semibold">Edit Anggota Tim</h2>
        </div>

        <!-- Error message -->
        @if (session('error'))
            <div class="mx-6 mt-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('adminanggotatim.update', $anggotaTim->id) }}" method="POST" class="p-6 pt-0 space-y-6">
            @csrf
            @method('PUT')

            <!-- Member info card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-accent/15 flex items-center justify-center text-accent/90">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ $anggotaTim->user->name }}</h3>
                            <div class="text-xs text-gray-500 mt-1 space-y-1">
                                <p class="flex items-center">
                                    <i class="fas fa-id-card mr-1"></i>
                                    <span>NIP: {{ $anggotaTim->user->nip }}</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    <span>Jabatan: {{ $anggotaTim->user->jabatan }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team selection -->
            <div class="space-y-2">
                <label for="tim_id" class="block text-sm font-medium text-gray-700 flex items-center">
                    <i class="fas fa-users mr-2 text-accent/90"></i>
                    <span>Pilih Tim</span>
                </label>
                <select id="tim_id" name="tim_id" required
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/90 focus:border-primary/90 @error('tim_id') border-red-500 @enderror">
                    <option value="">-- Pilih Tim --</option>
                    @foreach ($timKerjas as $tim)
                        <option value="{{ $tim->id }}" {{ $tim->id == $anggotaTim->tim_id ? 'selected' : '' }}>
                            {{ $tim->nama_tim }}
                        </option>
                    @endforeach
                </select>
                @error('tim_id')
                    <p class="text-red-600 text-xs mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Role selection -->
            <div class="space-y-2">
                <label for="role" class="block text-sm font-medium text-gray-700 flex items-center">
                    <i class="fas fa-user-tag mr-2 text-accent/90"></i>
                    <span>Role</span>
                </label>
                <select id="role" name="role" required
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/90 focus:border-primary/90 @error('role') border-red-500 @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="Ketua" {{ $anggotaTim->role == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                    <option value="anggota" {{ $anggotaTim->role == 'anggota' ? 'selected' : '' }}>Anggota</option>
                </select>
                @error('role')
                    <p class="text-red-600 text-xs mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Action buttons -->
            <div class="flex space-x-4 pt-4">
                <a href="{{ route('adminanggotatim.index') }}" 
                    class="flex-1 text-sm bg-gray-300 text-gray-900 px-4 py-2 rounded-lg shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="submit" 
                    class="flex-1 text-sm bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection --}}