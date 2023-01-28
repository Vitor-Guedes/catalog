<?php

namespace Modules\Attribute\Services\Attribute;

use Modules\Attribute\Entities\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Modules\Attribute\Entities\AttributeGroupMapping;

class AttributeGroupMappingService
{
    protected $model;

    public function __construct(AttributeGroupMapping $model)
    {
        $this->model = $model;
    }
    /**
     * @param Group $group
     * @param array|Collection $attributes
     * 
     * @return bool
     */
    public function storeMapping(Group $group, $attributes)
    {
        $rows = [];

        if (is_array($attributes)) {
            $attributes = collect($attributes);
        }
        
        if ($attributes instanceof Collection) {
            $attributes->each(function ($attribute) use (&$rows, $group) {
                Arr::set($rows, $attribute->id . '.attribute_id', $attribute->id);
                Arr::set($rows, $attribute->id . '.attribute_group_id', $group->id);
            });
        }

        return $this->model->insert($rows);
    }
}