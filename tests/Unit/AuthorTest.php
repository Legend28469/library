<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_only_name_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'Cool Author',
        ]);

        $this->assertCount(1, Author::all());
    }
}
