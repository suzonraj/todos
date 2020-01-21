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
        return $this->active;
    }
}
