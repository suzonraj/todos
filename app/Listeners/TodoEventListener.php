<?php

namespace App\Listeners;


use App\Events\Todo\TodoCompleted;
use App\Events\Todo\TodoCreated;
use App\Events\Todo\TodoDeleted;
use App\Events\Todo\TodoReactivated;
use App\Events\Todo\TodoUpdated;
use Illuminate\Events\Dispatcher;
use Log;


class TodoEventListener
{
    public function onCreated(): void
    {
        Log::info('Todo Created');
    }

    public function onUpdated(): void
    {
        Log::info('Todo Updated');
    }

    public function onDeleted(): void
    {
        Log::info('Todo Deleted');
    }

    public function onCompleted()
    {
        Log::info('Todo Completed');
    }

    public function onReactivated()
    {
        Log::info('Todo Reactivated');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            TodoCreated::class,
            'App\Listeners\TodoEventListener@onCreated'
        );

        $events->listen(
            TodoUpdated::class,
            'App\Listeners\TodoEventListener@onUpdated'
        );

        $events->listen(
            TodoDeleted::class,
            'App\Listeners\TodoEventListener@onDeleted'
        );

        $events->listen(
            TodoCompleted::class,
            'App\Listeners\TodoEventListener@onCompleted'
        );

        $events->listen(
            TodoReactivated::class,
            'App\Listeners\TodoEventListener@onReactivated'
        );
    }
}
