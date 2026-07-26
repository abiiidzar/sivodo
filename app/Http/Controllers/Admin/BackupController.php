<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

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

        $db = config('database.connections.mysql');

        // Cari path mysqldump yang tersedia
        $mysqldump = $this->findMysqldumpPath();

        if (!$mysqldump) {
            return redirect()->back()->with('error', 'Tidak ditemukan mysqldump. Pastikan MySQL terinstal.');
        }

        // === DEBUG: Tampilkan command yang dijalankan ===
        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s %s > "%s" 2>&1',
            $mysqldump,
            $db['username'],
            $db['password'],
            $db['host'],
            $db['database'],
            $path
        );

        // Simpan command ke log untuk debug
        Log::info('Backup Command: ' . $command);

        // Jalankan command
        exec($command, $output, $returnCode);

        // === DEBUG: Tampilkan output ===
        Log::info('Backup Return Code: ' . $returnCode);
        Log::info('Backup Output: ' . implode("\n", $output));

        if ($returnCode === 0 && file_exists($path) && filesize($path) > 0) {
            return response()->download($path, $filename);
        }

        $errorMsg = implode("\n", $output);
        return redirect()->back()->with('error', 'Gagal membuat backup! Error: ' . $errorMsg);
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

        // === CEK ISI FILE ===
        $fileContent = File::get($path);
        $fileSize = File::size($path);

        Log::info('=== RESTORE DEBUG ===');
        Log::info('File size: ' . $fileSize . ' bytes');
        Log::info('File path: ' . $path);

        // Cek apakah file berisi data SQL
        if ($fileSize < 100) {
            return redirect()->back()->with('error', 'File SQL terlalu kecil (' . $fileSize . ' bytes). Pastikan file backup valid dan berisi data.');
        }

        // Cek apakah ada keyword SQL penting
        if (!str_contains($fileContent, 'CREATE TABLE') && !str_contains($fileContent, 'INSERT INTO')) {
            Log::warning('File SQL tidak mengandung CREATE TABLE atau INSERT INTO');
            return redirect()->back()->with('error', 'File SQL tidak valid (tidak mengandung struktur tabel atau data).');
        }

        $db = config('database.connections.mysql');

        // Cari path mysql yang tersedia
        $mysql = $this->findMysqlPath();

        if (!$mysql) {
            return redirect()->back()->with('error', 'Tidak ditemukan mysql. Pastikan MySQL terinstal.');
        }

        // === BACA FILE DAN JALANKAN PER QUERY (UNTUK MENGHINDARI ERROR) ===
        $sqlContent = File::get($path);

        // Pisahkan query berdasarkan ";" (tapi hati-hati dengan delimiter)
        $queries = explode(";\n", $sqlContent);
        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        // Matikan foreign key checks untuk menghindari error constraint
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Log::info('Foreign key checks disabled');
        } catch (\Exception $e) {
            Log::warning('Could not disable foreign key checks: ' . $e->getMessage());
        }

        foreach ($queries as $query) {
            $query = trim($query);
            if (empty($query)) {
                continue;
            }

            // Skip komentar
            if (str_starts_with($query, '--') || str_starts_with($query, '/*')) {
                continue;
            }

            try {
                DB::statement($query);
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = $e->getMessage();
                Log::warning('Query failed: ' . $query . ' - Error: ' . $e->getMessage());
            }
        }

        // Aktifkan kembali foreign key checks
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (\Exception $e) {
            Log::warning('Could not enable foreign key checks: ' . $e->getMessage());
        }

        Log::info('Restore completed. Success: ' . $successCount . ', Errors: ' . $errorCount);

        if ($errorCount > 0 && $successCount === 0) {
            return redirect()->back()->with('error', 'Gagal merestore database! Semua query gagal. Error pertama: ' . ($errors[0] ?? 'Unknown error'));
        }

        if ($errorCount > 0) {
            return redirect()->back()->with('warning', 'Restore selesai dengan ' . $errorCount . ' error. ' . $successCount . ' query berhasil dijalankan. Error: ' . implode('; ', array_slice($errors, 0, 3)));
        }

        return redirect()->back()->with('success', 'Database berhasil direstore! ' . $successCount . ' query dijalankan.');
    }

    /**
     * Cari path mysqldump yang tersedia
     */
    private function findMysqldumpPath()
    {
        $paths = [
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.31-winx64\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.32-winx64\\bin\\mysqldump.exe',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                Log::info('Found mysqldump at: ' . $path);
                return $path;
            }
        }

        // Coba cari di PATH
        $output = shell_exec('where mysqldump 2>nul');
        if ($output) {
            Log::info('Found mysqldump in PATH: ' . trim($output));
            return trim($output);
        }

        Log::error('mysqldump not found!');
        return null;
    }

    /**
     * Cari path mysql yang tersedia
     */
    private function findMysqlPath()
    {
        $paths = [
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.31-winx64\\bin\\mysql.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.32-winx64\\bin\\mysql.exe',
            'C:\\xampp\\mysql\\bin\\mysql.exe',
            'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql.exe',
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                Log::info('Found mysql at: ' . $path);
                return $path;
            }
        }

        // Coba cari di PATH
        $output = shell_exec('where mysql 2>nul');
        if ($output) {
            Log::info('Found mysql in PATH: ' . trim($output));
            return trim($output);
        }

        Log::error('mysql not found!');
        return null;
    }

    /**
     * Cek path MySQL yang tersedia (untuk debugging)
     */
    public function checkMysql()
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        $paths = [];
        if ($isWindows) {
            $mysqlPaths = [
                'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysql.exe',
                'C:\\laragon\\bin\\mysql\\mysql-8.0.31-winx64\\bin\\mysql.exe',
                'C:\\laragon\\bin\\mysql\\mysql-8.0.32-winx64\\bin\\mysql.exe',
                'C:\\xampp\\mysql\\bin\\mysql.exe',
                'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysql.exe',
            ];

            foreach ($mysqlPaths as $path) {
                $paths[] = [
                    'path' => $path,
                    'exists' => file_exists($path) ? '✅' : '❌'
                ];
            }

            // Cek di PATH
            $output = shell_exec('where mysql 2>nul');
            if ($output) {
                $paths[] = [
                    'path' => trim($output) . ' (dari PATH)',
                    'exists' => '✅'
                ];
            }
        }

        return response()->json([
            'os' => $isWindows ? 'Windows' : 'Linux/Mac',
            'mysql_paths' => $paths,
            'db_config' => [
                'database' => config('database.connections.mysql.database'),
                'host' => config('database.connections.mysql.host'),
                'username' => config('database.connections.mysql.username'),
            ]
        ]);
    }

    /**
     * Cek isi file backup (untuk debugging)
     */
    public function previewBackup($filename)
    {
        $path = 'backups/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $content = Storage::disk('local')->get($path);
        $lines = explode("\n", $content);
        $firstLines = array_slice($lines, 0, 50);

        return response()->json([
            'filename' => $filename,
            'size' => Storage::disk('local')->size($path) . ' bytes',
            'preview' => $firstLines,
            'total_lines' => count($lines),
        ]);
    }
}
