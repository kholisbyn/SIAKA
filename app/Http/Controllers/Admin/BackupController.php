<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Symfony\Component\Process\Process;

class BackupController extends Controller
{
    public function backup()
    {
        $filename = 'siaka_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

        $path = storage_path('app/' . $filename);

        $process = new Process([
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            '-h',
            env('DB_HOST', '127.0.0.1'),
            '-u',
            env('DB_USERNAME', 'root'),
            '--password=' . env('DB_PASSWORD', ''),
            env('DB_DATABASE', 'siaka'),
        ]);

        $process->setTimeout(120);

        $process->run();

        if (!$process->isSuccessful()) {
            return back()->with(
                'error',
                'Backup gagal: ' . $process->getErrorOutput()
            );
        }

        $output = $process->getOutput();

        if (empty($output)) {
            return back()->with(
                'error',
                'Backup gagal karena data kosong.'
            );
        }

        file_put_contents($path, $output);

        if (!file_exists($path) || filesize($path) === 0) {
            return back()->with(
                'error',
                'File backup gagal dibuat.'
            );
        }

        return response()->download(
            $path,
            $filename,
            [
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}