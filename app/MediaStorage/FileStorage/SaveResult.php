<?php
/**
 * Created by PhpStorm.
 * User: domatskiy
 * Date: 03.06.2018
 * Time: 11:29
 */

namespace App\MediaStorage\FileStorage;


class SaveResult
{
    private $path,
            $file_ext,
            $file_hash;

    private $errors = [];

    public function setError($message)
    {
        $this->errors[] = $message;
    }

    /**
     * @param $path
     * @throws \Exception
     */
    public function setPath($path)
    {
        if(!is_string($path))
            throw new \Exception('not correct path');

        $this->path = $path;
    }

    /**
     * @param $file_ext
     */
    public function setFileExt($file_ext)
    {
        if(!is_string($file_ext))
            throw new \Exception('not correct file ext');

        $this->file_ext = $file_ext;
    }

    /**
     * @param $file_hash
     * @throws \Exception
     */
    public function setFileHash($file_hash)
    {
        if(!is_string($file_hash))
            throw new \Exception('not correct file hash');

        $this->file_hash = $file_hash;
    }

    /**
     * @return string
     */
    public function getFullPath()
    {
        return $this->path.DIRECTORY_SEPARATOR.$this->getFileName();
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file_hash.($this->file_ext ? '.'.$this->file_ext : '');
    }

    /**
     * @return string
     */
    public function getFileHash()
    {
        return $this->file_hash;
    }

    /**
     * @return mixed
     */
    public function getFileExt()
    {
        return $this->file_ext;
    }
}