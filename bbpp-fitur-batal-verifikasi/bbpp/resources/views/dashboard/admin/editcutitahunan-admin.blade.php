@extends('dashboard.admin.base-admin')

@section('main')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --green-1: #27ae60;
    --green-2: #38b26a;
    --green-3: #2ecc71;
    --green-light: #f0fdf4;
    --green-border: #bbf7d0;
    --red: #ef4444;
    --red-light: #fef2f2;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-900: #111827;
    --blue: #3b82f6;
    --blue-light: #eff6ff;
  }

  .pdc-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    max-width: 780px;
    margin: 0 auto;
    padding: 24px 16px 48px;
    color: var(--gray-900);
  }

  /* ── Page Header ── */
  .pdc-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .pdc-header h1 {
    font-size: 20px;
    font-weight: 700;
    color: var(--gray-900);
    letter-spacing: -0.3px;
  }

  .pdc-btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 16px;
    background: #fff;
    border: 1.5px solid var(--gray-200);
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--gray-600);
    cursor: pointer;
    text-decoration: none;
    transition: all 0.18s;
    font-family: inherit;
  }

  .pdc-btn-back:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-700);
  }

  /* ── Alert ── */
  .pdc-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13.5px;
    font-weight: 500;
    margin-bottom: 16px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .pdc-alert-success { background: var(--green-light); color: #15803d; border: 1px solid var(--green-border); }
  .pdc-alert-error   { background: var(--red-light);   color: #b91c1c; border: 1px solid #fecaca; }

  /* ── Card ── */
  .pdc-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    margin-bottom: 16px;
    overflow: hidden;
  }

  .pdc-card-header {
    background: linear-gradient(135deg, var(--green-2) 0%, var(--green-1) 55%, var(--green-3) 100%);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .pdc-card-header .pdc-hicon {
    width: 32px;
    height: 32px;
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .pdc-card-header .pdc-hicon svg {
    width: 16px;
    height: 16px;
    stroke: #fff;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2.2;
  }

  .pdc-card-header h2 {
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.2px;
    text-transform: uppercase;
  }

  .pdc-card-body {
    padding: 20px 24px 24px;
  }

  /* ── Info Grid (read-only display) ── */
  .pdc-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0;
  }

  .pdc-info-item {
    padding: 14px 0;
    border-bottom: 1px dashed var(--gray-200);
    padding-right: 16px;
  }

  .pdc-info-item:last-child,
  .pdc-info-item.no-border { border-bottom: none; }

  .pdc-info-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 5px;
  }

  .pdc-info-label svg {
    width: 12px;
    height: 12px;
    stroke: var(--gray-500);
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2.2;
    flex-shrink: 0;
  }

  .pdc-info-value {
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-900);
    line-height: 1.4;
  }

  .pdc-info-value.muted {
    color: var(--gray-600);
    font-weight: 500;
  }

  .pdc-date-range {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-900);
    flex-wrap: wrap;
  }

  .pdc-date-range .arr { color: var(--gray-400); font-size: 13px; }

  .pdc-durasi-wrap {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .pdc-lama-badge {
    background: var(--green-light);
    color: var(--green-1);
    border: 1px solid var(--green-border);
    border-radius: 6px;
    padding: 2px 9px;
    font-size: 12px;
    font-weight: 700;
  }

  /* ── Form Field Grid (editable) ── */
  .pdc-field-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }

  .pdc-field-grid .pdc-span2 { grid-column: 1 / -1; }

  .pdc-field-group label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 700;
    color: var(--gray-600);
    margin-bottom: 6px;
    letter-spacing: 0.1px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .pdc-field-group label svg {
    width: 13px;
    height: 13px;
    stroke: var(--gray-400);
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2.2;
    flex-shrink: 0;
  }

  .pdc-input {
    width: 100%;
    padding: 9px 12px;
    background: #fff;
    border: 1.5px solid var(--gray-200);
    border-radius: 9px;
    font-size: 13.5px;
    font-weight: 500;
    color: var(--gray-900);
    font-family: 'Plus Jakarta Sans', sans-serif;
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s;
  }

  .pdc-input:focus {
    border-color: var(--green-2);
    box-shadow: 0 0 0 3px rgba(56,178,106,0.13);
  }

  .pdc-input.pdc-error {
    border-color: var(--red);
    box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
  }

  textarea.pdc-input {
    resize: none;
    line-height: 1.55;
  }

  .pdc-field-hint {
    font-size: 11.5px;
    color: var(--gray-500);
    margin-top: 4px;
  }

  .pdc-field-error {
    font-size: 11.5px;
    color: var(--red);
    margin-top: 4px;
    display: none;
  }

  .pdc-field-error.show { display: block; }

  .pdc-field-error-blade {
    font-size: 11.5px;
    color: var(--red);
    margin-top: 4px;
  }

  /* ── Lama Cuti row ── */
  .pdc-lama-row {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .pdc-hari-badge {
    background: var(--green-light);
    color: var(--green-1);
    border: 1px solid var(--green-border);
    border-radius: 7px;
    padding: 9px 12px;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
    white-space: nowrap;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* ── Loading spinner ── */
  .pdc-loading {
    display: none;
    align-items: center;
    gap: 6px;
  }

  .pdc-loading.show { display: flex; }

  .pdc-spinner {
    width: 14px;
    height: 14px;
    border: 2px solid var(--green-2);
    border-top-color: transparent;
    border-radius: 50%;
    animation: pdcSpin 0.7s linear infinite;
    flex-shrink: 0;
  }

  @keyframes pdcSpin { to { transform: rotate(360deg); } }

  .pdc-loading span {
    font-size: 12px;
    color: var(--gray-500);
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  /* ── Calendar popup ── */
  .pdc-cal-wrap { position: relative; }

  .pdc-calendar {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    z-index: 9999;
    background: #fff;
    border: 1.5px solid var(--gray-200);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    width: 260px;
    display: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .pdc-calendar.open { display: block; }
  .pdc-calendar.right { left: auto; right: 0; }

  .pdc-cal-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 12px;
    border-bottom: 1px solid var(--gray-100);
  }

  .pdc-cal-nav span {
    font-size: 13px;
    font-weight: 700;
    color: var(--gray-900);
  }

  .pdc-cal-btn {
    width: 26px;
    height: 26px;
    border: 1px solid var(--gray-200);
    border-radius: 7px;
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--gray-600);
    transition: all 0.15s;
    font-family: inherit;
    line-height: 1;
  }

  .pdc-cal-btn:hover { background: var(--gray-50); border-color: var(--gray-300); }

  .pdc-cal-grid-wrap { padding: 10px 10px 6px; }

  .pdc-cal-dow {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
    margin-bottom: 4px;
  }

  .pdc-cal-dow div {
    text-align: center;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--gray-500);
    padding: 3px 0;
  }

  .pdc-cal-dow div:first-child,
  .pdc-cal-dow div:last-child { color: var(--red); }

  .pdc-cal-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 2px;
  }

  .pdc-cal-day {
    text-align: center;
    font-size: 12px;
    padding: 5px 2px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.13s;
    color: var(--gray-700);
    font-weight: 500;
  }

  .pdc-cal-day:hover { background: var(--gray-100); }
  .pdc-cal-day.weekend { color: var(--red); }
  .pdc-cal-day.holiday { color: var(--red); font-weight: 700; }
  .pdc-cal-day.today { box-shadow: inset 0 0 0 1.5px var(--blue); color: var(--blue); }
  .pdc-cal-day.in-range { background: var(--blue-light); }
  .pdc-cal-day.selected { background: var(--green-2) !important; color: #fff !important; font-weight: 700; }

  .pdc-cal-legend {
    padding: 6px 12px 10px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: var(--gray-500);
    border-top: 1px solid var(--gray-100);
    margin-top: 4px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .pdc-cal-legend .dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--red);
    flex-shrink: 0;
  }

  /* ── Sisa Cuti card ── */
  .pdc-sisa-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    margin-bottom: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .pdc-sisa-icon {
    width: 54px;
    height: 54px;
    background: linear-gradient(135deg, #f87171, #ef4444);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(239,68,68,0.25);
  }

  .pdc-sisa-icon svg {
    width: 28px;
    height: 28px;
    stroke: #fff;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2;
  }

  .pdc-sisa-text { flex: 1; }

  .pdc-sisa-text h3 {
    font-size: 15px;
    font-weight: 700;
    color: var(--gray-900);
  }

  .pdc-sisa-text p {
    font-size: 12.5px;
    color: var(--gray-500);
    margin-top: 1px;
  }

  .pdc-sisa-numbers {
    display: flex;
    gap: 20px;
    align-items: center;
  }

  .pdc-sisa-num { text-align: center; }

  .pdc-sisa-num .num {
    font-size: 28px;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1;
  }

  .pdc-sisa-num .lbl {
    font-size: 11.5px;
    color: var(--gray-500);
    font-weight: 600;
    margin-top: 3px;
  }

  .pdc-sisa-divider {
    width: 1px;
    height: 40px;
    background: var(--gray-200);
    flex-shrink: 0;
  }

  /* ── Footer ── */
  .pdc-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-top: 4px;
  }

  .pdc-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    border: none;
    transition: all 0.18s;
    letter-spacing: 0.1px;
    text-decoration: none;
  }

  .pdc-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2.5;
    flex-shrink: 0;
  }

  .pdc-btn-cancel {
    background: #fff;
    color: var(--gray-600);
    border: 1.5px solid var(--gray-200);
  }

  .pdc-btn-cancel:hover {
    background: var(--gray-50);
    border-color: var(--gray-300);
    color: var(--gray-700);
  }

  .pdc-btn-save {
    background: linear-gradient(135deg, var(--green-2), var(--green-1));
    color: #fff;
    box-shadow: 0 4px 14px rgba(39,174,96,0.28);
  }

  .pdc-btn-save:hover:not(:disabled) {
    box-shadow: 0 6px 18px rgba(39,174,96,0.38);
    transform: translateY(-1px);
  }

  .pdc-btn-save:active { transform: translateY(0); }

  .pdc-btn-save:disabled {
    background: linear-gradient(135deg, #f87171, #ef4444);
    box-shadow: 0 4px 14px rgba(239,68,68,0.2);
    cursor: not-allowed;
  }

  /* ── Responsive ── */
  @media (max-width: 560px) {
    .pdc-info-grid  { grid-template-columns: 1fr; }
    .pdc-field-grid { grid-template-columns: 1fr; }
    .pdc-field-grid .pdc-span2 { grid-column: 1; }
    .pdc-sisa-numbers { gap: 12px; }
    .pdc-sisa-num .num { font-size: 22px; }
    .pdc-header h1 { font-size: 16px; }
  }
</style>

<div class="pdc-wrap">

  {{-- ── Page Header ── --}}
  <div class="pdc-header">
    <h1>Perubahan Data Cuti Tahunan</h1>
   </div>

  {{-- ── Alerts ── --}}
  @if(session('success'))
    <div class="pdc-alert pdc-alert-success">
      ✓ {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="pdc-alert pdc-alert-error">
      ✕ {{ session('error') }}
    </div>
  @endif

  @if ($errors->any())
    <div class="pdc-alert pdc-alert-error">
      <ul style="list-style:none;padding:0;margin:0;">
        @foreach ($errors->all() as $error)
          <li>✕ {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('adminperubahancuti.update', $pengajuan->id) }}" method="POST" id="perubahancutiForm">
    @csrf
    @method('PUT')

    {{-- ── BIODATA PEGAWAI ── --}}
    <div class="pdc-card">
      <div class="pdc-card-header">
        <div class="pdc-hicon">
          <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <h2>Biodata Pegawai</h2>
      </div>
      <div class="pdc-card-body">
        <div class="pdc-info-grid">

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
              Nama
            </div>
            <div class="pdc-info-value">{{ $pengajuan->user->name }}</div>
          </div>

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
              NIP
            </div>
            <div class="pdc-info-value">{{ $pengajuan->user->nip }}</div>
          </div>

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
              Jabatan
            </div>
            <div class="pdc-info-value">{{ $pengajuan->user->jabatan }}</div>
          </div>

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              Masa Kerja
            </div>
            <div class="pdc-info-value">{{ $pengajuan->masa_kerja }}</div>
          </div>

          <div class="pdc-info-item no-border">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.1 19.79 19.79 0 0 1 1.61 4.5 2 2 0 0 1 3.6 2.32h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              No HP
            </div>
            <div class="pdc-info-value">{{ $pengajuan->user->no_hp }}</div>
          </div>

        </div>
      </div>
    </div>

    {{-- ── DATA CUTI SEBELUM PERUBAHAN ── --}}
    <div class="pdc-card">
      <div class="pdc-card-header">
        <div class="pdc-hicon">
          <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <h2>Data Cuti Sebelum Perubahan</h2>
      </div>
      <div class="pdc-card-body">
        <div class="pdc-info-grid">

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Tanggal Pengajuan
            </div>
            <div class="pdc-info-value">
              {{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->translatedFormat('d F Y') }}
            </div>
          </div>

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Tanggal Cuti
            </div>
            <div class="pdc-date-range">
              <span>{{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->translatedFormat('d F Y') }}</span>
              <span class="arr">→</span>
              <span>{{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->translatedFormat('d F Y') }}</span>
            </div>
          </div>

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              Lama Cuti
            </div>
            <div class="pdc-durasi-wrap">
              <div class="pdc-info-value">{{ $pengajuan->lama_cuti }}</div>
              <span class="pdc-lama-badge">hari kerja</span>
            </div>
          </div>

          <div class="pdc-info-item">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.1 19.79 19.79 0 0 1 1.61 4.5 2 2 0 0 1 3.6 2.32h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.08 6.08l.98-.98a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              No HP Saat Cuti
            </div>
            <div class="pdc-info-value">{{ $pengajuan->no_hp_cuti }}</div>
          </div>

          <div class="pdc-info-item no-border">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Alasan Melakukan Cuti
            </div>
            <div class="pdc-info-value muted">{{ $pengajuan->alasan }}</div>
          </div>

          <div class="pdc-info-item no-border">
            <div class="pdc-info-label">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              Alamat Saat Cuti
            </div>
            <div class="pdc-info-value muted">{{ $pengajuan->alamat_saat_cuti }}</div>
          </div>

        </div>
      </div>
    </div>

    {{-- ── FORM PERUBAHAN DATA CUTI ── --}}
    <div class="pdc-card">
      <div class="pdc-card-header">
        <div class="pdc-hicon">
          <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <h2>Perubahan Data Cuti</h2>
      </div>
      <div class="pdc-card-body">
        <div class="pdc-field-grid">

          {{-- Tanggal Mulai --}}
          <div class="pdc-field-group">
            <label>
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Tanggal Mulai Cuti Baru
            </label>
            <div class="pdc-cal-wrap">
              <input type="date" name="tgl_mulai" id="tgl_mulai"
                value="{{ old('tgl_mulai', $pengajuan->tgl_mulai) }}"
                class="pdc-input" required>
              <div class="pdc-calendar" id="calStart">
                <div class="pdc-cal-nav">
                  <button type="button" class="pdc-cal-btn prev-start">‹</button>
                  <span class="cal-month-start">—</span>
                  <button type="button" class="pdc-cal-btn next-start">›</button>
                </div>
                <div class="pdc-cal-grid-wrap">
                  <div class="pdc-cal-dow">
                    <div>Min</div><div>Sen</div><div>Sel</div>
                    <div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                  </div>
                  <div class="pdc-cal-days" id="daysStart"></div>
                </div>
                <div class="pdc-cal-legend"><span class="dot"></span> Hari Libur / Weekend</div>
              </div>
            </div>
            @error('tgl_mulai')
              <p class="pdc-field-error-blade">{{ $message }}</p>
            @enderror
          </div>

          {{-- Tanggal Selesai --}}
          <div class="pdc-field-group">
            <label>
              <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              Tanggal Selesai Cuti Baru
            </label>
            <div class="pdc-cal-wrap">
              <input type="date" name="tgl_selesai" id="tgl_selesai"
                value="{{ old('tgl_selesai', $pengajuan->tgl_selesai) }}"
                class="pdc-input" required>
              <div class="pdc-calendar right" id="calEnd">
                <div class="pdc-cal-nav">
                  <button type="button" class="pdc-cal-btn prev-end">‹</button>
                  <span class="cal-month-end">—</span>
                  <button type="button" class="pdc-cal-btn next-end">›</button>
                </div>
                <div class="pdc-cal-grid-wrap">
                  <div class="pdc-cal-dow">
                    <div>Min</div><div>Sen</div><div>Sel</div>
                    <div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                  </div>
                  <div class="pdc-cal-days" id="daysEnd"></div>
                </div>
                <div class="pdc-cal-legend"><span class="dot"></span> Hari Libur / Weekend</div>
              </div>
            </div>
            <p class="pdc-field-error" id="dateError">Tanggal selesai harus ≥ tanggal mulai.</p>
            @error('tgl_selesai')
              <p class="pdc-field-error-blade">{{ $message }}</p>
            @enderror
          </div>

          {{-- Lama Cuti --}}
          <div class="pdc-field-group">
            <label>
              <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              Lama Cuti Baru (Hari Kerja)
            </label>
            <div class="pdc-lama-row">
              <input type="number" name="lama_cuti" id="lama_cuti"
                value="{{ old('lama_cuti', $pengajuan->lama_cuti) }}"
                class="pdc-input"
                style="max-width:90px;text-align:center;font-size:16px;font-weight:700;"
                min="1" readonly required>
              <span class="pdc-hari-badge">hari kerja</span>
              <div class="pdc-loading" id="loadingWrap">
                <div class="pdc-spinner"></div>
                <span>Memeriksa…</span>
              </div>
            </div>
            @error('lama_cuti')
              <p class="pdc-field-error-blade">{{ $message }}</p>
            @enderror
          </div>

          {{-- Spacer --}}
          <div></div>

          {{-- Catatan Perubahan --}}
          <div class="pdc-field-group pdc-span2">
            <label>
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              Catatan Perubahan <span style="color:var(--red);font-weight:700">*</span>
            </label>
            <textarea name="catatan" id="catatan" rows="3" class="pdc-input"
              placeholder="Contoh: Perubahan karena dipanggil dinas pada tanggal 20-21 Juli 2025"
              required>{{ old('catatan', $pengajuan->catatan) }}</textarea>
            <p class="pdc-field-hint">Jelaskan alasan perubahan jadwal cuti secara singkat.</p>
            @error('catatan')
              <p class="pdc-field-error-blade">{{ $message }}</p>
            @enderror
          </div>

        </div>
      </div>
    </div>

    {{-- ── CATATAN SISA CUTI ── --}}
    <div class="pdc-sisa-card">
      <div class="pdc-sisa-icon">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      </div>
      <div class="pdc-sisa-text">
        <h3>Catatan Sisa Cuti</h3>
        <p>Tahunan Pegawai</p>
      </div>
      <div class="pdc-sisa-numbers">
        <div class="pdc-sisa-num">
          <div class="num">{{ $kuotaCuti->kuota_n2 ?? '0' }}</div>
          <div class="lbl">N2</div>
        </div>
        <div class="pdc-sisa-divider"></div>
        <div class="pdc-sisa-num">
          <div class="num">{{ $kuotaCuti->kuota_n1 ?? '0' }}</div>
          <div class="lbl">N1</div>
        </div>
        <div class="pdc-sisa-divider"></div>
        <div class="pdc-sisa-num">
          <div class="num">{{ $kuotaCuti->kuota_n ?? '0' }}</div>
          <div class="lbl">N</div>
        </div>
      </div>
    </div>

    {{-- ── Footer Buttons ── --}}
    <div class="pdc-footer">
      <a href="{{ route('adminperubahancuti.index') }}" class="pdc-btn pdc-btn-cancel">
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
      </a>
      <button type="submit" id="submitBtn" class="pdc-btn pdc-btn-save">
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        Simpan Perubahan
      </button>
    </div>

  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  let holidayCache = {};

  const inputStart = document.getElementById('tgl_mulai');
  const inputEnd   = document.getElementById('tgl_selesai');
  const calStart   = document.getElementById('calStart');
  const calEnd     = document.getElementById('calEnd');
  const daysStart  = document.getElementById('daysStart');
  const daysEnd    = document.getElementById('daysEnd');
  const lamaCuti   = document.getElementById('lama_cuti');
  const loading    = document.getElementById('loadingWrap');
  const dateError  = document.getElementById('dateError');
  const submitBtn  = document.getElementById('submitBtn');

  const calState = {
    start: { year: new Date().getFullYear(), month: new Date().getMonth() },
    end:   { year: new Date().getFullYear(), month: new Date().getMonth() }
  };

  // Init calendar state from input values
  if (inputStart.value) {
    const d = new Date(inputStart.value);
    calState.start = { year: d.getFullYear(), month: d.getMonth() };
  }
  if (inputEnd.value) {
    const d = new Date(inputEnd.value);
    calState.end = { year: d.getFullYear(), month: d.getMonth() };
  }

  // ── Open/close calendars ──
  inputStart.addEventListener('click', e => {
    e.preventDefault();
    renderCalendar('start');
    calStart.classList.add('open');
    calEnd.classList.remove('open');
  });

  inputEnd.addEventListener('click', e => {
    e.preventDefault();
    renderCalendar('end');
    calEnd.classList.add('open');
    calStart.classList.remove('open');
  });

  document.addEventListener('click', e => {
    if (!inputStart.contains(e.target) && !calStart.contains(e.target)) calStart.classList.remove('open');
    if (!inputEnd.contains(e.target)   && !calEnd.contains(e.target))   calEnd.classList.remove('open');
  });

  // ── Navigation buttons ──
  document.querySelector('.prev-start').addEventListener('click', () => navigate('start', -1));
  document.querySelector('.next-start').addEventListener('click', () => navigate('start',  1));
  document.querySelector('.prev-end').addEventListener('click',   () => navigate('end',   -1));
  document.querySelector('.next-end').addEventListener('click',   () => navigate('end',    1));

  function navigate(which, dir) {
    calState[which].month += dir;
    if (calState[which].month < 0)  { calState[which].month = 11; calState[which].year--; }
    if (calState[which].month > 11) { calState[which].month =  0; calState[which].year++; }
    renderCalendar(which);
  }

  // ── Fetch holidays ──
  async function fetchHolidays(year) {
    if (holidayCache[year]) return holidayCache[year];
    try {
      const r = await fetch(`https://libur.deno.dev/api?year=${year}`);
      holidayCache[year] = r.ok ? (await r.json()).map(h => h.date) : [];
    } catch { holidayCache[year] = []; }
    return holidayCache[year];
  }

  // ── Render calendar grid ──
  async function renderCalendar(which) {
    const s = calState[which];
    const monthLabel = document.querySelector(`.cal-month-${which}`);
    const grid = which === 'start' ? daysStart : daysEnd;
    const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    monthLabel.textContent = `${months[s.month]} ${s.year}`;

    const holidays = await fetchHolidays(s.year);
    const first    = new Date(s.year, s.month, 1);
    const last     = new Date(s.year, s.month + 1, 0);
    const selStart = inputStart.value;
    const selEnd   = inputEnd.value;
    const today    = fmt(new Date());

    grid.innerHTML = '';

    for (let i = 0; i < first.getDay(); i++) {
      grid.appendChild(document.createElement('div'));
    }

    for (let d = 1; d <= last.getDate(); d++) {
      const date = new Date(s.year, s.month, d);
      const fmtd = fmt(date);
      const dow  = date.getDay();

      const cell = document.createElement('div');
      cell.className = 'pdc-cal-day';
      cell.textContent = d;

      if (dow === 0 || dow === 6) cell.classList.add('weekend');
      if (holidays.includes(fmtd)) cell.classList.add('holiday');
      if (fmtd === today) cell.classList.add('today');
      if (selStart && selEnd && fmtd > selStart && fmtd < selEnd) cell.classList.add('in-range');
      if (fmtd === selStart || fmtd === selEnd) cell.classList.add('selected');

      cell.addEventListener('click', () => selectDate(which, fmtd));
      grid.appendChild(cell);
    }
  }

  function selectDate(which, fmtd) {
    if (which === 'start') {
      inputStart.value = fmtd;
      if (inputEnd.value && fmtd > inputEnd.value) inputEnd.value = fmtd;
      calStart.classList.remove('open');
    } else {
      inputEnd.value = fmtd;
      if (inputStart.value && fmtd < inputStart.value) inputStart.value = fmtd;
      calEnd.classList.remove('open');
    }
    validateDates();
    calculateDays();
    renderCalendar('start');
    renderCalendar('end');
  }

  function fmt(date) {
    return `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`;
  }

  // ── Validate ──
  function validateDates() {
    if (inputStart.value && inputEnd.value && inputEnd.value < inputStart.value) {
      dateError.classList.add('show');
      inputEnd.classList.add('pdc-error');
      return false;
    }
    dateError.classList.remove('show');
    inputEnd.classList.remove('pdc-error');
    return true;
  }

  // ── Calculate working days ──
  async function calculateDays() {
    if (!inputStart.value || !inputEnd.value || !validateDates()) {
      lamaCuti.value = 0;
      return;
    }

    loading.classList.add('show');

    const start = new Date(inputStart.value);
    const end   = new Date(inputEnd.value);
    const years = new Set();
    for (let y = start.getFullYear(); y <= end.getFullYear(); y++) years.add(y);
    for (const y of years) await fetchHolidays(y);

    let count = 0;
    for (let d = new Date(start); d <= end; d.setDate(d.getDate()+1)) {
      const dow  = d.getDay();
      const fmtd = fmt(d);
      if (dow !== 0 && dow !== 6) {
        const isHoliday = Object.values(holidayCache).some(arr => arr.includes(fmtd));
        if (!isHoliday) count++;
      }
    }

    loading.classList.remove('show');
    lamaCuti.value = count;

    // Kuota check — gunakan nilai dari Blade
    const kuotaTotal = {{ ($kuotaCuti->kuota_n ?? 0) + ($kuotaCuti->kuota_n1 ?? 0) + ($kuotaCuti->kuota_n2 ?? 0) }};
    const asalLama   = {{ $pengajuan->lama_cuti ?? 0 }};
    const avail      = kuotaTotal + asalLama;

    if (count > avail) {
      alert('Lama hari cuti melebihi kuota cuti tahunan pegawai!');
      lamaCuti.classList.add('pdc-error');
      submitBtn.disabled = true;
    } else {
      lamaCuti.classList.remove('pdc-error');
      submitBtn.disabled = false;
    }
  }

  // ── Form submit validation ──
  document.getElementById('perubahancutiForm').addEventListener('submit', function(e) {
    if (!validateDates()) e.preventDefault();
  });

  // ── Listen for manual input changes ──
  inputStart.addEventListener('change', () => { validateDates(); calculateDays(); });
  inputEnd.addEventListener('change',   () => { validateDates(); calculateDays(); });

  // ── Initial calculation ──
  if (inputStart.value && inputEnd.value) calculateDays();

});
</script>

@endsection