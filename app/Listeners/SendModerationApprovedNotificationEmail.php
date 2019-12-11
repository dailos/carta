<?php

namespace App\Listeners;

use App\Events\ModerationApproved;
use App\Mail\ModerationApproved as ModerationApprovedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendModerationApprovedNotificationEmail
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
     * @param  ModerationApproved  $event
     * @return void
     */
    public function handle(ModerationApproved $event)
    {
        $send_to = false;
        if($event->moderableRecord->user){
            $send_to = $event->moderableRecord->user;
        }

        if($send_to){
            \Mail::to($send_to)
            ->send(new ModerationApprovedMail($event->moderableRecord));    
        }
    }
}
