<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TicketsImport;
use App\Models\CsvData;

class TicketController extends Controller
{

    public function getAll() {
        $ticket = Ticket::all();
        return response()->json($ticket->toJson());
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Store the file in the local storage
            $path = $file->store('csv_files');

            // Read and parse the CSV file data
            $csvData = array_map('str_getcsv', file($file->getPathname()));

            $header = array_shift($csvData);

            foreach ($csvData as $row) {
                if (count($row) >= 13) {
                    CsvData::create([
                        'ticket_id' => $row[0],
                        'diagnosis' => $row[1],
                        'terminal_id' => $row[2],
                        'atm_id' => $row[3],
                        'created_time' => $row[4],
                        'end_time' => $row[5],
                        'down_time' =>$row[6],
                        'model' => $row[7],
                        'atm_type' => $row[8],
                        'atm_classification' => $row[9],
                        'atm_down' => $row[10],
                        'issue' => $row[12],
                        'action_taken' => $row[11],
                    ]);
                }
            }
            // Return the path or perform additional processing as needed
            return response()->json(['message' => 'File uploaded successfully', 'path' => $path, 'data' => $csvData]);
        } else {
            return response()->json(['message' => 'No file uploaded'], 400);
        }
    }

    public function csvToJson(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $header = $csv->fetchOne();
        $data = [];
        $csv->setHeaderOffset(0);
        foreach ($csv->getRecords() as $record) {
            $data[] = array_combine($header, $record);
        }
        return response()->json($data);
    }

    public function index()
    {
        $data = DB::table('tickets')->orderBy('ticket_id', 'DES')
                ->get();
        return view('import_execl', compact('data'));
    }
    public function processCsv(Request $request)
    {
        // Retrieve the uploaded file from the request
        $uploadedFile = $request->file('file');

        if ($uploadedFile) {
            // Open the uploaded file
            $file = fopen($uploadedFile->getRealPath(), 'r');

            if ($file) {
                // Skip the header row if it exists
                fgetcsv($file);

                while (($row = fgetcsv($file)) !== false) {
                    if (count($row) >= 13) {
                        try {
                            DB::table('tickets')->insert([
                                'ticket_id' => $row[0],
                                'diagnosis' => $row[1],
                                'terminal_id' => $row[2],
                                'atm_id' => $row[3],
                                'created_time' => $row[4],
                                'end_time' => $row[5],
                                'down_time' => $row[6],
                                'model' => $row[7],
                                'atm_type' => $row[8],
                                'atm_classification' => $row[9],
                                'atm_down' => $row[10],
                                'issue' => $row[12],
                                'action_taken' => $row[11],
                            ]);
                        } catch (\Exception $e) {
                            // Handle the exception or log the error message for debugging
                            echo "Error: " . $e->getMessage();
                        }
                    }
                }
                fclose($file);
            } else {
                echo "Failed to open the CSV file.";
            }
        } else {
            echo "No file uploaded.";
        }
    }

}

