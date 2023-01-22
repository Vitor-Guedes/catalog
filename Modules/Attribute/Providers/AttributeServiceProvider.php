<?php

namespace Modules\Attribute\Providers;

use Modules\Attribute\Entity\Family;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Modules\Attribute\Services\Attribute\FamilyService;

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

    public function boot()
    {
        $this->dependencyInjection();
    }

    public function register()
    {
        $this->app->register(RouteSerivceProvider::class);
    }

    /**
     * Aplica as injeções de dependecias de acordo com as 
     * necessidades do modulo
     */
    public function dependencyInjection()
    {
        $this->app->when(FamilyService::class)
            ->needs(Model::class)
            ->give(Family::class);
    }
}