<?php
namespace App\Repositories;

use App\Models\Article;
use App\Models\UserPreference;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
class ArticleRepository
{
    /**
     * Paginate the articles.
     *
     * @param $articles
     * @return JsonResponse
     */
    public function paginateResponse($articles): JsonResponse
    {
        return response()->json([
            'data' => $articles->items(),
            'links' => [
                'first' => $articles->url(1),
                'last' => $articles->url($articles->lastPage()),
                'prev' => $articles->previousPageUrl(),
                'next' => $articles->nextPageUrl(),
            ],
            'meta' => [
                'current_page' => $articles->currentPage(),
                'from' => $articles->firstItem(),
                'last_page' => $articles->lastPage(),
                'path' => $articles->path(),
                'per_page' => $articles->perPage(),
                'to' => $articles->lastItem(),
                'total' => $articles->total(),
            ],
        ]);
    }

    /**
     * Fetch articles based on user preferences.
     *
     * @param UserPreference $preferences
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getArticlesByPreferences(UserPreference $preferences, int $perPage): LengthAwarePaginator
    {
        $query = UserPreference::query();
        $this->applyFilter($query, 'sources', $preferences->sources);
        $this->applyFilter($query, 'categories', $preferences->categories);
        $this->applyFilter($query, 'author', $preferences->author);

        return $query->orderByDesc('published_at')->paginate($perPage);
    }

    /**
     * Apply filter to the query based on the preference.
     *
     * @param Builder $query
     * @param string $column
     * @param mixed $value
     */
    private function applyFilter(Builder $query, string $column, mixed $value): void
    {
        if (empty($value)) {
            return;
        }

        $values = is_array($value) ? array_map('trim', $value) : array_map('trim', explode(',', $value));

        if (count($values) > 1) {
            $query->where(function ($subQuery) use ($column, $values) {
                foreach ($values as $item) {
                    $subQuery->orWhere($column, 'like', '%' . $item . '%');
                }
            });
        } else {
            $query->where($column, 'like', '%' . $values[0] . '%');
        }
    }

    /**
     * Filter articles based on the given data.
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function filter(array $data): LengthAwarePaginator
    {
        return Article::when($data['keyword'], function ($query, $keyword) {
            return $query->where('keywords', 'like', '%' . $keyword . '%');
        })
            ->when($data['date'], function ($query, $date) {
                return $query->whereDate('published_at', $date);
            })
            ->when($data['category'], function ($query, $category) {
                return $query->where(function ($query) use ($category) {
                    $query->where('category', 'like', '%' . $category . '%')
                        ->orWhere('category', '=', $category);
                });
            })
            ->when($data['source'], function ($query, $source) {
                return $query->where(function ($query) use ($source) {
                    $query->where('source', 'like', '%' . $source . '%')
                        ->orWhere('source', '=', $source);
                });
            })
            ->orderByDesc('published_at')
            ->paginate($data['per_page']);
    }
}
