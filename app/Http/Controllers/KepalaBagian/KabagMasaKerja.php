<?php

namespace App\Http\Controllers\KepalaBagian;

use App\Http\Controllers\Controller;
use App\Models\MasaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KabagMasaKerja extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;
        
        // Get the user's masa kerja data if it exists
        $masakerja = MasaKerja::where('user_id', $userId)->first();
        
        // Return the view with both the existing data and form in one view
        return view('dashboard.kepalabagian.masakerja-kabag', compact('masakerja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_masa_kerja' => 'required',
        ], [
            'jumlah_masa_kerja.required' => 'Mohon Hitung terlebih dahulu Masa Kerja Anda'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create new record
        MasaKerja::create([
            'user_id' => $request->input('user_id'),
            'jumlah_masa_kerja' => $request->input('jumlah_masa_kerja'),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Masa Kerja berhasil disimpan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_masa_kerja' => 'required',
        ], [
            'jumlah_masa_kerja.required' => 'Mohon Hitung terlebih dahulu Masa Kerja Anda'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Find the record by ID and update it
        $masakerja = MasaKerja::findOrFail($id);
        $masakerja->update([
            'jumlah_masa_kerja' => $request->input('jumlah_masa_kerja'),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Masa Kerja berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $masakerja = MasaKerja::findOrFail($id);
        $masakerja->delete();

        return redirect()->route('kabagmasakerja.index')
            ->with('success', 'Data Masa Kerja berhasil dihapus');
    }
}