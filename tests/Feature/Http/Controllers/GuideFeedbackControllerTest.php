<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Guide;
use App\Models\GuideFeedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GuideFeedbackController
 */
final class GuideFeedbackControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GuideFeedbackController::class,
            'store',
            \App\Http\Requests\GuideFeedbackStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $guide = Guide::factory()->create();
        $is_helpful = fake()->boolean();
        $comment = fake()->text();

        $response = $this->post(route('guide-feedbacks.store'), [
            'guide_id' => $guide->id,
            'is_helpful' => $is_helpful,
            'comment' => $comment,
        ]);

        $guideFeedbacks = GuideFeedback::query()
            ->where('guide_id', $guide->id)
            ->where('is_helpful', $is_helpful)
            ->where('comment', $comment)
            ->get();
        $this->assertCount(1, $guideFeedbacks);
        $guideFeedback = $guideFeedbacks->first();

        $response->assertRedirect(route('back'));
        $response->assertSessionHas('Thanks for the feedback', $Thanks for the feedback);
    }
}
