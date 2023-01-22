<?php

namespace Modules\Attribute\Services\Attribute;

use Modules\Basic\Traits\Facet;
use Modules\Attribute\Entity\Family;
use Modules\Basic\Services\Service as BasicService;

class FamilyService
extends BasicService
{
    use Facet;

    protected $moduleName = 'attribute';

    public function __construct(Family $model)
    {
        parent::__construct($model);

        $this->buildFacets();
    }

    /**
     * @param string $value | 'id,asc' - '{column},{direction}'
     */
    public function order(string $value)
    {
        if (preg_match("/[^a-z0-9]/", $value, $matches)) {
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
}