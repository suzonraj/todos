<?php

namespace App\Events\Todo;

use Illuminate\Queue\SerializesModels;


/**
 * Class TodoCreated
 *
 * @package App\Events\Todo
 */
class TodoCreated
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
