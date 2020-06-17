<?php

namespace App\Mail;


use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Mail\Mailable;

class WellcomeMail extends Mailable
{
    use SendGrid;
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $address = env('MAIL_FROM');
        $subject = 'Wellcome to our API';
        $name =    'Eduzz-Api';

        return $this->view('emails.wellcome')
                    ->from($address, $name)
                    ->subject($subject);
                   
    }
}