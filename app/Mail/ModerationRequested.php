<?php

namespace App\Mail;

use App\ModerableRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ModerationRequested extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The moderable record instance.
     *
     */
    public $moderableRecord;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ModerableRecord $moderableRecord)
    {
        $this->moderableRecord = $moderableRecord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.moderation.requested')->with([
            'moderableRecord' => $this->moderableRecord
        ]);
    }
}