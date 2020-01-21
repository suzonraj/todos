<?php

namespace App\Models\Traits\Method;


/**
 * Trait TodoMethod
 *
 * @package App\Models\Traits\Method
 */
trait TodoMethod
{
    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status == 2;
    }
}
