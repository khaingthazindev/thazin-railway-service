<?php

namespace App\Http\Controllers\Api\UserPortal;

use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\WalletRepository;

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

            return ResponseService::success([
                'access_token' => $user->createToken(config('app.name'))->plainTextToken
            ], 'Successfully registered');

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        DB::beginTransaction();
        try {
            // Using session base because call from same domain client 
            if (Auth::guard('users')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::guard('users')->user();
                $response = [
                    'access_token' => $user->createToken(config('app.name'))->plainTextToken
                ];
            } else {
                throw new \Exception('The credentials do not match our records.');
            }

            DB::commit();
            return ResponseService::success($response, 'Successfully logged in');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            // it will delete browser token and token from database 
            $request->user()->currentAccessToken()->delete();

            return ResponseService::success([], 'Successfully logged out');
        } catch (\Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
