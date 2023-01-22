<?php

namespace Modules\Attribute\Providers;

use Illuminate\Support\ServiceProvider;

class AttributeServiceProvider
extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Attribute';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'attribute';

    public function register()
    {
        $this->app->register(RouteSerivceProvider::class);
    }
}