<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request): JsonResponse {
        return response()->json(User::factory()->create());
    }
    public function getBalances(Request $request, int $userId): JsonResponse
    {
        return response()->json(
            UserBalance::query()
                ->where('user_id', $userId)
                ->get()
        );
    }
}
