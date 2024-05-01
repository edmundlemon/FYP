<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    //

    public function fetchImage(Request $request, Lecturer $lecturer){
        // $filename = request('filename');
        // $lecturer = Lecturer::find($lecturer->id);
        // Log::channel('api_post_log')->error('Fetching lecturer for lecturer: {lecturer}', ['lecturer' => $lecturer->photo]);
        // $path = storage_path('storage/' . $lecturer->photo);
        $path = asset('storage' . $lecturer->photo);
        Log::channel('api_post_log')->error('Path for the photo: {path}', ['path' => $path, 'lecturer' => $lecturer->id]);
        return response()->json($path)->header('Content-Type', 'application/json');



        // $path = asset('storage/photos' . $filename);
        // Log:: channel('api_post_log')->error('Path for the photo: {path}', ['path' => $path]);
        // if (!file_exists($path)) {
        //     Log::channel('api_post_log')->error('File not found');
        //     abort(404);
        // }
        // $file = file_get_contents($path);
        // $type = mime_content_type($path);
        // return response($file)->header('Content-Type', $type);
    }
}
