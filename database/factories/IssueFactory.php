<?php

namespace Database\Factories;

use App\Enums\IssuePriority;
use App\Enums\IssueStatus;
use App\Enums\IssueStoryPoints;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $usersCount = User::query()->count();

        return [
            'assigner_id' => rand(1, $usersCount),
            'assignee_id' => rand(1, $usersCount),
            'title' => fake()->realText(25),
            'description' => fake()->realText(100),
            'priority' => fake()->numberBetween(IssuePriority::Low->value, IssuePriority::High->value),
            'status_id' => fake()->numberBetween(IssueStatus::Todo->value, IssueStatus::Backlog->value),
            'story_points' => fake()->numberBetween(IssueStoryPoints::One->value, IssueStoryPoints::Eight->value)
        ];
    }
}
