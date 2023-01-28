<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class Product
extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'sku',
        'type',
        'attribute_family_id'
    ];
}