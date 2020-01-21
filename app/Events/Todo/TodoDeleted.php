<?php

namespace App\Events\Todo;

use Illuminate\Queue\SerializesModels;

/**
 * Class TodoDeleted
 *
 * @package App\Events\Todo
 */
class TodoDeleted
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
