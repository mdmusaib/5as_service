<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $messageData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $attachment)
    {
        $this->messageData = $message;
        $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->attachment){
            return $this->subject('Celebrations With Fifth Angle Studios')
                        ->view('mails.clientmessage')
                        ->attach($this->attachment->getRealPath(),
                        [
                            'as' => $this->attachment->getClientOriginalName(),
                            'mime' => $this->attachment->getClientMimeType(),
                        ]);
        }else{
            return $this->subject('Celebrations With Fifth Angle Studios')
                        ->view('mails.clientmessage');
        }
    }
}
