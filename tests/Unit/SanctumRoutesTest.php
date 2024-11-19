<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SanctumRoutesTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function retrieve_articles_with_pagination(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        Article::factory()->count(20)->create();
        $response = $this->getJson('/api/articles');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'author',
                    'source',
                    'published_at',
                    'url',
                ]
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'path',
                'per_page',
                'to',
                'total',
            ]
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function retrieve_articles_without_token(): void
    {
        $response = $this->getJson('/api/articles');

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
