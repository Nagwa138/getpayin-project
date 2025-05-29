<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Profile\ChangePasswordRequest;
use App\Http\Requests\API\Profile\ProfileUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //get user data (email and name)
    // update user data (email or name or both)
    //user change password
    // Get authenticated user's data
    public function show(): JsonResponse
    {
        $user = auth()->user();
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'join_at' => $user->created_at,
        ]);
    }

    // Update user profile
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = Auth::user();

        $user->update($request->only(['name', 'email']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }
}
