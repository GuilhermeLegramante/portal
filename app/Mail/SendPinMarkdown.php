<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPinMarkdown extends Mailable
{
    use Queueable, SerializesModels;

    private $cpf;
    private $pin;
    public $subject = "PIN hsPortal";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cpf, $pin)
    {
        $this->cpf = $cpf;
        $this->pin = $pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cpf = $this->cpf;
        $pin = $this->pin;
        return $this->markdown('emails.send-pin-markdown')->with(['cpf' => $cpf, 'pin' => $pin]);
    }
}
