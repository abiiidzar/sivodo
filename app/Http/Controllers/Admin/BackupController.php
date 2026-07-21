<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('local')->files('backups');
        $backupList = [];

        foreach ($backups as $backup) {
            $backupList[] = (object) [
                'name' => basename($backup),
                'path' => $backup,
                'size' => Storage::disk('local')->size($backup),
                'date' => Storage::disk('local')->lastModified($backup),
            ];
        }

        usort($backupList, function ($a, $b) {
            return $b->date <=> $a->date;
        });

        return view('admin.backup.index', compact('backupList'));
    }

    public function create()
    {
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        // Buat folder jika belum ada
        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Dapatkan konfigurasi database
        $db = config('database.connections.mysql');
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            $db['username'],
            $db['password'],
            $db['host'],
            $db['database'],
            $path
        );

        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            return redirect()->back()->with('success', 'Backup berhasil dibuat!');
        }

        return redirect()->back()->with('error', 'Gagal membuat backup!');
    }

    public function download($filename)
    {
        $path = 'backups/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('local')->download($path);
    }

    public function delete($filename)
    {
        $path = 'backups/' . $filename;

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            return redirect()->back()->with('success', 'File backup berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan!');
    }

    public function restore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:sql|max:51200',
        ]);

        $file = $request->file('file');
        $path = $file->getPathname();

        $db = config('database.connections.mysql');
        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s',
            $db['username'],
            $db['password'],
            $db['host'],
            $db['database'],
            $path
        );

        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            return redirect()->back()->with('success', 'Database berhasil direstore!');
        }

        return redirect()->back()->with('error', 'Gagal merestore database!');
    }
}
