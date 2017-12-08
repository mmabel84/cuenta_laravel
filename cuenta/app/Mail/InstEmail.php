<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstEmail extends Mailable
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
        return $this->subject('Creación de solución de '.$this->array_data['app'].' de '.$this->array_data['empr'])
                    ->view('instemail')
                    ->with([
                        'app'=>$this->array_data['app'],
                        'empr'=>$this->array_data['empr'],
                        'ctarfc'=>$this->array_data['ctarfc'],
                        'emprrfc'=>$this->array_data['emprrfc'],
                        'user'=>$this->array_data['user'],
                        'password'=>$this->array_data['password'],
                        'url'=>$this->array_data['url'],
                        ])
                    ;
    }
}
