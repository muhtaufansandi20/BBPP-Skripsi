<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\JenisCuti;
use Illuminate\Http\Request;

class AdminDataJenisCuti extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jeniscutis = JenisCuti::all();
        return view ('dashboard.admin.datajeniscuti-admin', compact('jeniscutis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('dashboard.admin.createjeniscuti-admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_cuti' => 'required|string|max:255'
        ]);
    
        JenisCuti::create([
            'nama_cuti' => $request->nama_cuti,
        ]);

        return redirect()->route('admindatajeniscuti.index')->with('success', 'Jenis Cuti Baru Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
