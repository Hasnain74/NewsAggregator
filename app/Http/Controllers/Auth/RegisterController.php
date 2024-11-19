<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\RegisterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /**
     * RegisterController constructor.
     * @param RegisterRepository $registerRepository
     */
    public function __construct(private readonly RegisterRepository $registerRepository)
    {
    }

    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->registerRepository->createUser($request->all());
        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
