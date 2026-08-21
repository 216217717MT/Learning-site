<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Guide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GuideController
 */
final class GuideControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_displays_view(): void
    {
        $guides = Guide::factory()->count(3)->create();

        $response = $this->get(route('guides.index'));

        $response->assertOk();
        $response->assertViewIs('guide.index');
        $response->assertViewHas('guides', $guides);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $guide = Guide::factory()->create();
        $guides = Guide::factory()->count(3)->create();

        $response = $this->get(route('guides.show', $guide));

        $response->assertOk();
        $response->assertViewIs('guide.show');
        $response->assertViewHas('guide', $guide);
    }
}
