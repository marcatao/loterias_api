<?php

namespace App\Mail;


use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Mail\Mailable;

class ReceivedDeposit extends Mailable
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
        $subject = 'We received your deposit';
        $name =    'Eduzz-Api';

        return $this->view('emails.ReceivedDeposit')
                    ->from($address, $name)
                    ->subject($subject);
                   
    }
}