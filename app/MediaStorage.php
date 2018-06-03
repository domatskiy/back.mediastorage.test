<?php
/**
 * Created by PhpStorm.
 * User: evgenyi
 * Date: 01.06.2018
 * Time: 11:18
 */

namespace App;

use App\MediaStorage\FileStorage\SaveResult;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MediaStorage
{
    private $errors = [];

    private $enable_email_notice = true;

    function __construct()
    {
    }

    public function setSendEmail($enable)
    {
        $this->enable_email_notice = $enable;
    }

    /**
     * @return MediaStorage\Files|bool
     * @throws \Exception
     */
    public function create(UploadedFile $upload_file, $uuid, $description = null, $email = null)
    {
        # save file
        $res = MediaStorage\FileStorage::save($upload_file, $uuid);

        if($res instanceof SaveResult)
        {
            Log::debug('MediaStorage::create / file saved ='.$res->getFullPath());

            try {

                $file = MediaStorage\Files::create([
                    'user' => $uuid,
                    'email' => $email,
                    'file' => $res->getFileHash(),
                    'ext' => $res->getFileExt(),
                    'description' => $description,
                    ]);

                if($file)
                {
                    Log::debug('MediaStorage::create / enable_email_notice ='.$file->enable_email_notice);
                    Log::debug('MediaStorage::create / send to ='.$file->email);

                    # send to email
                    if($file->email && $this->enable_email_notice)
                    {
                        Mail::to($file->email)
                            ->send(new \App\Mail\FileUploaded($file));
                    }

                    return $file;
                }

            } catch (\Exception $e) {

                Log::critical('not create file '.$e->getMessage());
                MediaStorage\FileStorage::remove($CookieUser->uuid, $res->getFileName());
                throw new \Exception('system error');

            }

        }

    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return MediaStorage\Files|null
     */
    public static function getFile($user_hash, $file_hash, $with_root = false)
    {
        $file = \App\MediaStorage\Files::select([
            'user',
            'file',
            'ext',
            ])
            ->where([
                ['user', $user_hash],
                ['file', $file_hash],
            ])
            ->first();

        if(!$file)
            return null;

        Log::debug('getFile:: file found, path = ' . $file->path);

        return ($with_root ? storage_path('app').'/' : '') . $file->path;
    }
}