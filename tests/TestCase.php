<?php

namespace Achillesp\Filterable\Test;

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        $this->setUpDatabase();
        $this->migrateTables();
        $this->seedTables();
    }

    protected function setUpDatabase()
    {
        $database = new DB();

        $database->addConnection(['driver' => 'sqlite', 'database' => ':memory:']);
        $database->bootEloquent();
        $database->setAsGlobal();
    }

    protected function migrateTables()
    {
        DB::schema()->create('posts', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('category_id')->unsigned();
            $table->boolean('is_published');
            $table->timestamps();
        });
    }

    protected function seedTables()
    {
        // We have some models that use the trait
        Post::unguard();
        Post::create(['title' => 'The Long Tale: Preface', 'category_id' => 1, 'is_published' => true]);
        Post::create(['title' => 'The Long Tale: Chapter 1', 'category_id' => 1, 'is_published' => false]);
        Post::create(['title' => 'The Short Tale', 'category_id' => 2, 'is_published' => true]);
        Post::reguard();
    }
}
