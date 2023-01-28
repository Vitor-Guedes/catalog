<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeGroupMapping extends Model
{
    protected $table = 'attribute_group_mapping';

    protected $fillable = [
        'attribute_id',
        'attribute_group_id'
    ];

    public $timestamps = false;
}
