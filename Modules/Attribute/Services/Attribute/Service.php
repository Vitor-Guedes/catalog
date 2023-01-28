<?php

namespace Modules\Attribute\Services\Attribute;

use Modules\Basic\Traits\Facet;
use Modules\Attribute\Entities\Attribute;
use Modules\Basic\Services\Service as BasicService;

class Service
extends BasicService
{
    use Facet;

    protected $moduleName = 'attribute';

    public function __construct(Attribute $model)
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
     * @param array $code
     * 
     * @return \Illuminate\Database\Eloquent\Collection 
     */
    public function getAttributesByCode(array $codes = [], array $columns = ['*'])
    {
        return $this->model->whereIn('code', $codes)->get($columns);
    }
}