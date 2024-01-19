<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class UploadFileController extends Controller
{
    //upload folder
    public function uploadFolder(Request $request)
    {
        $request->validate([
            'folderZip' => 'required|mimes:zip|max:2048',
        ]);

        $zipFile = $request->file('folderZip');
        $zipPath = $zipFile->storeAs('uploads', $zipFile->getClientOriginalName(), 'public');

        $extractPath = storage_path('app/public/uploads/' . pathinfo($zipFile->getClientOriginalName(), PATHINFO_FILENAME));

        // Extract the contents of the zip file
        $zip = new ZipArchive;
        $zip->open(storage_path("app/public/{$zipPath}"));
        $zip->extractTo($extractPath);
        $zip->close();

        // Get information about the extracted folder and its contents
        $folderInfo = $this->getFolderInfo($extractPath);

        return response()->json(['success' => true, 'folder_info' => $folderInfo]);
    }

    private function getFolderInfo($folderPath)
    {
        $files = collect(Storage::disk('public')->files('uploads/' . basename($folderPath)));

        return [
            'folder_name' => basename($folderPath),
            'file_count' => $files->count(),
            'files' => $files->toArray(),
        ];
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'files.*' => 'required|mimes:txt|max:2048',
        ]);

        $uploadedFiles = [];

        foreach ($request->file('textFiles') as $file) {
            $content = file_get_contents($file->path());
            // You can now access the content of the text file and perform actions as needed

            $uploadedFiles[] = [
                'name' => $file->getClientOriginalName(),
                'content' => $content,
            ];
        }

        // You can save the file names and content to the database or perform other actions here

        return response()->json(['success' => true, 'text_files' => $uploadedFiles]);
    }
}
