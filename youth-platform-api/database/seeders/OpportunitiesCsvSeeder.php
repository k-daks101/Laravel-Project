<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OpportunitiesCsvSeeder extends Seeder
{
    public function run(): void
    {
        $folder = 'opportunities_chunks';
        $path = storage_path("app/$folder");

        echo "📁 Looking inside: $path\n";

        $files = scandir($path);
        echo "📂 Files found:\n";
        print_r($files);

        foreach ($files as $fileName) {
            if (in_array($fileName, ['.', '..'])) continue;

            $filePath = $path . DIRECTORY_SEPARATOR . $fileName;
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $header = null;

            foreach ($lines as $index => $line) {
                $row = str_getcsv($line);
                if (!$header) {
                    $header = $row;
                    continue;
                }

                if (count($header) !== count($row)) {
                    echo "⚠️ Skipped row in $fileName at line " . ($index + 1) . ": Column count mismatch\n";
                    continue;
                }

                $data = array_combine($header, $row);

                if (!$data || empty($data['Name'])) {
                    echo "⚠️ Skipped row in $fileName at line " . ($index + 1) . ": Missing required 'Name'\n";
                    continue;
                }

                DB::table('opportunities')->insert([
                    'name' => $data['Name'] ?? null,
                    'description' => $data['Description'] ?? null,
                    'url' => $data['URL'] ?? null,
                    'criteria' => $data['Criteria'] ?? null,
                    'country_region' => $data['Country/Region'] ?? null,
                    'deadline' => date('Y-m-d', strtotime($data['Deadline'] ?? '1970-01-01')),
                    'type' => $data['Type'] ?? null,
                    'funding_salary' => $data['Funding/Salary'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            echo "✅ Seeded: $fileName\n";
        }
    }
}
