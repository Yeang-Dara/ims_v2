<?php

namespace Database\Seeders;

use App\Models\HR\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'last_name' => 'admin',
            'first_name' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => '1',
            'password' => bcrypt('password')
        ]);

        User::create([
            'last_name' => 'Yip',
            'first_name' => 'David',
            'name' => 'David',
            'email' => 'davidy@btipayments.com.sg',
            'role_id' => '3',
            'password' => bcrypt('123456')
        ]);

        $user = [
            [
                'last_name' => 'Nou',
                'first_name' => 'Savoeun',
                'name' => 'Savoeunn',
                'email' => 'savoeunn@btipayments.com.sg',
                'dept_id' => 2,
                'gender' => 'Male',
                'address' => 'Phnom Penh',
                'start_date' => '2022-08-01',
                'phone' => '089 888 501',
                'role_id' => 5,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'Srey',
                'first_name' => 'Botin',
                'name' => 'Botins',
                'email' => 'botins@btipayments.com.sg',
                'dept_id' => 2,
                'gender' => 'Male',
                'address' => 'Phnom Penh',
                'start_date' => '2022-02-14',
                'phone' => '086 665 251',
                'role_id' => 2,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'Soy',
                'first_name' => 'Chanpiseth',
                'name' => 'Chanpiseths',
                'email' => 'piseths@btipayments.com.sg',
                'dept_id' => 2,
                'gender' => 'Male',
                'address' => 'Phnom Penh',
                'start_date' => '2022-02-14',
                'phone' => '078 503 388',
                'role_id' => 2,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'Soth',
                'first_name' => 'Sopheaparinha',
                'name' => 'Sopheaparinhas',
                'email' => 'parinhas@btipayments.com.sg',
                'dept_id' => 2,
                'gender' => 'Male',
                'address' => 'Phnom Penh',
                'start_date' => '2022-02-14',
                'phone' => '086 873 700',
                'role_id' => 2,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'Keo',
                'first_name' => 'Sereipichey',
                'name' => 'Sereipicheyk',
                'email' => 'picheyk@btipayments.com.sg',
                'dept_id' => 3,
                'gender' => 'Female',
                'address' => 'Phnom Penh',
                'start_date' => '2022-02-14',
                'phone' => '097 339 9111',
                'role_id' => 4,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'Lor',
                'first_name' => 'Pheary',
                'name' => 'Phearyl',
                'email' => 'phearyl@btipayments.com.sg',
                'dept_id' => 6,
                'gender' => 'Female',
                'address' => 'Phnom Penh',
                'start_date' => '2023-07-01',
                'phone' => '077 227 350',
                'role_id' => 6,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'Yeang',
                'first_name' => 'Dara',
                'name' => 'Daray',
                'email' => 'daray@btipayments.com.sg',
                'dept_id' => 2,
                'gender' => 'Male',
                'address' => 'Phnom Penh',
                'start_date' => '2022-02-14',
                'phone' => '086 873 700',
                'role_id' => 2,
                'password' => bcrypt('123456')
            ],
            [
                'last_name' => 'An',
                'first_name' => 'Sreykhouch',
                'name' => 'Sreykhoucha',
                'email' => 'sreykhoucha@btipayments.com.sg',
                'dept_id' => 2,
                'gender' => 'Female',
                'address' => 'Phnom Penh',
                'start_date' => '2022-02-14',
                'phone' => '086 873 700',
                'role_id' => 2,
                'password' => bcrypt('123456')
            ],
        ];

        User::insert($user);
    }
}
