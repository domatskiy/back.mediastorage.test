<?php

namespace App\MediaStorage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class User extends Model
{
    protected
        $table = 'media_storage_user',

        $fillable = [
            'email',
            'hash',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
