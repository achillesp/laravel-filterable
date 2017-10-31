<?php

namespace Achillesp\Filterable;

trait Filterable
{
    /**
     * Add scope to model based on declared filters that are used in current request.
     *
     * @param $query
     * @param Filters $filters
     *
     * @return mixed $query
     */
    public function scopeFilter($query, Filters $filters)
    {
        return $filters->apply($query);
    }
}
