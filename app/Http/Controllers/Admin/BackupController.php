<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function index()
    {
        $backupDir = storage_path('app/backups');
        $backupList = [];

        if (is_dir($backupDir)) {
            $files = array_filter(scandir($backupDir), function ($item) use ($backupDir) {
                if ($item === '.' || $item === '..') {
                    return false;
                }

                return is_file($backupDir . DIRECTORY_SEPARATOR . $item);
            });

            foreach ($files as $file) {
                $path = $backupDir . DIRECTORY_SEPARATOR . $file;
                $backupList[] = (object) [
                    'name' => $file,
                    'path' => $path,
                    'size' => filesize($path),
                    'date' => filemtime($path),
                ];
            }
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

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $db = config('database.connections.mysql');
        $mysqldump = $this->findMysqldumpPath();

        if (!$mysqldump) {
            return redirect()->back()->with('error', 'Tidak ditemukan mysqldump. Pastikan MySQL terinstal.');
        }

        // Jangan sertakan --password jika kosong untuk menghindari warning
        $credentials = "--user={$db['username']} --host={$db['host']}";
        if (!empty($db['password'])) {
            $credentials .= " --password={$db['password']}";
        }

        // --add-drop-table agar saat restore, tabel lama ditimpa
        $command = sprintf(
            '"%s" %s --add-drop-table %s > "%s" 2>&1',
            $mysqldump,
            $credentials,
            $db['database'],
            $path
        );

        exec($command, $output, $returnCode);

        if ($returnCode === 0 && file_exists($path) && filesize($path) > 0) {
            return response()->download($path, $filename);
        }

        return redirect()->back()->with('error', 'Gagal membuat backup! Error: ' . implode("\n", $output));
    }

    public function download($filename)
    {
        $path = storage_path('app/backups/' . $filename);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        return response()->download($path, $filename);
    }

    public function delete($filename)
    {
        $path = storage_path('app/backups/' . $filename);

        if (file_exists($path)) {
            @unlink($path);
            return redirect()->back()->with('success', 'File backup berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'File tidak ditemukan!');
    }

    public function restore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $mysql = $this->findMysqlPath();

        if (!$mysql) {
            return redirect()->back()->with('error', 'Tidak ditemukan mysql.exe. Pastikan MySQL terinstal di server.');
        }

        $db = config('database.connections.mysql');

        // 1. Pindahkan file upload ke folder storage
        $file = $request->file('file');
        $tempPath = storage_path('app/backups/restore_temp.sql');

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $file->move(storage_path('app/backups'), 'restore_temp.sql');

        // 2. Siapkan credentials
        $credentials = "--user={$db['username']} --host={$db['host']}";
        if (!empty($db['password'])) {
            $credentials .= " --password={$db['password']}";
        }

        // 3. PERBAIKAN UTAMA:
        // Ubah path backslash (\) menjadi slash (/) agar bisa dibaca oleh perintah source MySQL
        $sourcePath = str_replace('\\', '/', $tempPath);

        // Gunakan perintah -e "source ..." agar mysql.exe membaca file-nya sendiri tanpa pipe cmd
        $command = sprintf(
            '"%s" %s %s -e "source %s" 2>&1',
            $mysql,
            $credentials,
            $db['database'],
            $sourcePath
        );

        // Eksekusi command
        exec($command, $output, $returnCode);

        // 4. Hapus file sementara
        @unlink($tempPath);

        // Catat log
        Log::info('Restore Command: ' . $command);
        Log::info('Restore Return Code: ' . $returnCode);
        Log::info('Restore Output: ' . implode("\n", $output));

        // Cek hasil eksekusi
        if ($returnCode === 0 && empty($output)) {
            ActivityLog::logActivity(
                auth()->id(),
                'Restore Database',
                "Berhasil merestore database dari file: " . $file->getClientOriginalName()
            );

            return redirect()->back()->with('success', 'Database berhasil direstore! Silakan refresh halaman untuk melihat perubahan data.');
        }

        // Jika ada output error dari mysql, tampilkan ke layar
        $errorMsg = "Return Code: {$returnCode}\n";
        $errorMsg .= "Output Sistem: " . implode("\n", $output) . "\n";

        return redirect()->back()->with('error', 'Gagal merestore database! Detail Error: ' . $errorMsg);
    }
        public function restoreFromList($filename)
    {
        $mysql = $this->findMysqlPath();

        if (!$mysql) {
            return redirect()->back()->with('error', 'Tidak ditemukan mysql.exe. Pastikan MySQL terinstal di server.');
        }

        $db = config('database.connections.mysql');

        // Path file backup yang ada di storage
        $tempPath = storage_path('app/backups/' . $filename);

        if (!file_exists($tempPath)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan di server!');
        }

        // Siapkan credentials
        $credentials = "--user={$db['username']} --host={$db['host']}";
        if (!empty($db['password'])) {
            $credentials .= " --password={$db['password']}";
        }

        // Ubah path backslash (\) menjadi slash (/)
        $sourcePath = str_replace('\\', '/', $tempPath);

        // Gunakan perintah -e "source ..."
        $command = sprintf(
            '"%s" %s %s -e "source %s" 2>&1',
            $mysql,
            $credentials,
            $db['database'],
            $sourcePath
        );

        // Eksekusi command
        exec($command, $output, $returnCode);

        // Catat log
        Log::info('Restore List Command: ' . $command);
        Log::info('Restore List Return Code: ' . $returnCode);
        Log::info('Restore List Output: ' . implode("\n", $output));

        if ($returnCode === 0 && empty($output)) {
            ActivityLog::logActivity(
                auth()->id(),
                'Restore Database',
                "Berhasil merestore database dari daftar file: " . $filename
            );

            return redirect()->back()->with('success', 'Database berhasil direstore dari daftar! Silakan refresh halaman.');
        }

        $errorMsg = "Return Code: {$returnCode}\n";
        $errorMsg .= "Output Sistem: " . implode("\n", $output) . "\n";

        return redirect()->back()->with('error', 'Gagal merestore database! Detail Error: ' . $errorMsg);
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

        $output = shell_exec('where mysqldump 2>nul');
        if ($output) {
            return trim($output);
        }

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

        $output = shell_exec('where mysql 2>nul');
        if ($output) {
            return trim($output);
        }

        return null;
    }

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

            $output = shell_exec('where mysql 2>nul');
            if ($output) {
                $paths[] = ['path' => trim($output) . ' (dari PATH)', 'exists' => '✅'];
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

    public function previewBackup($filename)
    {
        $path = storage_path('app/backups/' . $filename);

        if (!file_exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        $content = file_get_contents($path);
        $lines = explode("\n", $content);
        $firstLines = array_slice($lines, 0, 50);

        return response()->json([
            'filename' => $filename,
            'size' => filesize($path) . ' bytes',
            'preview' => $firstLines,
            'total_lines' => count($lines),
        ]);
    }

}
