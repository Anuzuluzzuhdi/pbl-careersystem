<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

abstract class CsvSeeder extends Seeder
{
    protected function importCsv(string $filePath, string $table, array $columnMap = []): void
    {
        $rows = $this->parseCsv($filePath);
        if (empty($rows)) {
            return;
        }

        foreach ($rows as $row) {
            $insert = [];

            if ($columnMap === []) {
                $insert = $row;
            } else {
                foreach ($columnMap as $csvKey => $columnName) {
                    $insert[$columnName] = $row[$csvKey] ?? null;
                }
            }

            DB::table($table)->insert($insert);
        }
    }

    protected function parseCsv(string $relativePath): array
    {
        $path = base_path($relativePath);
        if (!file_exists($path)) {
            return [];
        }

        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $headers = fgetcsv($handle);
            if ($headers === false) {
                fclose($handle);
                return [];
            }

            $headers = array_map(fn ($header) => trim($header), $headers);
            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) !== count($headers)) {
                    continue;
                }

                $rows[] = array_combine($headers, $data);
            }
            fclose($handle);
        }

        return $rows;
    }
}
