<?php

namespace App\Http\Controllers\Api\UserPortal;

use App\Repositories\UserRepository;
use Response;
use Exception;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserPortal\ProfileResource;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = Auth::guard('users_api')->user();

        return ResponseService::success(new ProfileResource($user));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'max:20'],
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::guard('users_api')->user();

            if (!Hash::check($request->old_password, $user->password)) {
                throw new Exception('Old password is incorrect');
            }

            (new UserRepository())->update([
                'password' => Hash::make($request->new_password)
            ], $user->id);

            DB::commit();
            return ResponseService::success([], 'Successfully changed');
        } catch (Exception $e) {
            DB::rollBack();
            return ResponseService::fail($e->getMessage());
        }
    }
}
