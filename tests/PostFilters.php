<?php

namespace Achillesp\Filterable\Test;

class PostFilters extends \Achillesp\Filterable\Filters
{
    protected $filters = ['title', 'category', 'published'];

    protected function title(string $title)
    {
        return $this->builder->where('title', 'like', "%$title%");
    }

    protected function category(int $categoryId)
    {
        return $this->builder->where('category_id', $categoryId);
    }

    protected function published(bool $isPublished)
    {
        return $this->builder->where('is_published', $isPublished);
    }
}
