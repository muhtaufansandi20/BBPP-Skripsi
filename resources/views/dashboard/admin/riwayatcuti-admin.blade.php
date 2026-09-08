@extends('dashboard.admin.base-admin')
@section('main')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  :root {
    --green-1: #27ae60;
    --green-2: #38b26a;
    --green-3: #2ecc71;
    --gray-50:  #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-900: #111827;
  }

  .rc-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--gray-900);
  }

  /* ── Top card ── */
  .rc-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.08);
    overflow: hidden;
  }

  /* ── Header ── */
  .rc-card-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 18px 24px 16px;
    border-bottom: 1px solid var(--gray-100);
  }

  .rc-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-900);
    letter-spacing: -0.3px;
  }

  .rc-controls {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
  }

  .rc-select, .rc-input {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--gray-700);
    background: #fff;
    border: 1.5px solid var(--gray-200);
    border-radius: 9px;
    padding: 8px 12px;
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
    min-width: 160px;
  }

  .rc-select:focus, .rc-input:focus {
    border-color: var(--green-2);
    box-shadow: 0 0 0 3px rgba(56,178,106,0.12);
  }

  .rc-btn-export {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 18px;
    background: linear-gradient(135deg, var(--green-2), var(--green-1));
    color: #fff;
    border: none;
    border-radius: 9px;
    font-size: 13.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(39,174,96,0.28);
    transition: all 0.18s;
  }

  .rc-btn-export:hover {
    box-shadow: 0 5px 14px rgba(39,174,96,0.38);
    transform: translateY(-1px);
  }

  .rc-btn-export svg {
    width: 15px; height: 15px;
    stroke: #fff; fill: none;
    stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;
    flex-shrink: 0;
  }

  /* ── Table container ── */
  .rc-table-wrap {
    overflow-x: auto;
    padding: 0;
  }

  /* ── Table ── */
  .rc-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 860px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .rc-table thead tr {
    background: linear-gradient(135deg, var(--green-2) 0%, var(--green-1) 60%, var(--green-3) 100%);
  }

  .rc-table thead th {
    padding: 13px 16px;
    font-size: 12px;
    font-weight: 700;
    color: #fff;
    text-align: left;
    letter-spacing: 0.3px;
    white-space: nowrap;
  }

  .rc-table thead th.center { text-align: center; }

  .rc-table tbody tr {
    border-bottom: 1px solid var(--gray-100);
    transition: background 0.13s;
  }

  .rc-table tbody tr:last-child { border-bottom: none; }
  .rc-table tbody tr:hover { background: var(--gray-50); }

  .rc-table td {
    padding: 13px 16px;
    font-size: 13.5px;
    color: var(--gray-700);
    vertical-align: middle;
  }

  .rc-table td.center { text-align: center; }

  /* ── Pegawai cell ── */
  .rc-pegawai-name {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1.3;
  }

  .rc-pegawai-sub {
    font-size: 11.5px;
    color: var(--gray-500);
    margin-top: 1px;
    line-height: 1.4;
  }

  /* ── Period cell ── */
  .rc-period {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: var(--gray-700);
    white-space: nowrap;
  }

  .rc-period svg, .rc-addr svg, .rc-phone svg {
    width: 13px; height: 13px;
    stroke: var(--gray-400); fill: none;
    stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;
    flex-shrink: 0;
  }

  .rc-addr {
    display: flex;
    align-items: flex-start;
    gap: 5px;
    font-size: 13px;
    color: var(--gray-700);
  }

  .rc-addr svg { margin-top: 2px; }

  .rc-phone {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: var(--gray-700);
    white-space: nowrap;
  }

  /* ── Jenis Cuti badges — pill style like reference image ── */
  .rc-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px 5px 8px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    white-space: nowrap;
    border: 1.5px solid transparent;
  }

  .rc-badge-icon {
    width: 14px; height: 14px;
    fill: none;
    stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;
    flex-shrink: 0;
  }

  /* Tahunan — biru terang */
  .rc-badge-tahunan {
    background: #eff6ff;
    color: #2563eb;
    border-color: #bfdbfe;
  }
  .rc-badge-tahunan .rc-badge-icon { stroke: #2563eb; }

  /* Cuti Alasan Penting — ungu/indigo */
  .rc-badge-penting {
    background: #eef2ff;
    color: #4338ca;
    border-color: #c7d2fe;
  }
  .rc-badge-penting .rc-badge-icon { stroke: #4338ca; }

  /* Cuti Besar — hijau */
  .rc-badge-besar {
    background: #f0fdf4;
    color: #16a34a;
    border-color: #bbf7d0;
  }
  .rc-badge-besar .rc-badge-icon { stroke: #16a34a; }

  /* Cuti Sakit — kuning */
  .rc-badge-sakit {
    background: #fefce8;
    color: #ca8a04;
    border-color: #fde68a;
  }
  .rc-badge-sakit .rc-badge-icon { stroke: #ca8a04; }

  /* Cuti Melahirkan — merah muda */
  .rc-badge-melahirkan {
    background: #fff1f2;
    color: #e11d48;
    border-color: #fecdd3;
  }
  .rc-badge-melahirkan .rc-badge-icon { stroke: #e11d48; }

  /* Lainnya — abu */
  .rc-badge-other {
    background: var(--gray-100);
    color: var(--gray-600);
    border-color: var(--gray-200);
  }
  .rc-badge-other .rc-badge-icon { stroke: var(--gray-500); }

  /* ── Lama badge ── */
  .rc-lama {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 700;
    background: #fefce8;
    color: #a16207;
    border: 1px solid #fde68a;
    white-space: nowrap;
  }

  /* ── Status badge ── */
  .rc-status-approved {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
    background: #f0fdf4;
    color: #16a34a;
    border: 1.5px solid #bbf7d0;
    white-space: nowrap;
  }

  .rc-status-approved::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #22c55e;
    flex-shrink: 0;
  }

  /* ── Footer ── */
  .rc-footer {
    padding: 12px 24px;
    border-top: 1px solid var(--gray-100);
    font-size: 13px;
    color: var(--gray-500);
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* ── No data row ── */
  .rc-empty {
    text-align: center;
    padding: 48px 24px;
    color: var(--gray-400);
    font-size: 14px;
  }

  /* ── Spinner for export ── */
  @keyframes rcSpin { to { transform: rotate(360deg); } }
  .rc-spin { animation: rcSpin 0.7s linear infinite; }
</style>

<div class="rc-wrap">
  <div class="rc-card">

    {{-- ── Header ── --}}
    <div class="rc-card-header">
      <h3 class="rc-title">Riwayat Cuti Terakhir</h3>
      <div class="rc-controls">
        <select id="filterJenisCuti" class="rc-select">
          <option value="">Semua Jenis Cuti</option>
          <option value="Tahunan">Tahunan</option>
          @foreach ($jenisCuti as $jenis)
            <option value="{{ $jenis->nama_cuti }}">{{ $jenis->nama_cuti }}</option>
          @endforeach
        </select>
        <input type="text" id="filterNama" class="rc-input" placeholder="🔍  Cari nama pegawai…">
        <button onclick="exportToExcel()" class="rc-btn-export" id="exportBtn">
          <svg viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          Export Excel
        </button>
      </div>
    </div>

    {{-- ── Table ── --}}
    <div class="rc-table-wrap">
      <table id="cutiTable" class="rc-table">
        <thead>
          <tr>
            <th class="center" style="width:48px">#</th>
            <th style="min-width:150px">Tanggal Pengajuan</th>
            <th style="min-width:180px">Pegawai</th>
            <th style="min-width:160px">Jenis Cuti</th>
            <th style="min-width:160px">Periode</th>
            <th class="center" style="min-width:90px">Lama</th>
            <th style="min-width:170px">Alamat Saat Cuti</th>
            <th style="min-width:140px">No. Telp Saat Cuti</th>
            <th class="center" style="min-width:110px">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($riwayatCuti as $cuti)
            @php
              $isTahunan = $cuti instanceof \App\Models\PengajuanCutiTahunan;
              $namaJenis = $isTahunan ? 'Tahunan' : ($cuti->jeniscuti->nama_cuti ?? '-');
              $tglMulai  = \Carbon\Carbon::parse($cuti->tgl_mulai);
              $tglSelesai = \Carbon\Carbon::parse($cuti->tgl_selesai);
              $lamaCuti  = $cuti->jumlah_hari ?? '0';
              $satuan    = 'Hari';
              if (!$isTahunan && in_array($namaJenis, ['Cuti Besar', 'Cuti Melahirkan']) && $cuti->jumlah_hari <= 3) {
                  $satuan = 'Bulan';
              }

              // Badge class mapping
              $badgeClass = match(true) {
                  $isTahunan                          => 'rc-badge-tahunan',
                  str_contains($namaJenis, 'Alasan')  => 'rc-badge-penting',
                  str_contains($namaJenis, 'Besar')   => 'rc-badge-besar',
                  str_contains($namaJenis, 'Sakit')   => 'rc-badge-sakit',
                  str_contains($namaJenis, 'Melahirkan') => 'rc-badge-melahirkan',
                  default                             => 'rc-badge-other',
              };
            @endphp
            <tr
              data-jenis-cuti="{{ $namaJenis }}"
              data-nama="{{ strtolower($cuti->user->name) }}">

              <td class="center" style="font-weight:600;color:#9ca3af;">{{ $loop->iteration }}</td>

              <td>{{ $cuti->created_at->translatedFormat('d F Y') }}</td>

              <td>
                <div class="rc-pegawai-name">{{ $cuti->user->name }}</div>
                <div class="rc-pegawai-sub">{{ $cuti->user->nip }}</div>
                <div class="rc-pegawai-sub">{{ $cuti->user->jabatan }}</div>
              </td>

              <td>
                <span class="rc-badge {{ $badgeClass }}">
                  <svg class="rc-badge-icon" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                  </svg>
                  {{ $namaJenis }}
                </span>
              </td>

              <td>
                <div class="rc-period">
                  <svg viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                  </svg>
                  {{ $tglMulai->format('d/m/Y') }} — {{ $tglSelesai->format('d/m/Y') }}
                </div>
              </td>

              <td class="center">
                <span class="rc-lama">{{ $lamaCuti }} {{ $satuan }}</span>
              </td>

              <td>
                <div class="rc-addr">
                  <svg viewBox="0 0 24 24">
                    <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  {{ $cuti->alamat_saat_cuti ?? '-' }}
                </div>
              </td>

              <td>
                <div class="rc-phone">
                  <svg viewBox="0 0 24 24">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.69 13.1 19.79 19.79 0 011.61 4.5 2 2 0 013.6 2.32h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.91 9.91a16 16 0 006.08 6.08l.98-.98a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                  </svg>
                  {{ $cuti->no_hp_cuti ?? '-' }}
                </div>
              </td>

              <td class="center">
                <span class="rc-status-approved">Disetujui</span>
              </td>

            </tr>
          @empty
            <tr>
              <td colspan="9" class="rc-empty">
                Belum ada riwayat cuti.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- ── Footer ── --}}
    <div class="rc-footer">
      <span id="footerCount">Total data: {{ count($riwayatCuti) }} riwayat cuti</span>
    </div>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const filterNama      = document.getElementById('filterNama');
  const filterJenisCuti = document.getElementById('filterJenisCuti');
  const tableRows       = document.querySelectorAll('#cutiTable tbody tr[data-nama]');
  const footerCount     = document.getElementById('footerCount');
  const total           = {{ count($riwayatCuti) }};

  function filterTable() {
    const search  = filterNama.value.toLowerCase().trim();
    const jenis   = filterJenisCuti.value;
    let visible   = 0;

    tableRows.forEach(row => {
      const namaMatch  = row.dataset.nama.includes(search);
      const jenisMatch = !jenis || row.dataset.jenisCuti === jenis;
      const show       = namaMatch && jenisMatch;

      row.style.display = show ? '' : 'none';
      if (show) {
        visible++;
        row.cells[0].textContent = visible;
      }
    });

    footerCount.textContent = search || jenis
      ? `Data ditampilkan: ${visible} dari ${total} riwayat cuti`
      : `Total data: ${total} riwayat cuti`;
  }

  filterNama.addEventListener('input', filterTable);
  filterJenisCuti.addEventListener('change', filterTable);
});

function exportToExcel() {
  const btn = document.getElementById('exportBtn');
  const orig = btn.innerHTML;

  btn.innerHTML = `
    <svg class="rc-spin" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 12a9 9 0 11-6.219-8.56"/>
    </svg>
    Mengekspor…
  `;
  btn.disabled = true;

  const excelData = [
    ['No','Tanggal Pengajuan','Nama Pegawai','NIP','Jabatan','Jenis Cuti',
     'Tanggal Mulai','Tanggal Selesai','Lama Cuti','Alamat Saat Cuti','No. Telp Saat Cuti','Status']
  ];

  @foreach ($riwayatCuti as $index => $cuti)
    @php
      $isTahunan = $cuti instanceof \App\Models\PengajuanCutiTahunan;
      $namaJenis = $isTahunan ? 'Tahunan' : ($cuti->jeniscuti->nama_cuti ?? '-');
      $lama = $cuti->jumlah_hari ?? '0';
      $satuan = 'Hari';
      if (!$isTahunan && in_array($namaJenis, ['Cuti Besar','Cuti Melahirkan']) && $cuti->jumlah_hari <= 3) {
          $satuan = 'Bulan';
      }
    @endphp
    excelData.push([
      {{ $index + 1 }},
      "{{ \Carbon\Carbon::parse($cuti->created_at)->locale('id')->translatedFormat('l, d F Y') }}",
      "{{ addslashes($cuti->user->name) }}",
      "{{ $cuti->user->nip }}",
      "{{ addslashes($cuti->user->jabatan) }}",
      "{{ $namaJenis }}",
      "{{ \Carbon\Carbon::parse($cuti->tgl_mulai)->format('d/m/Y') }}",
      "{{ \Carbon\Carbon::parse($cuti->tgl_selesai)->format('d/m/Y') }}",
      "{{ $lama }} {{ $satuan }}",
      "{{ addslashes($cuti->alamat_saat_cuti ?? '-') }}",
      "{{ $cuti->no_hp_cuti ?? '-' }}",
      "Disetujui"
    ]);
  @endforeach

  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet(excelData);

  ws['!cols'] = [
    {wch:5},{wch:26},{wch:26},{wch:20},{wch:26},
    {wch:18},{wch:15},{wch:15},{wch:14},{wch:30},{wch:20},{wch:14}
  ];

  XLSX.utils.book_append_sheet(wb, ws, 'Riwayat Cuti');
  XLSX.writeFile(wb, `Riwayat_Cuti_${new Date().toISOString().slice(0,10)}.xlsx`);

  setTimeout(() => {
    btn.innerHTML = orig;
    btn.disabled = false;
  }, 1000);
}
</script>

@endsection