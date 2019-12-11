<?php

namespace App\Traits;

use App\ModerableRecord;
use App\Observers\ModerationObserver;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Moderable
{
    public $moderate = false;
    public $deferredActions;

    /**
     * Register the moderation observer on the model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::observe(new ModerationObserver());
    }

    /**
     * Enable moderation for the next action performed
     *
     * @return Model
     */
    public function moderate()
    {
        $this->moderate = true;
        return $this;
    }

    /**
     * Enable moderation for the next action performed
     *
     * @return Model
     */
    public function deferred (array $actions)
    {
        $this->deferredActions = $actions;
        return $this;
    }

    /**
     * Get all the moderable records of the model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function moderableRecords() : MorphMany
    {
        return $this->morphMany(ModerableRecord::class, 'moderable');
    }
}
