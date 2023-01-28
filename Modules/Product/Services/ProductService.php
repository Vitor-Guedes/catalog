<?php

namespace Modules\Product\Services;

use Modules\Basic\Traits\Facet;
use Modules\Product\Entities\Product;
use Modules\Basic\Services\Service as BasicService;

class ProductService
extends BasicService
{
    use Facet;

    protected $moduleName = 'product';

    public function __construct(Product $model)
    {
        parent::__construct($model);

        $this->buildFacets();
    }
}