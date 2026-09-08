@php
use Carbon\Carbon;
Carbon::setLocale('id');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Permintaan dan Pemberian Cuti Umum</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        @page {
            size: 210mm 330mm; /* Ukuran kertas F4 */
            margin: 5mm 5mm 2mm 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 8px;
            font-size: 12px;
        }

        h1, h2 {
            text-align: center;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 7px 0;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-size: 10px;
        }
        
        footer {
            font-family: 'Poppins', sans-serif;
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
            padding: 2px;
            background-color: #f8f8f8;
            color: #555;
        }
    </style>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</head>
<body>
    <img src="{{ public_path('image/kopsuratcuti2.png') }}" style="width: 100%; height: auto; object-fit: cover;">

    <!-- Tanggal dan tujuan surat -->
    <div style="text-align: right; margin-right: 75px; font-size: 12px; margin-top: 5px">
        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <div style="margin-left: 340; font-size: 12px; margin-top:5px ; width: 50%;">
        <div style="text-align: center; margin-right :100;">Kepada</div>
        <div>Yth, Kepala Balai Besar Pelatihan Pertanian</div>
        <div>Batangkaluku</div>
        <div style="text-indent: 30px;">Cq. Kabag Umum BBPP Batangkaluku</div>
        <div>Di</div>
        <div>Gowa</div>
    </div>  

    <h1 style="text-align: center; font-size: 12px; font-weight: bold; margin-top: 5px; margin-bottom: 2px;">
        FORMULIR PERMINTAAN DAN PEMBERIAN CUTI
    </h1>

    <p style="text-align: center; font-size: 12px; margin-top: 2px;">
        Nomor: <em>{{ str_pad($cuti->no_surat, 4, '0', STR_PAD_LEFT) }} /KP.580/I.18.1/ 
        @if($verifikasi && $verifikasi->tanggal_ttd_kabalai)
            {{ date('m/Y', strtotime($verifikasi->tanggal_ttd_kabalai)) }}
        @else
            {{ date('m/Y') }}
        @endif
        </em>
    </p>
    
    <!-- DATA PEGAWAI -->
    <table>
        <tr>
            <th colspan="4">I. DATA PEGAWAI</th>
        </tr>
        <tr>
            <th>Nama</th>
            <td><strong>{{ strtoupper($cuti->user->name) }}</strong></td>
            <th>NIP</th>
            <td>{{ $cuti->user->nip }}</td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td>{{ strtoupper($cuti->user->jabatan) }}</td>
            <th>Masa Kerja</th>
            <td>{{ $cuti->masa_kerja }}</td>            
        </tr>
        <tr>
            <th>Unit Kerja</th>
            <td colspan="3">BALAI BESAR PELATIHAN PERTANIAN BATANGKALUKU</td>
        </tr>
    </table>

    <!-- JENIS CUTI -->
    <table>
        <tr>
            <th colspan="4">II. JENIS CUTI YANG DIAMBIL**</th>
        </tr>
        <tr>
            <td>1. Cuti Tahunan</td>
            <td></td>
            <td>2. Cuti Besar</td>
            <td style="{{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Besar' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Besar' ? '✓' : '' }}
            </td>
        </tr>
        <tr>
            <td>3. Cuti Sakit</td>
            <td style="{{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Sakit' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Sakit' ? '✓' : '' }}
            </td>
            <td>4. Cuti Melahirkan</td>
            <td style="{{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Melahirkan' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Melahirkan' ? '✓' : '' }}
            </td>
        </tr>
        <tr>
            <td>5. Cuti Karena Alasan Penting</td>
            <td style="{{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Alasan Penting' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Alasan Penting' ? '✓' : '' }}
            </td>
            <td>6. Cuti di Luar Tanggungan Negara</td>
            <td style="{{ $cuti->jenis_cuti == 'Cuti di Luar Tanggungan Negara' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenis_cuti == 'Cuti di Luar Tanggungan Negara' ? '✓' : '' }}
            </td>
        </tr>
    </table>

    <!-- ALASAN CUTI -->
    <table>
        <tr>
            <th>III. ALASAN CUTI</th>
        </tr>
        <tr>
            <td style="padding-left: 10px; height: 5px; overflow: hidden;">{{ ucfirst($cuti->alasan) }}</td>
        </tr>
    </table>    

    <!-- LAMANYA CUTI --> 
    <table>
        <tr>
            <th colspan="6">IV. LAMANYA CUTI</th>
        </tr>
        <tr>
            <td>Selama</td>
            <td style="text-align: center;">
                {{ $cuti->jumlah_hari }} 
                {{ in_array($cuti->jenisCuti->nama_cuti, ['Cuti Besar', 'Cuti Melahirkan']) ? 'Bulan' : 'Hari' }}
            </td>            
            <td style="text-align: center;">Mulai tanggal</td>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->translatedFormat('d F') }}</td>
            <td style="text-align: center;">s/d</td>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($cuti->tgl_selesai)->translatedFormat('d F Y') }}</td>
        </tr>        
    </table>    

    <!-- CATATAN CUTI -->
    <table>
        <tr>
            <th colspan="6">V. CATATAN CUTI***</th>
        </tr>
        <tr>
            <th colspan="3">1. CUTI TAHUNAN</th>
            <th colspan="2">2. CUTI BESAR</th>
            <td style="{{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Besar' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
            {{ $cuti->jenisCuti && $cuti->jenisCuti->nama_cuti == 'Cuti Besar' ? '✓' : '' }}
        </td>
        </tr>
        <tr>
            <td>Tahun</td>
            <td>Sisa</td>
            <td>Keterangan</td>
            <td colspan="2">3. CUTI SAKIT</td>
            <td style="{{ $cuti->jenis_cuti == 'Cuti Sakit' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenis_cuti == 'Cuti Sakit' ? '✓' : '' }}
            </td> 
        </tr>
        <tr>
            <td>N-2</td>
            <td>{{ $kuota->kuota_n2 ?? '0' }}</td>
            <td>Hari</td>
            <td colspan="2">4. CUTI MELAHIRKAN</td>
            <td style="{{ $cuti->jenis_cuti == 'Cuti Melahirkan' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenis_cuti == 'Cuti Melahirkan' ? '✓' : '' }}
            </td>
        </tr>
        <tr>
            <td>N-1</td>
            <td>{{ $kuota->kuota_n1 ?? '0' }}</td>
            <td>Hari</td>
            <td colspan="2">5. CUTI KARENA ALASAN PENTING</td>
            <td style="{{ $cuti->jenis_cuti == 'Cuti Karena Alasan Penting' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenis_cuti == 'Cuti Karena Alasan Penting' ? '✓' : '' }}
            </td>
        </tr>
        <tr>
            <td>N</td>
            <td>{{ $kuota->kuota_n ?? '0' }}</td>
            <td>Hari</td>
            <td colspan="2">6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
            <td style="{{ $cuti->jenis_cuti == 'Cuti di Luar Tanggungan Negara' ? 'font-family: DejaVu Sans, sans-serif; text-align: center;' : '' }}">
                {{ $cuti->jenis_cuti == 'Cuti di Luar Tanggungan Negara' ? '✓' : '' }}
            </td>
        </tr>
    </table>

    <!-- ALAMAT SELAMA CUTI -->
    <table>
        <tr>
            <th colspan="2">VI. ALAMAT SELAMA MENJALANKAN CUTI</th>
        </tr>
        <tr>

            <td width="70%" rowspan="2" style="padding-left:15px; font-size: 12px; max-height: 60px; overflow: hidden;">
                {{ $cuti->alamat_saat_cuti ?? '-' }}<br>
            </td>            
            <td width="30%"><b>Telp.</b> &nbsp; {{ $cuti->no_hp_cuti ?? '-' }}</td>
        </tr>
        <tr>
            <td style="vertical-align: middle; text-align: center;">
                Hormat Saya,<br><br><br><br>
                <strong style="font-size: 10px; text-transform: uppercase;">
                    {{ $cuti->user->name ?? '-' }}
                </strong><br>                
                NIP. {{ $cuti->user->nip ?? '-' }}
            </td>            
        </tr>
    </table>
    
    <!-- PERTIMBANGAN ATASAN -->
    @if(!$cuti->is_kabag)
        <table>
            <tr>
                <th colspan="4">VII. PERTIMBANGAN ATASAN LANGSUNG**</th>
            </tr>
            <tr>
                <th width="23%">DISETUJUI</th>
                <th width="23%">PERUBAHAN****</th>
                <th width="23%">DITANGGUHKAN****</th>
                <th width="30%">TIDAK DISETUJUI****</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td rowspan="2" style="text-align: center; vertical-align: middle; height: 90px; position: relative;">
                    <!-- Gambar Tanda Tangan Ka. Bagian Umum -->
                    <div style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%); z-index: 10;">
                        @if(isset($ttdKabagPath) && $ttdKabagPath)
                            <img src="{{ public_path('storage/'.$ttdKabagPath) }}" alt="Tanda Tangan Kabag" width="190" height="70">
                        @endif
                    </div>
                    <!-- Teks Ka. Bagian Umum dan Nama -->
                    <div style="position: relative; z-index: 5;">
                        <div style="margin-top: -5px;">Kepala Bagian Umum</div>
                        <br><br><br>
                        <div style="margin-top: 5px;">
                        <strong>{{ strtoupper($kepalaUmum->name ?? 'ROSDIANA, S.Pi, M.M') }}</strong><br>
                            NIP. {{ $kepalaUmum->nip ?? '197001141999032001' }}
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" height="10"></td>
            </tr>
        </table>
    @endif

    <!-- KEPUTUSAN PEJABAT -->
    <table>
        <tr>
            <th colspan="4">VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI**</th>
        </tr>
        <tr>
            <th width="23%">DISETUJUI</th>
            <th width="23%">PERUBAHAN****</th>
            <th width="23%">DITANGGUHKAN****</th>
            <th width="30%">TIDAK DISETUJUI****</th>
        </tr>
        <tr>
            <td height="5"></td>
            <td></td>
            <td></td>
            <td rowspan="2" style="text-align: center; vertical-align: middle; height: 100px; position: relative;">
                <div style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                    <div style="width: 200px; height: 110px; display: flex; justify-content: center; align-items: center;">
                        @if(isset($ttdKabalaiPath) && $ttdKabalaiPath)
                            <img src="{{ public_path('storage/'.$ttdKabalaiPath) }}" alt="Tanda Tangan Kabalai" width="110" height="70" style="object-fit: contain;">
                        @else
                            <span style="font-size: 12px; color: #777;">Area Tanda Tangan Kepala Balai</span>
                        @endif
                    </div>
                </div>
                
                <!-- Teks Kepala Balai dan Nama -->
                <div style="position: relative; z-index: 5; padding-top: 0;">
                    <div style="margin-top: -5px;">Kepala Balai</div>
                    <br><br><br>
                    <div style="margin-top: 15px;">
                        <strong>{{ strtoupper($kepalaBalai->name ?? 'JAMALUDDIN AL AFGANI, S.Pd., MP') }}</strong><br>
                        NIP. {{ $kepalaBalai->nip ?? '197705012008011010' }}
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="10"></td>
        </tr>
    </table>
    
    <footer>
        Sibaco © 2025 — Sistem Informasi Cuti Online BBPP Batangkaluku
    </footer>
</body>
</html>