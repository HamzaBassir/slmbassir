<?php

use App\Imports\FilesImport;
use App\Models\FileName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use VIPSoft\Unzip\Unzip;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('addfile', function (Request $req) {

    $req->validate([
        'shapefile' => "required",
    ]);
    if ($req->hasFile('shapefile')) {
        $unzipper  = new Unzip();
        $fileSHP = $req->file('shapefile');
        $fileNameSHP = $fileSHP->getClientOriginalName();
        $fileUploadedSHP =  $fileSHP->storeAs('', $fileNameSHP);
        $filenames = $unzipper->extract(storage_path('app/' . $fileUploadedSHP), storage_path('app'));
        Storage::delete($fileUploadedSHP);
    }

    $filesToTreat = $filenames;
    $filesDuplicate = 0;
    foreach ($filesToTreat as $file) {
        if (FileName::where('file_name', '=', $file)->exists()) {
            $filesDuplicate++;
        } else {
            FileName::create([
                'file_name' => $file
            ]);
            Excel::import(new FilesImport, $file);
        }
    }
    if(count(FileName::all()) == $filesDuplicate){
        $filesDuplicate = 'duplicated';
    }
    return $filesDuplicate;
});
