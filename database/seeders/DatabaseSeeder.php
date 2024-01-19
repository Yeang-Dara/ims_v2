<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Terminalmodel;
use App\Models\Terminaltype;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $this->call(UserSeeder::class);
        $this->call(UsingSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(TerminalTypeSeeder::class);
        $this->call(TerminalmodelSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(TerminalstatusSeeder::class);
    }
}
