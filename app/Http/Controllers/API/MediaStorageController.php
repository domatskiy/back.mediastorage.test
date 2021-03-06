<?php

namespace App\Http\Controllers\Api;

use \App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaStorageController extends \App\Http\Controllers\Controller
{
    #POST
    public function upload(Requests\API\MediaStorageAddRequest $request)
    {
        $errors = [];
        $file = $request->file('file');

        if($file !== null)
        {
            Log::debug('save file');

            try {

                $mediastorage = new \App\MediaStorage;
                $mediastorage->create($file, $request->get('uuid'), $request->get('description'), $request->get('email'));

            } catch (\Exception $e) {

                $errors[] = $e->getMessage();
                Log::error('save err '.$e->getMessage());

            }

        }
        else
        {
            $errors[] = 'file not exit';
            Log::error('file not exit');
        }

        if(empty($errors))
            return response(['message' => 'success'], 200);
        else
            return response(['errors' => $errors], 422);
    }

    #GET
    public function get($user_hash, $file_hash, Request $request)
    {
        $path = \App\MediaStorage::getFile($user_hash, $file_hash, true);

        if(!$path)
            return response([], 404);

        Log::debug('file download '. $path);

        # download
        # return response()->file($path);
        return response()->download($path);
    }
}
