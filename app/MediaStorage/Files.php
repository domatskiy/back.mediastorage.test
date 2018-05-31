<?php

namespace App\MediaStorage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class Files extends Model
{
    static $file;

    const UPLOAD_DIR = '/mediastorage';

    protected
        $table = 'media_storage_file',
		
        $appends = ['url'],
		
        $fillable = [
            'storage_user_id',
            'file',
			'description',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected static function boot()
    {
        parent::boot();

        #====================================================
        # before
        #====================================================
        static::creating(function(Files $file) {
            self::__getFleInfo($file);
        });

        static::updating(function(Files $file) {
            self::__getFleInfo($file);
        });

        static::saving(function(Files $file) {
            self::__getFleInfo($file);
        });

        #====================================================
        # after
        #====================================================
        static::created(function(Files $file) {
            self::__saveFile($file);
			
			#Mail::to($request->user())->send(new Files($file));
        });

        static::saved(function(Files $file) {
            self::__saveFile($file);
        });

        static::updated(function(Files $file) {
            self::__saveFile($file);
        });

        static::deleting(function($building) {
            return true;
        });
    }

    public function getUrlAttribute()
    {
        // return app('url').'/'.$this->code.'/';
    }

    private static function __getFleInfo(Files &$file)
    {
        if ($file->file instanceof UploadedFile)
        {
            /**
             * @var $file->file UploadedFile
             */

            static::$file = $file->file;
			$file->file = '';
        }
		
        return true;
    }

    private static function __saveFile(Files $file)
    {
        $file = null;

        if (static::$file instanceof UploadedFile)
        {
            $fileStorage = self::getStorage();

            /**
             * @var $img UploadedFile
             */
            #$file = static::$file;
            #$file_original = $file->getClientOriginalName();
			
			# TODO change 'dir' to user hash
            $file_name = $file->id . '.' . $img->extension();
            $fileStorage->putFile(self::UPLOAD_DIR.'/dir/'.$file_name, static::$file, []);

            #$file->file_original = $file_original;
            $file->file = $file_name;

            static::$file = null;

            $file->update();
        }
    }

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public static function getStorage()
    {
        # TODO option
        $disk = app().config('filesystems.disks.local');
        return \Storage::disk($disk);
    }
}
