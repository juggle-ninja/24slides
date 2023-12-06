<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Issue;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1000)->create();

        $tags = Tag::factory(1000)->create();

        Issue::factory(10000)->create()->each(function (Issue $issue) use ($tags) {
            $issue->tags()->sync($tags->random(3)->pluck('id')->toArray());
        });
    }
}
