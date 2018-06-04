<?php

namespace App\Mail;

use App\MediaStorage\Files;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class FileUploaded extends Mailable
{
    use Queueable, SerializesModels;

    private $media_file;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Files $file)
    {
        $this->media_file = $file;

        if($file === null)
            throw new \Exception('not correct file');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $url = 'http://mediastorage.test/uploaded/'.$this->media_file->user.'/'.$this->media_file->file;

        Log::debug('send mail with url='.$url);

        return $this->markdown('emails.mediastorage.uploaded')
            ->with([
                'file' => $url,
                'description' => $this->media_file->description,
                ]);
    }
}
