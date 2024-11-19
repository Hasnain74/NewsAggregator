<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class UserPreferenceFactory
 * @package Database\Factories
 */
class UserPreferenceFactory extends Factory
{
    protected $model = UserPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'sources' => json_encode(['NewsAPI', 'Testing']),
            'categories' => json_encode(['Tech', 'Science']),
            'authors' => json_encode(['Hasnain Khan', 'Hasnain Khan']),
        ];
    }
}
