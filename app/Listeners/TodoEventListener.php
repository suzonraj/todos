<?php

namespace App\Listeners;


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
            \App\Events\Todo\TodoCreated::class,
            'App\Listeners\TodoEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Todo\TodoUpdated::class,
            'App\Listeners\TodoEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Todo\TodoDeleted::class,
            'App\Listeners\TodoEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Todo\TodoCompleted::class,
            'App\Listeners\TodoEventListener@onCompleted'
        );

        $events->listen(
            \App\Events\Todo\TodoReactivated::class,
            'App\Listeners\TodoEventListener@onReactivated'
        );
    }
}
