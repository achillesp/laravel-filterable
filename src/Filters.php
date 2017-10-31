<?php

namespace Achillesp\Filterable;

abstract class Filters
{
    protected $request;
    protected $query;
    protected $builder;
    protected $filters = [];

    /**
     * Filters constructor.
     *
     * @param $query
     */
    public function __construct($query)
    {
        if (is_object($query) && 'Illuminate\Http\Request' === get_class($query)) {
            $this->request = $query;
        } elseif (is_array($query)) {
            $this->query = $query;
        }
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
        if (!empty($this->request)) {
            return $this->request->only($this->filters);
        }

        if (!empty($this->query)) {
            return array_intersect_key($this->query, array_flip($this->filters));
        }

        return [];
    }
}
