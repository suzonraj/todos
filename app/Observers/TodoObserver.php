<?php

namespace App\Observers;

use App\Models\Todo;
use Exception;


/**
 * Class TodoObserver
 *
 * @package App\Observers
 */
class TodoObserver
{
    /**
     * Handle the todo "retrieved" event.
     *
     * @param $model
     */
    public function retrieved($model): void
    {
//        \Log::info('Retrieved By:'). \Auth::user()->id;
    }

    /**
     * Handle the todo "creating" event.
     *
     * @param $model
     * @throws Exception
     */
    public function creating($model): void
    {
        $model->created_by = \Auth::user()->id;
    }

    /**
     * Handle the todo "created" event.
     *
     * @param  Todo  $model
     */
    public function created(Todo $model): void
    {
        //
    }

    /**
     * Handle the todo "updating" event.
     *
     * @param $model
     */
    public function updating($model): void
    {
        $model->updated_by = \Auth::user()->id;
    }

    /**
     * Handle the todo "updated" event.
     *
     * @param  Todo  $model
     */
    public function updated(Todo $model): void
    {
        //
    }

    /**
     * Handle the todo "deleted" event.
     *
     * @param  Todo  $model
     */
    public function deleting($model): void
    {
        $model->deleted_by = \Auth::user()->id;
    }

    /**
     * Handle the todo "deleted" event.
     *
     * @param  Todo  $model
     */
    public function deleted(Todo $model): void
    {
        //
    }

    /**
     * Handle the todo "restored" event.
     *
     * @param  Todo  $model
     */
    public function restored(Todo $model): void
    {
        //
    }

    /**
     * Handle the todo "force deleted" event.
     *
     * @param  Todo  $model
     */
    public function forceDeleted(Todo $model): void
    {
        //
    }

    /**
     * Handle the todo "removing" event.
     *
     * @param $model
     */
    public function removing($model): void
    {
        $model->deleted_by = \Auth::user()->id;
    }

    /**
     * Handle the todo "removed" event.
     *
     * @param $model
     */
    public function removed($model): void
    {
        //
    }
}
