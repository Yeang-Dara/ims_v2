<?php 

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(){
        DB::table('customers')->delete();
        $customers = [
              
                [
                    "customer_name"=>"ABA Bank",
                ],
                [
                    "customer_name"=>"AMK MFI",
                ],
                [
                    "customer_name"=>"BTI Share",
                ],
                [
                    "customer_name"=>"Philip Bank",
                ],
                [
                    "customer_name"=>"WingBank",
                ],
            ];
        Customer::insert($customers);
    }
}