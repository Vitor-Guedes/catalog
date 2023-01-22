<?php

namespace Modules\Basic\Traits;

trait Facet
{
    protected $allowedMethods = ['GET'];

    public function buildFacets()
    {
        if (!in_array(request()->method(), $this->allowedMethods)) {
            return ;
        }
        foreach (request()->all() as $function => $value) {
            if (method_exists($this, $function)) {
                $this->$function($value);
            }
        }
    }
}