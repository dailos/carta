<?php

namespace App\Events;

use App\ModerableRecord;
use Illuminate\Queue\SerializesModels;

class ModerationApproved
{
    use SerializesModels;

    public $moderableRecord;

    /**
     * Create a new event instance.
     *
     * @param  \App\ModerableRecord  $moderableRecord
     * @return void
     */
    public function __construct(ModerableRecord $moderableRecord)
    {
        $this->moderableRecord = $moderableRecord;
    }
}