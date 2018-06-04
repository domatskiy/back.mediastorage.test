<?php

namespace App\MediaStorage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class Files extends Model
{
    static $file;

    const UPLOAD_DIR = '/mediastorage';

    protected
        $table = 'media_storage_file',
		
        $appends = ['filename', 'path'],
		
        $fillable = [
            'user',
            'email',
            'file',
            'ext',
			'description',
            ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function(Files $file) {
            FileStorage::remove($file->user, $file->filename);
        });
    }

    /**
     * @return string
     */
    public function getFilenameAttribute()
    {
        return $this->file.($this->ext ? '.'.$this->ext : '');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getPathAttribute()
    {
        return FileStorage::getPath($this->user, $this->getFilenameAttribute());
    }
}
