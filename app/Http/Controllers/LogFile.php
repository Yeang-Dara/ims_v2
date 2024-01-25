<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use App\Models\LogEntry;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;


class LogFile extends Controller
{

    //test file convert to JSON
    public function processLog1(){
        $text = "I am not sure today";

        // Split the text into an array of words based on space
        $words = explode(' ', $text);

        // Convert the array to JSON format
        $jsonResult = json_encode($words);

        // You can now use $jsonResult as needed in your application

        // Optionally, return a response or redirect as needed
        return response()->json(['words' => $jsonResult]);

    }

    // Convert text to CSV file
    public function processLog(){

        // input text
        // $text = "I am not sure today";
        $text = "2023-12-30 00:02:13:013 2 main ActionManager : received TerminalStatusRequest";

        // Split the text into an array of words based on space
        $words = explode(' ', $text);

        // Create a temporary file for CSV
        $csvFile = tempnam(sys_get_temp_dir(), 'csv_');

        // Open the CSV file in write mode
        $csvHandle = fopen($csvFile, 'w');

        // Write the words to the CSV file
        fputcsv($csvHandle, $words);

        // Close the CSV file handle
        fclose($csvHandle);

        // Read the CSV file content
        $csvContent = file_get_contents($csvFile);

        // Remove the temporary CSV file
        unlink($csvFile);

        // You can now use $csvContent as needed in your application

        // Optionally, return a response or redirect as needed
        return response($csvContent)->header('Content-Type', 'text/csv');

     }

     /// convert simple folder to csv file by add condition if have space to comma , if have comma to ;

     public function convertFile(Request $request)
     {
        $request->validate([
            'file' => 'required|mimes:txt|max:20480', // Adjust validation rules as needed
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        // Store the uploaded file in the 'input' directory within the storage/app directory
        $inputFilePath = $file->storeAs('input', 'input.txt', 'local');

        // Read the content of the file into an array, where each element represents a line
        $lines = Storage::disk('local')->get($inputFilePath);
        $lines = explode(PHP_EOL, $lines);

        // Prepare CSV content
        $csvContent = "Date, Time, ID, Thread, Log Message\n";

        foreach ($lines as $line) {
            // Extract the first 4 values (assuming they don't contain spaces)
            $firstFourValues = array_slice(explode(' ', $line, 5), 0, 4);

            // Combine the first 4 values and the remaining part of the line as the log message
            $logMessage = implode(' ', $firstFourValues);

            // Split the line into values based on spaces
            $allValuesInLine = preg_split('/\s+/', $line, 5);

            // Check if there are at least 5 values in the line
            if (count($allValuesInLine) >= 5) {
                // Replace commas with semicolons in the log message
                $logMessage = str_replace(',', ';', $allValuesInLine[4]);

                // Append a new line to the CSV content
                $csvContent .= implode(',', array_map('utf8_encode', array_merge($firstFourValues, [$logMessage]))) . "\n";
            } else {
                // Handle the case where there are less than 5 values in the line
                // You may want to add some default behavior or log a warning
            }
        }

        // Create a temporary file for CSV
        $csvFile = tempnam(sys_get_temp_dir(), 'csv_');

        // Write the CSV content to the file
        file_put_contents($csvFile, $csvContent);

        // Store the CSV file in the 'output' directory within the storage/app directory
        $outputFilePath = 'output/' . date('Y-m-d_H-i-s') . '_output.csv';
        Storage::disk('local')->put($outputFilePath, file_get_contents($csvFile));

        // Remove the temporary CSV file
        unlink($csvFile);

        // Optionally, return a response or redirect as needed
        return response()->download(storage_path("app/$outputFilePath"));
     }

     /// convert simple folder to csv file by add condition if have space to comma
    public function convertFile1(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt|max:20480', // Adjust validation rules as needed
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        // Store the uploaded file in the 'input' directory within the storage/app directory
        $inputFilePath = $file->storeAs('input', 'input.txt', 'local');

        // Read the content of the file into an array, where each element represents a line
        $lines = Storage::disk('local')->get($inputFilePath);
        $lines = explode(PHP_EOL, $lines);

        // Prepare CSV content
        $csvContent = "Date, Time, ID, Thread, Log Message\n";

        foreach ($lines as $line) {
            // Extract the first 4 values (assuming they don't contain spaces)
            $firstFourValues = array_slice(explode(' ', $line, 5), 0, 4);

            // Combine the first 4 values and the remaining part of the line as the log message
            $logMessage = implode(' ', $firstFourValues);

            // Split the line into values based on spaces
            $allValuesInLine = preg_split('/\s+/', $line, 5);

            // Check if there are at least 5 values in the line
            if (count($allValuesInLine) >= 5) {
                // Append a new line to the CSV content
                $csvContent .= implode(',', array_map('utf8_encode', array_merge($firstFourValues, [$allValuesInLine[4]]))) . "\n";
            } else {
                // Handle the case where there are less than 5 values in the line
                // You may want to add some default behavior or log a warning
            }
        }

        // Create a temporary file for CSV
        $csvFile = tempnam(sys_get_temp_dir(), 'csv_');

        // Write the CSV content to the file
        file_put_contents($csvFile, $csvContent);

        // Store the CSV file in the 'output' directory within the storage/app directory
        $outputFilePath = 'output/' . date('Y-m-d_H-i-s') . '_output.csv';
        Storage::disk('local')->put($outputFilePath, file_get_contents($csvFile));

        // Remove the temporary CSV file
        unlink($csvFile);

        // Optionally, return a response or redirect as needed
        return response()->download(storage_path("app/$outputFilePath"));
    }

    // upload big file
    public function Uploadfile2(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt|max:20480', // Adjust validation rules as needed
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        // Store the uploaded file in the 'input' directory within the storage/app directory
        $inputFilePath = $file->storeAs('input', 'input.txt', 'local');

        // Read the content of the file into an array, where each element represents a line
        $lines = Storage::disk('local')->get($inputFilePath);
        $lines = explode(PHP_EOL, $lines);

        // Prepare CSV content
        $csvContent = "Date, Time, ID, Thread, Log Message\n";

        foreach ($lines as $line) {
            // Extract the first 4 values (assuming they don't contain spaces)
            $firstFourValues = array_slice(explode(' ', $line, 5), 0, 4);

            // Combine the first 4 values and the remaining part of the line as the log message
            $logMessage = implode(' ', $firstFourValues);

            // Split the line into values based on spaces
            $allValuesInLine = preg_split('/\s+/', $line, 5);

            // Check if there are at least 5 values in the line
            if (count($allValuesInLine) >= 5) {
                // Replace commas with semicolons in the log message
                $logMessage = str_replace(',', ';', $allValuesInLine[4]);

                // Append a new line to the CSV content
                $csvContent .= implode(',', array_map('utf8_encode', array_merge($firstFourValues, [$logMessage]))) . "\n";
            } else {
                // Handle the case where there are less than 5 values in the line
                // You may want to add some default behavior or log a warning
            }
        }

        // Create a temporary file for CSV
        $csvFile = tempnam(sys_get_temp_dir(), 'csv_');

        // Write the CSV content to the file
        file_put_contents($csvFile, $csvContent);

        // Store the CSV file in the 'output' directory within the storage/app directory
        $outputFilePath = 'output/' . date('Y-m-d_H-i-s') . '_output.csv';
        Storage::disk('local')->put($outputFilePath, file_get_contents($csvFile));

        // Remove the temporary CSV file
        unlink($csvFile);

        // Optionally, return a response or redirect as needed
        return response()->download(storage_path("app/$outputFilePath"));

    }

    // final can upload file clientLog and split text
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt|max:20480', // 20 MB limit
        ]);

        // Retrieve the uploaded file
        $file = $request->file('file');

        // Store the uploaded file in the 'input' directory within the storage/app directory
        $inputFilePath = $file->storeAs('input', 'input.txt', 'local');

        // Output CSV file path
        $outputFilePath = 'output/' . date('Y-m-d_H-i-s') . '_output.csv';

        // Use Laravel's CSV writer
        $csvWriter = Writer::createFromPath(storage_path("app/$outputFilePath"), 'w+');
        $csvWriter->insertOne(["Date", "Time", "Code", "Thread", "Log Message"]);

        // Read the file in chunks and process each line
        $handle = fopen(storage_path("app/$inputFilePath"), 'r');

        while (($line = fgets($handle)) !== false) {
            $this->processLine($line, $csvWriter);
        }

        fclose($handle);

        // Optionally, return a response or redirect as needed
        return response()->download(storage_path("app/$outputFilePath"));
    }

    // codition add by line
    private function processLine($line, $csvWriter)
    {
        // Split the line into values based on spaces
        $allValuesInLine = preg_split('/\s+/', $line, 5);

        // Check if there are at least 5 values in the line
        if (count($allValuesInLine) >= 5) {
            // Extract values
            $date = $allValuesInLine[0];
            $time = $allValuesInLine[1];
            $code = $allValuesInLine[2];
            $thread = $allValuesInLine[3];
            $logMessage = str_replace(',', ';', $allValuesInLine[4]);
            // $logMessage = str_replace('"', '', $record[4]);

            // // Write to CSV
            $csvWriter->insertOne([$date, $time, $code, $thread, $logMessage]);

             // Save to the database
             LogEntry::create([
                'date' => $date,
                'time' => $time,
                'code' => $code,
                'thread' => $thread,
                'log_message' => $logMessage,
            ]);
        }
    }

    public function getAll()
    {
        $data = LogEntry::all();

        return response()->json(['data' => $data]);
    }

    public function QRScanLog_date(Request $request)
    {
        $date = $request->input('date');

        $data = DB::table('log_entries')
                ->select('time')
                ->where('date', $date)
                ->where('log_message', 'like', '%QRServer : decode%')
                ->get();

        return response()->json(['data' => $data]);
    }

    public function QRScanLog_time(Request $request)
    {
        $time= $request->input('time');

        $data = DB::table('log_entries')
                ->where('time', $time)
                ->where('log_message', 'like', '%QRServer : decode%')
                ->get();

        return response()->json(['data' => $data]);
    }
}
