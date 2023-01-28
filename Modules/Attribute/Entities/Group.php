<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;

class Group
extends Model
{
    protected $table = 'attribute_groups';
    
    public $timestamps = false;

    protected $fillable = ['name', 'attribute_family_id'];

    public function attributeFamily()
    {
        return $this->belongsTo(Family::class, 'attribute_family_id');
    }

    public function findByName(string $name)
    {
        return (new static)->where('name', $name)->firstOrFail();
    }
}