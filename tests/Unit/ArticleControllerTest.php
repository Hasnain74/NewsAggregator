<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\UserPreference;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     */
    public function it_fetches_articles_with_pagination(): void
    {
        Article::factory()->count(5)->create();
        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/api/articles?per_page=5');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'published_at', 'category', 'source'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'total'],
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function it_fetches_preference_based_articles(): void
    {
        $user = User::factory()->create();
        $preferences = UserPreference::create([
            'user_id' => $user->id,
            'sources' => 'Tech,Science',
            'categories' => 'Technology,Science',
            'authors' => 'John Doe',
        ]);

        Article::factory()->count(5)->create();
        $this->actingAs($user);
        $response = $this->getJson('/api/preference-articles?per_page=5');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'published_at', 'category', 'source'],
            ],
        ]);
    }

    /**
     * @return void
     * @test
     */
    public function it_filters_articles_based_on_query_parameters(): void
    {
        Article::factory()->create(['title' => 'Tech Article', 'category' => 'Technology', 'source' => 'Tech News']);
        Article::factory()->create(['title' => 'Science Article', 'category' => 'Science', 'source' => 'Science Daily']);
        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/api/filter-articles?category=Technology');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['title' => 'Tech Article']);
        $response = $this->getJson('/api/filter-articles?source=Science Daily');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['title' => 'Science Article']);
    }
}
