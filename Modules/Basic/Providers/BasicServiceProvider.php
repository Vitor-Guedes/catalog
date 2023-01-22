<?php

namespace Modules\Basic\Providers;

use Illuminate\Support\ServiceProvider;

class BasicServiceProvider
extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Basic';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'basic';

    public function register()
    {
        $this->app->register(RouteSerivceProvider::class);
    }
}