<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Repositories\OTPRepository;
use Exception;
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

        } catch (Exception $e) {
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

                if ($user->email_verified_at) {
                    $response = [
                        'is_verified' => 1,
                        'access_token' => $user->createToken(config('app.name'))->plainTextToken
                    ];
                } else {
                    $otp = (new OTPRepository())->send($request->email);

                    $response = [
                        'is_verified' => 0,
                        'otp_token' => $otp->token,
                    ];
                }

            } else {
                throw new Exception('The credentials do not match our records.');
            }

            DB::commit();
            return ResponseService::success($response, 'Successfully logged in');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function twoStepVerification(Request $request)
    {
        $request->validate([
            'otp_token' => 'required',
            'code' => 'required',
        ]);

        DB::beginTransaction();
        try {

            (new OTPRepository())->verify($request->otp_token, $request->code);

            $decrypted_otp_token = decrypt($request->otp_token);
            $user = (new UserRepository())->findByEmail($decrypted_otp_token['email']);
            if (!$user) {
                throw new Exception('The user is not found.');
            }
            $user = (new UserRepository())->update([
                'email_verified_at' => date('Y-m-d H:i:s')
            ], $user->id);

            DB::commit();
            return ResponseService::success([
                'access_token' => $user->createToken(config('app.name'))->plainTextToken
            ], 'Successfully logged in');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'otp_token' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $otp = (new OTPRepository())->resend($request->otp_token);

            DB::commit();
            return ResponseService::success($response = [
                'otp_token' => $otp->token,
            ], 'Successfully resent');
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            return ResponseService::fail($e->getMessage());
        }
    }
}
