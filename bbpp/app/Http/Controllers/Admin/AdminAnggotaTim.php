<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AnggotaTim;
use App\Models\TimKerja;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAnggotaTim extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
    
        // Mengambil anggota tim dengan urutan role 'Ketua' di atas
        $anggotaTims = AnggotaTim::with(['tim', 'user'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('tim', function ($q) use ($search) {
                    $q->where('nama_tim', 'LIKE', "%{$search}%");
                });
            })
            ->orderByRaw("CASE WHEN role = 'Ketua' THEN 0 ELSE 1 END") 
            ->get();
    
        // Data untuk dropdown modal pop-up (Tim Kerja, Calon Ketua, dan Calon Anggota)
        $timKerjas = TimKerja::all(); 
        
        $calonKetua = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('anggota_tims');
        })
        ->where('role', 'kepalatimkerja')
        ->orderBy('name', 'asc')
        ->get();

        $calonAnggota = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('anggota_tims');
        })
        ->where('role', '!=', 'kepalatimkerja')
        ->orderBy('name', 'asc')
        ->get();
    
        // Kirim semua variabel ke view index
        return view('dashboard.admin.anggotatim-admin', compact(
            'anggotaTims', 
            'timKerjas', 
            'calonKetua', 
            'calonAnggota'
        ));
    }

    public function create()
    {
        $timKerjas = TimKerja::all(); 
        
        $calonKetua = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('anggota_tims');
        })
        ->where('role', 'kepalatimkerja')
        ->orderBy('name', 'asc')
        ->get();

        $calonAnggota = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('anggota_tims');
        })
        ->where('role', '!=', 'kepalatimkerja')
        ->orderBy('name', 'asc')
        ->get();

        return view('dashboard.admin.createanggotatim-admin', compact('calonKetua', 'calonAnggota', 'timKerjas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tim_id' => 'required|exists:tim_kerjas,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:Ketua,anggota',
        ]);
        
        $selectedUser = User::find($request->user_id);

        if ($selectedUser->role === 'kepalatimkerja' && $request->role === 'anggota') {
            return redirect()->back()->withErrors([
                'role' => 'Pengguna ini adalah Kepala Tim Kerja. Anda tidak bisa menjadikannya sebagai Anggota biasa.'
            ])->withInput();
        }

        if ($selectedUser->role !== 'kepalatimkerja' && $request->role === 'Ketua') {
            return redirect()->back()->withErrors([
                'role' => 'Pengguna ini bukan Kepala Tim Kerja. Anda tidak bisa menjadikannya sebagai Ketua Tim.'
            ])->withInput();
        }
        
        $existingMembership = AnggotaTim::where('user_id', $request->user_id)->first();
        if ($existingMembership) {
            return redirect()->back()->withErrors([
                'user_id' => 'Pengguna ini sudah terdaftar di tim lain'
            ])->withInput();
        }
    
        if ($request->role == 'Ketua') {
            $existingKetua = AnggotaTim::where('tim_id', $request->tim_id)
                ->where('role', 'Ketua')
                ->first();
    
            if ($existingKetua) {
                return redirect()->back()->withErrors([
                    'role' => 'Tim ini sudah memiliki ketua'
                ])->withInput();
            }
        }
    
        AnggotaTim::create([
            'tim_id' => $request->tim_id,
            'user_id' => $request->user_id,
            'role' => $request->role,
        ]);
    
        return redirect()->route('adminanggotatim.index')->with('success', 'Anggota tim berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $anggotaTim = AnggotaTim::findOrFail($id);
        $timKerjas = TimKerja::all();

        return view('dashboard.admin.editanggotatim-admin', compact('anggotaTim', 'timKerjas'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tim_id' => 'required|exists:tim_kerjas,id',
            'role' => 'required|in:Ketua,anggota',
        ]);

        $anggotaTim = AnggotaTim::findOrFail($id);
        
        if ($request->tim_id != $anggotaTim->tim_id) {
            if ($request->role == 'Ketua') {
                $existingKetua = AnggotaTim::where('tim_id', $request->tim_id)
                    ->where('role', 'Ketua')
                    ->first();

                if ($existingKetua) {
                    return redirect()->back()->withErrors([
                        'role' => 'Tim baru sudah memiliki ketua'
                    ])->withInput();
                }
            }
        } else {
            if ($request->role == 'Ketua' && $anggotaTim->role != 'Ketua') {
                $existingKetua = AnggotaTim::where('tim_id', $request->tim_id)
                    ->where('role', 'Ketua')
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingKetua) {
                    return redirect()->back()->withErrors([
                        'role' => 'Tim ini sudah memiliki ketua'
                    ])->withInput();
                }
            }
        }

        $anggotaTim->update([
            'tim_id' => $request->tim_id,
            'role' => $request->role,
        ]);

        return redirect()->route('adminanggotatim.index')->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $anggotaTim = AnggotaTim::findOrFail($id);
        $anggotaTim->delete();

        return redirect()->route('adminanggotatim.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}