<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AppFileController extends Controller
{
    public function upload(Request $request): string
    {
        // Check if any files are uploaded
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Check if the file is valid
            if ($file->isValid()) {

                // Save file to public/uploads
                // $file->move(public_path('uploads'), $file->getClientOriginalName());

                // Lưu file vào storage/app/public/uploads
                $filePath = $file->storeAs('uploads', $file->getClientOriginalName(), 'public');

                return 'Upload successful: ' . $filePath;
            } else {
                return 'Invalid file';
            }
        }

        return 'No files uploaded';
    }

    public function download(string $filename): BinaryFileResponse|JsonResponse
    {
        $disk = Storage::disk('public');
        $filePath = 'uploads/' . $filename;

        // Check if file exists
        if ($disk->exists($filePath)) {
            // Get the full path of a file
            $fullPath = $disk->path($filePath);

            // Check if the file is accessible
            if (file_exists($fullPath)) {
                return response()->download($fullPath);
            }
        }

        // Returns an error message if the file does not exist
        return response()->json(['error' => 'File does not exist'], ResponseAlias::HTTP_NOT_FOUND);
    }
}
