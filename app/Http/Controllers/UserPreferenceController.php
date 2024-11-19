<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserPreferenceRequest;
use App\Models\UserPreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserPreferenceController
 * @package App\Http\Controllers
 */
class UserPreferenceController extends Controller
{
    /**
     * Fetch user preferences.
     * @return JsonResponse
     */
    public function getPreferences(): JsonResponse
    {
        $preferences = UserPreference::where('user_id', Auth::id())->first();

        return response()->json([
            'success' => true,
            'preferences' => $preferences
        ]);
    }

    /**
     * Set user preferences.
     * @param UserPreferenceRequest $request
     * @return JsonResponse
     */
    public function setPreferences(UserPreferenceRequest $request): JsonResponse
    {
        $preferences = UserPreference::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'sources' => $request->get('sources', []),
                'categories' => $request->get('categories', []),
                'authors' => $request->get('authors', []),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Preferences saved successfully.',
            'preferences' => $preferences,
        ]);
    }
}
