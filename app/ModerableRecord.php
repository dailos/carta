<?php

namespace App;

use Auth;
use App\User;
use App\Events\ModerationApproved;
use App\Events\ModerationRejected;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ModerableRecord extends Model
{
    protected $fillable = ['user_id', 'action', 'fields', 'deferred_actions', 'status', 'comment'];

    protected $casts = [
        'fields' => 'array',
        'deferred_actions' => 'array'
    ];

    // Statuses can take a moderable record
    const PENDING  = 1;
    const APPROVED = 2;
    const REJECTED = 3;

    /**
     * The moderable record belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A moderable action can be referencing any model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model() : MorphTo
    {
        return $this->morphTo('moderable');
    }

    /**
     * Scope a query to only include pending moderable records
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query, $class = null) : Builder
    {
        if ($class) {
            $query = $query->where('moderable_type', $class);
        }
        return $query->where('status', static::PENDING);
    }

    /**
     * Scope a query to only include not pending moderable records
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPending($query, $class = null) : Builder
    {
        if ($class) {
            $query = $query->where('moderable_type', $class);
        }
        return $query->where('status', '!=', static::PENDING);
    }

    /**
     * Scope a query to only include approved moderable records
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query, $class = null) : Builder
    {
        if ($class) {
            $query = $query->where('moderable_type', $class);
        }
        return $query->where('status', static::APPROVED);
    }

    /**
     * Scope a query to only include rejected moderable records
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query, $class = null) : Builder
    {
        if ($class) {
            $query = $query->where('moderable_type', $class);
        }
        return $query->where('status', static::REJECTED);
    }

    /**
     * Applies the action stored
     * over the referenced model
     *
     * @return void
     */
    public function apply($comment = null) : void
    {
        if (Auth::user()->can('moderate') || ($this->moderable_type == 'App\User' && Auth::user()->can('validate_users'))){
            // In case of a create action the actual DB record doesnt exist yet
            // so we call the method from the class namespace
            $model = $this->model ?: $this->moderable_type;

            // Call the action over the model with fields as parameter
            $response = call_user_func_array([$model, $this->action], [$this->fields]);

            // Checks if a model instance has been created and assigns it to the model variable
            $model = is_a($response, Model::class) ? $response : $model;

            $this->applyDeferredActions($model);

            $this->update(['status' => static::APPROVED, 'comment' => $comment]);

            event(new ModerationApproved($this));
        }
        return;
    }

    /**
     * Applies the array of deferred actions over the model
     * This can be used to apply relations and other actions after the
     * moderation have been applied
     *
     * @return void
     */
    public function applyDeferredActions($model) : void
    {//dd($this->deferred_actions);
        if (is_null($this->deferred_actions) || empty($this->deferred_actions)) {
            return;
        }

        foreach ($this->deferred_actions as $action => $parameters) {
            call_user_func_array([$model, $action], $parameters);
        }
    }

    /**
     * Rejects the action stored
     * over the referenced model
     *
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     * @return void
     */
    public function reject($comment = null) : void
    {
        if (Auth::user()->can('moderate') || ($this->moderable_type == 'App\User' && Auth::user()->can('validate_users'))){
            $this->update(['status' => static::REJECTED, 'comment' => $comment]);    
            event(new ModerationRejected($this));
        }
        return;
    }

    /**
     * Obtener el valor del campo de moderación, o en su defecto el valor en el modelo
     *
     * @param string $field - nombre del campo
     */
    public function getField($field)
    {
        if(isset($this->fields[$field])) {
            return $this->fields[$field];
        } elseif (isset($this->model)) {
            return $this->model->$field;
        } else {
            return null;
        }
    }

    /**
     * Obtener el valor del campo-relacionado de moderación, o en su defecto el valor en el modelo
     *
     * @param string $field - nombre del campo
     */
    public function getRelatedField($field)
    {
        $model = str_replace('_id', '', $field);

        $model = 'App\\' . ucfirst($model);

        if(isset($this->fields[$field])) {
            $m = $model::find($this->fields[$field]);
            return isset($m) ? $m->nombre : null;
        } elseif (isset($this->model)) {
            $m = $model::find($this->model->$field);
            return isset($m) ? $m->nombre : null;
        } else {
            return null;
        }
    }
}
