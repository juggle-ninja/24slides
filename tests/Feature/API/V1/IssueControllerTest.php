<?php

namespace Tests\Feature\API\V1;

use App\Enums\IssueStatus;
use App\Models\Issue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_without_filters_successful_response(): void
    {
        $response = $this->json('get', route('issues.index'));

        $response->assertStatus(200);
    }

    public function test_index_with_filters_with_story_points_as_string(): void
    {
        $response = $this->json('get',  route('issues.index'),
           [
                'filters' => [
                    'is:status_id' => collect(IssueStatus::cases())->random()->value,
                    'in:story_points' => collect(IssueStatus::cases())->random(rand(2, 5))->pluck('value')->implode(','),
                    'contain:description' => fake()->word,
            ]
        ]);

        $response->assertStatus(200);
    }

    public function test_index_with_filters_with_story_points_as_array(): void
    {
        $response = $this->json('get',  route('issues.index'),
            [
                'filters' => [
                    '!is:status_id' => collect(IssueStatus::cases())->random()->value,
                    '!in:story_points' => collect(IssueStatus::cases())->random(rand(2, 4))->pluck('value')->toArray(),
                    '!contain:description' => fake()->word,
                ]
            ]);

        $response->assertStatus(200);
    }

    public function test_index_with_filters_with_or_query_logic(): void
    {
        $response = $this->json(
            'get',
            route('issues.index'),
            [
                'filters' => [
                    'status_id' => collect(IssueStatus::cases())->random()->value,
                    'in:story_points' => collect(IssueStatus::cases())->random(rand(2, 4))->pluck('value')->toArray(),
                    'contain:description' => fake()->word,
                ],
                'logic' => 'or'
            ]
        );

        $response->assertStatus(200);
    }
}
