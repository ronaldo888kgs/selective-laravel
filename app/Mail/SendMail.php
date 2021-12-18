<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        //dd($this->$details);
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->$mailData);
        //return $this->view('view.name');
        // return $this->subject($this->$mailData["title"])
        //             ->view('mail.template', ['mailData' => $this->$mailData["mail-editor"]]);
        return $this->subject($this->details["title"])
                    ->view('mail.template');
    }
}
