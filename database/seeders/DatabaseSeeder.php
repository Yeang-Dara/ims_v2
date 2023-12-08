<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
        // $this->call(UsingSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(SiteSeeder::class);
    }
}
