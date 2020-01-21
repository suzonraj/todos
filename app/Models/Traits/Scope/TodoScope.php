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
     * @param  bool  $status
     *
     * @return mixed
     */
    public function scopeActive($query, $status = true)
    {
        return $query->where('active', $status);
    }
}
