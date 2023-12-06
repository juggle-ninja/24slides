<?php

namespace Tests\Feature\API\V1;

use App\Enums\IssueStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_without_filters_successful_response(): void
    {
        $response = $this->get(route('issues.index'));

        $response->assertStatus(200);
    }

    public function test_with_filters_and_logic_v1(): void
    {
        $response = $this->get(route('issues.index', [
            'filters' => [
                'status_id' => [
                    'is' => collect(IssueStatus::cases())->random()->value
                ],
                'story_points' => [
                    'in' => collect(IssueStatus::cases())->random(3)->pluck('value')
                ],
                'description' => [
                    'contains' => fake()->word,
                ]
            ]
        ]));

        $response->assertStatus(200);
    }

    public function test_with_filters_and_logic_v2(): void
    {
        $response = $this->get(route('issues.index', [
            'filters' => [
                'status_id' => [
                    'is' => collect(IssueStatus::cases())->random()->value,
                    'or_is' => collect(IssueStatus::cases())->random()->value,
                ],
                'story_points' => [
                    'in' => collect(IssueStatus::cases())->random(3)->pluck('value')
                ],
                'description' => [
                    'contains' => fake()->word,
                ]
            ]
        ]));

        $response->assertStatus(200);
    }

    public function test_with_filters_or_logic(): void
    {
        $response = $this->get(route('issues.index', [
            'filters' => [
                'status_id' => [
                    'is' => collect(IssueStatus::cases())->random()->value
                ],
                'story_points' => [
                    'in' => collect(IssueStatus::cases())->random(3)->pluck('value')
                ],
                'description' => [
                    'contains' => fake()->word,
                ]
            ],
            'logic' => 'or'
        ]));

        $response->assertStatus(200);
    }
}
