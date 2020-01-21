<?php

namespace App\Events\Todo;

use Illuminate\Queue\SerializesModels;


/**
 * Class TodoReactivated
 *
 * @package App\Events\Todo
 */
class TodoReactivated
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
