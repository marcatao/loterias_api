<?php

namespace App\Mail;


use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Mail\Mailable;

class BuyBtc extends Mailable
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
        $subject = 'your purchase bitcoins';
        $name =    'Eduzz-Api';

        return $this->view('emails.BuyBtc')
                    ->from($address, $name)
                    ->subject($subject);
                   
    }
}