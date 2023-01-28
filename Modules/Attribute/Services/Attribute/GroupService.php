<?php

namespace Modules\Attribute\Services\Attribute;

use Exception;
use Illuminate\Support\Arr;
use Modules\Basic\Traits\Facet;
use Modules\Attribute\Entities\Group;
use Modules\Basic\Services\Service as BasicService;
use Modules\Attribute\Services\Attribute\AttributeGroupMappingService;

class GroupService
extends BasicService
{
    use Facet;

    protected $moduleName = 'attribute';

    public function __construct(Group $model)
    {
        parent::__construct($model);

        $this->buildFacets();
    }

    /**
     * @param string $value | 'id,asc' - '{column},{direction}'
     */
    public function order(string $value)
    {
        if (preg_match("/[^a-z0-9|^_]/", $value, $matches)) {
            list($column, $direction) = explode(current($matches), $value);
            if ($column && $direction) {
                if (in_array(strtolower($direction), ['asc', 'desc'])) {
                    return $this->builder->orderBy($column, $direction);
                }
            }
        }
    }

    /**
     * @param int $value
     */
    public function limit(int $value)
    {
        if (is_numeric($value)) {
            return $this->limit = $value;
        }
    }

    /**
     * @param string $value
     */
    public function name(string $value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', $value);
        }
    }

    /**
     * @param string|int $value
     */
    public function search($value)
    {
        if (is_numeric($value)) {
            return $this->builder->where('id', $value);
        }
        return $this->builder->where('name', 'like', "%$value%");
    }

    /**
     * @param string $value
     */
    public function columns(string $value)
    {
        if (preg_match("/[^a-z0-9|^_]/", $value, $matches)) {
            $this->columns = explode(current($matches), $value);
        }
    }

    /**
     * @param array $data
     * 
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function mappingAttributes(array $data = [])
    {
        try {
            $groupName = Arr::get($data, 'attribute_groups.name');
            $group = $this->model->findByName($groupName);

            $attributeCodes = Arr::get($data, 'attribute_groups.attributes.code');        
            
            /** @var Service $attributeService */
            $attributeService = app()->make(Service::class);
            $attributes = $attributeService->getAttributesByCode($attributeCodes, ['id']);

            /** @var AttributeGroupMappingService $attributeGroupMapping */
            $attributeGroupMapping = app()->make(AttributeGroupMappingService::class);
            return $attributeGroupMapping->storeMapping($group, $attributes);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param array $data
     * 
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function mappingAttributeIds(array $data = [])
    {
        try {
            $group = $this->findOrFail(
                Arr::get($data, 'attribute_group_id')
            );

            /** @var Service $attributeService */
            $attributeService = app()->make(Service::class);
            $attribute = $attributeService->findOrFail(
                Arr::get($data, 'attribute_id')
            );

            /** @var AttributeGroupMappingService $attributeGroupMapping */
            $attributeGroupMapping = app()->make(AttributeGroupMappingService::class);
            return $attributeGroupMapping->storeMapping($group, Arr::wrap($attribute));
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}