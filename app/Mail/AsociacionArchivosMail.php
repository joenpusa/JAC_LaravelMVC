<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AsociacionArchivosMail extends Mailable
{
    use Queueable, SerializesModels;

    public $asociacion;
    public $zipPath;

    public function __construct($asociacion, $zipPath)
    {
        $this->asociacion = $asociacion;
        $this->zipPath = $zipPath;
    }

    public function build()
    {
        return $this->subject('Archivos de la Asociación ' . $this->asociacion->id)
                    ->markdown('emails.asociacion.archivos')
                    ->attach($this->zipPath, [
                        'as' => 'archivos_asociacion_' . $this->asociacion->id . '.zip',
                        'mime' => 'application/zip',
                    ]);
    }
}
