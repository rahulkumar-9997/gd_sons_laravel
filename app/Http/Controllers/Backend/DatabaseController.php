<?php
namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class DatabaseController extends Controller
{
    public function showTables()
    {
        $tables = DB::select('SHOW TABLES');
        $database = env('DB_DATABASE');
        $tableNames = array_map(function ($table) use ($database) {
            return $table->{'Tables_in_' . $database};
        }, $tables);

        return view('backend.database.index', compact('tableNames'));
    }

    public function truncateTables(Request $request){
        $selectedTables = $request->input('tables');

        if (!$selectedTables || count($selectedTables) === 0) {
            return back()->with('error', 'No tables selected for truncation.');
        }

        try {
            foreach ($selectedTables as $table) {
               //DB::table($table)->truncate();
            }
            return back()->with('success', 'Selected tables truncated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to truncate tables: ' . $e->getMessage());
        }
    }

    public function backupDatabase()
    {
        try {
            $backupFileName = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $backupPath = storage_path('app/backups/' . $backupFileName);
            
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host = env('DB_HOST');
            $port = env('DB_PORT');
            $mysqldumpPath = exec('which mysqldump') ?: '/usr/bin/mysqldump';
            //$mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe'; 
            if (!file_exists($mysqldumpPath)) {
                throw new \Exception('mysqldump command not found at '.$mysqldumpPath);
            }
            $password = escapeshellarg($password);
            $command = sprintf(
                '%s --user=%s --password=%s --host=%s --port=%s %s > %s',
                $mysqldumpPath,
                escapeshellarg($username),
                $password,
                escapeshellarg($host),
                escapeshellarg($port),
                escapeshellarg($database),
                escapeshellarg($backupPath)
            );

            $output = [];
            $result = null;
            exec($command . ' 2>&1', $output, $result);
            
            Log::info('Backup command output: ' . implode("\n", $output));
            Log::info('Backup command result: ' . $result);
            
            if ($result === 0) {
                return response()->download($backupPath, $backupFileName)->deleteFileAfterSend(true);
            } else {
                throw new \Exception('Backup command failed. Exit code: ' . $result . '. Output: ' . implode("\n", $output));
            }
        } catch (\Exception $e) {
            Log::error('Database backup failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create database backup: ' . $e->getMessage());
        }
    }

}


