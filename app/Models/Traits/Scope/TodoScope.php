<?php

namespace App\Models\Traits\Scope;


/**
 * Trait TodoScope
 *
 * @package App\Models\Traits\Scope
 */
trait TodoScope
{
    /**
     * @param        $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * @param        $query
     * @return mixed
     */
    public function scopeComplete($query)
    {
        return $query->where('status', 2);
    }
}
