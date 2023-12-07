<?php

namespace Tests\Feature\API\V1;

use App\Enums\IssueStatus;
use App\Models\Issue;
use GuzzleHttp\Client;
use Tests\TestCase;

class IssueControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_issues_success(): void
    {
        $response = $this->get(route('issues.index'));

        $response->assertStatus(200);
    }

    public function test_get_filtered_issues_with_and_filter_logic_v1_success(): void
    {
        $response = $this->get(
            route('issues.index',
            [
                'filters' => [
                    'is:status_id' => collect(IssueStatus::cases())->random()->value,
                    'in:story_points' => collect(IssueStatus::cases())
                        ->random(rand(2, 5))
                        ->pluck('value')
                        ->implode(','),
                    'contain:description' => fake()->word,
                ]
            ]
            ),
        );

        $response->assertStatus(200);
    }

    public function test_get_filtered_issues_with_and_filter_logic_v2_success(): void
    {
        $response = $this->get(
            route('issues.index', [
                'filters' => [
                    '!is:status_id' => collect(IssueStatus::cases())->random()->value,
                    '!in:story_points' => collect(IssueStatus::cases())
                        ->random(rand(2, 4))
                        ->pluck('value')
                        ->toArray(),
                    '!contain:description' => fake()->word,
                ]
            ]),
        );

        $response->assertStatus(200);
    }

    public function test_get_filtered_issues_with_or_filter_logic_v1_success(): void
    {
        $response = $this->get(
            route('issues.index', [
                'filters' => [
                    '!is:status_id' => collect(IssueStatus::cases())->random()->value,
                    '!in:story_points' => collect(IssueStatus::cases())
                        ->random(rand(2, 4))
                        ->pluck('value')
                        ->toArray(),
                    '!contain:description' => fake()->word,
                ],
                'logic' => 'or'
            ]),
        );

        $response->assertStatus(200);
    }


    public function test_get_filtered_issues_using_incorrect_filter_field_error(): void
    {
        $response = $this->get(
            route('issues.index', [
                'filters' => [
                    'is:id' => Issue::query()->inRandomOrder()->first()->id, //@see model $filterFields
                    'in:story_points' => collect(IssueStatus::cases())
                        ->random(rand(2, 4))
                        ->pluck('value')
                        ->toArray(),
                    'contain:description' => fake()->word,
                ]
            ]),
        );

        $response->assertStatus(500);
    }

    public function test_get_filtered_issues_using_incorrect_filter_field_prefix_error(): void
    {
        $response = $this->get(
            route('issues.index', [
                'filters' => [
                    'test:story_points' => collect(IssueStatus::cases()) //wrong prefix
                        ->random(rand(2, 4))
                        ->pluck('value')
                        ->toArray(),
                    'contain:description' => fake()->word,
                ]
            ]),
        );

        $response->assertStatus(500);
    }
}
