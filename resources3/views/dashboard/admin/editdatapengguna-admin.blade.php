@extends('dashboard.admin.base-admin')

@section('main')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-primary to-lime-500">
            <h2 class="text-xl font-semibold text-white">Edit Data Pengguna</h2>
        </div>
        
        <!-- Notifications - Tightened spacing -->
        <div class="px-6 py-0 space-y-2">
            @if(session('success'))
                <div class="bg-green-50 text-green-800 text-sm p-3 rounded-lg border border-green-100">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 text-red-800 text-sm p-3 rounded-lg border border-red-100">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 text-red-800 text-sm p-3 rounded-lg border border-red-100">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Form - Adjusted spacing -->
        <form action="{{ route('admindatapengguna.update', $user->id) }}" method="POST" class="px-6 pb-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <label for="name" class="text-sm font-medium text-gray-700">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
            </div>

            <div class="space-y-1">
                <label for="nip" class="text-sm font-medium text-gray-700">NIP</label>
                <input type="text" id="nip" name="nip" value="{{ old('nip', $user->nip) }}" required
                    class="w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
            </div>

            <div class="space-y-1">
                <label for="role" class="text-sm font-medium text-gray-700">Role</label>
                <select id="role" name="role" required
                    class="w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                    {{-- <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option> --}}
                    <option value="widyaiswara" {{ $user->role === 'widyaiswara' ? 'selected' : '' }}>Widyaiswara</option>
                    <option value="kepalatimkerja" {{ $user->role === 'kepalatimkerja' ? 'selected' : '' }}>Kepala Tim Kerja</option>
                    <option value="kepalabagian" {{ $user->role === 'kepalabagian' ? 'selected' : '' }}
                        {{ $user->role !== 'kepalabagian' && isset($hasKepalaBagian) && $hasKepalaBagian ? 'disabled' : '' }}>
                        Kepala Bagian {{ $user->role !== 'kepalabagian' && isset($hasKepalaBagian) && $hasKepalaBagian ? '(Sudah Ada)' : '' }}
                    </option>
                    <option value="kepalabalai" {{ $user->role === 'kepalabalai' ? 'selected' : '' }}
                        {{ $user->role !== 'kepalabalai' && isset($hasKepalaBalai) && $hasKepalaBalai ? 'disabled' : '' }}>
                        Kepala Balai {{ $user->role !== 'kepalabalai' && isset($hasKepalaBalai) && $hasKepalaBalai ? '(Sudah Ada)' : '' }}
                    </option>
                </select>
            </div>

            <div class="space-y-1">
                <label for="no_hp" class="text-sm font-medium text-gray-700">No HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                    class="w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
            </div>

            <div class="space-y-1">
                <label for="jabatan" class="text-sm font-medium text-gray-700">Jabatan</label>
                <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan', $user->jabatan) }}"
                    class="w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
            </div>

            <div class="space-y-1">
                <label for="password" class="text-sm font-medium text-gray-700">Password (Kosongkan jika tidak ingin diubah)</label>
                <input type="password" id="password" name="password"
                    class="w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary">
            </div>

            <div class="flex space-x-3 pt-4">
                <a href="{{ route('admindatapengguna.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-100 focus:ring-offset-1 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:ring-offset-1 transition-colors">
                    Update
                </button>
            </div>
        </form>
        
        <!-- Role Warnings -->
        @if($user->role !== 'kepalabagian' && isset($hasKepalaBagian) && $hasKepalaBagian)
            <div class="px-6 pb-4">
                <div class="bg-yellow-50 text-yellow-800 text-sm p-3 rounded-lg border border-yellow-100">
                    <p class="font-medium">Perhatian!</p>
                    <p>User dengan role Kepala Bagian sudah ada. Tidak dapat mengubah role menjadi Kepala Bagian.</p>
                </div>
            </div>
        @endif

        @if($user->role !== 'kepalabalai' && isset($hasKepalaBalai) && $hasKepalaBalai)
            <div class="px-6 pb-4">
                <div class="bg-yellow-50 text-yellow-800 text-sm p-3 rounded-lg border border-yellow-100">
                    <p class="font-medium">Perhatian!</p>
                    <p>User dengan role Kepala Balai sudah ada. Tidak dapat mengubah role menjadi Kepala Balai.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection