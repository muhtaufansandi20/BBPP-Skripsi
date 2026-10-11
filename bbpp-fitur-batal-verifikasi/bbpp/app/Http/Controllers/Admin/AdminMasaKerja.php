<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\MasaKerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminMasaKerja extends Controller
{
public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = User::query();
        
        if ($search) {
            $keywords = explode(' ', $search);
            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    // Gunakan LIKE alih-alih regexp agar lebih aman dan kompatibel
                    $q->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('nip', 'like', '%' . $keyword . '%');
                }
            });
        }
        
        // Gunakan paginate dan withQueryString()
        // withQueryString memastikan ?search=... tidak hilang saat klik page 2
        $users = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();
        
        $masakerja = MasaKerja::all();
        
        return view('dashboard.admin.masakerjapengguna', compact('users', 'masakerja', 'search'));
    }

    /**
     * Store masa kerja untuk user tertentu
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'jumlah_masa_kerja' => 'required',
        ], [
            'jumlah_masa_kerja.required' => 'Mohon hitung terlebih dahulu masa kerja',
            'user_id.required' => 'User ID tidak valid',
            'user_id.exists' => 'User tidak ditemukan'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        MasaKerja::create([
            'user_id' => $request->input('user_id'),
            'jumlah_masa_kerja' => $request->input('jumlah_masa_kerja'),
        ]);

        return redirect()->route('adminmasakerja.index')
            ->with('success', 'Masa kerja berhasil ditambahkan');
    }

    /**
     * Update masa kerja untuk user tertentu
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_masa_kerja' => 'required',
        ], [
            'jumlah_masa_kerja.required' => 'Mohon hitung terlebih dahulu masa kerja'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $masakerja = MasaKerja::findOrFail($id);
        $masakerja->update([
            'jumlah_masa_kerja' => $request->input('jumlah_masa_kerja'),
        ]);

        return redirect()->route('adminmasakerja.index')
            ->with('success', 'Masa kerja berhasil diperbarui');
    }

    /**
     * Delete masa kerja
     */
    public function destroy(string $id)
    {
        $masakerja = MasaKerja::findOrFail($id);
        $masakerja->delete();

        return redirect()->route('adminmasakerja.index')
            ->with('success', 'Data masa kerja berhasil dihapus');
    }
}