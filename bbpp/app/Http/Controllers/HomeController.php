<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MasaKerja;
use App\Models\AnggotaTim;
use Illuminate\Http\Request;
use App\Models\KuotaCutiTahunan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\PengajuanCutiUmum;
use App\Models\CtStatusKabagKabal;
use App\Models\CuStatusKabagKabal;
use App\Models\PengajuanCutiTahunan;
use App\Models\JenisCuti;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            if(Auth::user()->role == 'admin') {
                // Get filter parameters
                $selectedYear = $request->input('tahun', date('Y'));
                $selectedMonth = $request->input('bulan', null);
                $selectedTriwulan = $request->input('triwulan', null);
                $startDate = $request->input('start_date', null);
                $endDate = $request->input('end_date', null);

                // Get available years and validate selection
                $availableYears = $this->getAvailableYears();
                if (!$availableYears->contains($selectedYear) && $availableYears->isNotEmpty()) {
                    $selectedYear = $availableYears->first();
                }

                // Get available months and validate selection
                $availableMonths = $this->getAvailableMonths($selectedYear);
                if ($selectedMonth && !$availableMonths->contains($selectedMonth)) {
                    $selectedMonth = null;
                }

                // Initialize queries with proper eager loading
                $cutiTahunanQuery = PengajuanCutiTahunan::with([
                    'user',
                    'ctStatusUserAdmin',
                    'ctStatusUserAdmin.ctStatusAdminKatimker',
                    'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag',
                    'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal'
                ])->where(function($query) {
                    $query->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        })
                        ->orWhereHas('user', function($q) {
                            $q->whereIn('role', ['kepalabagian', 'widyaiswara']);
                        });
                });

                $cutiUmumQuery = PengajuanCutiUmum::with([
                    'user',
                    'jenisCuti',
                    'cuStatusUserAdmin',
                    'cuStatusUserAdmin.cuStatusAdminKatimker',
                    'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag',
                    'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal'
                ])->where(function($query) {
                    $query->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        })
                        ->orWhereHas('user', function($q) {
                            $q->whereIn('role', ['kepalabagian', 'widyaiswara']);
                        });
                });

                // Apply date filters
                if ($selectedMonth) {
                    // Monthly filter
                    $cutiTahunanQuery->whereYear('tgl_mulai', $selectedYear)
                        ->whereMonth('tgl_mulai', $selectedMonth);
                    $cutiUmumQuery->whereYear('tgl_mulai', $selectedYear)
                        ->whereMonth('tgl_mulai', $selectedMonth);
                    
                    $daysInMonth = Carbon::create($selectedYear, $selectedMonth)->daysInMonth;
                    $labels = range(1, $daysInMonth);
                    $chartTitle = 'Pengajuan Cuti Disetujui per Hari';
                    $xAxisTitle = 'Tanggal';
                } elseif ($selectedTriwulan) {
                    // Quarterly filter
                    $startMonth = (($selectedTriwulan - 1) * 3) + 1;
                    $endMonth = $startMonth + 2;
                    
                    $cutiTahunanQuery->whereYear('tgl_mulai', $selectedYear)
                        ->whereMonth('tgl_mulai', '>=', $startMonth)
                        ->whereMonth('tgl_mulai', '<=', $endMonth);
                    $cutiUmumQuery->whereYear('tgl_mulai', $selectedYear)
                        ->whereMonth('tgl_mulai', '>=', $startMonth)
                        ->whereMonth('tgl_mulai', '<=', $endMonth);
                    
                    $labels = [];
                    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    for ($i = $startMonth; $i <= $endMonth; $i++) {
                        $labels[] = $monthNames[$i - 1];
                    }
                    $chartTitle = 'Pengajuan Cuti Disetujui per Bulan (Triwulan ' . $selectedTriwulan . ')';
                    $xAxisTitle = 'Bulan';
                } elseif ($startDate && $endDate) {
                    // Date range filter
                    $cutiTahunanQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
                    $cutiUmumQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
                    
                    $start = Carbon::parse($startDate);
                    $end = Carbon::parse($endDate);
                    $diffInDays = $start->diffInDays($end);
                    
                    if ($diffInDays <= 31) {
                        // Daily view
                        $labels = [];
                        $current = $start->copy();
                        while ($current <= $end) {
                            $labels[] = $current->format('j M');
                            $current->addDay();
                        }
                        $chartTitle = 'Pengajuan Cuti Disetujui per Hari';
                        $xAxisTitle = 'Tanggal';
                    } else {
                        // Weekly view
                        $labels = [];
                        $current = $start->copy();
                        while ($current <= $end) {
                            $weekEnd = $current->copy()->addDays(6);
                            if ($weekEnd > $end) $weekEnd = $end;
                            $labels[] = $current->format('j M') . ' - ' . $weekEnd->format('j M');
                            $current->addDays(7);
                        }
                        $chartTitle = 'Pengajuan Cuti Disetujui per Minggu';
                        $xAxisTitle = 'Minggu';
                    }
                } else {
                    // Yearly view
                    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    $chartTitle = 'Pengajuan Cuti Disetujui per Bulan';
                    $xAxisTitle = 'Bulan';
                    
                    $cutiTahunanQuery->whereYear('tgl_mulai', $selectedYear);
                    $cutiUmumQuery->whereYear('tgl_mulai', $selectedYear);
                }

                // Execute queries
                $cutiTahunan = $cutiTahunanQuery->get();
                $cutiUmum = $cutiUmumQuery->get();

                // Calculate counts
                $jumlahCuti = $this->calculateCutiCount($labels, $cutiTahunan, $cutiUmum, $selectedMonth, $startDate, $endDate, $selectedTriwulan);
                $totalHariCuti = array_sum($jumlahCuti);

                // Prepare data for dashboard
                $pieChartData = $this->preparePieChartData($cutiTahunan, $cutiUmum);
                $totalPengajuan = $this->getTotalPengajuan($selectedYear, $selectedMonth, $selectedTriwulan, $startDate, $endDate);
                $pengajuanDisetujui = $this->getPengajuanDisetujui($selectedYear, $selectedMonth, $selectedTriwulan, $startDate, $endDate);
                $jumlahPegawaiMengajukanCuti = $this->getJumlahPegawaiMengajukanCuti($selectedYear, $selectedMonth, $selectedTriwulan, $startDate, $endDate);
                
                $sedangCuti = $this->getPegawaiSedangCuti();
                
                $topUsers = $this->getTopUsersWithMostSubmissions($selectedYear, $selectedMonth, $selectedTriwulan, $startDate, $endDate);
                $statistikCuti = $this->getStatistikCutiDalamProses();

                // Chart colors
                $chartColors = [
                    '#60a5fa', // blue
                    '#34d399', // emerald
                    '#facc15', // yellow
                    '#fb7185', // rose
                    '#c084fc', // purple
                    '#f97316', // orange
                    '#10b981'  // green
                ];

                return view('dashboard.admin.dashboard-admin', compact(
                    'totalPengajuan',
                    'pengajuanDisetujui',
                    'jumlahPegawaiMengajukanCuti',
                    'jumlahCuti',
                    'availableYears',
                    'availableMonths',
                    'selectedYear',
                    'selectedMonth',
                    'totalHariCuti',
                    'chartColors',
                    'labels',
                    'chartTitle',
                    'xAxisTitle',
                    'sedangCuti',
                    'topUsers',
                    'statistikCuti',
                    'selectedTriwulan',
                    'startDate',
                    'endDate'
                ))->with([
                    'yAxisTitle' => 'Jumlah Pengajuan',
                    'cutiJenisLabels' => $pieChartData['cutiJenisLabels'],
                    'cutiJenisData' => $pieChartData['cutiJenisData'],
                    'cutiJenisColors' => $pieChartData['cutiJenisColors']
                ]);
            }
            else {
                $user = Auth::user();
                $kuotaCuti = KuotaCutiTahunan::where('user_id', $user->id)->latest()->first();
                $masakerja = MasaKerja::where('user_id', $user->id)->first();
                $admin = User::where('role', 'admin')->first();
                $anggotaTim = AnggotaTim::where('user_id', $user->id)->with('tim')->first();
                $timkerja = $anggotaTim?->tim;

                if(Auth::user()->role == 'kepalabagian') {
                    return view('dashboard.kepalabagian.dashboard-kabag', compact('user', 'masakerja', 'admin'));  
                }
                else if(Auth::user()->role == 'kepalatimkerja') {
                    return view('dashboard.kepalatimkerja.dashboard-katimker', compact('user', 'kuotaCuti', 'masakerja', 'admin', 'timkerja'));
                }
                else if(Auth::user()->role == 'kepalabalai') {
                    return view('dashboard.kepalabalai.dashboard-kepalabalai', compact('user', 'kuotaCuti', 'masakerja', 'admin'));
                }
                else if(Auth::user()->role == 'widyaiswara') {
                    return view('dashboard.widyaiswara.dashboard-widyaiswara', compact('user', 'kuotaCuti', 'masakerja', 'admin'));
                }
                else {
                    return view('dashboard.user.dashboard-user', compact('user', 'kuotaCuti', 'masakerja', 'admin', 'timkerja'));  
                }    
            }       
        } else {
            return redirect ('login');
        }
    }

    private function getAvailableYears()
    {
        $yearsTahunan = PengajuanCutiTahunan::selectRaw('YEAR(tgl_mulai) as year')
            ->distinct()
            ->pluck('year');
            
        $yearsUmum = PengajuanCutiUmum::selectRaw('YEAR(tgl_mulai) as year')
            ->distinct()
            ->pluck('year');

        return $yearsTahunan->merge($yearsUmum)
            ->unique()
            ->sortDesc()
            ->values();
    }

    private function getAvailableMonths($year)
    {
        $monthsTahunan = PengajuanCutiTahunan::selectRaw('MONTH(tgl_mulai) as month')
            ->whereYear('tgl_mulai', $year)
            ->distinct()
            ->pluck('month');
            
        $monthsUmum = PengajuanCutiUmum::selectRaw('MONTH(tgl_mulai) as month')
            ->whereYear('tgl_mulai', $year)
            ->distinct()
            ->pluck('month');

        return $monthsTahunan->merge($monthsUmum)
            ->unique()
            ->sort()
            ->values();
    }

    private function getTotalPengajuan($year, $month = null, $triwulan = null, $startDate = null, $endDate = null)
    {
        $tahunanQuery = PengajuanCutiTahunan::whereYear('tgl_mulai', $year);
        $umumQuery = PengajuanCutiUmum::whereYear('tgl_mulai', $year);

        if ($month) {
            $tahunanQuery->whereMonth('tgl_mulai', $month);
            $umumQuery->whereMonth('tgl_mulai', $month);
        } 
        elseif ($triwulan) {
            $startMonth = (($triwulan - 1) * 3) + 1;
            $endMonth = $startMonth + 2;
            
            $tahunanQuery->whereMonth('tgl_mulai', '>=', $startMonth)
                        ->whereMonth('tgl_mulai', '<=', $endMonth);
            $umumQuery->whereMonth('tgl_mulai', '>=', $startMonth)
                    ->whereMonth('tgl_mulai', '<=', $endMonth);
        }
        elseif ($startDate && $endDate) {
            $tahunanQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
            $umumQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
        }

        return $tahunanQuery->count() + $umumQuery->count();
    }

    private function getPengajuanDisetujui($year, $month = null, $triwulan = null, $startDate = null, $endDate = null)
    {
        $tahunanQuery = PengajuanCutiTahunan::whereYear('tgl_mulai', $year)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('is_kabag', false)
                    ->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        });
                });
                
                $query->orWhere(function($q) {
                    $q->where('is_kabag', true)
                    ->whereHas('ctStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    })
                    ->whereHas('ctStatusUserAdmin.ctStatusAdminKabal', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
                
                $query->orWhere(function($q) {
                    $q->whereHas('user', function($q) {
                        $q->where('role', 'widyaiswara');
                    })
                    ->whereHas('ctStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
            });

        $umumQuery = PengajuanCutiUmum::whereYear('tgl_mulai', $year)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('is_kabag', false)
                    ->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        });
                });
                
                $query->orWhere(function($q) {
                    $q->where('is_kabag', true)
                    ->whereHas('cuStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    })
                    ->whereHas('cuStatusUserAdmin.cuStatusAdminKabal', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
                
                $query->orWhere(function($q) {
                    $q->whereHas('user', function($q) {
                        $q->where('role', 'widyaiswara');
                    })
                    ->whereHas('cuStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
            });

        $this->applyDateFilters($tahunanQuery, $umumQuery, $month, $triwulan, $startDate, $endDate);

        return $tahunanQuery->count() + $umumQuery->count();
    }

    private function getJumlahPegawaiMengajukanCuti($year, $month = null, $triwulan = null, $startDate = null, $endDate = null)
    {
        $tahunanQuery = PengajuanCutiTahunan::query()
            ->whereYear('tgl_mulai', $year);
            
        $umumQuery = PengajuanCutiUmum::query()
            ->whereYear('tgl_mulai', $year);

        if ($month) {
            $tahunanQuery->whereMonth('tgl_mulai', $month);
            $umumQuery->whereMonth('tgl_mulai', $month);
        } 
        elseif ($triwulan) {
            $startMonth = (($triwulan - 1) * 3) + 1;
            $endMonth = $startMonth + 2;
            
            $tahunanQuery->whereMonth('tgl_mulai', '>=', $startMonth)
                        ->whereMonth('tgl_mulai', '<=', $endMonth);
            $umumQuery->whereMonth('tgl_mulai', '>=', $startMonth)
                    ->whereMonth('tgl_mulai', '<=', $endMonth);
        }
        elseif ($startDate && $endDate) {
            $tahunanQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
            $umumQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
        }

        $userIdsTahunan = $tahunanQuery->pluck('user_id');
        $userIdsUmum = $umumQuery->pluck('user_id');

        $allUserIds = $userIdsTahunan->merge($userIdsUmum)->unique();

        return User::whereIn('id', $allUserIds)
            ->where(function($query) {
                $query->whereNotIn('role', ['admin', 'kepalabalai'])
                    ->orWhereIn('role', ['kepalabagian', 'widyaiswara']);
            })
            ->count();
    }

    private function getPegawaiSedangCuti()
    {
        $today = Carbon::today();
        
        $cutiTahunan = PengajuanCutiTahunan::with(['user'])
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('is_kabag', false)
                    ->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        });
                });
                
                $query->orWhere(function($q) {
                    $q->where('is_kabag', true)
                    ->whereHas('ctStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    })
                    ->whereHas('ctStatusUserAdmin.ctStatusAdminKabal', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
                
                $query->orWhere(function($q) {
                    $q->whereHas('user', function($q) {
                        $q->where('role', 'widyaiswara');
                    })
                    ->whereHas('ctStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
            })->get();

        $cutiUmum = PengajuanCutiUmum::with(['user', 'jenisCuti'])
            ->whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_selesai', '>=', $today)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('is_kabag', false)
                    ->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        });
                });
                
                $query->orWhere(function($q) {
                    $q->where('is_kabag', true)
                    ->whereHas('cuStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    })
                    ->whereHas('cuStatusUserAdmin.cuStatusAdminKabal', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
                
                $query->orWhere(function($q) {
                    $q->whereHas('user', function($q) {
                        $q->where('role', 'widyaiswara');
                    })
                    ->whereHas('cuStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
            })->get();

        return $cutiTahunan->concat($cutiUmum);
    }

    private function preparePieChartData($cutiTahunan, $cutiUmum)
    {
        $labels = [];
        $data = [];
        $colors = [];

        $totalCutiTahunan = $cutiTahunan->filter(function($cuti) {
            if (!$cuti->is_kabag) {
                return $cuti->ctStatusUserAdmin &&
                    $cuti->ctStatusUserAdmin->ctStatusAdminKatimker &&
                    $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag &&
                    $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal &&
                    $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal->status === 'disetujui';
            }
            elseif ($cuti->is_kabag) {
                return $cuti->ctStatusUserAdmin &&
                    $cuti->ctStatusUserAdmin->ctStatusAdminKabal &&
                    $cuti->ctStatusUserAdmin->status === 'disetujui' &&
                    $cuti->ctStatusUserAdmin->ctStatusAdminKabal->status === 'disetujui';
            }
            elseif ($cuti->user && $cuti->user->role === 'widyaiswara') {
                return $cuti->ctStatusUserAdmin &&
                    $cuti->ctStatusUserAdmin->status === 'disetujui';
            }
            return false;
        })->count();

        if ($totalCutiTahunan > 0) {
            $labels[] = 'Cuti Tahunan';
            $data[] = $totalCutiTahunan;
            $colors[] = '#3b82f6';
        }

        $cutiUmumData = $cutiUmum->filter(function($cuti) {
            if (!$cuti->is_kabag) {
                return $cuti->cuStatusUserAdmin &&
                    $cuti->cuStatusUserAdmin->cuStatusAdminKatimker &&
                    $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag &&
                    $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal &&
                    $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status === 'disetujui';
            }
            elseif ($cuti->is_kabag) {
                return $cuti->cuStatusUserAdmin &&
                    $cuti->cuStatusUserAdmin->cuStatusAdminKabal &&
                    $cuti->cuStatusUserAdmin->status === 'disetujui' &&
                    $cuti->cuStatusUserAdmin->cuStatusAdminKabal->status === 'disetujui';
            }
            elseif ($cuti->user && $cuti->user->role === 'widyaiswara') {
                return $cuti->cuStatusUserAdmin &&
                    $cuti->cuStatusUserAdmin->status === 'disetujui';
            }
            return false;
        })->groupBy('jeniscuti_id');

        $colorPalette = [
            '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316',
        ];

        $colorIndex = 0;
        
        foreach ($cutiUmumData as $jeniscutiId => $cutis) {
            $namaJenis = JenisCuti::find($jeniscutiId)?->nama_cuti ?? 'Lainnya';
            $count = $cutis->count();
            
            $labels[] = $namaJenis;
            $data[] = $count;
            $colors[] = $colorPalette[$colorIndex % count($colorPalette)];
            $colorIndex++;
        }

        return [
            'cutiJenisLabels' => $labels,
            'cutiJenisData' => $data,
            'cutiJenisColors' => $colors
        ];
    }

    private function applyDateFilters(&$tahunanQuery, &$umumQuery, $month, $triwulan, $startDate, $endDate)
    {
        if ($month) {
            $tahunanQuery->whereMonth('tgl_mulai', $month);
            $umumQuery->whereMonth('tgl_mulai', $month);
        } 
        elseif ($triwulan) {
            $startMonth = (($triwulan - 1) * 3) + 1;
            $endMonth = $startMonth + 2;
            
            $tahunanQuery->whereMonth('tgl_mulai', '>=', $startMonth)
                        ->whereMonth('tgl_mulai', '<=', $endMonth);
            $umumQuery->whereMonth('tgl_mulai', '>=', $startMonth)
                    ->whereMonth('tgl_mulai', '<=', $endMonth);
        }
        elseif ($startDate && $endDate) {
            $tahunanQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
            $umumQuery->whereBetween('tgl_mulai', [$startDate, $endDate]);
        }
    }

    private function getTopUsersWithMostSubmissions($year, $month = null, $triwulan = null, $startDate = null, $endDate = null)
    {
        $tahunanQuery = PengajuanCutiTahunan::whereYear('tgl_mulai', $year)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('is_kabag', false)
                    ->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        });
                });
                
                $query->orWhere(function($q) {
                    $q->where('is_kabag', true)
                    ->whereHas('ctStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    })
                    ->whereHas('ctStatusUserAdmin.ctStatusAdminKabal', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
                
                $query->orWhere(function($q) {
                    $q->whereHas('user', function($q) {
                        $q->where('role', 'widyaiswara');
                    })
                    ->whereHas('ctStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
            });

        $umumQuery = PengajuanCutiUmum::whereYear('tgl_mulai', $year)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->where('is_kabag', false)
                    ->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal', 
                        function($q) {
                            $q->where('status', 'disetujui');
                        });
                });
                
                $query->orWhere(function($q) {
                    $q->where('is_kabag', true)
                    ->whereHas('cuStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    })
                    ->whereHas('cuStatusUserAdmin.cuStatusAdminKabal', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
                
                $query->orWhere(function($q) {
                    $q->whereHas('user', function($q) {
                        $q->where('role', 'widyaiswara');
                    })
                    ->whereHas('cuStatusUserAdmin', function($q) {
                        $q->where('status', 'disetujui');
                    });
                });
            });

        $this->applyDateFilters($tahunanQuery, $umumQuery, $month, $triwulan, $startDate, $endDate);

        $tahunanCounts = $tahunanQuery->with('user')
            ->selectRaw('user_id, count(*) as total')
            ->groupBy('user_id')
            ->get();

        $umumCounts = $umumQuery->with('user')
            ->selectRaw('user_id, count(*) as total')
            ->groupBy('user_id')
            ->get();

        $combined = $tahunanCounts->concat($umumCounts)
            ->groupBy('user_id')
            ->map(function ($items) {
                return [
                    'user_id' => $items->first()->user_id,
                    'total' => $items->sum('total'),
                    'user' => $items->first()->user
                ];
            });

        return $combined->sortByDesc('total')
            ->take(5)
            ->map(function ($item) {
                return [
                    'name' => $item['user']->name ?? 'User tidak ditemukan',
                    'total' => $item['total'],
                    'role' => $item['user']->role ?? null
                ];
            })
            ->values();
    }

    private function getStatistikCutiDalamProses()
    {
        $baseTahunanQuery = function() {
            return PengajuanCutiTahunan::with([
                'ctStatusUserAdmin',
                'ctStatusUserAdmin.ctStatusAdminKatimker',
                'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag',
                'ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal',
                'user' => function($q) {
                    $q->select('id', 'role');
                }
            ]);
        };

        $baseUmumQuery = function() {
            return PengajuanCutiUmum::with([
                'cuStatusUserAdmin',
                'cuStatusUserAdmin.cuStatusAdminKatimker',
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag',
                'cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal',
                'user' => function($q) {
                    $q->select('id', 'role');
                }
            ]);
        };

        $adminTahunan = $baseTahunanQuery()
            ->whereDoesntHave('ctStatusUserAdmin')
            ->whereHas('user', fn($q) => $q->whereIn('role', ['user', 'kepalatimkerja', 'widyaiswara', 'kepalabagian']))
            ->count();

        $adminUmum = $baseUmumQuery()
            ->whereDoesntHave('cuStatusUserAdmin')
            ->whereHas('user', fn($q) => $q->whereIn('role', ['user', 'kepalatimkerja', 'widyaiswara', 'kepalabagian']))
            ->count();

        $timKerjaTahunan = $baseTahunanQuery()
            ->whereHas('ctStatusUserAdmin', fn($q) => $q->where('status', 'disetujui'))
            ->whereDoesntHave('ctStatusUserAdmin.ctStatusAdminKatimker')
            ->whereHas('user', fn($q) => $q->where('role', 'user'))
            ->count();

        $timKerjaUmum = $baseUmumQuery()
            ->whereHas('cuStatusUserAdmin', fn($q) => $q->where('status', 'disetujui'))
            ->whereDoesntHave('cuStatusUserAdmin.cuStatusAdminKatimker')
            ->whereHas('user', fn($q) => $q->where('role', 'user'))
            ->count();

        $kabagTahunan = $baseTahunanQuery()
            ->where(function($query) {
                $query->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag')
                    ->whereHas('user', fn($q) => $q->where('role', 'user'));
            })
            ->orWhere(function($query) {
                $query->whereDoesntHave('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag')
                    ->whereHas('user', fn($q) => $q->where('role', 'kepalatimkerja'));
            })
            ->count();

        $kabagUmum = $baseUmumQuery()
            ->where(function($query) {
                $query->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag')
                    ->whereHas('user', fn($q) => $q->where('role', 'user'));
            })
            ->orWhere(function($query) {
                $query->whereDoesntHave('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag')
                    ->whereHas('user', fn($q) => $q->where('role', 'kepalatimkerja'));
            })
            ->count();

        $kabalTahunan = $baseTahunanQuery()
            ->where(function($query) {
                $query->whereHas('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('ctStatusUserAdmin.ctStatusAdminKatimker.ctStatusKatimkerKabag.ctStatusKabagKabal')
                    ->whereHas('user', fn($q) => $q->whereIn('role', ['user', 'kepalatimkerja']));
            })
            ->orWhere(function($query) {
                $query->whereHas('ctStatusUserAdmin', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('ctStatusUserAdmin.ctStatusAdminKabal')
                    ->whereHas('user', fn($q) => $q->where('role', 'widyaiswara'));
            })
            ->orWhere(function($query) {
                $query->whereHas('ctStatusUserAdmin', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('ctStatusUserAdmin.ctStatusAdminKabal')
                    ->whereHas('user', fn($q) => $q->where('role', 'kepalabagian'));
            })
            ->count();

        $kabalUmum = $baseUmumQuery()
            ->where(function($query) {
                $query->whereHas('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('cuStatusUserAdmin.cuStatusAdminKatimker.cuStatusKatimkerKabag.cuStatusKabagKabal')
                    ->whereHas('user', fn($q) => $q->whereIn('role', ['user', 'kepalatimkerja']));
            })
            ->orWhere(function($query) {
                $query->whereHas('cuStatusUserAdmin', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('cuStatusUserAdmin.cuStatusAdminKabal')
                    ->whereHas('user', fn($q) => $q->where('role', 'widyaiswara'));
            })
            ->orWhere(function($query) {
                $query->whereHas('cuStatusUserAdmin', fn($q) => $q->where('status', 'disetujui'))
                    ->whereDoesntHave('cuStatusUserAdmin.cuStatusAdminKabal')
                    ->whereHas('user', fn($q) => $q->where('role', 'kepalabagian'));
            })
            ->count();

        return [
            'admin' => [
                'tahunan' => $adminTahunan,
                'umum' => $adminUmum
            ],
            'tim_kerja' => [
                'tahunan' => $timKerjaTahunan,
                'umum' => $timKerjaUmum
            ],
            'kepala_bagian' => [
                'tahunan' => $kabagTahunan,
                'umum' => $kabagUmum
            ],
            'kepala_balai' => [
                'tahunan' => $kabalTahunan,
                'umum' => $kabalUmum
            ]
        ];
    }

    private function calculateCutiCount(
        array $labels,
        $cutiTahunan,
        $cutiUmum,
        ?int $selectedMonth = null,
        ?string $startDate = null,
        ?string $endDate = null,
        ?int $selectedTriwulan = null
    ): array {
        $jumlahCuti = array_fill(0, count($labels), 0);
        
        $getIndex = function(string $date) use ($labels, $selectedMonth, $startDate, $endDate, $selectedTriwulan): ?int {
            try {
                $carbonDate = Carbon::parse($date);
                
                if ($selectedMonth) {
                    if ($carbonDate->month != $selectedMonth) {
                        return null;
                    }
                    $dayIndex = $carbonDate->day - 1;
                    return ($dayIndex >= 0 && $dayIndex < count($labels)) ? $dayIndex : null;
                }
                
                if ($startDate && $endDate) {
                    $start = Carbon::parse($startDate);
                    $end = Carbon::parse($endDate);
                    
                    if ($carbonDate->lt($start) || $carbonDate->gt($end)) {
                        return null;
                    }
                    
                    $diff = $start->diffInDays($carbonDate);
                    return ($diff >= 0 && $diff < count($labels)) ? $diff : null;
                }
                
                if ($selectedTriwulan) {
                    $startMonth = (($selectedTriwulan - 1) * 3) + 1;
                    $endMonth = $startMonth + 2;
                    
                    if ($carbonDate->month < $startMonth || $carbonDate->month > $endMonth) {
                        return null;
                    }
                    
                    $monthIndex = $carbonDate->month - $startMonth;
                    return ($monthIndex >= 0 && $monthIndex < count($labels)) ? $monthIndex : null;
                }
                
                $monthIndex = $carbonDate->month - 1;
                return ($monthIndex >= 0 && $monthIndex < count($labels)) ? $monthIndex : null;
                
            } catch (\Exception $e) {
                return null;
            }
        };
        
        foreach ($cutiTahunan as $cuti) {
            if (!$cuti->tgl_mulai) continue;
            
            $isApproved = false;
            if ($cuti->is_kabag) {
                $isApproved = $cuti->ctStatusUserAdmin && 
                             $cuti->ctStatusUserAdmin->ctStatusAdminKabal &&
                             $cuti->ctStatusUserAdmin->status === 'disetujui' &&
                             $cuti->ctStatusUserAdmin->ctStatusAdminKabal->status === 'disetujui';
            } elseif ($cuti->user && $cuti->user->role === 'widyaiswara') {
                $isApproved = $cuti->ctStatusUserAdmin && 
                             $cuti->ctStatusUserAdmin->status === 'disetujui';
            } else {
                $isApproved = $cuti->ctStatusUserAdmin &&
                             $cuti->ctStatusUserAdmin->ctStatusAdminKatimker &&
                             $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag &&
                             $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal &&
                             $cuti->ctStatusUserAdmin->ctStatusAdminKatimker->ctStatusKatimkerKabag->ctStatusKabagKabal->status === 'disetujui';
            }
            
            if ($isApproved) {
                $index = $getIndex($cuti->tgl_mulai);
                if ($index !== null && isset($jumlahCuti[$index])) {
                    $jumlahCuti[$index]++;
                }
            }
        }
        
        foreach ($cutiUmum as $cuti) {
            if (!$cuti->tgl_mulai) continue;
            
            $isApproved = false;
            if ($cuti->is_kabag) {
                $isApproved = $cuti->cuStatusUserAdmin && 
                             $cuti->cuStatusUserAdmin->cuStatusAdminKabal &&
                             $cuti->cuStatusUserAdmin->status === 'disetujui' &&
                             $cuti->cuStatusUserAdmin->cuStatusAdminKabal->status === 'disetujui';
            } elseif ($cuti->user && $cuti->user->role === 'widyaiswara') {
                $isApproved = $cuti->cuStatusUserAdmin && 
                             $cuti->cuStatusUserAdmin->status === 'disetujui';
            } else {
                $isApproved = $cuti->cuStatusUserAdmin &&
                             $cuti->cuStatusUserAdmin->cuStatusAdminKatimker &&
                             $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag &&
                             $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal &&
                             $cuti->cuStatusUserAdmin->cuStatusAdminKatimker->cuStatusKatimkerKabag->cuStatusKabagKabal->status === 'disetujui';
            }
            
            if ($isApproved) {
                $index = $getIndex($cuti->tgl_mulai);
                if ($index !== null && isset($jumlahCuti[$index])) {
                    $jumlahCuti[$index]++;
                }
            }
        }
        
        return $jumlahCuti;
    }
}