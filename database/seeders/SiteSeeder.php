<?php 
namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SiteSeeder extends Seeder
{
    public function run()
    {
          DB::table('sites')->delete();
        $sites =[
                [
                    "site_name"=>"2nd ATM",
                ],
                [
                    "site_name"=>"AEON 2",
                ],
                [
                    "site_name"=>"AEON 3",
                ],
                [
                    "site_name"=>"Branch Site",
                ],
                [
                    "site_name"=>"LOBBY",
                ],
                 [
                    "site_name"=>"MALL",
                ],
                 [
                    "site_name"=>"OffSite",
                ],
                [
                    "site_name"=>"OnSite",
                ],
                 [
                    "site_name"=>"UAT",
                ],
           
         ];
          Site::insert($sites);
    }
}