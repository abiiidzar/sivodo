<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('aktivitas', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('role', $request->role);
            });
        }

        $logs = $query->latest()->paginate(20);
        $logs->appends($request->all());

        return view('admin.activity-log.index', compact('logs'));
    }

    public function export()
    {
        return redirect()->back()->with('info', 'Fitur export dalam pengembangan');
    }

    public function clear()
    {
        ActivityLog::truncate();
        return redirect()->back()->with('success', 'Semua activity log berhasil dihapus!');
    }
}
