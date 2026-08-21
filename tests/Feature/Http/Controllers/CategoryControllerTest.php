<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CategoryController
 */
final class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function show_displays_view(): void
    {
        $category = Category::factory()->create();
        $categories = Category::factory()->count(3)->create();

        $response = $this->get(route('categories.show', $category));

        $response->assertOk();
        $response->assertViewIs('category.show');
        $response->assertViewHas('category', $category);
    }
}
