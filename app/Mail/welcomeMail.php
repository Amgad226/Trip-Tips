<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class welcomeMail extends Mailable
{
    use Queueable, SerializesModels;


    
    public $input;

    public function __construct($input)
    {
        $this->input=$input;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.WelcomeMail');
    }
}
