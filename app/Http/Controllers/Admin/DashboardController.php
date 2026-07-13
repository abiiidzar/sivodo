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


        // Data untuk grafik (contoh)
        $votingData = Voting::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $data = [
            'total_dosen' => Dosen::count(),
            'total_mahasiswa' => Mahasiswa::count(),
            'total_mata_kuliah' => MataKuliah::count(),
            'total_voting' => Voting::count(),
        ];

        return view('admin.dashboard', compact(
            'totalDosen',
            'totalMahasiswa',
            'totalMataKuliah',
            'totalVoting',
            'votingData',
            'recentActivities',
            'data'
        ));
    }
}
