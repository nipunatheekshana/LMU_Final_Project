<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class StorageFileControlle extends Controller
{
    public function returnImage($filename)
    {
        try {
            $path = storage_path('app\private\images/' . $filename);
            if (!File::exists($path)) {
                abort(404);
            }

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    ##########################################################
    ##########same function route Wise########################
    ##########################################################

    // Route::get('/storage/{filename}', function ($filename) {
    //     $path = storage_path('app\private\images/' . $filename);

    //     if (!File::exists($path)) {
    //         abort(404);
    //     }

    //     $file = File::get($path);
    //     $type = File::mimeType($path);

    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //     return $response;
    // });
}
