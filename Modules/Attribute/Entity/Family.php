<?php

namespace Modules\Attribute\Entity;

use Illuminate\Database\Eloquent\Model;

class Family
extends Model
{
    protected $table = 'attribute_families';

    protected $fillable = ['name'];
    
    public $timestamps = false;

    public function attributeGroups()
    {
        return $this->hasMany(Group::class, 'attribute_family_id');
    }
}