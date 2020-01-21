<?php

namespace App\Models;

use App\Models\Traits\Attribute\TodoAttribute;
use App\Models\Traits\Method\TodoMethod;
use App\Models\Traits\Relationship\TodoRelationship;
use App\Models\Traits\Scope\TodoScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Todo
 *
 * @package App\Models
 */
class Todo extends Model
{
    use SoftDeletes,
        TodoAttribute,
        TodoMethod,
        TodoRelationship,
        TodoScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'serial',
        'consultant_id',
        'procedure_id',
        'procedure_type_id',
        'patient_id',
        'trans_date',
        'notes',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'trans_date'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trans_date' => 'date:Y-m-d',
        'active' => 'boolean',
    ];
}
