<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class LeaveController extends Controller
{
    /**
     * Calculate business days between dates, excluding holidays
 * Calculate business days between dates, excluding holidays
 * 
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\JsonResponse
    */
    public function calculateBusinessDays(Request $request)
    {
        // Validate the request
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'jenis_cuti' => 'required'
        ]);
        
        $tglMulai = new \DateTime($request->tgl_mulai);
        $tglSelesai = new \DateTime($request->tgl_selesai);
        
        // Get jenis cuti
        $jenisCuti = JenisCuti::find($request->jenis_cuti);
        
        // For sick leave and important reason leave, exclude holidays
        if ($jenisCuti && ($jenisCuti->nama_cuti == 'Cuti Sakit' || $jenisCuti->nama_cuti == 'Cuti Alasan Penting')) {
            // Fetch holidays from API
            $holidays = $this->fetchHolidaysFromAPI($tglMulai, $tglSelesai);
            
            // Calculate business days excluding weekends and holidays
            $businessDays = $this->countBusinessDays($tglMulai, $tglSelesai, $holidays);
            
            return response()->json([
                'jumlah_hari' => $businessDays,
                'holidays' => $holidays
            ]);
        } else {
            // For other leave types, use the existing calculation
            return $this->hitungDurasiCuti($request);
        }
    }

    /**
     * Calculate leave duration (existing method)
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hitungDurasiCuti(Request $request)
    {
        // Validate the request
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai'
        ]);
        
        $tglMulai = new \DateTime($request->tgl_mulai);
        $tglSelesai = new \DateTime($request->tgl_selesai);
        
        // Calculate the difference in days
        $interval = $tglMulai->diff($tglSelesai);
        $days = $interval->days + 1; // Include both start and end date
        
        return response()->json([
            'jumlah_hari' => $days
        ]);
    }

    /**
     * Fetch holidays from API
     * 
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return array
     */
    private function fetchHolidaysFromAPI(\DateTime $startDate, \DateTime $endDate)
    {
        $startYear = $startDate->format('Y');
        $endYear = $endDate->format('Y');
        
        $allHolidays = [];
        
        // Get holidays for each year in the range
        for ($year = $startYear; $year <= $endYear; $year++) {
            $url = "https://libur.deno.dev/api?year=" . $year;
            
            try {
                $response = Http::get($url);
                
                if ($response->successful()) {
                    $holidays = $response->json();
                    
                    foreach ($holidays as $holiday) {
                        $holidayDate = new \DateTime($holiday['date']);
                        
                        // Only include holidays within our date range
                        if ($holidayDate >= $startDate && $holidayDate <= $endDate) {
                            $allHolidays[] = [
                                'date' => $holiday['date'],
                                'name' => $holiday['name'] ?? 'Hari Libur Nasional'
                            ];
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching holidays: ' . $e->getMessage());
            }
        }
        
        return $allHolidays;
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param array $holidays
     * @return int
     */
    private function countBusinessDays(\DateTime $startDate, \DateTime $endDate, array $holidays)
    {
        // Convert holidays array to simple date strings for easier comparison
        $holidayDates = array_map(function($holiday) {
            return $holiday['date'];
        }, $holidays);
        
        // Kasus khusus: jika start date dan end date sama
        if ($startDate->format('Y-m-d') === $endDate->format('Y-m-d')) {
            // Jika hari kerja (bukan akhir pekan) dan bukan hari libur
            $dayOfWeek = (int)$startDate->format('w'); // 0 = Minggu, 6 = Sabtu
            $dateString = $startDate->format('Y-m-d');
            
            if ($dayOfWeek !== 0 && $dayOfWeek !== 6 && !in_array($dateString, $holidayDates)) {
                return 1; // Hitung sebagai 1 hari kerja
            } else {
                return 0; // Bukan hari kerja
            }
        }
        
        $workDays = 0;
        $currentDate = clone $startDate;
        
        while ($currentDate <= $endDate) {
            // Jika bukan akhir pekan (0 = Minggu, 6 = Sabtu) dan bukan hari libur
            $dayOfWeek = (int)$currentDate->format('w');
            $dateString = $currentDate->format('Y-m-d');
            
            if ($dayOfWeek !== 0 && $dayOfWeek !== 6 && !in_array($dateString, $holidayDates)) {
                $workDays++;
            }
            
            $currentDate->modify('+1 day');
        }
        
        return $workDays;
    }
}