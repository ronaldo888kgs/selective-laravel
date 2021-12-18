<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendBulkQueueMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mail_data;
    public $contacts;
    public $timeout = 7200; 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_data, $contacts)
    {
        //
        $this->mail_data = $mail_data;
        $this->contacts = $contacts; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$contacts = explode(',', $this->strContacts);
        foreach($this->contacts as $contact)
        {
            $mailData = [
                'title' => $this->mail_data['title'],
                'content' => $this->mail_data['content']
            ];
            Mail::to($contact)->send(new SendMail($mailData));
        }

    }
}
