<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupAndTruncateService
{
    /**
     * Backup and truncate specified tables.
     *
     * @param array $tables
     * @return void
     */
    public function backupAndTruncate(array $tables)
    {
        foreach ($tables as $table) {
            // Backup table
            $this->backupTable($table);

            // Truncate table
//            DB::table($table)->truncate();
        }
    }

    /**
     * Backup the specified table.
     *
     * @param string $table
     * @return void
     */
    private function backupTable($table)
    {
        $data = DB::table($table)->get();

        $filePath = "backups/{$table}_" . now()->format('Y-m-d_H-i-s') . '.json';

        Storage::put($filePath, $data->toJson());

        // Optionally, log the backup operation
        info("Backed up table: $table to $filePath");
    }
}
