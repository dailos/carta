<?php

namespace App\Observers;

use Auth;
use App\ModerableRecord;
use Illuminate\Database\Eloquent\Model;

class ModerationObserver
{

    /**
     * Listen to a moderable model saving event.
     *
     * @param  \App\Interfaces\Model  $model
     * @return void
     */
    public function saving(Model $model)
    {
        if ($model->moderate &&
            $model->exists &&
            !$model->isDirty() &&
            $model->deferredActions) {
                $model->moderableRecords()->create([
                    'user_id'=> Auth::id(),
                    'action' => 'update',
                    'fields' => [],
                    'deferred_actions' => $model->deferredActions,
                    'status' => ModerableRecord::PENDING
                ]);
            $model->moderate = false;

            return false;
        }
    }

    /**
     * Listen to a moderable model creating event.
     *
     * @param  \App\Interfaces\Model  $model
     * @return void
     */
    public function creating(Model $model)
    {
        if ($model->moderate) {
            $moderableRecord = $model->moderableRecords()->create([
                'user_id'=> Auth::id(),
                'action' => 'create',
                'fields' => $model->makeVisible($model->getHidden())->toArray(),
                'deferred_actions' => $model->deferredActions,
                'status' => ModerableRecord::PENDING
            ]);
            $model->moderate = false;

            return false;
        }
    }

    /**
     * Listen a moderable model updating event.
     *
     * @param  \App\Interfaces\Model  $model
     * @return void
     */
    public function updating(Model $model)
    {

        if ($model->moderate) {
            $get_dirty_array = [];
            foreach($model->getDirty() as $key=>$dirty){
                $get_dirty_array[$key] = is_json($dirty, true) ?: $dirty;
            }

            $moderableRecord = $model->moderableRecords()->create([
                'user_id'=> Auth::id(),
                'action' => 'update',
                // 'fields' => $model->getDirty(),
                'fields' => $get_dirty_array,
                'deferred_actions' => $model->deferredActions,
                'status' => ModerableRecord::PENDING
            ]);
            $model->moderate = false;

            return false;
        }
    }

    /**
     * Listen a moderable model deleting event.
     *
     * @param  \App\Interfaces\Model  $model
     * @return void
     */
    public function deleting(Model $model)
    {
        if ($model->moderate) {
            $model->moderableRecords()->create([
                'user_id'=> Auth::id(),
                'action' => 'delete',
                'deferred_actions' => $model->deferredActions,
                'status' => ModerableRecord::PENDING
            ]);
            $model->moderate = false;

            return false;
        }
    }
}
