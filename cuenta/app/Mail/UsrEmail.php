<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UsrEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data_array)
    {
        $this->array_data = $data_array;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vinculación a Cuenta de Advans SA de CV')
                    ->view('usremail')
                    ->with([
                        'ctarfc'=>$this->array_data['ctarfc'],
                        'user'=>$this->array_data['user'],
                        'password'=>$this->array_data['password'],
                        'url'=>$this->array_data['url'],
                        ])
                    ;
    }
}
