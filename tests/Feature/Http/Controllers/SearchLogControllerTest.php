<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\SearchLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SearchLogController
 */
final class SearchLogControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SearchLogController::class,
            'store',
            \App\Http\Requests\SearchLogStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $query_text = fake()->word();
        $result_count = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('search-logs.store'), [
            'query_text' => $query_text,
            'result_count' => $result_count,
        ]);

        $searchLogs = SearchLog::query()
            ->where('query_text', $query_text)
            ->where('result_count', $result_count)
            ->get();
        $this->assertCount(1, $searchLogs);
        $searchLog = $searchLogs->first();

        $response->assertRedirect(route('back'));
    }
}
