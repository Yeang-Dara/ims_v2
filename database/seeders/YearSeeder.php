<?php

namespace Database\Seeders;

use App\Models\HR\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('years')->delete();

        $years = [
            [
                'year_number' => 2023,
            ],
            [
                'year_number' => 2024,
            ]
        ];

        Year::insert($years);
    }
}
