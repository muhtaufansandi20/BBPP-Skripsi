<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KuotaCutiTahunan;
use App\Models\LogEditKct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AdminDataKuotaCutiTahunan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $usersQuery = User::leftJoin('kuota_cuti_tahunan', 'users.id', '=', 'kuota_cuti_tahunan.user_id')
            ->whereNull('kuota_cuti_tahunan.user_id');
            
        if ($search) {
            $usersQuery->where(function($query) use ($search) {
                $query->where('users.name', 'like', '%'.$search.'%')
                      ->orWhere('users.nip', 'like', '%'.$search.'%');
            });
        }
            
        $users = $usersQuery->select('users.*')->get();

        $kuotacutitahunan = KuotaCutiTahunan::join('users', 'kuota_cuti_tahunan.user_id', '=', 'users.id')
            ->leftJoin('log_edit_kcts', function ($join) {
                $join->on('kuota_cuti_tahunan.id', '=', 'log_edit_kcts.id_kuota_cuti_tahunan')
                    ->whereRaw('log_edit_kcts.id = (SELECT MAX(id) FROM log_edit_kcts WHERE id_kuota_cuti_tahunan = kuota_cuti_tahunan.id)');
            })
            ->select(
                'users.nip',
                'users.name',
                'kuota_cuti_tahunan.*',
                'log_edit_kcts.date_edit',
                'log_edit_kcts.time_edit'
            )
            ->get();

        return view('dashboard.admin.kuotacutitahunan-admin', compact('users', 'kuotacutitahunan', 'search'));
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
            'user_id' => 'required|array', // Validasi memastikan kita menerima array
            'user_id.*' => 'exists:users,id'
        ]);

        $userIds = $request->input('user_id');
        $count = 0;

        foreach ($userIds as $id) {
            // Gunakan firstOrCreate untuk menghindari data terduplikat jika user diklik/dikirim berkali-kali
            $created = KuotaCutiTahunan::firstOrCreate([
                'user_id' => $id,
            ]);
            
            if ($created->wasRecentlyCreated) {
                $count++;
            }
        }

        return redirect()->back()->with('success', $count . ' User berhasil diverifikasi');
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
    public function edit($id) {
        $kuota = KuotaCutiTahunan::findOrFail($id);
        return response()->json($kuota);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        Log::info('Update request data for kuota_cuti_tahunan ID: ' . $id, $request->all());

        $request->validate([
            'kuota_n' => 'integer|min:0|max:12',
            'kuota_n1' => 'integer|min:0|max:3',
            'kuota_n2' => 'integer|min:0|max:3',
            'catatan' => 'nullable|string'
        ]);

        try {
            $kuota = KuotaCutiTahunan::findOrFail($id);
            
            // Create a new timestamp for the log entry
            $timestamp = now()->format('d-m-Y H:i:s');
            
            // Get new and old values for the log
            $oldValues = [
                'n' => $kuota->kuota_n,
                'n1' => $kuota->kuota_n1,
                'n2' => $kuota->kuota_n2
            ];
            
            $newValues = [
                'n' => $request->kuota_n,
                'n1' => $request->kuota_n1,
                'n2' => $request->kuota_n2
            ];
            
            // Prepare the new note entry
            $newNote = "";
            
            // Add user's note if provided
            if (!empty($request->catatan)) {
                $newNote .= $request->catatan . "\n\n";
            }
            
            // Add automatic change log if values changed
            if ($oldValues != $newValues) {
                $newNote .= "Perubahan kuota pada $timestamp:\n";
                
                if ($oldValues['n'] != $newValues['n']) {
                    $newNote .= "- Kuota N: {$oldValues['n']} → {$newValues['n']}\n";
                }
                
                if ($oldValues['n1'] != $newValues['n1']) {
                    $newNote .= "- Kuota N1: {$oldValues['n1']} → {$newValues['n1']}\n";
                }
                
                if ($oldValues['n2'] != $newValues['n2']) {
                    $newNote .= "- Kuota N2: {$oldValues['n2']} → {$newValues['n2']}\n";
                }
            } else if (empty($request->catatan)) {
                // If no values changed and no note provided, add default note
                $newNote = "Diedit pada $timestamp tanpa perubahan nilai";
            }
            
            // Combine with existing notes
            $existingCatatan = $kuota->catatan;
            $finalCatatan = $newNote;
            
            if (!empty($existingCatatan)) {
                $finalCatatan .= "\n\n---\n\n" . $existingCatatan;
            }
            
            // Update the record
            $kuota->update([
                'kuota_n' => $request->kuota_n,
                'kuota_n1' => $request->kuota_n1,
                'kuota_n2' => $request->kuota_n2,
                'catatan' => $finalCatatan
            ]);

            // Log the update
            LogEditKct::create([
                'id_kuota_cuti_tahunan' => $kuota->id,
                'date_edit' => now()->toDateString(),
                'time_edit' => now()->toTimeString(),
            ]);

            return redirect()->back()->with('success', 'Kuota cuti berhasil diperbarui');
        } catch (\Exception $e) {
            // Log the error for troubleshooting
            Log::error('Error updating kuota_cuti_tahunan: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui kuota: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kuotacutitahunan = KuotaCutiTahunan::findOrFail($id);
        $kuotacutitahunan->delete();
        return redirect()->back()->with('success', 'Pembatalan verifkasi berhasil');
    }

    public function bulkReset()
{
    try {
        $allKuota = KuotaCutiTahunan::all();

        foreach ($allKuota as $kuota) {
            $oldN = $kuota->kuota_n;

            // Maksimal carry-over 6
            $carryOver = min($oldN, 6);

            // Isi N1 maksimal 3
            $newN1 = min($carryOver, 3);

            // Sisa ke N2 maksimal 3
            $newN2 = min($carryOver - $newN1, 3);

            $timestamp = now()->format('d-m-Y H:i:s');

            $newNote = "Reset kuota tahunan pada $timestamp:\n";
            $newNote .= "- Kuota N direset menjadi 12\n";
            $newNote .= "- Sisa kuota tahun lalu: $oldN\n";
            $newNote .= "- Carry-over digunakan: $carryOver\n";
            $newNote .= "- N1 diisi: $newN1\n";
            $newNote .= "- N2 diisi: $newN2";

            $existingCatatan = $kuota->catatan;

            if (!empty($existingCatatan)) {
                $newNote .= "\n\n---\n\n" . $existingCatatan;
            }

            $kuota->update([
                'kuota_n' => 12,
                'kuota_n1' => $newN1,
                'kuota_n2' => $newN2,
                'catatan' => $newNote
            ]);

            LogEditKct::create([
                'id_kuota_cuti_tahunan' => $kuota->id,
                'date_edit' => now()->toDateString(),
                'time_edit' => now()->toTimeString(),
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Semua kuota cuti tahunan berhasil direset'
        );

    } catch (\Exception $e) {
        return redirect()->back()->with(
            'error',
            'Terjadi kesalahan: ' . $e->getMessage()
        );
    }
}

}