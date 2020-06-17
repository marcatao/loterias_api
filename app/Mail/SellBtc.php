<?php

namespace App\Mail;


use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Mail\Mailable;

class SellBtc extends Mailable
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
        $subject = 'Your btc sale';
        $name =    'Eduzz-Api';

        return $this->view('emails.SellBtc')
                    ->from($address, $name)
                    ->subject($subject);
                   
    }
}