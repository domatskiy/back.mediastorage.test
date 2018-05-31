<?
namespace App\Http\Controllers\API;

use \App;
use \App\Http\Requests;
use \Illuminate\Http\Request;

class MediaStorageController extends App\Http\Controllers\Controller
{

    #POST
    public function upload(Requests\API\MediaStorageAddRequest $request)
    {

    }

    #GET
    public function getFile($user_hash, $file_hash, Request $request)
    {
        $file = \App\MediaStorage\Files::select([
            'media_storage_file.file'
            ])
            ->join('media_storage_user', 'media_storage_user.id', '=', 'media_storage_file')
            ->where([
                ['media_storage_user.hash', $user_hash],
                ['media_storage_file.file', $file_hash],
            ])
            ->first();

        if(!$file)
            abort(404);

        # TODO download
        # return response()->download($pathToFile);
    }

}
