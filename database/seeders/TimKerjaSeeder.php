<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimKerja;

class TimKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timKerja = [
            ['nama_tim' => 'KEPEGAWAIAN DAN TATA USAHA'],
            ['nama_tim' => 'BMN DAN RUMAH TANGGA'],
            ['nama_tim' => 'KEUANGAN'],
            ['nama_tim' => 'PENYELENGGARAAN PELATIHAN'],
            ['nama_tim' => 'PELATIHAN APARATUR & NON APARATUR'],
            ['nama_tim' => 'SERTIFIKASI PROFESI LAYANAN KONSULTASI DAN PENGELOLAAN IA'],
            ['nama_tim' => 'PROGRAM DAN EVALUASI'],
            ['nama_tim' => 'PROGRAM DAN KERJASAMA'],
            ['nama_tim' => 'EVALUASI DAN PELAPORAN'],
        ];
        

        foreach ($timKerja as $item) {
            TimKerja::create($item);
        }
    }
}
