<?php

namespace Modules\Attribute\Entity;

use Illuminate\Database\Eloquent\Model;

class Attribute
extends Model
{
    const TYPE_VARCHAR = 'varchar';

    const TYPE_INTEGER = 'int';

    const TYPE_FLOAT = 'float';

    const TYPE_TEXT = 'text';

    protected $table = 'attributes';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'label',
        'type',
        'is_filterable',
        'is_required'
    ];
        
    public static function getTypes()
    {
        return [
            static::TYPE_VARCHAR,
            static::TYPE_INTEGER,
            static::TYPE_FLOAT,
            static::TYPE_TEXT,
        ];
    } 
}