<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->data;
        // return $this->from('info@shixeh.com')
        //             ->subject($this->data->subject)
        //             ->view('mails.forms');
        return $this->from('info@shixeh.com')
            ->subject($this->data['subject'])
            ->markdown('vendor.mail.html.message')->with([
            'slot'=>$this->data['message'],
            'title' => $this->data['subject'],
            'message'=>$this->data['message']
        ]);
        // return $this->view('view.name');
    }
}
