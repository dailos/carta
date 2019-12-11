<?php

namespace App\Listeners;

use App\Events\ModerationRejected;
use App\Mail\ModerationRejected as ModerationRejectedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendModerationRejectedNotificationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ModerationRejected  $event
     * @return void
     */
    public function handle(ModerationRejected $event)
    {
        $send_to = false;
        if($event->moderableRecord->user){
            $send_to = $event->moderableRecord->user;
        }

        if($send_to){
            \Mail::to($send_to)
            ->send(new ModerationRejectedMail($event->moderableRecord));    
        }
    }
}
