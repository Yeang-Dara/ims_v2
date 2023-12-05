<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::truncate();
        $csvData = fopen(base_path('database/csv/ticket.csv'), 'r');

        $transRaw = true;

        while (($data = fgetcsv($csvData, '555', ',')) !== false) {
            if (! $transRaw) {
                Ticket::create([
                    'ticket_id' => $data[0],
                    'atm_id' => $data[1],
                    'model' => $data[2],
                    'terminal_id' => $data[3],
                    'atm_type' => $data[4],
                    'created_time' => $data[5],
                    'issue' => $data[6],
                    'end_time' => $data[7],
                    'atm_down' => $data[8],
                    'diagnosis' => $data[9],
                    'action_taken' => $data[10],
                    'categories' => $data[11],
                ]);
            }
            $transRaw = false;
        }
        fclose($csvData);
    }
}
