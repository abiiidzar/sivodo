<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Voting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk statistik
        $total_dosen = Dosen::count();
        $total_mahasiswa = Mahasiswa::count();
        $total_mata_kuliah = MataKuliah::count();
        $total_voting = Voting::count();

        // Data untuk activity log
        $recent_activities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recent_dosen = Dosen::latest()
            ->take(5)
            ->get();

        // Data untuk chart voting
        $votingData = $this->getVotingChartData();

        return view('admin.dashboard', compact(
            'total_dosen',
            'total_mahasiswa',
            'total_mata_kuliah',
            'total_voting',
            'recent_activities',
            'recent_dosen',
            'votingData' // Tambahkan ini
        ));
    }

    /**
     * Get voting data for chart
     */
    private function getVotingChartData()
    {
        try {
            // Coba ambil data voting per bulan
            $votingData = Voting::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $months = [];
            $counts = [];

            for ($i = 1; $i <= 12; $i++) {
                $monthName = date('F', mktime(0, 0, 0, $i, 1));
                $months[] = $monthName;

                $found = $votingData->firstWhere('month', $i);
                $counts[] = $found ? $found->total : 0;
            }

            return [
                'labels' => $months,
                'data' => $counts,
            ];
        } catch (\Exception $e) {
            // Jika error, return data dummy
            return [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                'data' => [0, 0, 0, 0, 0, 0],
            ];
        }
    }
}
