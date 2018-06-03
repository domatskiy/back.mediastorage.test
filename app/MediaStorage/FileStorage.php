<?php
/**
 * Created by PhpStorm.
 * User: domatskiy
 * Date: 03.06.2018
 * Time: 2:25
 */

namespace App\MediaStorage;

use App\MediaStorage\FileStorage\SaveResult;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileStorage
{
    const UPLOAD_DIR = '/mediastorage';

    /**
     * @param $user_hash
     * @param $file_name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function getFileContent($user_hash, $file_name)
    {
        $fileStorage = self::getStorage();

        $path = self::getPath($user_hash, $file_name);

        return $fileStorage->get($path);
    }

    /**
     * @param $user_hash
     * @param $file_name
     * @return bool
     * @throws \Exception
     */
    public static function remove($user_hash, $file_name)
    {
        $fileStorage = self::getStorage();

        $path = self::getPath($user_hash, $file_name);
        Log::debug('remove file '.$path);

        $res = $fileStorage->delete($path);

        # удаление директории пользователя, если нет файлов
        $dir = self::getDir($user_hash);
        $files = $fileStorage->files($dir);
        if(count($files) === 0) {
            $fileStorage->deleteDir($dir);
        }

        return $res;
    }

    /**
     * @param UploadedFile $file
     * @param string $user_hash
     * @return SaveResult
     * @throws \Exception
     */
    public static function save(UploadedFile $file, $user_hash)
    {
        $fileStorage = self::getStorage();

        /**
         * @var $img UploadedFile
         */
        #$file = static::$file;
        #$file_original = $file->getClientOriginalName();

        $file_hash = md5_file($file->getPathname());

        $file_name = $file_hash. '.' . $file->getClientOriginalExtension();

        $dir = self::getDir($user_hash);
        $path = $dir.DIRECTORY_SEPARATOR;

        if(!$fileStorage->exists($dir)) {
            $fileStorage->createDir($dir);
        }

        Log::debug('FileStorage::save - save file to '.$path. ' as '.$file_name);

        $fileStorage->putFileAs($path, $file, $file_name, []);

        $result = new SaveResult();

        $result->setPath($path);
        $result->setFileHash($file_hash);
        $result->setFileExt($file->getClientOriginalExtension());

        return $result;
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public static function getStorage()
    {
        #$disk = config('filesystems.disks.local');
        return \Storage::disk('local');
    }

    /**
     * @param string $user_hash
     * @return string
     * @throws \Exception
     */
    public static function getDir($user_hash)
    {
        if(!is_string($user_hash))
            throw new \Exception('need string of user_hash');

        if(strlen($user_hash) < 32)
            throw new \Exception('not correct user_hash, len='.strlen($user_hash));

        $user_dir = substr($user_hash,0, 3);

        return self::UPLOAD_DIR.DIRECTORY_SEPARATOR.$user_dir.DIRECTORY_SEPARATOR.$user_hash;
    }

    /**
     * @param string $user_hash
     * @param $file_name
     * @return string
     * @throws \Exception
     */
    public static function getPath($user_hash, $file_name)
    {
        if(strlen($file_name) < 1)
            throw new \Exception('not correct file_name');

        return self::getDir($user_hash).DIRECTORY_SEPARATOR.$file_name;
    }
}