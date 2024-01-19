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
<<<<<<< HEAD
        $this -> call(DepartmentSeeder::class);
        $this -> call(UserSeeder::class);
        $this -> call(LeaveSeeder::class);
        $this -> call(StatusSeeder::class);
        $this -> call(YearSeeder::class);
        $this -> call(RolesTableSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this -> call(TicketSeeder::class);
        // $this -> call(TerminalSeeder::class);
        // $this->call(UserSeeder::class);
=======
       
        $this->call(UserSeeder::class);
>>>>>>> d71c5e18e877df8591686f41273adb75feb44b51
        $this->call(UsingSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SiteSeeder::class);
        $this->call(TerminalTypeSeeder::class);
        $this->call(TerminalmodelSeeder::class);
        $this->call(CategorySeeder::class);
    }
}
