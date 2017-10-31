<?php

namespace Achillesp\Filterable;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;
    protected $builder;
    protected $filters = [];

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply all filters to builder.
     *
     * @param $builder
     *
     * @return mixed
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Return only those filters that are present in the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }



    public function filterString($filter, $value)
    {
        return $this->builder->where($filter, 'like', "%$value%");
    }

    public function filterInteger($filter, $value)
    {
        return $this->builder->where($filter, $value);
    }

    public function filterBoolean($filter, $value)
    {
        return $this->builder->where($filter, $value);
    }
}
