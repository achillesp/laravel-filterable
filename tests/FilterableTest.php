<?php

namespace Achillesp\Filterable\Test;

use Illuminate\Http\Request;
/**
 * @coversFilterable
 * @coversFilters
 * @coversNothing
 */
class FilterableTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function it_is_filtered_by_using_the_scope()
    {
        // We have a request using the filters.
        $request = new Request();
        $request->merge([
            'title'    => 'Preface',
        ]);

        // We get the model's filters for the request.
        $filters = new PostFilters($request);

        // We apply the scope
        $posts = Post::filter($filters)->get();
        $this->assertCount(Post::where('title', 'like', '%Preface%')->count(), $posts);

        // A new request with different filter
        $request = new Request();
        $request->merge([
            'category'    => '1',
        ]);

        $filters = new PostFilters($request);

        $posts = Post::filter($filters)->get();
        $this->assertCount(Post::where('category_id', 1)->count(), $posts);

        // A new request with 2 filters
        $request = new Request();
        $request->merge([
            'category'    => '1',
            'published'   => false,
        ]);

        $filters = new PostFilters($request);

        $posts = Post::filter($filters)->get();
        $this->assertCount(
            Post::where('category_id', 1)
                ->where('is_published', false)
                ->count(),
            $posts
        );
    }

    /** @test */
    public function it_filters_only_filters_declared_in_request_and_class()
    {
        // We have a request using a wrongly typed filter.
        $request = new Request();
        $request->merge([
            'title_has'    => 'Short',
        ]);

        // We get the model's filters for the request.
        $filters = new PostFilters($request);

        // We apply the scope and everything is returned
        $posts = Post::filter($filters)->get();
        $this->assertCount(Post::all()->count(), $posts);
    }

}
