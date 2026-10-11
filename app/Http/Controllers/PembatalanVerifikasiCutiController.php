<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class PembatalanVerifikasiCutiController extends Controller
{
    /**
     * Membatalkan persetujuan milik verifikator terakhir yang berwenang.
     * Pengajuan tidak dihapus; status dikembalikan menjadi "belum disetujui".
     */
    public function batal(Request $request, string $jenis, int $id)
    {
        $role = strtolower(str_replace([' ', '_', '-'], '', (string) $request->user()->role));
        abort_unless(in_array($role, ['admin', 'kepalatimkerja', 'katimker', 'kepalabagian', 'kepalabalai'], true), 403);

        $config = $this->config($jenis);
        $stage = match ($role) {
            'admin' => 'admin',
            'kepalatimkerja', 'katimker' => 'katimker',
            'kepalabagian' => 'kabag',
            'kepalabalai' => 'kabalai',
        };

        $message = DB::transaction(function () use ($id, $config, $stage) {
            $root = DB::table($config['admin_table'])
                ->where($config['application_fk'], $id)
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if (!$root) {
                throw ValidationException::withMessages(['pengajuan' => 'Status verifikasi untuk pengajuan ini tidak ditemukan.']);
            }

            $chain = $this->chain($config, $root->id);
            $current = $chain[$stage] ?? null;

            if (!$current || strtolower((string) $current->status) !== 'disetujui') {
                throw ValidationException::withMessages(['verifikasi' => 'Hanya persetujuan yang sudah Anda berikan yang dapat dibatalkan.']);
            }

            $nextStage = match ($stage) {
                'admin' => 'katimker',
                'katimker' => 'kabag',
                'kabag' => 'kabalai',
                default => null,
            };

            // Untuk tiga tahap pertama, atasan berikutnya tidak boleh sudah menyetujui.
            if ($nextStage && isset($chain[$nextStage])) {
                $nextStatus = strtolower((string) $chain[$nextStage]->status);
                // Record "belum disetujui" berarti tahap berikutnya belum mengambil keputusan.
                // Disetujui, ditolak, ditangguhkan, atau perubahan semuanya berarti sudah diverifikasi.
                if ($nextStatus !== 'belum disetujui') {
                    throw ValidationException::withMessages(['verifikasi' => 'Verifikasi tidak dapat dibatalkan karena verifikator pada tahap berikutnya sudah memproses pengajuan ini.']);
                }
            }

            DB::table($current->table)
                ->where('id', $current->id)
                ->update([
                    'status' => 'belum disetujui',
                    'catatan' => null,
                    'updated_at' => now(),
                ]);

            // Tanda tangan digital harus mengikuti status persetujuan yang masih berlaku.
            if ($stage === 'kabag' || $stage === 'kabalai') {
                $ttdTable = $config['ttd_table'];
                if (Schema::hasTable($ttdTable)) {
                    $ttdUpdate = $stage === 'kabag'
                        ? ['ttd_kabag' => false, 'tanggal_ttd_kabag' => null]
                        : ['ttd_kabalai' => false, 'tanggal_ttd_kabalai' => null];
                    $ttdUpdate['updated_at'] = now();
                    DB::table($ttdTable)
                        ->where($config['ttd_application_fk'], $id)
                        ->update($ttdUpdate);
                }
            }

            return match ($stage) {
                'admin' => 'Verifikasi admin berhasil dibatalkan. Pengajuan kembali menunggu verifikasi admin.',
                'katimker' => 'Verifikasi Kepala Tim Kerja berhasil dibatalkan. Pengajuan menunggu verifikasi ulang pada tahap ini.',
                'kabag' => 'Verifikasi Kepala Bagian berhasil dibatalkan. Tanda tangan Kepala Bagian juga dinonaktifkan.',
                default => 'Verifikasi Kepala Balai berhasil dibatalkan. Tanda tangan Kepala Balai juga dinonaktifkan.',
            };
        });

        return back()->with('success', $message);
    }

    private function chain(array $c, int $rootId): array
    {
        $chain = [];
        $root = DB::table($c['admin_table'])->where('id', $rootId)->first();
        if (!$root) return $chain;
        $chain['admin'] = (object) array_merge((array) $root, ['table' => $c['admin_table']]);

        $katimker = DB::table($c['katimker_table'])
            ->where($c['katimker_root_fk'], $rootId)->orderByDesc('id')->first();
        if ($katimker) {
            $chain['katimker'] = (object) array_merge((array) $katimker, ['table' => $c['katimker_table']]);
            $kabag = DB::table($c['kabag_table'])
                ->where($c['kabag_katimker_fk'], $katimker->id)
                ->orderByDesc('id')->first();
            if ($kabag) {
                $chain['kabag'] = (object) array_merge((array) $kabag, ['table' => $c['kabag_table']]);
                $kabalai = DB::table($c['kabalai_table'])
                    ->where($c['kabalai_kabag_fk'], $kabag->id)
                    ->orderByDesc('id')->first();
                if ($kabalai) {
                    $chain['kabalai'] = (object) array_merge((array) $kabalai, ['table' => $c['kabalai_table']]);
                }
            }
        }
        return $chain;
    }

    private function config(string $jenis): array
    {
        abort_unless(in_array($jenis, ['tahunan', 'umum'], true), 404);

        if ($jenis === 'tahunan') {
            return [
                'application_fk' => 'id_pengajuan_cuti_tahunan',
                'admin_table' => 'ct_status_user_admins',
                'katimker_table' => 'ct_status_admin_katimkers',
                'katimker_root_fk' => 'id_ct_status_user_admin',
                'kabag_table' => 'ct_status_katimker_kabags',
                'kabag_katimker_fk' => 'id_ct_status_admin_katimker',
                'kabalai_table' => 'ct_status_kabag_kabals',
                'kabalai_kabag_fk' => 'id_ct_status_katimker_kabag',
                'ttd_table' => 'verifikasi_ttd_cuti_tahunans',
                'ttd_application_fk' => 'pengajuan_cuti_tahunan_id',
            ];
        }

        return [
            'application_fk' => 'id_pengajuan_cuti_umum',
            'admin_table' => 'cu_status_user_admins',
            'katimker_table' => 'cu_status_admin_katimkers',
            'katimker_root_fk' => 'cu_status_user_admin_id',
            'kabag_table' => 'cu_status_katimker_kabags',
            'kabag_katimker_fk' => 'cu_status_admin_katimker_id',
            'kabalai_table' => 'cu_status_kabag_kabals',
            'kabalai_kabag_fk' => 'cu_status_katimker_kabag_id',
            'ttd_table' => 'verifikasi_ttd_cuti_umums',
            'ttd_application_fk' => 'pengajuan_cuti_umum_id',
        ];
    }
}
