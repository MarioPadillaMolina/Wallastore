<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailProducto extends Mailable
{
    use Queueable, SerializesModels;
    
    private $link;
    private $producto;
    private $cuerpo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $producto, $cuerpo)
    {
        $this->link = $link;
        $this->producto = $producto;
        $this->cuerpo = $cuerpo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.nuevomensaje')->subject('Tiene un nuevo mensaje acerca del producto: "' . $this->producto . '"')->with(['link' => $this->link, 'cuerpo' => $this->cuerpo]);
    }
}
