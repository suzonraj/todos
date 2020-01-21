<?php

namespace App\Events\Todo;

use Illuminate\Queue\SerializesModels;


/**
 * Class TodoCompleted
 *
 * @package App\Events\Todo
 */
class TodoCompleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $event;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->event = $data;
    }
}
