<?php

namespace Database\Seeders;

use App\Models\Terminal;
use Illuminate\Database\Seeder;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Terminal::truncate();
        $csvData = fopen(base_path('database/csv/terminal.csv'), 'r');

        $transRaw = true;

        while (($data = fgetcsv($csvData, '555', ',')) !== false) {
            if (! $transRaw) {
                Terminal::create([
                    'atm_id' => $data[0],
                    'alias_name' => $data[1],
                    'install_date' => $data[2],
                    'location' => $data[3],
                    'atm_type' => $data[4],
                    'bank' => $data[5],
                    'model' => $data[6],
                ]);
            }
            $transRaw = false;
        }
        fclose($csvData);
    }
}
