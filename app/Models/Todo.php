<?php

namespace App\Models;

use App\Models\Traits\Attribute\TodoAttribute;
use App\Models\Traits\Method\TodoMethod;
use App\Models\Traits\Relationship\TodoRelationship;
use App\Models\Traits\Scope\TodoScope;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Todo
 *
 * @package App\Models
 */
class Todo extends Model
{
    use TodoAttribute,
        TodoMethod,
        TodoRelationship,
        TodoScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'todo',
        'status',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'trans_date'];
}
