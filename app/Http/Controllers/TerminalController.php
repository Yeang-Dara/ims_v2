<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    public function import(Request $request) {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Store the file in the local storage
            $path = $file->store('csv_files');
             // Read and parse the CSV file data
             $csvData = array_map('str_getcsv', file($file->getPathname()));

             $header = array_shift($csvData);

            foreach ($csvData as $row) {
                if (count($row) >= 8) {
                    Terminal::create([
                        'atm_id' => $row[0],
                        'alias_name' => $row[1],
                        'install_date' => $row[2],
                        'location' => $row[3],
                        'atm_type' => $row[4],
                        'bank' => $row[5],
                        'model' => $row[6],
                        'active' => $row[7],
                        // Add more columns as needed
                    ]);
                }

            }
            // Return the path or perform additional processing as needed
            return response()->json(['message' => 'File uploaded successfully', 'data' => $csvData]);
        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }

    }
}
