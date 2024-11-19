<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPreferenceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     * @test
     */
    public function set_preferences(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('preferences.set'), [
            'sources' => ['NewsAPI', 'Testing'],
            'categories' => ['Tech', 'Science'],
            'authors' => ['John Doe', 'Jane Doe'],
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Preferences saved successfully.',
            ]);

        $this->assertDatabaseHas('user_preferences', [
            'user_id' => $user->id,
        ]);

        $storedPreferences = UserPreference::where('user_id', $user->id)->first();

        $this->assertEquals(
            ['NewsAPI', 'Testing'],
            is_string($storedPreferences->sources)
                ? json_decode($storedPreferences->sources, true)
                : $storedPreferences->sources
        );
        $this->assertEquals(
            ['Tech', 'Science'],
            is_string($storedPreferences->categories)
                ? json_decode($storedPreferences->categories, true)
                : $storedPreferences->categories
        );
        $this->assertEquals(
            ['John Doe', 'Jane Doe'],
            is_string($storedPreferences->authors)
                ? json_decode($storedPreferences->authors, true)
                : $storedPreferences->authors
        );
    }
}
