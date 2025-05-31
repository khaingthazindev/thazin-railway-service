<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Repositories\WalletRepository;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:20'],
        ]);

        DB::beginTransaction();
        try {
            $user = (new UserRepository())->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            (new WalletRepository())->firstOrCreate(
                ['user_id' => $user->id],
                ['amount' => 0]
            );

            DB::commit();

            $token = $user->createToken(config('app.name'))->plainTextToken;

            return [
                'data' => [
                    'access_token' => $token
                ],
                'message' => 'Successfully registered',
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
