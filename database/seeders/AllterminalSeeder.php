<?php

namespace Database\Seeders;

use App\Models\Allterminal;
use Illuminate\Database\Seeder;


class AllterminalSeeder extends Seeder
{
    public function run(): void{
        Allterminal::truncate();
        $datas = fopen(base_path('database/csv/DataTerminal1.csv'), 'r');
        $transRow = true;
  
        while(($data = fgetcsv($datas,'1000', ',')) !== false){
          if(!$transRow){
            Allterminal::create([
  
                'atm_id' => $data[0],
                'serial_number' => $data[9],
                'alias_id' => $data[1],
                'install_date' => $data[3],
                'delivery_date' => $data[4],
                'takeover_date' => $data[5],
                'android_version' => $data[8],
                'model_id' => $data[7],
                'type_id' => $data[10],
                'banklocation_id' => $data[2],
                'category_id' => $data[6],
                'status_id' => $data[11],
                'warrenty' => $data[12],
            ]);
          }
          $transRow = false;
        }
        fclose($datas);
      }
}