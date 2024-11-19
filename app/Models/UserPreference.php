<?php
namespace App\Models;

use Database\Factories\UserPreferenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sources',
        'categories',
        'authors'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sources' => 'array',
        'categories' => 'array',
        'authors' => 'array',
    ];

    /**
     * @return UserPreferenceFactory
     */
    protected static function newFactory(): UserPreferenceFactory
    {
        return UserPreferenceFactory::new();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
