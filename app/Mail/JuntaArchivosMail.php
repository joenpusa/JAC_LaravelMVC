<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JuntaArchivosMail extends Mailable
{
    use Queueable, SerializesModels;

    public $junta;
    public $zipPath;

    public function __construct($junta, $zipPath)
    {
        $this->junta = $junta;
        $this->zipPath = $zipPath;
    }

    public function build()
    {
        return $this->subject('Archivos de la Junta ' . $this->junta->id)
                    ->markdown('emails.junta.archivos')
                    ->attach($this->zipPath, [
                        'as' => 'archivos_junta_' . $this->junta->id . '.zip',
                        'mime' => 'application/zip',
                    ]);
    }
}
