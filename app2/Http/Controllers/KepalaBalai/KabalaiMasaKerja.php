<?php

namespace App\Http\Controllers\KepalaBalai;

use App\Models\MasaKerja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KabalaiMasaKerja extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            ->with('success', 'Masa Kerja berhasil diperbaharui');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
            ->with('success', 'Masa Kerja berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
