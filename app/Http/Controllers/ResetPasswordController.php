<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

/**
 * ResetPasswordController
 * @package App\Http\Controllers
 */
class ResetPasswordController extends Controller
{
    /**
     * Reset the user's password.
     *
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset(ResetPasswordRequest $request): JsonResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password has been successfully reset.',
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to reset password.',
            'error' => __($status),
        ], 400);
    }
}
