<?php

namespace Tests\Unit;

use App\MediaStorage;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaStorageTest extends TestCase
{
    private $test_file = __DIR__.DIRECTORY_SEPARATOR.'/test.txt';
    private $uploaded_file;

    function getPath()
    {
        echo $this->test_file;
    }

    function createUploadedFile() {

        $file = $this->test_file;

        $name = File::name($file);
        $extension = File::extension($file);
        $originalName = $name . '.' . $extension;
        $mimeType = File::mimeType($file);
        $size = File::size($file);

        $this->uploaded_file =new UploadedFile(
            $file,
            $originalName,
            $mimeType,
            $size,
            null,
            true
        );

    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testFileStorage()
    {
        $this->createUploadedFile();

        $user_hash = md5(time().rand(10,10000));
        $CFileSaveResult = MediaStorage\FileStorage::save($this->uploaded_file, $user_hash);

        $storage = MediaStorage\FileStorage::getStorage();
        $this->assertTrue($storage->exists($CFileSaveResult->getFullPath()));

        $content = MediaStorage\FileStorage::getFileContent($user_hash, $CFileSaveResult->getFileName());
        $this->assertTrue($content === file_get_contents($this->test_file));

        MediaStorage\FileStorage::remove($user_hash, $CFileSaveResult->getFileName());
        $this->assertFalse($storage->exists($CFileSaveResult->getFullPath()));
    }

    public function testMediaStorage()
    {
        $this->createUploadedFile();

        $path = 'api/upload';
        $data = [];
        $response = $this->call('POST', $path, $data, [], [
            'file' => $this->uploaded_file
        ]);

        $response->assertStatus(200);
    }


}
