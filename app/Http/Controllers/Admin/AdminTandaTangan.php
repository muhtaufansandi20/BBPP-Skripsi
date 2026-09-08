<?php

namespace App\Http\Controllers\Admin;

use App\Models\TandaTangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminTandaTangan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.admin.uploadsignature-admin'); 
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
    $request->validate([
        'role' => 'required|in:kepalabagian,kepalabalai',
        'gambar_ttd' => 'required|image|mimes:png|max:2048',
    ]);
    
    $role = $request->role;
    $tandaTangan = TandaTangan::firstOrNew(['role' => $role]);
    
    if ($request->hasFile('gambar_ttd')) {
        // Delete old file if exists
        if ($tandaTangan->gambar_ttd_path && Storage::disk('public')->exists($tandaTangan->gambar_ttd_path)) {
            Storage::disk('public')->delete($tandaTangan->gambar_ttd_path);
        }
        
        // Generate a custom filename based on role
        $filename = 'ttd_' . $role . '_image_' . time() . '.png';
        
        // Store the file with custom name
        $path = $request->file('gambar_ttd')->storeAs('tanda_tangan', $filename, 'public');
        
        $tandaTangan->gambar_ttd_path = $path;
        $tandaTangan->nama_file = $request->file('gambar_ttd')->getClientOriginalName();
        $tandaTangan->tanggal_upload = now();
        $tandaTangan->save();
    }
    
    return redirect()->route('adminkelolatandatangan.index')
        ->with('success', 'Tanda tangan berhasil disimpan');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
