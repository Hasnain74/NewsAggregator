<?php
namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /**
     * Handle the request for sending the password reset link.
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent successfully.'])
            : response()->json(['message' => 'Failed to send reset link.'], 400);
    }
}
