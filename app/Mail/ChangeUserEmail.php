<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangeUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $enlace; //
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($enlace) //cuando creamos el objeto, le pasamos el enlace que queremos posteriormente mandar al correo (en build())
    {
        $this->enlace = $enlace;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.changeuser')->subject('Change User Mail')->with(['enlace' => $this->enlace]);
    }
}

