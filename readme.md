# Filter Laravel Models

This Laravel package provides an abstraction for filtering Eloquent Models based on a request.

## Installation

From the command line, run:

```
composer require achillesp/laravel-filterable
```

## Usage

To be able to filter a model, you need to use the trait Filterable.

```php
use Achillesp\Filterable\Filterable;

class Post extends Eloquent
{
    use Filterable;
}
```

The filters are defined in their own class, which extends the class Achillesp\Filterable\Filters.
In this class you need to provide a `$filters` array which contains the names of the filters you'd like to use.
You then declare a method for each of those filters, that queries the model accordingly.
You could use the same filter class for more than one model, or have a different filter class for each model you want to filter.

```php
use Achillesp\Filterable\Filters;

class PostFilters extends Filters
{
    protected $filters = ['category', 'published'];

    protected function category(int $categoryId)
    {
        return $this->builder->where('category_id', $categoryId);
    }

    protected function published(bool $isPublished)
    {
        return $this->builder->where('is_published', $isPublished);
    }
}
```

You can then filter the model either directly from a request or by giving an array of key-value pais.

To filter based on a request, for example in a controller:

```php
public function search(Request $request)
{
    $filters = new PostFilters($request);
    $posts = Post::filter($filters)->get();
    return $posts;
}
```

Or to filter based on an array:

```php
$filters = new PostFilters(['category' => 1, 'published' => true]);
$posts = Post::filter($filters)->get();
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.