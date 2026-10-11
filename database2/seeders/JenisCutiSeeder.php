<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisCuti;

class JenisCutiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jeniscuti=[
            [
            'nama_cuti' => 'Cuti Besar'
            ],
            [
            'nama_cuti' => 'Cuti Melahirkan'
            ],
            [
            'nama_cuti' => 'Cuti Sakit',
            ],
            [
            'nama_cuti' => 'Cuti Alasan Penting',
            ]
            ];
            foreach($jeniscuti as $item) {
                JenisCuti::create($item);
                } 
    }
}
