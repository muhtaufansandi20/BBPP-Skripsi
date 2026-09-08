/ resources/views/users/manageusers-admin.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kelola Pengguna</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah Pengguna</a>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->nip }}</td>
                <td>{{ $user->nama }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus pengguna ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
