<?php

namespace App\Events\Todo;

use Illuminate\Queue\SerializesModels;


/**
 * Class TodoUpdated
 *
 * @package App\Events\Todo
 */
class TodoUpdated
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
