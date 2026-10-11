@extends('dashboard.admin.base-admin')
@section('main')
<div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-6">Ajukan Cuti Pegawai</h2>
    <form action="{{ route('adminpengajuancutitahunan.store') }}" method="POST" class="space-y-4" id="cutiForm">
        @csrf
        <div>
            <label class="block text-gray-700">Pilih Pegawai:</label>
            <select name="user_id" required class="w-full p-2 border rounded-md" id="user_id">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} - {{ $user->nip }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-gray-700">Tanggal Pengajuan:</label>
            <input type="date" name="tgl_pengajuan" required class="w-full p-2 border rounded-md" id="tgl_pengajuan" value="{{ old('tgl_pengajuan') }}">
        </div>
        <div>
            <label class="block text-gray-700">Tanggal Mulai:</label>
            <input type="date" name="tgl_mulai" id="tanggalCutiMulai" required class="w-full p-2 border rounded-md" value="{{ old('tgl_mulai') }}">
        </div>
        <div>
            <label class="block text-gray-700">Tanggal Selesai:</label>
            <input type="date" name="tgl_selesai" id="tanggalCutiSelesai" required class="w-full p-2 border rounded-md" value="{{ old('tgl_selesai') }}">
        </div>
        <div>
            <label class="block text-gray-700">Lama Cuti (hari):</label>
            <input type="number" name="lama_cuti" id="lama_cuti" required readonly class="w-full p-2 border rounded-md bg-gray-100" value="{{ old('lama_cuti') }}">
        </div>
        <div>
            <label class="block text-gray-700">Alasan:</label>
            <textarea name="alasan" required class="w-full p-2 border rounded-md" id="alasan">{{ old('alasan') }}</textarea>
        </div>
        <div>
            <label class="block text-gray-700">Alamat Saat Cuti:</label>
            <input type="text" name="alamat_saat_cuti" required class="w-full p-2 border rounded-md" id="alamat_saat_cuti" value="{{ old('alamat_saat_cuti') }}">
        </div>
        <div>
            <label class="block text-gray-700">No HP Cuti:</label>
            <input type="text" name="no_hp_cuti" required class="w-full p-2 border rounded-md" id="no_hp_cuti" value="{{ old('no_hp_cuti') }}">
        </div>
        <div>
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-md">Ajukan Cuti</button>
        </div>
    </form>
</div>

<script>
    const form = document.getElementById('cutiForm');
    const fields = ['user_id', 'tgl_pengajuan', 'tanggalCutiMulai', 'tanggalCutiSelesai', 'lama_cuti', 'alasan', 'alamat_saat_cuti', 'no_hp_cuti'];

    window.addEventListener('load', () => {
        fields.forEach(field => {
            const savedValue = localStorage.getItem(field);
            if (savedValue) {
                const element = document.getElementById(field);
                if (element) {
                    element.value = savedValue;
                }
            }
        });
    });

    fields.forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.addEventListener('input', () => {
                localStorage.setItem(field, element.value);
            });
        }
    });

    form.addEventListener('submit', () => {
        fields.forEach(field => localStorage.removeItem(field));
    });

    document.getElementById('tanggalCutiMulai').addEventListener('change', calculateDays);
    document.getElementById('tanggalCutiSelesai').addEventListener('change', calculateDays);

    function calculateDays() {
        const startDate = document.getElementById('tanggalCutiMulai').value;
        const endDate = document.getElementById('tanggalCutiSelesai').value;

        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            let validDaysCount = 0;

            for (let currentDate = new Date(start); currentDate <= end; currentDate.setDate(currentDate.getDate() + 1)) {
                if (currentDate.getDay() !== 0 && currentDate.getDay() !== 6) {
                    validDaysCount++;
                }
            }
            document.getElementById('lama_cuti').value = validDaysCount;
            localStorage.setItem('lama_cuti', validDaysCount);
        }
    }
</script>
@endsection